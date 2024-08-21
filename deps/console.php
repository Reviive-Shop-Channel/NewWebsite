<?php
// Logger Console - Dakotath.
class DTUBEConLogger {
    public $logId = "";
    private $file = "console.php";

    // ID Generator.
    private function __generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
    
        return $randomString;
    }

    // Normal log.
    public function log($msg) {
        $this->logId = $this->__generateRandomString();
        echo("<script id='".$this->logId."'>console.log(\"".str_replace("\\", "/", $this->file).": ".$msg."\"); document.getElementById(\"".$this->logId."\").remove();</script>");
    }

    // Constructor.
    public function __construct($fileNam) {
        $this->file = $fileNam;
        $this->log("Init Debugger");
    }
}