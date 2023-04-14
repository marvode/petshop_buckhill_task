<?php

return [
    'issuer' => env('JWT_ISSUER', ''),
    'audience' => env('JWT_AUDIENCE', ''),

    // JWT_EXPIRATION is in seconds
    'expiration' => env('JWT_EXPIRATION', 3600),
];
