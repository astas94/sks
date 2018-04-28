<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: view.html.php 105 2012-08-30 13:20:09Z quannv $
 **/

defined('_JEXEC') or die('Restricted access');

AImporter::helper('bookpro','bus');

class BookProViewPrintTicket extends JViewLegacy
{
   	
    function display($tpl = null)
    {
        $mainframe = JFactory::getApplication();
        $input = $mainframe->input;
        $id = $input->get('id',0,'int');
        $return = $input->get('return',0,'int');
        parent::display($tpl);
      
	    }
 
   
   

	
	
}

?>