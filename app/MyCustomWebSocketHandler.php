<?php
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;

class MyCustomWebSocketHandler implements MessageComponentInterface
{

    public function onOpen(ConnectionInterface $connection)
    {
        // TODO: Implement onOpen() method.
        echo "abierto";
    }
    
    public function onClose(ConnectionInterface $connection)
    {
        // TODO: Implement onClose() method.
        echo "cerrado";
    }

    public function onError(ConnectionInterface $connection, \Exception $e)
    {
        // TODO: Implement onError() method.
        echo "error";
    }

    public function onMessage(ConnectionInterface $connection, MessageInterface $msg)
    {
        // TODO: Implement onMessage() method.
        echo "mensaje".$msg;
    }
}