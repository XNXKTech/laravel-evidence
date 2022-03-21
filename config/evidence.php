<?php

declare(strict_types=1);

return [
    'app_id' => env('EVIDENCE_APPID', 'your-app-id'),
    'secret' => env('EVIDENCE_SECRET', 'your-app-secret'),
    'evidence_server' => env('EVIDENCE_SERVER', 'https://smlcunzheng.tsign.cn:9443/evi-service/evidence'),
    'esign_server' => env('ESIGN_SERVER', 'https://smlopenapi.esign.cn')
];