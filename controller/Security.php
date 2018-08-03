<?php
namespace Custom\Security;

require_once(__DIR__."/MessageOutput.php");
    
use Custom\Output as Output;
    
class Tokenizer
{
    protected $className = "Tokenizer";
    
    public function useToken($token)
    {
        $errorMessage = "Token expired, please refresh your page pressing the refresh button of your web 
        browser or F5 for short.";
        if (isset($_SESSION['vfyToken'])) {
            if ($_SESSION['vfyToken']==$token) {
                $MessageOutput = new Output\MessageOutput($this->className, true, "", 1);
                return $MessageOutput->output();
            } else {
                $MessageOutput = new Output\MessageOutput($this->className, false, $errorMessage, 1);
            }
        } else {
            $MessageOutput = new Output\MessageOutput($this->className, false, $errorMessage, 1);
            return $MessageOutput->output();
        }
    }
    public function generateToken()
    {
        return $_SESSION['vfyToken'] = bin2hex(random_bytes(32));
    }
    public function checkToken()
    {
        if (!empty($_SESSION['vfyToken'])) {
            return $_SESSION['vfyToken'] = bin2hex(random_bytes(32));
        }
        return false;
    }
}
