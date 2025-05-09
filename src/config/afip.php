<?php

return [
    'cuit' => env('AFIP_CUIT'),
    'cert' => storage_path('storage/certs/mi_certificado.crt'),
    'key' => storage_path('storage/certs/mi_clave.key'),
    'modo' => env('AFIP_MODO', 'production'),
];
