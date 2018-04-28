<?php
/**
 * @version     1.0.0
 * @package     com_bookpro
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Ngo <quannv@gmail.com> - http://joombooking.com
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Bus controller class.
 */
class BookproControllerBus extends JControllerForm
{

    function __construct() {
        $this->view_list = 'buses';
        parent::__construct();
    }
    
 

}