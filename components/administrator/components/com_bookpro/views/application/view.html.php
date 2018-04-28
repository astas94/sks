<?php
/** * @package 	Bookpro * @author 		Ngo Van Quan * @link 		http://joombooking.com * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html * @version 	$Id: tours.php 21 2012-07-06 04:06:17Z quannv $ **/
defined('_JEXEC') or die('Restricted access');

// //import needed Joomla! libraries
// jimport('joomla.application.component.view');
// //import needed models
//AImporter::model('categories');
// //import needed JoomLIB helpers
// AImporter::helper('bookpro', 'request');
class BookProViewApplication extends JViewLegacy
{	protected $item;	protected $form;		public function display($tpl=null){		$this->item = $this->get('Item');		$this->form = $this->get('Form');			if (count($errors = $this->get('Errors'))){			JError::raiseError(500, implode("\n", $errors));			return false;		}			$this->addToolbar();		parent::display($tpl);	}		protected function addToolbar(){		JFactory::getApplication()->input->set('hidemainmenu', true);		$edit		= $this->item->id;		$text = !$edit ? JText::_( 'JTOOLBAR_NEW' ) : JText::_( 'JACTION_EDIT' );		JToolbarHelper::title(JText::_('COM_BOOKPRO_APPLICATION_MANAGER').': '.$text);		JToolbarHelper::apply('application.apply');		JToolbarHelper::save('application.save');			if(empty($this->item->id)){			JToolbarHelper::cancel('application.cancel');		}		else{			JToolbarHelper::cancel('application.cancel', 'JTOOLBAR_CLOSE');		}		}
   	

   

    
}

?>