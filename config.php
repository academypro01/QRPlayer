<?php
ob_start();
// Set Time Zone
date_default_timezone_set("Asia/Tehran");

// Define Domain Name
define("DOMAIN_NAME", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));
define('ROOT_LINK', '');

// Define Root Path of This Directory
define("ROOTPATH", __DIR__.DIRECTORY_SEPARATOR);

// Define Directory Separator
define('DS', DIRECTORY_SEPARATOR);

// Define Salt
define('SALT','asdf654asdf-*+65ASDFASDf564234-*+6ertRRf65e-*65yiojkl+9665+6*98fgh65454548465fg4h5g4jh5h4gj6k5g4yhj654#$%^&$%^URDFGDFDFgdfghDRGHDRGHdfhDFGHDFGHDghDFgh65958-*/+95+5+654fg6h54fg6h54r6f5h4df64ghgfh654hj6,5l4jkl6;54op654[io[65]4op654;/l65.4jgj6m4ghj');

// Define Database Credential
define('DBS_SERVER','localhost');
define('DBS_USER', 'root');
define('DBS_PASS', '');
define('DBS_NAME','');




// set cookie flags
if(!isset($_SESSION)){  
    session_set_cookie_params(0, '/', DOMAIN_NAME, true, true);
    ini_set( 'session.cookie_httponly', 1 );
    @session_regenerate_id(true);  
    ob_start();  
    session_start();
    
} 