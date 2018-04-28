<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: airport.php 66 2012-07-31 23:46:01Z quannv $
 **/


defined('_JEXEC') or die('Restricted access');

//import needed JoomLIB helpers
jimport('joomla.application.component.controller');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.archive');
jimport('joomla.filesystem.path');
class BookProControllerUpdate extends JControllerLegacy
{
    
	function update(){
		
		jimport( 'joomla.installer.helper' );
		JLog::addLogger(array('text_file' =>'update.txt','text_file_path'=>'logs'),JLog::ALL);
		
		$url = JPATH_ROOT.'/components/com_bookpro/install/update.sql';
		$extractdir = JPATH_ROOT.'/components/com_bookpro/install';
		if (JFile::exists($url)){
			$db = JFactory::getDBO();
			$lines = file($extractdir."/update.sql");
			$fullline = implode(" ", $lines);
			$queryes = $db->splitSql($fullline);
			
			foreach($queryes as $query){
				if (trim($query)!=''){
					$db->setQuery($query);
					$db->query();
					if ($db->getErrorNum()) {
						JError::raiseWarning( 500, $db->stderr() );
						
						JLog::add(JText::_('Update:').$db->stderr(), JLog::DEBUG);
					}
				}
			}
		}
		$this->setRedirect('index.php?option=com_bookpro');
	}

}

?>