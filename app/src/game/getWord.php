<?php

session_start();

header('Content-Type: application/json');

require_once __DIR__ . '/gameMessage.php';

try {

    $result = sendGameMessage(
        "get_word",
        [
            "email" => $_SESSION["email"] ?? null
        ]
    );

    error_log(print_r($response, true));


    if (!$result["success"]) {

        http_response_code(500);

        echo json_encode([
            "error" => "RabbitMQ request failed",
            "details" => $result["error"],
            "location" =>
                $result["file"] . ":" . $result["line"]
        ]);

        exit;
    }


    $response = $result["data"];


    if (!$response || !isset($response["word_id"])) {

        http_response_code(500);

        echo json_encode([
            "error" => "Invalid response from game server",
            "response_received" => $response
        ]);

        exit;
    }


    echo json_encode($response);


} catch (Throwable $e) {


    http_response_code(500);

    echo json_encode([
        "error" => $e->getMessage(),
        "file" => $e->getFile(),
        "line" => $e->getLine()
    ]);

}