<?php
#$type = $argv[1] ?? "echo";
#$email = $argv[2] ?? "test message";
#$password = $argv[3] ?? "email";
#sendInformation($type,$email,$password);

function sendInformation ($type, $email, $password)
{

$request = [
    "type" => $type,
    "email" => $email,
    "password" => $password,
    "sent_at" => date(DATE_ATOM),
];

try {
    require_once __DIR__ . "/milestone2Lib.inc";

    $client = new rabbitMQClient(__DIR__ . "/authRabbitMQ.ini");
    $response = $client->send_request($request);

    echo "Client received response:" . PHP_EOL;
    return $response;
  #  print_r($response);
} catch (Throwable $error) {
    error_log("RabbitMQ client sample failed: " . $error->getMessage());
    fwrite(STDERR, "Client error: " . $error->getMessage() . PHP_EOL);
    exit(1);
}
}