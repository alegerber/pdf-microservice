<?php


namespace App\Domain\Pdf;


interface PdfInterface
{
    /**
     * @param $str
     * @param null $encoding
     * @return mixed
     */
    public function loadHtml($str, $encoding = null);


    /**
     * @param $size
     * @param string $orientation
     * @return mixed
     */
    public function setPaper($size, $orientation = "portrait");

    /**
     * @return string
     */
    public function persist(): string;
}