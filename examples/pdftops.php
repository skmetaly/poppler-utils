<?php

require_once('../vendor/autoload.php');


$pdf = new \Skmetaly\PopplerUtils\PDF(__DIR__ . '/file.pdf');

$response = $pdf->toPS(__DIR__ . '/example.ps')
    ->generateLevel1()
    ->run();

if($response->getStatusCode() !==0){
    echo $response->getErrors();
    echo "\n Failed";
}else{
    echo "Successful\n";
}

