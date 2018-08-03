<?php
require_once(__DIR__."/../controller/UploadHandler.php");
require_once(__DIR__."/../controller/Security.php");
require_once(__DIR__."/../controller/Security.php");

use Custom\FileHandler as FileHandler;
use Custom\Security as Security;
use Custom\Output as Output;

if (isset($_FILES['upload'])) {
    $file = $_FILES['upload'];
    if (isset($_POST["format"])&&isset($_POST["token"])) {
        $outputFormat = $_POST["format"];
        $token = $_POST["token"];
        $UploadHandler = new FileHandler\UploadHandler($outputFormat, $token);
        $result = $UploadHandler->readCSV($file, $token);
        echo $result;
    } else {
        $MessageOutput = new Output\MessageOutput("POST", false, "Invalid request please try again", 1);
        echo $MessageOutput->output();
    }
} else {
    $MessageOutput = new Output\MessageOutput("POST", false, "Please upload a CSV", 1);
    echo $MessageOutput->output();
}
