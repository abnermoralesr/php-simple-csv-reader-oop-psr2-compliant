<?php
namespace Custom\Output;

session_start();

class MessageOutput
{
    protected $scope;
    protected $success;
    protected $body;
    protected $output;
    public function __construct($scope, $success, $body, $output)
    {
        $this->scope = $scope;
        $this->success = $success;
        $this->body = $body;
        $this->output = $output;
    }
    public function output()
    {
        switch ($this->output) {
            case 1:
                return $this->jSon();
            break;
            default:
                return $this->jSon();
            break;
        }
    }
    private function jSon()
    {
        $finalArray = array(
            "scope"=>$this->scope,
            "success"=>$this->success,
            "body"=>$this->body
        );
        return json_encode($finalArray);
    }
}
