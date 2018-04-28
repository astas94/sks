<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: applications.php  23-06-2012 23:33:14
 **/

defined('_JEXEC') or die('Restricted access');

class BookProModelApplications extends JModelList
{
	public function __construct($config =array()){
		if (empty($config['filter_fields'])){
			$config['filter_fields'] = array(
					'id', 'a.id',
					'title', 'a.title',
					'code', 'a.code',
					'state', 'a.state',
			);
		}
	
		parent::__construct($config);
	}
	protected function populateState($ordering = null, $direction =	null)
	{
	
		
		parent::populateState('a.title', 'ASC');
	
	
	}
	public function getData(){
		$db = $this->getDbo();
		
		$query = $this->getListQuery();
		$db->setQuery($query);
		$result = $db->loadObjectList();
		
		return $result;
		
	}
	protected function getListQuery(){
	
		$db = $this->getDbo();
		$query = $db->getQuery(true);
	
		$query->select('a.*');
		$query->from($db->quoteName('#__bookpro_application') . ' AS a');
	
		$orderCol = $this->state->get('list.ordering');
		$orderDirn = $this->state->get('list.direction');
		if (empty($orderCol)|| empty($orderDirn))
		{
			$orderCol='a.title';
			$orderDirn='ASC';
		}
		$query->order($db->escape($orderCol.' '.$orderDirn));
		
		return $query;
	
	}
}

?>