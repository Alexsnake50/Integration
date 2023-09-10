<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/AmoSender.php';
require_once __DIR__ . '/config.php';

header("Access-Control-Allow-Origin: *");
$body=json_decode(file_get_contents('php://input'), true);

$sender = new AmoSender($body);

$sender->handle();