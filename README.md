# PDF Microservice 

This is a microservice for Pdf generation.

It is possible to convert html into a Pdf.

#example 1
persist the file

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
        
#example 2
stream the file

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
            'stream' => true,
        ];

        $options['body'] = json_encode($body, JSON_THROW_ON_ERROR);
        $response        = $client->request('post', 'http://localhost:8080/pdf/generate', $options);
        $content         = $response->getBody()->getContents();

        file_put_contents('/tmp/test_stream.pdf', $content);