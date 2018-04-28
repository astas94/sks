<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: application.php  23-06-2012 23:33:14
 **/

defined('_JEXEC') or die('Restricted access');

class TableApplication extends JTable
{

	var $id;
	var $title;
	var $desc;
	var $email_send_from;
	var $email_send_from_name;
	var $email_customer_body;
	var $email_customer_subject;
	var $email_admin;
	var $email_admin_body;
	var $email_admin_subject;
	var $success;
	var $failed;
	var $code;
	var $access;
	var $active;
	var $views;
	var $state;
	
	
	 
	/**
	 * Construct object.
	 *
	 * @param JDatabaseMySQL $db database connector
	 */
	function __construct(& $db)
	{
		parent::__construct('#__bookpro_application', 'id', $db);
	}

	/**
	 * Init empty object.
	 */
	function init()
	{
		$this->title='';
		$this->desc='';
		$this->email_send_from='';
		$this->email_send_from_name='';
		$this->email_customer_body="";
		$this->email_customer_subject="";
		$this->email_admin='';
		$this->email_admin_body='';
		$this->email_admin_subject='';
		$this->code='';
		$this->state=0;
		$this->views='';
		$this->access=0;
		$this->active=0;
	}
	
	function check(){
		
		return true;
	}
	
}

?>