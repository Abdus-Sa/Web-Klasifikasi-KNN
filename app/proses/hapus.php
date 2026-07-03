<?php

require_once __DIR__ . '/../init.php';

if (dataFormLengkap($_GET, 'formHapusDataset')) {

	$type = (isset($_GET['type'])) ? $_GET['type'] : "dataset";

	// echo $type;
	// die;

	$hasil = hapusDataBerdasarkanId(intval($_GET["id"]), $type);

	$redirect = ($type == "dataset") ? "dataset.php" : "hasil_hitung.php";

	if ($hasil) {
		

		echo "<script>
			alert('Berhasil menghapus data!')
			const getUrl = window.location;
			const baseUrl = getUrl .protocol + '//' + getUrl.host + '/' + getUrl.pathname.split('/')[1];
			window.location.href = baseUrl + '/" . $redirect . "';
		</script>";
	} else {

		echo "<script>
			alert('Gagal menghapus data!')
			const getUrl = window.location;
			const baseUrl = getUrl .protocol + '//' + getUrl.host + '/' + getUrl.pathname.split('/')[1];
			window.location.href = baseUrl + '/" . $redirect . "';
		</script>";
	}
} else {
	echo "<script>
			alert('Maaf, aktivitas ini tidak diizinkan!')
			const getUrl = window.location;
			const baseUrl = getUrl .protocol + '//' + getUrl.host + '/' + getUrl.pathname.split('/')[1];
			window.location.href = baseUrl + '/" . $redirect . "';
		</script>";
	return;
}
