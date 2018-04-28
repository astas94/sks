<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: bus.php  23-06-2012 23:33:14
 **/
defined('_JEXEC') or die('Restricted access');

class TableSeattemplate extends JTable
{
  
    var $id;
    var $title;
    var $block_layout;  
   
    /**
     * Construct object.
     * 
     * @param JDatabaseMySQL $db database connector
     */
    function __construct(& $db)
    {
        parent::__construct('#__' . PREFIX . '_bus_seattemplate', 'id', $db);
    }

    /**
     * Init empty object.
     */
    function init()
    {
        $this->id = 0;
        $this->title = '';
        $this->block_layout = 1;
              
    }
    function check(){
    	if (!$this->id) {
    		
    	}
    	if($this->id){
    		
    	}
    	return true;
    }
    
}

?>