<?php

return [
    'cuit' => env('AFIP_CUIT'),
    'cert' => storage_path('app/afip/certificado.crt'), 
    'key' => storage_path('app/afip/clave.key'), 
    'modo' => env('AFIP_MODO', 'testing'),
];
