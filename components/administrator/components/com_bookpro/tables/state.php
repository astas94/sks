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

class TableState extends JTable
{
  
   var $id;
	var $country_id = null;
	var $state_name = null;
	var $state_3_code = null;
	var $state_2_code = null;
	var $state	= null;
   
    /**
     * Construct object.
     * 
     * @param JDatabaseMySQL $db database connector
     */
    function __construct(& $db)
    {
        parent::__construct('#__bookpro_state', 'id', $db);
    }
 function init()
    {
        $this->id = 0;
        $this->country_id = '';
        $this->state=1;
              
    }
}
?>
