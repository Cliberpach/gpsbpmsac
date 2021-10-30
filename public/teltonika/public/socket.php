<?php

require '../vendor/autoload.php';

$form=new  Uro\TeltonikaFmParser\FmParser("tcp");
$parser = new FmParser('tcp');
$socket = stream_socket_server("tcp://0.0.0.0:8043", $errno, $errstr);
if (!$socket) {
    throw new \Exception("$errstr ($errno)");
} else {
    while ($conn = stream_socket_accept($socket)) {
        // Read IMEI
        $payload = fread($conn, 1024);
        $imei = $parser->decodeImei($payload);
        // Accept packet
        fwrite($conn, Reply::accept());
        // Decline packet
        // fwrite($conn, Reply::reject());
        // Read Data
        $payload = fread($conn, 1024);
        $packet = $parser->decodeData($payload);
        // Send acknowledge
        fwrite($conn, $parser->encodeAcknowledge($packet));
        // Close connection
        fclose($conn);
    }

    fclose($socket);
}
