<?php

declare(strict_types=1);

namespace App\Application\Actions\Pdf;

use App\Application\Actions\Action;
use App\Application\Validator\GenerateValidator;
use App\Domain\Pdf\Pdf;
use Psr\Http\Message\ResponseInterface as Response;

class GenerateAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $pdf       = new Pdf();
        $formData  = $this->getFormData(true);
        $validator = new GenerateValidator();

        $validator->validate($formData);

        $pdf->loadHtml(
            $formData['html']
        );

        if (isset($formData['paper'])) {
            $pdf->setPaper($formData['paper']['size'], $formData['paper']['orientation']);
        }

        return $this->respondWithData([
            'pdfDir' => $pdf->persist(),
        ]);
    }
}
