<?php

declare(strict_types=1);

return [
    'app_id' => env('EVIDENCE_APPID', 'your-app-id') ?: getenv('EVIDENCE_APPID'),
    'secret' => env('EVIDENCE_SECRET', 'your-app-secret') ?: getenv('EVIDENCE_SECRET'),
    'evidence_server' => env('EVIDENCE_SERVER', 'https://smlcunzheng.tsign.cn:9443/evi-service/evidence') ?: getenv('EVIDENCE_SERVER'),
    'esign_server' => env('ESIGN_SERVER', 'https://smlopenapi.esign.cn') ?: getenv('ESIGN_SERVER'),
];
