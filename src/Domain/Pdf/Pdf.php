<?php
declare(strict_types=1);

namespace App\Domain\Pdf;

use Dompdf\Dompdf;

class Pdf extends Dompdf implements PdfInterface
{
    public const PERSIST_DIR = '/tmp/share/pdf';

    /**
     * @var \SplFileObject $file
     */
    private $file;

    /**
     * @var string $filePath
     */
    private $filePath;

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }


    /**
     * @param string $filePath
     * @return Pdf
     */
    public function setFilePath(string $filePath): Pdf
    {
        $this->filePath = $filePath;
        return $this;
    }


    /**
     * @return \SplFileObject
     */
    public function getFile(): \SplFileObject
    {
        return $this->file;
    }

    /**
     * @param \SplFileObject $file
     * @return Pdf
     */
    public function setFile(\SplFileObject $file): Pdf
    {
        $this->file = $file;
        return $this;
    }


    public function __construct($options = null)
    {
        if (!is_dir($concurrentDirectory = self::PERSIST_DIR)) {
            mkdir($concurrentDirectory);
        }

        $fileName       = md5(uniqid(__FILE__,true)) . 'pdf';
        $this->filePath = self::PERSIST_DIR . DIRECTORY_SEPARATOR . $fileName;
        $this->file     = new \SplFileObject($this->getFilePath(),'w');

        parent::__construct($options);
    }


    /**
     * @return string
     */
    public function persist(): string
    {
        $this->render();
        $this->getFile()->fwrite($this->output());

        return $this->getFilePath();
    }
}
