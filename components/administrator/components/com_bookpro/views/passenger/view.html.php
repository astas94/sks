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

AImporter::model('countries','cgroups');
AImporter::helper('bookpro', 'request');

class BookProViewPassenger extends JViewLegacy
{

	protected $form;
	protected $item;
	protected $state;
    function display($tpl = null)
    {
        $this->form		= $this->get('Form');
		$this->item		= $this->get('Item');
		$this->state	= $this->get('State');
		
		
		parent::display($tpl);
        //$this->_displayForm($tpl, $obj);
	    }
   
	
}

?>