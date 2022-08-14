<?php
use AmoCRM\Client\AmoCRMApiClient;
use Symfony\Component\Dotenv\Dotenv;

include_once __DIR__ . '\..\vendor\autoload.php';

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '\.env');

$client_id = $_ENV['CLIENT_ID'];
$client_secret = $_ENV['CLIENT_SECRET'];
$redirect_uri = $_ENV['CLIENT_REDIRECT_URI'];
$auth_code = $_ENV['CLIENT_AUTHORIZATION_CODE'];
$subdomain = $_ENV['SUBDOMAIN'];

$api_client = new AmoCRMApiClient($clientId, $clientSecret, $redirectUri);

include_once __DIR__ . '/token_actions.php';
