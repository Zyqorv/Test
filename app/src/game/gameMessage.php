<?php

function sendGameMessage($type, $message)
{
    $request = [
        "type" => $type,
        "message" => $message,
        "sent_at" => date(DATE_ATOM),
    ];

    try {

        require_once __DIR__ . "/../RabbitMQLib.inc";

        $client = new rabbitMQClient(
            __DIR__ . "/../../config/gameRabbitMQ.ini"
        );

        $response = $client->send_request($request);

        return [
            "success" => true,
            "data" => $response
        ];

    } catch (Throwable $error) {

        error_log(
            "RabbitMQ error: " . $error->getMessage()
        );

        return [
            "success" => false,
            "error" => $error->getMessage(),
            "file" => $error->getFile(),
            "line" => $error->getLine()
        ];
    }
}