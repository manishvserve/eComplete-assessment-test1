<?php

require_once  __DIR__ . '/vendor/autoload.php';

$client = new MongoDB\Client('mongodb://localhost:27017');

$companydb = $client->test1;

$result1 = $companydb->createCollection('users');

var_dump($result1);
// try {
        //     $collection->insertOne($data);
        //     echo "Document inserted successfully.";
        // } catch (MongoDB\Driver\Exception\WriteException $e) {
        //     $error = $e->getWriteResult()->getWriteErrors()[0];
            
        //     if ($error->getCode() == 11000) {
        //         echo "Error: The value is not unique.";
        //     } else {
        //         echo "Error: " . $error->getMessage();
        //     }
        // }
?>