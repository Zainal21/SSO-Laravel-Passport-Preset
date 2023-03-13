<?php

return [
    'url_token' => env('SSO_GET_TOKEN_ENDPOINT'),
    'url_claim_user' => env('SSO_CLAIM_ENDPOINT'),
    'url_authorize' => env('SSO_AUTHORIZE_ENDPOINT'),
    'url_client_callback' => env('SSO_CLIENT_CALLBACK_ENDPOINT'),
];
