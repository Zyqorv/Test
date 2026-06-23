<?php
#put the client code into a function to make it callable in the future
function publishLog($source, $message)
{

$request = [
    "source" => $source,
    "message" => $message,
    "sent_at" => date(DATE_ATOM),
    
];

try {
    require_once __DIR__ . "/rabbitMQLib.inc";

    $client = new rabbitMQClient(__DIR__ . "/testRabbitMQ.ini");
     $client->publish($request);

    echo "Log published" . PHP_EOL;
} catch (Throwable $error) {
    error_log("RabbitMQ client sample failed: " . $error->getMessage());
    fwrite(STDERR, "Client error: " . $error->getMessage() . PHP_EOL);
    exit(1);
}
}

$source = $argv[1];
$message = $argv[2];

publishLog($source, $message);

