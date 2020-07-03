# PDF Microservice 

This is a microservice for Pdf generation.

It is possible to convert html into a Pdf.

#example

        $client  = new \GuzzleHttp\Client();
        $options = [];
        $body    = [
            'html' => 'test',
            'paper' => [
                'size' => 'A4',
                'orientation' => 'landscape'
            ],
            'options' => [
                'defaultFont' => 'Courier',
            ],
        ];

        $options['body'] = json_encode($body, JSON_THROW_ON_ERROR);
        $response        = $client->request('post', 'http://localhost:8080/pdf/generate', $options);
        $content         = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        $stream          = fopen($content['data']['pdfDir'], 'rb');