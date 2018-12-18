<?php

return [
    'endpoint' => [
        'localhost' => [
            'host' => env('SOLR_HOST', '192.168.1.110'),
            'port' => env('SOLR_PORT', '8983'),
            'path' => env('SOLR_PATH', '/solr/'),
            'core' => env('SOLR_CORE', 'DOCS')
        ]
    ]
];