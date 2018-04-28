<?php 
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: bookpro.php 27 2012-07-08 17:15:11Z quannv $
 **/

defined ( '_JEXEC' ) or die ();

class modBusHelper {
	static function createDestinationSelectBox( $selected,$att='') {
		
		$db = JFactory::getDbo();
		
		$subQuery = $db->getQuery ( true );
		$subQuery->select ( 'p.adult' );
		$subQuery->from ( '#__bookpro_roomrate AS p' );
		$subQuery->where ( $db->qn('date').' >= ' . $db->quote ( JFactory::getDate ()->toSql () ) );
		$subQuery->where ( 'p.room_id=t.id' );
		$subQuery->order ( 'p.adult asc limit 0,1' );
		
		
		$query = $db->getQuery(true);
		//$query->select(array ('d.id,d.title,(' . $subQuery . ') AS price'));
		//$query->select(array('d.id,d.title'));
		$query->select(array ('d.id,d.title'));
		
		$query->from($db->quoteName('#__bookpro_dest').  ' AS d');
		//$query->where->append('EXISTS ('.$subQuery.')');
		$query->innerJoin('#__bookpro_bustrip AS t on t.from=d.id');
		$query->where('d.state=1','t.state=1')->append('EXISTS ('.$subQuery.')');;
		$query->order('d.title ASC');
		//$query->having('price > 0');
		$query->group('d.id');
		$sql = (string)$query;
		$db->setQuery($sql);
		$dest = $db->loadObjectList();
		
		//echo $query->dump();
		//die;
		
		$options = array();
		foreach($dest as $des)
		{
			$options[] = JHtml::_('select.option', $des->id, $des->title);
		}
			
		$option = JHtml::_ ( 'select.option', '', JText::_ ( "MOD_JBBUS_BUS_FROM" ) );
		array_unshift ( $options, $option );
		$select = JHtml::_ ( 'select.genericlist', $options, 'filter_from', $att, 'value', 'text', $selected, false );
		return $select;
	}
	
	public static function getArrivalDestination($field, $selected, $from) {
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->select ( 'f.`to` AS `key` ,`d2`.`title` AS `value`' );
		$query->from ( '#__bookpro_bustrip AS f' );
		$query->leftJoin ( '#__bookpro_dest AS d2 ON f.to =d2.id' );
		$query->where ( array (
				'f.from=' . $from,
				'f.state=1'
		) );
		$query->group ( 'f.to' );
		$query->order ( 'value' );
		$sql = ( string ) $query;
		$db->setQuery ( $sql );
		$flight = $db->loadObjectList ();
	
		if (! $flight) {
			$temp = new stdClass ();
			$temp->key = '';
			$temp->value = JText::_ ( 'MOD_JBBUS_BUS_TO' );
			$flight [] = $temp;
		}
	
		$select = JHtml::_ ( 'select.genericlist', $flight, $field, 'class="input-medium" size="1"', 'key', 'value', $selected, false );
		return $select;
	}
	
	static function getRadio($name,$required ,$selected,$id){
		
			$html = array();
		
			// Initialize some field attributes.
			$class     = 'class="radio btn-group"' ;
			$required  = $required? ' required aria-required="true"' : '';
		
			// Start the radio field output.
			$html[] = '<fieldset id="' . $id . '"' . $class . $required . ' >';
		
			
			$object=new JObject();
			$object->value="1";
			$object->text="roundtrip";
			$options[] =$object;
			
			$object=new JObject();
			$object->value="0";
			$object->text="Oneway";
			$options[] =$object;
		
			// Build the radio field output.
			foreach ($options as $i => $option)
			{
				// Initialize some option attributes.
				$checked = ((string) $option->value == (string) $selected) ? ' checked="checked"' : '';
				$class = !empty($option->class) ? ' class="' . $option->class . '"' : '';
		
				$html[] = '<input type="radio" id="' . $id . $i . '" name="' . $name . '" value="'
						. htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8') . '"' . $checked . $class . $required . ' />';
		
				$html[] = '<label for="' . $id . $i . '"' . $class . ' >'
						. JText::alt($option->text, preg_replace('/[^a-zA-Z0-9_\-]/', '_', true)) . '</label>';
		
				$required = '';
			}
		
			// End the radio field output.
			$html[] = '</fieldset>';
		
			return implode($html);
		}
		
		
	
	
}
?>
