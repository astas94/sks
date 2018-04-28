<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id$
 **/
defined('_JEXEC') or die('Restricted access');

class BookProControllerRefund extends JControllerLegacy{
	public function display($cachable = false, $urlparams = array())
	{
		$vName	 = JRequest::getCmd('view', 'refund');
		
		JRequest::setVar('view', $vName);
		parent::display();
	}

}