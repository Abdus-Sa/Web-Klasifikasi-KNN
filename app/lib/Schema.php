<?php

/*
 * @author Abdus Salam <salamduez9166@gmail.com>
 * @github https://github.com/Abdus-Sa 
 */

namespace Abdus\PMB\KNN;

class Schema
{
    /**
     * @var string[]
     */
    protected $parameters = [];

    /**
     * @var string
     */
    protected $parameterKlasifikasi = [];

    /**
     * @param string $parameter
     * @return $this
     */
    public function tambahParameter($parameter)
    {
        $this->parameters[] = $parameter;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param string $parameter
     * @return $this
     */
    public function setParameterKlasifikasi(string $parameter)
    {
        $this->parameterKlasifikasi = $parameter;
        return $this;
    }

    /**
     * @return string
     */
    public function getParameterKlasifikasi()
    {
        return $this->parameterKlasifikasi;
    }
}
