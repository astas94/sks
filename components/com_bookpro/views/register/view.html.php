<?php

    /**
    * @package 	Bookpro
    * @author 		Ngo Van Quan
    * @link 		http://joombooking.com
    * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
    * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
    * @version 	$Id$
    **/

    defined('_JEXEC') or die('Restricted access');
    jimport( 'joomla.application.component.view' );
    class BookproViewRegister extends JViewLegacy
    {
        var $document=null;
        function display($tpl = null)
        {
            $this->document = JFactory::getDocument();
            $user=JFactory::getUser();
            $config = JComponentHelper::getParams('com_bookpro');

            if($user->id && in_array($config->get('supplier_usergroup'),$user->groups)){

                JFactory::getApplication()->redirect(JUri::base().'index.php?option=com_bookpro&view=supplierpage&Itemid='.JRequest::getVar('Itemid'));
            }
            $this->document->setTitle(JText::_('COM_BOOKPRO_REGISTER_VIEW'));

            parent::display($tpl);
        }


    }

?>
