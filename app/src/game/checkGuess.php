<?php

session_start();

require_once __DIR__ . '/gameMessage.php';

header('Content-Type: application/json');

try {

    $request = json_decode(file_get_contents("php://input"), true);

    if (
        !$request ||
        !isset($request["wordId"]) ||
        !isset($request["guess"])
    ) {

        http_response_code(400);

        echo json_encode([
            "error" => "Invalid request."
        ]);

        exit;
    }


    $message = sendGameMessage(
        "check_guess",
        [
            "word_id" => $request["wordId"],
            "guess" => trim($request["guess"])
        ]
    );


    if (!$message["success"]) {

        http_response_code(500);

        echo json_encode([
            "error" => "RabbitMQ request failed",
            "details" => $result["error"],
            "location" =>
                $result["file"] . ":" . $result["line"]
        ]);

        exit;
    }


    $response = $message["data"];

    error_log(print_r($response), true);

    if (!$response) {

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