<?php

namespace App\Domain\Pdf;

use Dompdf\Options;

interface PdfInterface
{
    /**
     * @param string $str
     * @param null   $encoding
     * @return mixed
     */
    public function loadHtml($str, $encoding = null);


    /**
     * @param string $size
     * @param string $orientation
     * @return mixed
     */
    public function setPaper($size, $orientation = "portrait");


    /**
     * @param Options $options
     * @return $this
     */
    public function setOptions(Options $options);


    /**
     * @return string
     */
    public function persist(): string;
}