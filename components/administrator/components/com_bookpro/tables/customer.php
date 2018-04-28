<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: customer.php 80 2012-08-10 09:25:35Z quannv $
 **/
defined('_JEXEC') or die('Restricted access');

class TableCustomer extends JTable
{
  
    var $id;
    
    var $gender;
    var $firstname;
    var $lastname;
    var $address;
    var $email;
    var $telephone;
    var $mobile;
   
    var $fax;
    var $city;
    var $country_id;
    var $zip;
    var $birthday;
    var $states;
    var $state;
    var $billing_address;
    var $checked_out;
    var $checked_out_time;
	var $user;
	var $created;
	var $referral_id;
	var $cgroup_id;
	var $card_token;
	
    
    function __construct(& $db)
    {
        parent::__construct('#__' . PREFIX . '_customer', 'id', $db);
    }

 
   
    function check(){
    	AImporter::helper('date');
    	$date = JFactory::getDate('now');
    	$this->created=$date->toSql();
    	return true;
    }
}

?>