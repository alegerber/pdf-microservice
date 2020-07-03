<?php

declare(strict_types=1);

namespace Tests\Domain\Pdf;

use App\Domain\Pdf\Pdf;
use Tests\TestCase;

class PdfTest extends TestCase
{

    public function testGetters(): void
    {
        $pdf = new Pdf();

        $this->assertInstanceOf(\SplFileObject::class, $pdf->getFile());
        $this->assertIsString($pdf->getFilePath());
    }
}
