<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/AmoSender.php';
use Predis\Client;

header("Access-Control-Allow-Origin: *");
$body=json_decode(file_get_contents('php://input'), true);

$sender = new AmoSender($body);

$sender->handle();
//print_r($body);
//echo json_encode(file_get_contents('php://input'));