<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  Time zone set
 */

date_default_timezone_set('Asia/Kolkata');

/**
 * Email Config
 */

$config['email_sender_name']  = 'Sender Name';
$config['email_sender_email'] = 'sender@gmail.com';

/**
 * Login Config
 */

$config['login_restrict']         = true;
$config['login_restrict_minutes'] = 10;
$config['login_max_attempt'] = 5;

/**
 * Pagination
 */

$config['number_of_items'] = 1; 