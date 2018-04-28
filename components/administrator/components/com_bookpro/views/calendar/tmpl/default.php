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
JHtml::_('behavior.calendar');
$depart=JRequest::getVar('start','');

if(strlen($depart)>0){
	
$this->start=explode(';', $depart);
	
}

?>
<h2><?php echo JText::_('Departure date edit')?></h2>
<div class="button2-left">
<div class="blank">
<input type="button" value="Save dates" onclick="closeBoxContent()">
</div></div>
<table >
	<thead>
		<tr>
			<th>Depart date</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody id="departdate">
			
	</tbody>
</table>
<input type="button" onclick="addRow('departdate','');" name="addRow" id="addRow" value="Add date" />

<script type="text/javascript">
 	init();
	function init(){
	  <?php for ($i=0;$i<count($this->start);$i++) 
	   {
			echo "addRow('departdate','" . $this->start[$i]."');";
	   }
	  
	  ?>
      
	}
	
	function showCalendar(inputField){
		Calendar.setup({ inputField  : inputField,
				ifFormat    : '%Y-%m-%d', button      : "start_img",
				singleClick:true,dateStatusFunc  :   function (date) {
				var myDate = new Date();
				if (date.getTime() < myDate.setDate(myDate.getDate() - 1)) return true;
				},weekNumbers : true   });
	}
	var index = 0;
	function addRow(tableId,value){
		
		var table = document.getElementById(tableId);
		var rowCount = table.rows.length;
		
		var row = table.insertRow(rowCount);
		row.id = "row"+rowCount;
		var cell1 = row.insertCell(0);
		var cell2 = row.insertCell(1);
		cell1.innerHTML = '<input type="text" value="'+value+'" onclick="showCalendar('+"'fdate_id"+rowCount+"'"+')" id="fdate_id'+rowCount+'" name="fdate" title="" />';
		cell2.innerHTML = '<input type="button" onclick="deleteRow(this,'+"'departdate'"+')" id="delete'+rowCount+'" name="deleteRow" value="Delete" />';
		
		
	}
	function deleteRow(obj,tableId){
		 
			var table = document.getElementById(tableId);
			var rowCount = table.rows.length;
			
			var id = obj.id;
			id = parseInt(id.substr(6));
			table.deleteRow(id);
			
			if(id < rowCount - 1){
				for(var i = id;i < rowCount;i++){
					var row = table.rows[i];
					row.id = "row"+i;
					row.cells[1].childNodes[0].id = "delete"+i;
				}
			}
		 
	}
	function closeBoxContent(){
		//calculate the date
		var table = document.getElementById('departdate');
		var rowCount = table.rows.length;
		var result='';
		if( rowCount > 0){
			for(var i = 0;i < rowCount;i++){
				if(document.getElementById('fdate_id'+i).value) {
				 result=result+document.getElementById('fdate_id'+i).value+';';
				}
			}
			result=result.substr(0,result.length-1);
		}
		
		window.parent.setDepart(result);
		window.parent.SqueezeBox.close();
	} 
</script>
