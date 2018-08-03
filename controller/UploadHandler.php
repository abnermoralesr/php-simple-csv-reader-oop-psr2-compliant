<?php
namespace Custom\FileHandler;

require_once(__DIR__."/MessageOutput.php");
require_once(__DIR__."/Security.php");
    
use Custom\Output as Output;
use Custom\Security as Security;
    
class UploadHandler
{
    protected $className = "UploadHandler";
    protected $output;
    public function __construct($output)
    {
        $this->output = $output;
    }
    public function readCSV($file, $token)
    {
        $Security = new Security\Tokenizer();
        $tokenUse = $Security->useToken($token);
        $token = json_decode($tokenUse, true);
        if ($token["success"]==true) {
            $errorMessage = "";
            $fileType = $file['type'];
            $fileOk = $this->fileTypeCheck($fileType);
            if ($file['error'] == 0) {
                $exploded = explode('.', $file['name']);
                $checkExtension = strtolower(end($exploded));
                if ($checkExtension === 'csv'&&$fileOk==true) {
                    $tmpName = $file['tmp_name'];
                    if (($handle = fopen($tmpName, 'r')) !== false) {
                        $firstRow = true;
                        $items = 0;
                        $tHead = "<thead>";
                        $tBody = "<tbody>";
                        while (($data = fgetcsv($handle)) !== false) {
                            $colCount = count($data);
                            if ($firstRow) {
                                $tHead .="<tr>";
                                for ($i = 0; $i < $colCount; $i++) {
                                    $tHead .= "<th>".strtoupper(str_replace("_", " ", $data[$i]))."</th>";
                                }
                                $tHead .="</tr>";
                                $firstRow = false;
                                continue;
                            } else {
                                $tBody .="<tr>";
                                for ($i = 0; $i < $colCount; $i++) {
                                    $tBody .= "<td>".$data[$i]."</td>";
                                }
                                $tBody .="</tr>";
                            }
                            $items++;
                        }
                        if ($items>=1) {
                            $tHead .= "</thead>";
                            $tBody .= "</tbody>";
                            $table = "<table id=\"myTable\">".$tHead.$tBody."</table>";
                            $MessageOutput = new Output\MessageOutput($this->className, true, $table, $this->output);
                            return $MessageOutput->output();
                        } else {
                            $errorMessage = "The file is not a CSV file or is empty, please try again.";
                            $MessageOutput = new Output\MessageOutput(
                                $this->className,
                                false,
                                $errorMessage,
                                $this->output
                            );
                            return $MessageOutput->output();
                        }
                    } else {
                        $errorMessage = "File could not be opened please try again.";
                        $MessageOutput = new Output\MessageOutput(
                            $this->className,
                            false,
                            $errorMessage,
                            $this->output
                        );
                        return $MessageOutput->output();
                    }
                } else {
                    $errorMessage = "The file is not a CSV file.";
                    $MessageOutput = new Output\MessageOutput($this->className, false, $errorMessage, $this->output);
                    return $MessageOutput->output();
                }
            } else {
                $errorMessage = $this->csvError($file['error']);
                $MessageOutput = new Output\MessageOutput($this->className, false, $errorMessage, $this->output);
                return $MessageOutput->output();
            }
        } else {
            return $tokenUse;
        }
    }
    private function csvError($error)
    {
        if ($error>=1) {
            $filesErrorMessage = array(
                1=>"The uploaded file exceeds the upload_max_filesize directive",
                2=>"The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
                3=>"The uploaded file was only partially uploaded",
                4=>"No file was uploaded",
                6=>"Missing a temporary folder"
            );
            return $filesErrorMessage[$error];
        } else {
            return $error;
        }
    }
    private function fileTypeCheck($fileType)
    {
        switch ($fileType) {
            case "text/csv":
                $fileOk = true;
                break;
            case "text/plain":
                $fileOk = true;
                break;
            case "application/vnd.ms-excel":
                $fileOk = true;
                break;
            case "application/octet-stream":
                $fileOk = true;
                break;
            default:
                $fileOk = false;
                break;
        }
        return $fileOk;
    }
    private function isCsv($file)
    {
        return fgetcsv($file);
    }
}
