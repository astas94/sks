<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: airline.php 14 2012-06-26 12:42:05Z quannv $
 **/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modeladmin');

class BookProModelRefund extends JModelAdmin
{
   
 	public function getForm($data = array(), $loadData = true)
        {

            $form = $this->loadForm('com_bookpro.refund', 'refund', array('control' => 'jform', 'load_data' => $loadData));
            
            if (empty($form))
                return false;
            return $form;
        }
    protected function loadFormData()
        {
        	$data = JFactory::getApplication()->getUserState('com_bookpro.edit.refund.data', array());
        	if (empty($data))
        		$data = $this->getItem();
        	return $data;
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
        	die();
            return $this->state('state', $cids, 0, 1);
        }

      
}

?>