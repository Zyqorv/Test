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

    $response = sendGameMessage(
        "check_guess",
        [
            "word_id" => $request["wordId"],
            "guess" => trim($request["guess"])
        ]
    );

    echo json_encode($response);

} catch (Throwable $e) {

    http_response_code(500);

    echo json_encode([
        "error" => "Unable to check guess."
    ]);
}
