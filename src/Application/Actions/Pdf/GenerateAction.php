<?php

declare(strict_types=1);

namespace App\Application\Actions\Pdf;

use App\Application\Actions\Action;
use App\Domain\Pdf\Pdf;
use Psr\Http\Message\ResponseInterface as Response;

class GenerateAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $pdf = new Pdf();

        $pdf->loadHtml(
            $this->request->getAttribute('html')
        );

        if (null !== $paper = $this->request->getAttribute('paper')) {
            $pdf->setPaper($paper['size'], $paper['orientation']);
        }

        return $this->respondWithData([
            'pdfDir' => $pdf->persist(),
        ]);
    }
}
