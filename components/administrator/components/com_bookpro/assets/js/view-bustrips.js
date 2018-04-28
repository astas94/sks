
function searchByFillter()
{
	$=jQuery;
	var numberitem=0;
	$('.search_items .items .item').each(function(index) {
		numberitem++;
		data_bustype=$(this).attr('data_bustype');
		var classshow=data_bustype;
		if(classshow=='sleeper')
		{
			classshow='seat_sleeper';
		}
		$('.bus-list .busitem').each(function(index) {
			if($(this).hasClass(classshow))
			{
				$(this).show();
			}
			else
			{
				$(this).hide();
				$(this).next().hide();
			}
		});
	});
	if(numberitem==0)
	{
		$('.bus-list .busitem').show();
	}
	
}
jQuery(document).ready(function($) {
	
	$(".items .item .close").live("click", function() {
		$(this).closest('.item').remove();
		searchByFillter();
	});
	$("#bustype").live("change", function() {
		if($(this).val()!=0)
		{
			var classshow=$(this).val();
			$('.bus-list .busitem').each(function(index) {
				if($(this).hasClass(classshow))
				{
					$(this).show();
				}
				else
				{
					$(this).hide();
					$(this).next().hide();
				}
			});
		}
		else $('.bus-list .busitem').show();
	});
	$(".search_items .items").live("change", function() {
		alert('hello');
	});
	
	var listselectseat=Array();
	$(".seats .colum .seat").live("click", function() {
		if ($(this).hasClass('unselect')||$(this).hasClass('noneseat'))
		{
			return false;
		}
		var formchooseseat=$(this).closest('.formchooseseat');
		if(!$(this).hasClass('choose') && formchooseseat.find('.bodybuyt .choose').length==adult)
		{
			alert(msg_select_again);
			return false;
		}
		if ($(this).hasClass('choose'))
		{
			$(this).removeClass("choose");
		}else
		{
			$(this).addClass("choose");
		}
		var strseat=new Array();
		formchooseseat.find('.bodybuyt .choose').each(function(index) {
			strseat.push($(this).attr('data'));
			
		});
		
		var strseat1 = strseat.join(' , '); 
		var strseat2 = strseat.join(',');
		formchooseseat.find(' .payout .yourseat .spanlistseat').html(strseat1);
		formchooseseat.find(' .payout  .inputlistseat').val(strseat2);
		
	});	
	$(".busitem .viewseat").live("click", function() {
		table_bus = $(this).closest('table.bus-list');
		this_tr_viewseat = $(this).closest('.busitem').next('.tr_viewseat');
		this_tr_viewseat.addClass('select');
		table_bus.find('tbody .radio_bus').each(function(index) {
			 $(this).prop('checked', false);
			//alert('hello');
		});
		
		table_bus.find('.busitem .viewseat').each(function(index) {
			tr_viewseat = $(this).closest('.busitem').next('.tr_viewseat');
			if (!tr_viewseat.hasClass('select')&&tr_viewseat.is(":visible")) {
				$(this).addClass('plusimage');
				$(this).removeClass('minusimage');
				tr_viewseat.slideToggle('slow');
			} 
			
		});
		$(this).closest('.busitem').find('.radio_bus').prop('checked', true);
		
		if (this_tr_viewseat.is(":visible")) {
			$(this).addClass('plusimage');
			$(this).removeClass('minusimage');

		} else {
			$(this).removeClass('plusimage');
			$(this).addClass('minusimage');
		}
		this_tr_viewseat.slideToggle('slow');
		this_tr_viewseat.removeClass('select');
		
	});
	
	
});
