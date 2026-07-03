<?php

/*
 * @author Abdus Salam <salamduez9166@gmail.com>
 * @github https://github.com/Abdus-Sa 
 */

namespace Abdus\PMB\KNN;

class DataSet
{
    /**
     * @var dataset[]
     */
    protected $dataset;

    /**
     * @var n
     */
    protected $n;

    /**
     * @var dataHasilHitung[]
     */
    protected $dataHasilHitung;

    /**
     * @var tetanggaTerdekat[]
     */
    protected $tetanggaTerdekat;

    /**
     * @var string
     */
    protected $hasilHitung;

    /**
     * @var int
     */
    protected $k;

    /**
     * @var Schema
     */
    protected $schema;

    /**
     * Constructor.
     *
     * @param Schema $schema
     * @param int    $k
     */
    public function __construct(Schema $schema, $k = 5)
    {
        $this->k = $k;
        $this->dataset = [];
        $this->dataHasilHitung = [];
        $this->schema = $schema;
    }

    /**
     * @return $dataset
     */
    public function getDataset()
    {
        return $this->dataset;
    }


    /**
     * @param Data $data
     * @return $this
     */
    public function tambah(Data $data)
    {
        $this->dataset[] = $data;

        return $this;
    }

    /**
     * @param  Data   $data
     * @param  string $parameter
     * @return mixed
     */
    public function hitung(Data $dataSample)
    {
        // $n => Banyak data
        $this->n = count($this->dataset);
        $this->dataHasilHitung = $this->dataset;

        // --- Proses Normalisasi Robust Scaler ---
        $robustScalerData = [];
        foreach ($this->schema->getParameters() as $parameter) {
            $isNumeric = true;
            $values = [];

            // Kumpulkan nilai pada dataset (hanya data latih)
            foreach ($this->dataHasilHitung as $dt) {
                $val = $dt->get($parameter);
                if (!is_numeric($val) && $val !== null && $val !== '') {
                    $isNumeric = false;
                    break;
                }
                if (is_numeric($val)) {
                    $values[] = floatval($val);
                }
            }

            // Simpan metadata median dan IQR jika parameter ini valid numerik
            if ($isNumeric && count($values) > 0) {
                $median = $this->calculatePercentile($values, 50);
                $q1 = $this->calculatePercentile($values, 25);
                $q3 = $this->calculatePercentile($values, 75);
                $iqr = $q3 - $q1;
                
                $robustScalerData[$parameter] = [
                    'median' => $median,
                    'iqr' => ($iqr == 0) ? 1 : $iqr // Hindari division by zero
                ];
            }
        }
        // --------------------------------

        foreach ($this->dataHasilHitung as $dataUji) {
            $totalKalkulasiJarakDataUjiDanDataSample = [];

            foreach ($this->schema->getParameters() as $parameter) {
                $valUji = $dataUji->get($parameter);
                $valSample = $dataSample->get($parameter);

                if (isset($robustScalerData[$parameter])) {
                    // Terapkan Rumus Robust Scaling: X_scaled = (X - Median) / IQR
                    $iqr = $robustScalerData[$parameter]['iqr'];
                    $median = $robustScalerData[$parameter]['median'];

                    $normUji = (floatval($valUji) - $median) / $iqr;
                    $normSample = (floatval($valSample) - $median) / $iqr;

                    $jarak = $normUji - $normSample;
                } else {
                    $strUji = strtolower(trim((string)$valUji));
                    $strSample = strtolower(trim((string)$valSample));
                    $jarak = ($strUji === $strSample) ? 0 : 1;
                }

                $totalKalkulasiJarakDataUjiDanDataSample[] = $jarak;
            }

            $totalJarakManhattan = 0;
            foreach ($totalKalkulasiJarakDataUjiDanDataSample as $jarak) {
                $totalJarakManhattan += abs($jarak);
            }

            $dataUji->setJarakHasil($totalJarakManhattan);
        }

        $this->urutkanData($this->dataHasilHitung);

        $this->cariTetanggaTerdekat();

        return [
            "hasil_hitung" => $this->hasilHitung,
            "tetangga_terdekat" => $this->tetanggaTerdekat,
            "data_hasil_hitung_yang_terurut" => $this->dataHasilHitung,
        ];
    }

    /**
     * @param  Data[]   $data
     * @return Dataset $this
     */
    public function setDataHasilHitung(array $data)
    {
        $this->dataHasilHitung = $data;

        return $this;
    }


    /**
     * Cari tetangga k-terdekat
     *
     * @param Data[] $data
     */
    public function cariTetanggaTerdekat()
    {
        $this->tetanggaTerdekat = array_slice($this->dataHasilHitung, 0, $this->k);
        $this->cariKlasifikasiTerbanyak($this->tetanggaTerdekat, function ($klasifikasi, $jarak) {
            $this->hasilHitung = [
                $this->schema->getParameterKlasifikasi() => $klasifikasi,
                'jarak_hasil' => $jarak,
                'nilai_k' => $this->k
            ];
        });
    }

    /**
     * Cari kriteria terbanyak
     *
     * @param Data[] $data
     * @param Function $callback
     */
    public function cariKlasifikasiTerbanyak(array $data, $callback)
    {
        $klasifikasiArray = [];
        $parameterKlasifikasi = $this->schema->getParameterKlasifikasi();


        foreach ($data as $key => $value) {
            if (isset($klasifikasiArray[$value->get($parameterKlasifikasi)])) {
                $jumlah = $klasifikasiArray[$value->get($parameterKlasifikasi)][0];
                $jarak = $klasifikasiArray[$value->get($parameterKlasifikasi)][1];
                $klasifikasiArray[$value->get($parameterKlasifikasi)] = [++$jumlah, $jarak];
            } else {
                $klasifikasiArray[$value->get($parameterKlasifikasi)] = [1, $value->getJarakHasil()];
            }
        }

        $klasifikasiTerdekat = "";
        $jarakKlasifikasi = 0.0;
        $terbanyakSementara = 1;
        $seimbang = true;
        $klasifikasiPertama = true;

        foreach ($klasifikasiArray as $key => $value) {
            if ($klasifikasiPertama) {
                $klasifikasiPertama = false;

                if ($value[0] > $terbanyakSementara) {
                    $terbanyakSementara = $value[0];
                    $jarakKlasifikasi = $value[1];
                    $klasifikasiTerdekat = $key;
                }
            }

            if ($value[0] > $terbanyakSementara) {
                $terbanyakSementara = $value[0];
                $jarakKlasifikasi = $value[1];
                $klasifikasiTerdekat = $key;
                $seimbang = false;
            }
        }

        if (is_callable($callback)) {
            if ($seimbang) {
                call_user_func($callback, $data[0]->get($parameterKlasifikasi), $data[0]->getJarakHasil());
            } else {
                call_user_func($callback, $klasifikasiTerdekat, $jarakKlasifikasi);
            }
        }
    }

    /**
     * Urut data berdasarkan jarakHasil
     *
     * @param Data[] $data
     */
    protected function urutkanData(array &$data)
    {
        usort(
            $data,
            function (Data $a, Data $b) {
                return $a->getJarakHasil() <=> $b->getJarakHasil();
            }
        );
    }

    /**
     * Helper: Menghitung persentil dari sebuah array
     *
     * @param array $values
     * @param int $percentile (0-100)
     * @return float
     */
    private function calculatePercentile(array $values, $percentile)
    {
        $count = count($values);
        if ($count === 0) return 0;
        
        sort($values);
        
        $index = ($percentile / 100) * ($count - 1);
        
        if (floor($index) == $index) {
            return floatval($values[$index]);
        }
        
        $i = (int)floor($index);
        $fraction = $index - $i;
        
        return $values[$i] + ($values[$i + 1] - $values[$i]) * $fraction;
    }
}
