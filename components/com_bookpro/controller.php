<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: controller.php 129 2012-09-10 04:34:01Z quannv $
 **/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controller library
AImporter::helper('bookpro');
/**
 * Hello World Component Controller
*/
class BookProController extends JControllerLegacy
{
	
	public function BookProController(){
		parent::__construct();
	}

	public function display($cachable = false, $urlparams = false)
	{
		// Get the document object.
		$document	= JFactory::getDocument();

		// Set the default view name and format from the Request.
		$vName	 = JRequest::getCmd('view', 'login');
		
		$user = JFactory::getUser();
		switch ($vName) {
			case 'profile':

				// If the user is a guest, redirect to the login page.

				if ($user->get('guest') == 1) {
					$return = 'index.php?option=com_bookpro&view=profile';
					$url    = 'index.php?option=com_bookpro&view=login';
					$url   .= '&return='.urlencode(base64_encode($return));
					$this->setRedirect(JRoute::_($url), false);
					return;
				}
				break;

			case 'mypage':

				// If the user is a guest, redirect to the login page.
				if ($user->get('guest') == 1) {
					$return = 'index.php?option=com_bookpro&view=mypage';
					$url    = 'index.php?option=com_bookpro&view=login';
					$url   .= '&return='.urlencode(base64_encode($return));
					$this->setRedirect(JRoute::_($url), false);
					return;
				}
				break;
			case 'driverreport':
				
				if ($user->get('guest') == 1) {
						
					$return = 'index.php?option=com_bookpro&view=driverreport';
					$url    = 'index.php?option=com_users&view=login';
					$url   .= '&return='.urlencode(base64_encode($return));
					$this->setRedirect(JRoute::_($url), false);
					return;
				}
				break;
			case 'agentpage':
			
				// If the user is a guest, redirect to the login page.
				
				if ($user->get('guest') == 1) {
					
					$return = 'index.php?option=com_bookpro&view=agentpage';
					$url    = 'index.php?option=com_users&view=login';
					$url   .= '&return='.urlencode(base64_encode($return));
					$this->setRedirect(JRoute::_($url), false);
					return;
				}
				break;
			case 'login':
				if(!$user->get('guest')){
					$return=JRequest::getVar('return');
					$this->setRedirect(base64_decode($return));
				}
				break;

		}
		
		JRequest::setVar('view', $vName);
		parent::display();

	}
	

	
	function listdestination()
	{

		$desfrom=JRequest::getVar( 'desfrom',0);
		$model = $this->getModel('BookPro');
		$dests = $model->getToAirportByFrom($desfrom);
		$return = "<?xml version=\"1.0\" encoding=\"utf8\" ?>";
		$return .= "<options>";
		$return .= "<option id='0'>".JText::_( 'TO' )."</option>";
		if(is_array($dests)) {
			foreach ($dests as $dest) {
				$return .="<option id='".$dest->key."'>".JText::_($dest->value)."</option>";
			}
		}
		$return .= "</options>";
		echo $return;
		//$mainframe->close();
	}
	
	function js() {
		header('Content-type: text/javascript');
		require_once( JPATH_COMPONENT_SITE.'/assets/js/master.js');
		die();
	}


	



}
