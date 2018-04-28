<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: airport.php  23-06-2012 23:33:14
 **/

defined('_JEXEC') or die('Restricted access');

//import needed Joomla! libraries
jimport('joomla.application.component.model');
//import needed JoomLIB helpers
jimport('joomla.application.component.modeladmin');

class BookProModelAirport extends JModelAdmin
{
	var $_table;

	var $_ids;

	function __construct()
	{
		parent::__construct();
		if (! class_exists('TableAirport')) {
			AImporter::table('airport');
		}
		$this->_table = $this->getTable('airport');
	}
	public function getForm($data = array(), $loadData = true)
	{
	
		$form = $this->loadForm('com_bookpro.airport', 'airport', array('control' => 'jform', 'load_data' => $loadData));
		
		if (empty($form))
			return false;
		return $form;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see JModelForm::loadFormData()
	 */
	protected function loadFormData()
	{
		$data = JFactory::getApplication()->getUserState('com_bookpro.edit.airport.data', array());
		if (empty($data))
			$data = $this->getItem();
		return $data;
	}
	
	public function save($data)
	{
		$dispatcher = JEventDispatcher::getInstance();
		$table = $this->getTable();
		$input = JFactory::getApplication()->input;
		
		
		
		$pk = (!empty($data['id'])) ? $data['id'] : (int) $this->getState($this->getName() . '.id');
		$isNew = true;
	
		if ((!empty($data['tags']) && $data['tags'][0] != ''))
		{
			$table->newTags = $data['tags'];
		}
	
		
	
		// Load the row if saving an existing category.
		if ($pk > 0)
		{
			$table->load($pk);
			$isNew = false;
		}
	
		if ($table->parent_id != $data['parent_id'] || $data['id'] == 0)
		{
			$table->setLocation($data['parent_id'], 'last-child');
		}
	
		// Alter the title for save as copy
		if ($input->get('task') == 'save2copy')
		{
			list($title, $alias) = $this->generateNewTitle($data['parent_id'], $data['alias'], $data['title']);
			$data['title'] = $title;
			$data['alias'] = $alias;
			$data['state'] = 0;
		}
	
		// Bind the data.
		if (!$table->bind($data))
		{
			$this->setError($table->getError());
			return false;
		}
	
		// Bind the rules.
		if (isset($data['rules']))
		{
			$rules = new JAccessRules($data['rules']);
			$table->setRules($rules);
		}
	
		// Check the data.
		if (!$table->check())
		{
			$this->setError($table->getError());
			return false;
		}
	
		// Trigger the onContentBeforeSave event.
		$result = $dispatcher->trigger($this->event_before_save, array($this->option . '.' . $this->name, &$table, $isNew));
		if (in_array(false, $result, true))
		{
			$this->setError($table->getError());
			return false;
		}
	
		// Store the data.
		if (!$table->store())
		{
			$this->setError($table->getError());
			return false;
		}
	
		
	
		// Trigger the onContentAfterSave event.
		$dispatcher->trigger($this->event_after_save, array($this->option . '.' . $this->name, &$table, $isNew));
	
	
	
		// Rebuild the paths of the category's children:
		if (!$table->rebuild($table->id, $table->lft, $table->level))
		{
			$this->setError($table->getError());
			return false;
		}
	
		$this->setState($this->getName() . '.id', $table->id);
	
		// Clear the cache
		$this->cleanCache();
	
		return true;
	}
	public function saveorder($idArray = null, $lft_array = null)
	{
		// Get an instance of the table object.
		$table = $this->getTable();
	
		if (!$table->saveorder($idArray, $lft_array))
		{
			$this->setError($table->getError());
			return false;
		}
	
		// Clear the cache
		$this->cleanCache();
	
		return true;
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
	public function rebuild()
	{
		// Get an instance of the table object.
		$table = $this->getTable();
	
		if (!$table->rebuild())
		{
			$this->setError($table->getError());
			return false;
		}
	
		// Clear the cache
		$this->cleanCache();
	
		return true;
	}
	
	function prepareTable($table){
		
		
	}

	function getObject($id)
	{
			$query = 'SELECT `dest`.* FROM `' . $this->_table->getTableName() . '` AS `dest` ';
			
			$query .= 'WHERE `dest`.`id` = ' . $id;
			$this->_db->setQuery($query);

			if (($object = &$this->_db->loadObject())) {
				$this->_table->bind($object);
				return $this->_table;
			}
		
	}
	function getObjectFull($id){
		$query = 'SELECT `dest`.* FROM `' . $this->_table->getTableName() . '` AS `dest` ';
			
		$query .= 'WHERE `dest`.`id` = ' . $id;
		$this->_db->setQuery($query);
		$object = &$this->_db->loadObject();
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('country.*');
		$query->from('#__bookpro_country AS country');
		$query->where('country.id='.$object->country_id);
		$db->setQuery($query);
		$country = $db->loadObject();
		$object->country = $country;
		return $object;
	}



	
	
	function getFormFieldParent()
	{
		JForm::addFormPath(JPATH_COMPONENT_ADMINISTRATOR.'/models/forms'); // set destination directory of xml maniest
		$form = JForm::getInstance('com_bookpro.airport', 'airport', array('control' => '', 'load_data' => true)); // load xml manifest
		/* @var $form JForm */
		return $form->getInput('parent_id');
	}
  

}

?>