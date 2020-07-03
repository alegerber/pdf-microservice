<?php
declare(strict_types=1);

namespace Tests\Application\Actions\Pdf;

use App\Application\Actions\Pdf\GenerateAction;
use App\Application\Validator\GenerateValidator;
use App\Application\Validator\ValidationException;
use App\Domain\Pdf\Pdf;
use PHPUnit\Framework\MockObject\Rule\InvokedCount;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Tests\TestCase;

class GenerateActionTest extends TestCase
{

    /**
     * @param array        $formData
     * @param InvokedCount $setPaper
     * @param InvokedCount $setOptions
     * @dataProvider providerTestAction
     */
    public function testAction(array $formData, InvokedCount $setPaper, InvokedCount $setOptions)
    {
        $pdf               = $this->createMock(Pdf::class);
        $generateValidator = $this->createMock(GenerateValidator::class);

        $pdf->expects($this->once())->method('loadHtml');
        $pdf->expects($setPaper)->method('setPaper');
        $pdf->expects($setOptions)->method('setOptions');

        $generateAction = $this->createPartialMock(GenerateAction::class, [
            'getPdf',
            'getGenerateValidator',
            'getFormData',
            'respondWithData',
        ]);

        $generateAction->method('getPdf')->willReturn($pdf);
        $generateAction->method('getGenerateValidator')->willReturn($generateValidator);
        $generateAction->method('getFormData')->willReturn($formData);
        $generateAction->method('respondWithData')->willReturn(new Response());


        $this->assertInstanceOf(ResponseInterface::class, $generateAction->action());
    }


    /**
     * @return array
     */
    public function providerTestAction(): array
    {
        return [
            'only_html' => [
                'formData' => ['html' => 'test'],
                'setPaper' => $this->never(),
                'setOptions' => $this->never(),
            ],
            'html_paper' => [
                'formData' => [
                    'html' => 'test',
                    'paper' => [
                        'size' => 'A4',
                        'orientation' => 'landscape'
                        ]
                ],
                'setPaper' => $this->once(),
                'setOptions' => $this->never(),
            ],
            'html_paper_options' => [
                'formData' => [
                    'html' => 'test',
                    'paper' => [
                        'size' => 'A4',
                        'orientation' => 'landscape'
                        ],
                    'options' => [
                        'defaultFont' => 'Courier',
                        ],
                ],
                'setPaper' => $this->once(),
                'setOptions' => $this->once(),
            ],
        ];
    }

    /**
     * @param array  $formData
     * @param string $exceptionMessage
     * @dataProvider providerTestActionException
     */
    public function testActionExcpetion(array $formData, string $exceptionMessage)
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage($exceptionMessage);

        $pdf               = $this->createMock(Pdf::class);
        $generateValidator = new GenerateValidator();

        $generateAction = $this->createPartialMock(GenerateAction::class, [
            'getPdf',
            'getGenerateValidator',
            'getFormData',
            'respondWithData',
        ]);

        $generateAction->method('getPdf')->willReturn($pdf);
        $generateAction->method('getGenerateValidator')->willReturn($generateValidator);
        $generateAction->method('getFormData')->willReturn($formData);
        $generateAction->method('respondWithData')->willReturn(new Response());

        $this->assertInstanceOf(ResponseInterface::class, $generateAction->action());
    }


    /**
     * @return array
     */
    public function providerTestActionException(): array
    {
        return [
            'only_html' => [
                'formData' => ['hmtl' => 'paper'],
                'exceptionMessage' => 'validation fails for \'html\''
            ],
            'html_paper' => [
                'formData' => [
                    'html' => 'test',
                    'paper' => [
                        'size' => 'A4',
                        ]
                ],
                'exceptionMessage' => 'validation fails for \'paper\''
            ],
            'html_paper_options' => [
                'formData' => [
                    'html' => 'test',
                    'paper' => [
                        'size' => 'A4',
                        'orientation' => 'landscape'
                    ],
                    'options' => 'defaultFont'
                ],
                'exceptionMessage' => 'validation fails for \'options\''
            ],
        ];
    }

}
