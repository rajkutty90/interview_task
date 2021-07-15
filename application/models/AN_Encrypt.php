<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

// Class for make Password secure

class AN_Encrypt extends CI_Model{
	
	//function to encrypt password
	
	function cryptPass($input, $rounds = 9){
	  $salt = "";
	  $saltChars = array_merge(range('A','Z'),range('a','z'),range('0','9'));
	  for($i=0;$i<22;$i++){
	    $salt .= $saltChars[array_rand($saltChars)];
	  }
	  return crypt($input, sprintf('$2y$%02d$', $rounds) . $salt);
	}
		
	//function to check password 	
	
	function check_password($password,$e_password){
		if(crypt($password,$e_password)==$e_password){
		 return  true;
		}
		return false;
	}
	
	//Function to generate unique string

	function generateUniqueCode($input){
		$crypt = md5(time().uniqid().$input);
		$crypt = sha1($crypt);
		return $crypt;
	}
}
