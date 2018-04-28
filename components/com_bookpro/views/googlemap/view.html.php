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
jimport( 'joomla.application.component.view' );
class BookProViewGooglemap extends JView
{
	function display($tpl = null)
	{
		$this->config=AFactory::getConfig();
		$this->_prepare();
		parent::display($tpl);
	}
	private function _prepare(){
		$doc=JFactory::getDocument();
		$doc->setTitle($this->obj->title);
		
	}

	
}