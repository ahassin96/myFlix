<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); 
    exit();
}


$payload = file_get_contents('php://input');


file_put_contents('webhook.log', $payload . PHP_EOL, FILE_APPEND);


http_response_code(200);
echo 'Webhook received successfully';

?>