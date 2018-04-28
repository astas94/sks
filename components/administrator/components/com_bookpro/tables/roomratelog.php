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

		

class TableRoomRateLog extends JTable
{
	var $id;
	var $startdate;
	var $enddate;
    var $adult;
    var $child;
    var $adult_discount;
    var $child_discount;
    var $room_id;
		
	function __construct(& $db) 
	{
	  	parent::__construct('#__bookpro_roomratelog', 'id', $db);
	}
    function init()
    {
        $this->id = 0;
        $this->startdate= '';
        $this->enddate  = '';
        $this->room_id  = '';
    }	
}
?>
