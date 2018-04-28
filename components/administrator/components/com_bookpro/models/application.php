<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: application.php  23-06-2012 23:33:14
 **/
defined('_JEXEC') or die('Restricted access');

// //import needed Joomla! libraries
// jimport('joomla.application.component.model');
// //import needed JoomLIB helpers
AImporter::helper('bookpro', 'model');
// //import needed tables

class BookProModelApplication extends JModelAdmin
{
	protected $text_prefix = 'COM_BOOKPRO';
	
	public function getTable($type = 'Application', $prefix = 'Table', $config=array()){
		return JTable::getInstance($type, $prefix, $config);
	}
	
	public function getForm($data = array(), $loadData = true){
		$app = JFactory::getApplication();
		//get data from Form
		$form = $this->loadForm('com_bookpro.application','application', array('control'=> 'jform', 'load_data'=>$loadData));
		if (empty($form)){
			return false;
		}
	
		return $form;
	}
	
	protected function loadFormData(){
		$data = JFactory::getApplication()->getUserState('com_bookpro.edit.application.data', array());
	
		if(empty($data)){
			$data = $this->getItem();
		}
	
		return $data;
	}
	


	function getObjectByCode($code)
	{	
			$db = $this->getDbo();
			$tablename = $db->quoteName('#__bookpro_application');
			$query = 'SELECT * FROM '. $tablename . ' AS obj ';
			$query .= 'WHERE UPPER(obj.code) = "' . strtoupper($code) .'"';
			
			$db->setQuery($query);
			
		
		return $db->loadObject();
	}



	 

}

?>