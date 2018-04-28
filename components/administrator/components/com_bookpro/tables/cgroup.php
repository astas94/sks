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

class TableCGroup extends JTable
{
  
    var $id;
    var $title;
    var $desc;
    var $state;
	var $discount;
    
    function __construct(& $db)
    {
        parent::__construct('#__' . PREFIX . '_cgroup', 'id', $db);
    }

    /**
     * Init empty object.
     */
    function init()
    {
       
    }
   
    function check(){
    	
    	return true;
    }
}

?>