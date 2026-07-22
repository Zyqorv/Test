<?php

session_start();

header('Content-Type: application/json');

try {

    $response = sendGameMessage(
        "get_word",
        [
            "email" => $_SESSION["email"] ?? null
        ]
    );

    if (!$response || !isset($response["word_id"])) {

        http_response_code(500);

        echo json_encode([
            "error" => "No word could be retrieved."
        ]);

        exit;
    }

    echo json_encode($response);

} catch (Exception $e) {

    http_response_code(500);

    echo json_encode([
        "error" => "Failed to load game data."
    ]);
}
