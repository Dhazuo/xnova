<?php

class logoutController {
    
    private static $instance;
    
    private function __construct() {
        session_destroy();
        unset($_SESSION);
        header('location: ?core=index');
    }
    
    public static function xnova() {
        if(!self::$instance instanceof self) {
            self::$instance = new self;
        } 
        return self::$instance;
    }
}

?>