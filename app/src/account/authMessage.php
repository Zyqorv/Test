<?php
#$type = $argv[1] ?? "echo";
#$message = $argv[2] ?? "message";
#sendInformation($type,$message);

function sendAuthMessage ($type, $message)
{

$request = [
    "type" => $type,
    "message" => $message,  
    "sent_at" => date(DATE_ATOM),
];

try {
    require_once __DIR__ . "/../RabbitMQLib.inc";

    $client = new rabbitMQClient(__DIR__ . "/../../config/authRabbitMQ.ini");
    $response = $client->send_request($request);

    return $response;
} catch (Throwable $error) {
    error_log("RabbitMQ client sample failed: " . $error->getMessage());
    fwrite(STDERR, "Client error: " . $error->getMessage() . PHP_EOL);

    return [
        'status' => 'error',
        'message' => 'Server error during authentication.',
    ];
}
}