<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: view.html.php 47 2012-07-13 09:43:14Z quannv $
 **/

defined('_JEXEC') or die('Restricted access');

AImporter::helper('bookpro','bus','date','paystatus');
AImporter::model('agents');

class BookProViewBusFilter3 extends JViewLegacy
{
	protected $items;

	protected $pagination;

	protected $state;
	
	function display($tpl = null)
	{

		$this->state		= $this->get('State');
		if($this->state->get('filter.depart_date')){
		$this->items		= $this->get('Items');
		}else {
			$this->items=array();
		}

		$this->pagination	= $this->get('Pagination');
		$select=$this->state->get('filter.pay_status');
		//$this->pay_status= AHtml::getFilterSelect('filter_pay_status',JText::_('COM_BOOKPRO_ORDER_PAY_STATUS'), PayStatus::$map, $select, false, 'class="input"', 'value', 'text');
		$this->agentbox=$this->getAgentSelectBox($this->state->get('filter.agent_id'));

        //echo("test1test");
        //var_dump ($this->items);
		parent::display($tpl);
        //echo("test2test");

	}

	function getAgentSelectBox($select){

		$model = new BookProModelAgents();
		$fullList = $model->getItems();

		return AHtml::getFilterSelect('filter_agent_id', JText::_('COM_BOOKPRO_SELECT_AGENT'), $fullList, $select, false, 'class="input-medium"', 'id', 'company');
	
	}

	
}

jimport( 'joomla.html.toolbar.button.link' );

class JToolbarButtonLinkext extends JToolbarButtonLink
{
	protected  $_name = 'Linkext';

	public function fetchButton( $type='Linkext', $name = 'back', $text = '', $url = null )
	{
		
		$text   = JText::_($text);
		$class  = $this->fetchIconClass($name);
		$doTask = $this->_getCommand($url);
		
		?>
		
		<button onclick="window.open('<?php echo $doTask; ?>','_blank');" class="btn btn-small">
			<span class="<?php echo $class; ?>"></span>
				<?php echo $text; ?>
		</button>
		
		<?php 

		
	}
	public function fetchId($type = 'Link', $name = '')
	{
		return $this->_parent->getName() . '-' . $name;
	}
}

?>