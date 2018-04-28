<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: bookpro.php 27 2012-07-08 17:15:11Z quannv $
 **/
defined('_JEXEC') or die('Restricted access');



if (! class_exists('JForm'))
    jimport('joomla.html.jform');

class AParameter extends JForm
{
    
    /**
     * Image base 
     * 
     * @var string
     */
    var $images;

    /**
     * Construct object.
     * 
     * @param $data
     * @param $path
     */
    function __construct($data, $path = null, &$xml = null)
    {
        $this->images = JURI::root() . 'components/' . OPTION . '/assets/images/';
       parent::__construct('form');
        if ($xml) {
            $this->load($xml);
        }
    }

   

    /**
     * Get toolbar image as only info icon or button with javascript onclick event function.
     * 
     * @param boolean $icon add image or empty div
     * @param string $name name of image and tool
     * @param int $id property ID 
     * @param string $function javascript event function
     * @return string HTML code
     */
    function tool($icon, $name, $id = null, $function = null)
    {
        $image = $this->getToolImage($name);
        $id = $id ? (' id="icon-' . $name . '-' . $id . '" ') : '';
        if ($icon) {
            $uname = ucfirst($name);
            $function = $function ? (' onclick="' . $function . ';" ') : '';
            $class = $function ? 'tool' : 'icon';
            return '<img src="' . $image . '" alt="' . $uname . '"' . $function . ' class="' . $class . '"' . $id . '/>';
        } else {
            return '<div class="emptyIcon"' . $id . '>&nbsp;</div>';
        }
    }

    /**
     * Get tool image full path.
     * 
     * @param string $name
     * @return string
     */
    function getToolImage($name)
    {
        return $this->images . 'icon-16-' . $name . '.png';
    }

    /**
     * Get main table toolbar table.
     * 
     * @return string HTML code
     */
    function toolbar()
    {
        $bar = &JToolBar::getInstance('template-properties');
        /* @var $bar JToolBar */
        $bar->appendButton('Link', 'new', 'New', 'javascript:ATemplate.add()');
        $bar->appendButton('Link', 'delete', 'Delete', 'javascript:ATemplate.trash(\'all\',true)');
        return $bar->render();
    }

    /**
     * Get toolbar button.
     * 
     * @param string $name tool name
     * @param string $function javascript onclick event function
     * @return array parts of HTML code
     */
 	function button($name, $function)
    {
        $html = array();
        $html[] = '<td class="button">';
        $html[] = '<a class="toolbar" href="javascript:' . $function . '">';
        $html[] = '<span class="icon-32-' . $name . '" title="' . ucfirst($name) . '">&nbsp;</span>';
        $name = JString::ucfirst($name);
        $html[] = JText::_($name);
        $html[] = '</a>';
        $html[] = '</td>';
        return $html;
    }

    /**
     * Load param.
     * 
     * @param JSimpleXMLElement $node param node
     * @param string $control_name param name
     * @param string $group param group
     * @return array param values
     */
    function getParam(&$node, $control_name = 'params', $group = '_default')
    {
        $type = $node->attributes('type');
        $type = str_replace('mos_', '', $type);
        $value = $this->get($node->attributes('name'), $node->attributes('default'), $group);
        switch ($type) {
            case 'checkbox':
                $param = &$this->renderCheckBox($node, $value, $control_name);
                break;
            case 'radio':
                $param = &$this->renderRadio($node, $value, $control_name);
                break;
            default:
                $element = &$this->loadElement($type);
                $param = &$element->render($node, $value, $control_name);
                break;
        }
        $param[] = $node->attributes('searchable');
        $param[] = $node->attributes('filterable');
        $param[] = $node->attributes('type');
        $param[] = $value;
        $param[] = $node->attributes('icon');
        $param[] = $node;
        return $param;
    }

    /**
     * Render check box.
     * 
     * @param JSimpleXMLElement $node param node
     * @param mixed $value param value
     * @param string $control_name param name
     * @return array
     */
    function renderCheckBox(&$node, $value, $control_name)
    {
        $param = array();
        
        $name = $node->attributes('name');
        $label = $node->attributes('label');
        
        $nodeName = $control_name . '[' . $name . ']';
        $nodeId = $control_name . $name;
        
        $param[] = '<label id="' . $nodeId . '-lbl" for="' . $nodeId . '">' . $label . '</label>';
        $param[] = '<input type="hidden" name="' . $nodeName . '" value="0"/><input type="checkbox" class="inputCheckbox" name="' . $nodeName . '" id="' . $nodeId . '" value="1" ' . (((int) $value == 1) ? 'checked="checked"' : '') . '/>';
        $param[] = '';
        $param[] = $label;
        $param[] = $value;
        $param[] = $name;
        
        return $param;
    }

    /**
     * Render radio buttons list.
     * 
     * @param JSimpleXMLElement $node param node
     * @param mixed $value param value
     * @param string $control_name param name
     * @return array
     */
    function renderRadio(&$node, $value, $control_name)
    {
        static $id;
        if (is_null($id)) {
            $id = 0;
        }
        $param = array();
        
        $name = $node->attributes('name');
        $label = $node->attributes('label');
        
        $nodeName = $control_name . '[' . $name . ']';
        $nodeId = $control_name . $name;
        
        $param[] = '<label id="' . $nodeId . '-lbl">' . $label . '</label>';
        
        $options = &$node->children();
        $count = count($options);
        $values = '';
        for ($i = 0; $i < $count; $i ++) {
            /* @var $option JSimpleXMLElement */
            $option = &$options[$i];
            $optionValue = $option->attributes('value');
            $id ++;
            $values .= '<input type="radio" class="inputRadio" name="' . $nodeName . '" id="radio' . $id . '" value="' . htmlspecialchars($optionValue) . '"';
            if ($value == $optionValue)
                $values .= ' checked="checked" ';
            $values .= '/><label for="radio' . $id . '" style="float: left">' . $optionValue . '</label>';
        }
        $param[] = $values;
        $param[] = '';
        $param[] = $label;
        $param[] = $value;
        $param[] = $name;
        return $param;
    }

    /**
     * Load component main params configuration.
     * @return JParameter
     */
    function loadComponentParams()
    {
        static $params;
        if (is_null($params)) {
            $db = &JFactory::getDBO();
            /* @var $db JDatabaseMySQL */
                     
            $db->setQuery('SELECT * FROM `#__bookpro_config`');
            $data = $db->loadAssocList('key','value');

            if(!$data)
            {
            	//no config values in the db
            	//JError::raiseWarning(0, "Config values wasn't loaded from database");
            	JLog::add("Config values wasn't loaded from database",JLog::DEBUG);
            }
            $params = new JRegistry($data);
        }
        return $params;
    }

    /**
     * Get component manifest data.
     * 
     * 
     */
    function getComponentInfo()
    {
        static $data;
        if (is_null($data)) {
            $data = &JApplicationHelper::parseXMLInstallFile(MANIFEST);
        }
        return $data;
    }
}

?>