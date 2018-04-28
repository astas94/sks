<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: customers.php 56 2012-07-21 07:53:28Z quannv $
 **/

defined('_JEXEC') or die('Restricted access');


class BookProModelCustomers extends JModelList
{

	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
					'id', 'a.id',
					'firstname', 'a.firstname',
					'lastname', 'a.lastname',
					'email', 'a.email',
					'a.created','created',
					'state',
			);
		}

		parent::__construct($config);
	}

	protected function populateState($ordering = null, $direction = null)
	{
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$active = $this->getUserStateFromRequest($this->context . '.filter.active', 'filter_active');
		$this->setState('filter.active', $active);

		$state = $this->getUserStateFromRequest($this->context . '.filter.state', 'filter_state');
		$this->setState('filter.state', $state);

		$groupId = $this->getUserStateFromRequest($this->context . '.filter.group', 'filter_group_id', null, 'int');
		$this->setState('filter.group_id', $groupId);


		$groups = json_decode(base64_decode($app->input->get('groups', '', 'BASE64')));

		if (isset($groups))
		{
			JArrayHelper::toInteger($groups);
		}

		$this->setState('filter.groups', $groups);

			
		// List state information.
		parent::populateState('a.firstname', 'asc');
	}

	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.state');

		return parent::getStoreId($id);
	}

	protected function getListQuery()
	{
		// Create a new query object.
		$db    = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
		$this->getState(
						'list.select',
						'a.*'
						)
						);

						$query->from($db->quoteName('#__bookpro_customer') . ' AS a');

						// If the model is set to check item state, add to the query.
						$state = $this->getState('filter.state');

						if (is_numeric($state))
						{
							$query->where('a.state = ' . (int) $state);
						}


						// Filter the items over the group id if set.

						$groupId = $this->getState('filter.group_id');
						if ($groupId!=0){
							if ($groupId!=-1)
							{
								$groups  = $this->getState('filter.groups');
								$query->join('LEFT', '#__users AS b ON b.id=a.user');
								$query->join('LEFT', '#__user_usergroup_map AS map2 ON map2.user_id = b.id')
								->group($db->quoteName(array('b.id', 'b.name', 'b.username', 'b.password', 'b.block', 'b.sendEmail', 'b.registerDate', 'b.lastvisitDate', 'b.activation', 'b.params', 'b.email')));
								$query->where('map2.group_id = ' . (int) $groupId);
							}else{
								$query->where('a.user IS NULL OR a.user = 0');
							}
						}

						// Filter the items over the search string if set.
						if ($this->getState('filter.search') !== '' && $this->getState('filter.search') !== null)
						{
							// Escape the search token.
							$search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($this->getState('filter.search')), true) . '%'));

							// Compile the different search clauses.
							$searches   = array();
							$searches[] = 'a.firstname LIKE ' . $search;
							$searches[] = 'a.lastname LIKE ' . $search;
							$searches[] = 'a.email LIKE ' . $search;

							// Add the clauses to the query.
							$query->where('(' . implode(' OR ', $searches) . ')');
						}

						// Add filter for registration ranges select list
						$range = $this->getState('filter.range');

						// Apply the range filter.
						if ($range)
						{
							// Get UTC for now.
							$dNow   = new JDate;
							$dStart = clone $dNow;

							switch ($range)
							{
								case 'past_week':
									$dStart->modify('-7 day');
									break;

								case 'past_1month':
									$dStart->modify('-1 month');
									break;

								case 'past_3month':
									$dStart->modify('-3 month');
									break;

								case 'past_6month':
									$dStart->modify('-6 month');
									break;

								case 'post_year':
								case 'past_year':
									$dStart->modify('-1 year');
									break;

								case 'today':
									// Ranges that need to align with local 'days' need special treatment.
									$app    = JFactory::getApplication();
									$offset = $app->get('offset');

									// Reset the start time to be the beginning of today, local time.
									$dStart = new JDate('now', $offset);
									$dStart->setTime(0, 0, 0);

									// Now change the timezone back to UTC.
									$tz = new DateTimeZone('GMT');
									$dStart->setTimezone($tz);
									break;
							}

							if ($range == 'post_year')
							{
								$query->where(
						'a.created < ' . $db->quote($dStart->format('Y-m-d H:i:s'))
								);
							}
							else
							{
								$query->where(
						'a.created >= ' . $db->quote($dStart->format('Y-m-d H:i:s')) .
						' AND a.created <=' . $db->quote($dNow->format('Y-m-d H:i:s'))
								);
							}
						}

						// Add the list ordering clause.
						$query->order($db->escape($this->getState('list.ordering', 'a.name')) . ' ' . $db->escape($this->getState('list.direction', 'ASC')));

						return $query;
	}

}

?>