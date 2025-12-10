<?php
//return [
//    'api_client_id' => env('35'),
//    'service_id'    => env('234330'),
//    'secret_key'    => env('7UiF90LT3RkIkala3FAxcwzYEXiy8Ztw'),
//    'endpoint'      => env('https://test.pesaflow.com/PaymentAPI/iframev2.1.php', 'https://test.pesaflow.com/PaymentAPI/iframev2.1.php'),
//];


return [

    /*
    |--------------------------------------------------------------------------
    | Pesaflow API Client Configuration
    |--------------------------------------------------------------------------
    */

    // Client ID provided by Pesaflow
    'api_client_id' => env('PESAFLOW_CLIENT_ID'),

    // Service ID provided by Pesaflow
    'service_id' => env('PESAFLOW_SERVICE_ID'),

    // Used inside the data string concatenation
    'secret' => env('PESAFLOW_SECRET'),

    // Used as the HMAC signing key
    'key' => env('PESAFLOW_KEY'),

    // Endpoint to load the payment iframe
    'endpoint' => env('PESAFLOW_IFRAME_URL', 'https://test.pesaflow.com/PaymentAPI/iframev2.1.php'),

];
