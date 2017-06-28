<?php
ini_set('date.timezone','Asia/Shanghai'); 
include($com_contact.'/log4php/php/Logger.php');
Logger::configure($com_contact.'/log4php/config.xml');
 
/**
 * This is a classic usage pattern: one logger object per class.
 */
class Foo
{
    /** Holds the Logger. */
    private $log;
 
    /** Logger is instantiated in the constructor. */
    public function __construct()
    {
        // The __CLASS__ constant holds the class name, in our case "Foo".
        // Therefore this creates a logger named "Foo" (which we configured in the config file)
        $this->log = Logger::getLogger(__CLASS__);
    }
 
    /** Logger can be used from any member method. */
    public function info($str)
    {
        $this->log->debug($str);
    }
}


?>