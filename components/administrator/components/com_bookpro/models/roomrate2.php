<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: room.php 48 2012-07-13 14:13:31Z quannv $
 **/
defined('_JEXEC') or die('Restricted access');


class BookProModelRoomRate2 extends JModelAdmin
{
public function getForm($data = array(), $loadData = true)
	{
	
		$form = $this->loadForm('com_bookpro.bustrip', 'bustrip', array('control' => 'jform', 'load_data' => $loadData));
	
		if (empty($form))
			return false;
		return $form;
		}
		protected function loadFormData()
        {
            $data = JFactory::getApplication()->getUserState('com_bookpro.edit.bustrip.data', array());
            if (empty($data))
                $data = $this->getItem();
            return $data;
        }
	 
      

}

?>