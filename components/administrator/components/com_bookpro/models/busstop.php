<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: cgroup.php 14 2012-06-26 12:42:05Z quannv $
 **/

defined('_JEXEC') or die('Restricted access');


//import needed JoomLIB helpers


class BookProModelBusstop extends JModelAdmin
{
	public function getTable($type = 'Busstop', $prefix = 'Table', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_bookpro.busstop', 'busstop', array('control' => 'jbusstop', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}
	
		return $form;
	}
	
	/**
	 * (non-PHPdoc)
	 * 
	 * @see JModelForm::loadFormData()
	 */
	protected function loadFormData() {
		$data = JFactory::getApplication ()->getUserState ( 'com_bookpro.edit.busstop.data', array () );
		if (empty ( $data ))
			$data = $this->getItem ();
		return $data;
	}
	protected function populateState()
	{
		$table = $this->getTable();
		$key = $table->getKeyName();
	
		// Get the pk of the record from the request.
		 
		$pk = JFactory::getApplication()->input->getInt($key);
		
		$this->setState($this->getName() . '.id', $pk);
		
		 
	
		// Load the parameters.
		
	}
    
	public function publish(&$pks, $value = 1)
	{
		$user = JFactory::getUser();
		$table = $this->getTable();
		$pks = (array) $pks;
	
		// Attempt to change the state of the records.
		if (!$table->publish($pks, $value, $user->get('id')))
		{
			$this->setError($table->getError());
	
			return false;
		}
	
		return true;
	}
	function unpublish($cids){
		 
		return $this->state('state', $cids, 0, 1);
	}
      
}

?>