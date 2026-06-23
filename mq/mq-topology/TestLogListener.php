<?php
function request_processor(array $request): array
{
	#checks to see if it is an error message if it is it just returns to immediatly exit the if statement
	if ($request["source"]=="error message")
	{
		return["message"=>"error message published"];
	}
	#validates the messages by checking if the have a valide source, message, and sent at time
	else if(empty($request["source"]) || empty($request["message"]) || empty($request["sent_at"]))
	{
		#if they are invalid it calls the publish error log function and returns
		echo "Invalid log message publishing to error log queue\n";
		
		publish_error_log();
		return
		[
			"status"=>"error",
			"message"=>"Invalid log message",
		];
	}
	else {
	file_put_contents(__DIR__ . "/mirror.log", $request["sent_at"] . " " ."[" . $request["source"] ."]". ": " . $request["message"] . PHP_EOL, FILE_APPEND);

	return
	[
		"status"=>"ok",
		"message"=> "Log recieved",
	];
}
	
}

function publish_error_log(): void
{
		#creates and error client and publishes it to the error log queue specified in the .ini file
	$errorClient = new rabbitMQClient(__DIR__ . "/errorlog.ini");
		#client publishes the message as there is no listener for error log and it does not need to wait for a response
                $errorClient->publish([
				"source" => "error message",
                                "message"=> "bad log publishing message",
                                "sent_at"=> date(DATE_ATOM),

		]);
	return;

}






try {
    #changed to a modified .inc to allow the function to push a message instead of waiting for a response	
    require_once __DIR__ . "/errorLog.inc";

    $server = new rabbitMQServer(__DIR__ . "/testRabbitMQ.ini");
    echo "RabbitMQ server sample starting" . PHP_EOL;
    $server->process_requests("request_processor");
} catch (Throwable $error) {
    error_log("RabbitMQ server sample failed: " . $error->getMessage());
    fwrite(STDERR, "Server error: " . $error->getMessage() . PHP_EOL);
    exit(1);
}
