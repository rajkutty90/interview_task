<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class AN_Curl extends CI_Model {

     public $server_url;
     private $curl;
     public $result;

     public function __construct($url = ''){
         if($url) $this->server_url = $url;
         $this->curl   = curl_init();
         curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
         curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
     }

     public function execute(){
        curl_setopt($this->curl,CURLOPT_URL,$this->server_url);
        $buffer = curl_exec($this->curl);
        if($buffer){
            $this->result = json_decode($buffer);
        }
     }

     public function __destruct(){
        curl_close($this->curl);
     }

}