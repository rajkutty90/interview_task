<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Form validation for UK Postcodes
 * 
 * Check that its a valid postcode
 * @author James Mills <james@koodoocreative.co.uk>
 * @version 1.0
 * @package FriendsSavingMoney
 */

class MY_Form_validation extends CI_Form_validation
{

    function __construct()
    {
        parent::__construct();  
        log_message('debug', '*** Hello from MY_Form_validation ***');
    }

    /**
     * Name validation
     */

    function valid_name($name)
    {

        if($name == '') return TRUE;

        $pattern = "/^[a-zA-Z\s]+$/";


        if (preg_match($pattern, strtoupper($name)))
        {
            return TRUE;
        } 
        else
        {
            $this->set_message('valid_name', 'Please enter a valid name');
            return FALSE;
        }
    }

    /**
     * UK phone number validation
     */

    function valid_uk_phone($phone)
    {

        if($phone == '') return TRUE;

        $pattern = "/^0[0-9]{9,10}+$/";


        if (preg_match($pattern, strtoupper($phone)))
        {
            return TRUE;
        } 
        else
        {
            $this->set_message('valid_uk_phone', 'Please enter a valid phone number');
            return FALSE;
        }
    }

    /**
     * Data of birth validate
     */

    public function valid_dob($str, $seperation = '/')
	{

        if($str == '') return TRUE;

		$validDate   = TRUE;
		$date_split = explode($seperation, $str);
  
		if($date_split && count($date_split) == 3){
			$selMonth  = (int)$date_split[0];
			$selDate   = (int)$date_split[1];
			$selYear   = (int)$date_split[2];

            

			if($selMonth > 0 && $selMonth < 13 && $selDate > 0 && $selDate < 32 && $selYear > 1900 && $selYear < 2100){
				$leapYear  = FALSE;
				if($selYear % 4 == 0)  $leapYear = TRUE; 
				if($selMonth == 4 || $selMonth == 6 || $selMonth == 9 || $selMonth == 11){
					if($selDate ==  31) $validDate = FALSE;
				}
				if($selMonth == 2){
					if($leapYear && $selDate > 29) $validDate = FALSE;
					if(!$leapYear && $selDate > 28) $validDate = FALSE;
				}
			}else{
				$validDate = FALSE;
			}

            if($validDate){
               
                $dob       = $selYear . '-' . $selMonth . '-' .$selDate." 00:00:00";
                $today     = date('d-m-Y',time()); 
                $exp       = date('d-m-Y',strtotime($dob));
                $expDate   =  date_create($exp);
                $todayDate = date_create($today);
                $diff =  date_diff($todayDate, $expDate);
                if($diff->format("%R%a")>0){
                    $validDate = FALSE;
                }
                
            }

		}else{
			$validDate = FALSE;
		}


        if ($validDate)
        {
            return TRUE;
        } 
        else
        {
            $this->set_message('valid_dob', 'Please enter a valid date');
            return FALSE;
        }
	}
}