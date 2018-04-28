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

class AImporter
{

    /**
     * Import file by absolute path from component root. 
     *
     * @param string $base last directory contain files: helpers, models, elements ...
     * @param array $names files names without path and extensions
     * @param string extension without dot: php, html, ini ...
     */
    static function import($base, $names, $ext = 'php')
    {
        if (! is_array($names)) {
            $names = array($names);
        }
        $filePathMask = ADMIN_ROOT . DS . $base . DS . '%s.' . $ext;
        foreach ($names as $name) {
            AImporter::importFile(sprintf($filePathMask, $name));
        }
    }
    static function classes(){
    	
    }

    /**
     * Import file view.html.php from component view.
     * 
     * @param string $view view name, if empty use parameter from request
     */
   static function importView($view = null)
    {
        AImporter::importFile(AImporter::getViewBase($view) . 'view.html.php');
    }

    /**
     * Import template file from component view.
     * 
     * @param string $view view name, if empty use parameter from request
     * @param string $tpl template name, if empty use default.php
     */
   static function importTpl($view = null, $tpl = null)
    {
        AImporter::importFile(AImporter::getViewBase($view) . 'tmpl' . DS . ($tpl ? $tpl : 'default') . '.php');
    }

    /**
     * Get component view base directory.
     * 
     * @param string $view view name, if empty use parameter from request
     */
    function getViewBase($view = null)
    {
        return ADMIN_ROOT . DS . 'views' . DS . ($view ? $view : JRequest::getString('view')) . DS;
    }

    static function importFile($filePath, $error = true)
    {
        if (file_exists($filePath)) {
            include_once ($filePath);
        } elseif ($error) {
            JError::raiseError(500, 'File ' . $filePath . ' not found');
        }
    }

   

    /**
     * Import component controller. Current or default according to client position.
     * @return boolean true if successfully imported
     */
 	static  function controller($name = null)
    {
       $match = array();
    	if (preg_match('/^([a-z_]+)\.([a-z_]+)$/', JRequest::getString('task'), $match)) {
    		JRequest::setVar('controller', $match[1]);
    		JRequest::setVar('task', $match[2]);
    	}
        $cname = is_null($name) ? JRequest::getString('controller', 'controller') : $name;
        $cname = $cname ? $cname : 'controller';
        AImporter::import('controllers', $cname);
        return AImporter::getControllerName($name);
    }
    

    static function getControllerName($name = null)
    {
        $name = is_null($name) ? JRequest::getString('controller', '') : $name;
        return CONTROLLER . $name;
    }

    /**
     * Import component constants.
     */
    static function defines()
    {
        AImporter::importFile(JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_bookpro' . DS . 'defines.php');
    }
    
    

    /**
     * Import component helper.
     *
     * @param mixed $name file name without extension and path
     */
    static function helper($name)
    {
        $names = func_get_args();
        AImporter::import('helpers', $names);
    }
	

    /**
     * Import component model.
     *
     * @param mixed $name file name without extension and path.
     */
    static function model($name)
    {
        $names = func_get_args();
        AImporter::import('models', $names);
    }

    /**
     * Import component table.
     *
     * @param mixed $name file name without extension and path.
     */
   static function table($name)
    {
        $names = func_get_args();
        AImporter::import('tables', $names);
    }

   
    /**
     * Import component element.
     *
     * @param mixed $name file name without extension and path.
     */
    function element($name)
    {
        $names = func_get_args();
        AImporter::import('elements', $names);
    }

    /**
     * Link js source into html head.
     *
     * @param mixed $name file name without extension and path
     */
    
    static function link($type, $names)
    {
    	$absMask = SITE_ROOT . DS . 'assets' . DS . $type . DS . '%s.' . $type;
    	$langMask = SITE_ROOT . DS . 'assets' . DS . 'language' . DS . '%s.php';
    	$realMask = JURI::root() . 'components/' . OPTION . '/assets/' . $type . '/%s.' . $type;
    	foreach ($names as $name) {
    		$abs = sprintf($absMask, $name);
    		$real = sprintf($realMask, $name);
    		if (file_exists($abs)) {
    			$document = JFactory::getDocument();
    			switch ($type) {
    				case 'js':
    					$document->addScript($real);
    					AImporter::importFile(sprintf($langMask, $name), false);
    					break;
    				case 'css':
    					$document->addStyleSheet($real);
    			}
    		} else {
    			JError::raiseError(500, 'File ' . $name . ' not found');
    		}
    	}
    }
    static function js($name)
    {
        $names = func_get_args();
        AImporter::link('js', $names);
    }

    /**
     * Link css source into html head.
     *
     * @param mixed $name file name without extension and path
     */
   static  function css($name)
    {
        $names = func_get_args();
        AImporter::link('css', $names);
    }

    /**
     * Import style for CSS icon into HTML page head.
     * 
     * @param string $className
     * @param string $fileName
     */
  static  function cssIcon($className, $fileName)
    {
        $css = '.aIcon' . ucfirst($className) . ' {' . PHP_EOL;
        $css .= '    background: transparent url(' . IMAGES . $fileName . ') no-repeat scroll left center;' . PHP_EOL;
        $css .= '}' . PHP_EOL;
        $document = JFactory::getDocument();
        /* @var $document JDocument */
        $document->addStyleDeclaration($css);
    }


   
   
    static function jquery($cdn=true){
    	$document=&JFactory::getDocument();
    	if($cdn){
    		$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js');
    		$document->addScriptDeclaration('jQuery.noConflict();');
    		
    	}else
    	{
    		$document->addScript(JURI::root().'components/com_bookpro/assets/js/jquery.min.js');
    		$document->addScriptDeclaration('jQuery.noConflict();');
    		
    	}
    }
    
    static function jqueryui($cdn=true){
    	$document=&JFactory::getDocument();
    	if($cdn){
    		$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js');
    		$document->addScript('http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js');
    		$document->addScriptDeclaration('jQuery.noConflict();');
    
    	}else
    	{
    		$document->addScript(JURI::root().'components/com_bookpro/assets/js/jquery.min.js');
    		$document->addScript(JURI::root().'components/com_bookpro/assets/js/jquery-ui.min.js');
    		$document->addScriptDeclaration('jQuery.noConflict();');
    
    	}
    }
}

?>