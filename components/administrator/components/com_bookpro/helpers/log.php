<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: bookpro.php 27 2012-07-08 17:15:11Z quannv $
 **/
defined('_JEXEC') or die('Restricted access');

class JBLog
{
	const DEFAULT_CATEGORY = 'booking';
	
	/**
	 * The global JBLog instance.
	 * @var    JBLog
	 */
	protected static $instance;
	
	/**
	 * Returns a reference to the a JBLog object, only creating it if it doesn't already exist.
	 * Note: This is principally made available for testing and internal purposes.
	 *
	 * @param   JBLog  $instance  The logging object instance to be used by the static methods.
	 * @return  void
	 */
	public static function setInstance($instance)
	{
		if (($instance instanceof JBLog) || $instance === null)
		{
			self::$instance = & $instance;
		}
	}
	
	public static function init($debug = true)
	{
		$categories = array(self::DEFAULT_CATEGORY);
		JLog::addLogger(array('text_file' => 'jb_emergency.php'),JLog::EMERGENCY,$categories);
		
		if($debug)
		{		
			// log every type of exception ind different file.
			JLog::addLogger(array('text_file' => 'jb_alert.php'),JLog::ALERT,$categories);
			JLog::addLogger(array('text_file' => 'jb_critical.php'),JLog::CRITICAL,$categories);
			JLog::addLogger(array('text_file' => 'jb_error.php'),JLog::ERROR,$categories);
			
		}
	}
	
	/**
	 * Method to add an exception message to the log with short debug.
	 *
	 * @param   Exception    $e
	 * @param   integer  $priority  Message priority.
	 * @param   int   $limit  number of showed
	 *
	 * @return  void
	 */
	public static function addException(Exception $e, $priority = JLog::ERROR, $limit = 2)
	{ 	
		static $logged;
		if( !isset($logged) )
			$logged = array();
		
    	//memory usage improve
    	if (version_compare(phpversion(), "5.4.0", ">="))
    		$deb = debug_backtrace(false, $limit);
    	else
    		$deb = debug_backtrace(false);
    	 
    	$message = $e->getMessage().' :|: ';
    	//create hash for error message and priority 
    	$hash = md5($message.$priority);
    	
    	//gal last n function calls from debug
    	for($i = $limit; $i > 0; $i--)
    	{
    		if($i != $limit)
    			$message .=	' -> ';
	    	if(array_key_exists($i,$deb))
	    		$message .= $deb[$i]['file'].':: '.$deb[$i]['line'].':'.$deb[$i]['function'].'()';
	    }
    	
	    //if message is new, log it
	    if(!array_key_exists($hash,$logged))
	    {
	    	$logged[$hash] = true;
	    	JBLog::add($message, $priority);
	    }
    }
    
    /**
     * Method to add an entry to the log.
     *
     * @param   mixed    $entry     The JLogEntry object to add to the log or the message for a new JLogEntry object.
     * @param   integer  $priority  Message priority.
     * @param   string   $category  Type of entry
     * @param   string   $date      Date of entry (defaults to now if not specified or blank)
     *
     * @return  void
     */
    public static function add($entry, $priority = JLog::ERROR, $category = JBLog::DEFAULT_CATEGORY, $date = null)
    {
    	JLog::add($entry, $priority, $category, $date);
    }
}

?>