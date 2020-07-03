<?php

declare(strict_types=1);

namespace Tests\Domain\Pdf;

use App\Domain\Pdf\Pdf;
use Tests\TestCase;

class PdfTest extends TestCase
{
    public function userProvider()
    {
        return [
            [1, 'bill.gates', 'Bill', 'Gates'],
            [2, 'steve.jobs', 'Steve', 'Jobs'],
            [3, 'mark.zuckerberg', 'Mark', 'Zuckerberg'],
            [4, 'evan.spiegel', 'Evan', 'Spiegel'],
            [5, 'jack.dorsey', 'Jack', 'Dorsey'],
        ];
    }

    public function testGetters(): void
    {
        $pdf = new Pdf();

        $this->assertInstanceOf(\SplFileObject::class, $pdf->getFile());
        $this->assertIsString($pdf->getFilePath());
    }

    public function testJsonSerialize(): void
    {
        $pdf = new Pdf();

        $pdf->setFile($this->createMock(\SplFileObject::class));
        $pdf->setFilePath('filepath.pdf');

        $expectedPayload = json_encode([
            'pdfDir' => 'filepath.pdf',
        ]);

        $this->assertEquals($expectedPayload, json_encode($pdf));
    }
}
