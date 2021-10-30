<?php

require '../vendor/autoload.php';
sleep(10);
$server = new SocketServer(Conf::host, Conf::port);
$server->runServer();
