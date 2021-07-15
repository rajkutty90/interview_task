<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class AN_Captcha extends CI_Model {

    /**
     * function to generate random captacha
    */

    public function create_capcha(){
       
        $this->load->helper(['captcha']);

        $vals = array(
                        'img_path'      => './captcha_images/',
                        'img_url'       => base_url().'captcha_images/',
                        'font_path'     => './path/to/fonts/texb.ttf',
                        'img_width'     => '150',
                        'img_height'    => 30,
                        'expiration'    => 7200,
                        'word_length'   => 8,
                        'font_size'     => 16,
                        'img_id'        => 'Imageid',
                        'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
                
                        // White background and border, black text and red grid
                        'colors'        => array(
                                'background' => array(255, 255, 255),
                                'border' => array(255, 255, 255),
                                'text' => array(0, 0, 0),
                                'grid' => array(255, 40, 40)
                        )
                );

        $captcha = create_captcha($vals);     
        $this->session->set_userdata('captcha_word', $captcha['word']);        

        return $captcha;        

    }

}