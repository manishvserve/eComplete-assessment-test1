<?php
require_once  __DIR__ . '/vendor/autoload.php';

// Connect to MongoDB server
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");

// Select database
$database = $mongoClient->test1;

// Select collection
$collection = $database->users;

// Add unique index to id_number field
$collection->createIndex(['id_number' => 1], ['unique' => true]);
// session_start();
?>