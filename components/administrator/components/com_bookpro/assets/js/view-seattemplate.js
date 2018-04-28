jQuery(document).ready(function($){
    /*
    $('#create-seat').creteseat({
        row:20,
        column:6,
        edit:true,
        
    });
    
    
    $("#create-seat").contextmenu({
        delegate: ".item",
        menu: "#rightmenu",
//        position: {my: "left top", at: "left bottom"},
        position: function(event, ui){
            return {my: "left top", at: "left bottom", of: ui.target};
        },
        show:{effect:"fast"},
        preventSelect: true,
        taphold: true,
        
        focus: function(event, ui) {
            
        },
        blur: function(event, ui) {
            
        },
        beforeOpen: function(event, ui) {
    
        },
        open: function(event, ui) {
//          
        },
        select: function(event, ui) {
                
        }
    });
   
    
    
    
   
    var isVisible = false;
    
    var hideAllPopovers = function() {
       $('#create-seat div.item').each(function() {
            $(this).popover('hide');
        });  
    };
    
    $('#create-seat div.item').popover({
        html: true,
         content: function() {
            return $('#popover_content_wrapper').html();
        },
        trigger: 'manual'
    }).on('click', function(e) {
        // if any other popovers are visible, hide them
        if(isVisible) {
            hideAllPopovers();
        }

        $(this).popover('show');

        // handle clicking on the popover itself
        $('.popover').off('click').on('click', function(e) {
            e.stopPropagation(); // prevent event for bubbling up => will not get caught with document.onclick
        });
        
        isVisible = true;
        e.stopPropagation();
    });

    
    $(document).on('click', function(e) {
        hideAllPopovers();
        isVisible = false;
    });
    */
    $('input[name="change"]').click(function(){
        var generate_item=$('#block_layout_row').val()*$('#block_layout_column').val();
        a_max=Math.max(generate_item,$('#create-seat .item').length);
        for(i=1;i<=a_max;i++)
        {
            if(i<=generate_item)
            {
                $('#create-seat .item:nth-child('+(i).toString()+')').css({
                    display:"block"
                });
            }
            else
            {
                $('#create-seat .item:nth-child('+(i).toString()+')').css({
                    display:"none"
                }); 
            }
            if(i>$('#create-seat .item').length)
            {
               $('#create-seat .item:last').after($('#create-seat .item:last').clone());
            }
        }
        $("#create-seat").css({
        width:($('#create-seat .item').width()+10)*$('#block_layout_column').val()
        
        
    });
        
    }); 
    
});