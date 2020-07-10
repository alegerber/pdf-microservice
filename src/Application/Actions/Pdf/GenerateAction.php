<?php

declare(strict_types=1);

namespace App\Application\Actions\Pdf;

use App\Application\Actions\Action;
use App\Application\Validator\GenerateValidator;
use App\Application\Validator\ValidatorInterface;
use App\Domain\Pdf\Pdf;
use App\Domain\Pdf\PdfInterface;
use Dompdf\Options;
use Psr\Http\Message\ResponseInterface as Response;

class GenerateAction extends Action
{
    public function getPdf(): PdfInterface
    {
        return new Pdf();
    }

    public function getGenerateValidator(): ValidatorInterface
    {
        return new GenerateValidator();
    }

    /**
     * {@inheritdoc}
     */
    public function action(): Response
    {
        $pdf       = $this->getPdf();
        $formData  = $this->getFormData(true);
        $validator = $this->getGenerateValidator();

        $validator->validate($formData);

        $pdf->loadHtml(
            $formData['html']
        );

        if (isset($formData['paper'])) {
            $pdf->setPaper($formData['paper']['size'], $formData['paper']['orientation']);
        }

        if (isset($formData['options'])) {
            $pdf->setOptions(new Options($formData['options']));
        }

        if (isset($formData['stream']) && $formData['stream']) {
            if (null === $output = $pdf->output()) {
                throw new \RuntimeException('could not generate the Pdf');
            }

            return $this->respondStream($output);
        }

        return $this->respondWithData($pdf);
    }
}
