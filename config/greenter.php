<?php

use Greenter\Ws\Services\SunatEndpoints;

return [
    'certificate' => storage_path('app/certificate.pem'), // Ruta del certificado
    'ruc' => env('SUNAT_RUC', '20000000001'),
    'user_sol' => env('SUNAT_USER', 'MODDATOS'),
    'password_sol' => env('SUNAT_PASS', 'moddatos'),
    'endpoint' => SunatEndpoints::FE_BETA, // Entorno beta de SUNAT
];