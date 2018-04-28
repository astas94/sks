(function($) { // Hide scope, no $ conflict
    /* creteseat manager. */
    function creteseat() {
         this._defaults = {
             row:4,
             column:10,
             block_type:null,
             listselected:null,
             
             upper_row:0,
             upper_column:0,
             upper_block_type: null,
             upper_seatnumber: null,
            	        
             hidden_input_submit:'setlistselect',
             setlistselected:null,
             seatnumber:null,
             show_lable:'show_lable',
             maxselect:2,
             areturn:0
         };
         this.regional = {
             renderer:this.defaultRenderer
         };
         $.extend(this._defaults, this.regional['']);
         this._disabled = [];
    }
    $.extend(creteseat.prototype, {
       dataName: 'creteseat',
       markerClass: 'hasCreteseat',
       commands: {
           blockclick:{text:'block',status:'enable',
                keystroke:{keyCode:36,ctrKey:true},
                enabled:function(inst){ return 1;}
           }
       },
       defaultRenderer:{
           creteseat: '<div class="createblock"></div>',
           block:'<div class="item"></div>',
           selectedClass:'item-selected'
       },
       setDefaults: function(settings) {
            $.extend(this._defaults, settings || {});
            return this;
        },
        getListSelected: function(target, settings,getarray) {
            var listselected=new Array();
            	
           target.find('.block_item.seat').each(function(index){
        	   
                if($(this).hasClass('choose'))
                {
                	
                    listselected.push(index);
                }
           });
           if(getarray==true)
        	   return listselected;
           return JSON.stringify(listselected); 
        },
        onclickseat :function(target, settings) {
        	
            return  getListSelected(target, settings);
        },
        getListSeatNumber: function(target, settings,getarray) {
            var listseatnumber=new Array();

           target.find('.block_item.seat').each(function(index){
                if($(this).hasClass('choose'))
                {   
                    listseatnumber.push($(this).attr('title'));
                }
           });
           if(getarray==true)
        	   return listseatnumber;
           
           //return JSON.stringify(listseatnumber);
           return listseatnumber.join(",");
        },
        
       _attachCreteseat: function(target, settings) {
            target = $(target);
            if (target.hasClass(this.markerClass)) {
                return;
            }
            target.addClass(this.markerClass);
            var inst = {
                target: target,
                inline: ($.inArray(target[0].nodeName.toLowerCase(), ['div', 'span']) > -1),
                get: function(name){
                    //var value = this.settings[name] !== undefined ? this.settings[name] : $.createseat._defaults[name];
                    return name;
                },
                getConfig:function(){
                     return {}
                }
                
            };
            $.data(target[0], this.dataName, inst);
            var inlineSettings = ($.fn.metadata ? target.metadata() : {});
            inst.settings = $.extend({}, settings || {}, inlineSettings || {});
            
            if (inst.inline) {
                  this._update(target[0]);
                  if ($.fn.mousewheel) {
                        target.mousewheel(this._doMouseWheel);
                    }
            }else
            {
                this._attachments(target, inst);
                target.bind('keydown.' + this.dataName, this._keyDown).
                    bind('keypress.' + this.dataName, this._keyPress).
                    bind('keyup.' + this.dataName, this._keyUp);
                if (target.attr('disabled')) {
                    this.disable(target[0]);
                }
            }
               
       },
       _update: function(target, hidden) {
          target = $(target.target || target);


          var inst = $.data(target[0], $.creteseat.dataName);
          if (inst) {
              if (inst.inline || $.creteseat.curInst == inst) {
                    
              }
              if (inst.inline) {
                  if(target.find('.block_item').length==0)
                  {
                	  if(inst.settings.upper_row>0){
	                      for(i=0;i<inst.settings.upper_row*inst.settings.upper_column;i++)
	                      {  
	                         if( (i)%inst.settings.upper_column ==0){
	                        	 $div = $("<div>", {class: "block_item",title:inst.settings.upper_seatnumber[i],style:"clear: both;"});
	                   	  	}else{
	                   	  		$div = $("<div>", {class: "block_item",title:inst.settings.upper_seatnumber[i]});
	                   	  	}
	                         target.append($div);
	                      }
	                      target.append('<div style="border-bottom: 1px solid #b8b8b8;clear: both;"></div>'); 
                	  }
                      
                      
                      for(i=0;i<inst.settings.row*inst.settings.column;i++)
                      {
                          if( (i)%inst.settings.column ==0){
                         	 $div = $("<div>", {class: "block_item",title:inst.settings.seatnumber[i],style:"clear: both;"});
                    	  	}else{
                    	  		$div = $("<div>", {class: "block_item",title:inst.settings.seatnumber[i]});
                    	  	}
                          target.append($div);
                      }
                      
                      
                      target.append('<input type="hidden" id="'+inst.settings.hidden_input_submit+'"  name="'+inst.settings.hidden_input_submit+'" value=""/>');
                  }
                  
                  //set selected
                
                  target.find('.block_item').each(function(index){
                	 if($.inArray($(this).attr('title').toString(),inst.settings.listselected )>-1)
        			 {
                		 
                		 $(this).addClass('selected');
        			 }
                  });
                  /*
                  if($.isArray(inst.settings.listselected)&&inst.settings.listselected.length>1) $.each(inst.settings.listselected, function(index, selected) {
                       target.find('.block_item:nth-child('+selected+')').addClass('selected');
                  });*/
                  
                   //set block type
	                  if(inst.settings.upper_row>0){
			                  $.each(inst.settings.upper_block_type, function(index, upper_blocktype) {
			                      target.find('.block_item:nth-child('+(index+1)+')').addClass(upper_blocktype);
			                });
	                  }   
                   $.each(inst.settings.block_type, function(index, blocktype) {
                        target.find('.block_item:nth-child('+(index+1)+')').addClass(blocktype);
                  });
                   

                  //set width view
                  target.css({ 
                         //width:($('.block_item').width()/2+10)*inst.settings.column
                	  width:"auto"
                  });
                  var self = this;  
                 target.find('.block_item').unbind('click');
                 inst.settings.setlistselected=new Array();
                 
                 target.find('.block_item.seat').click(function(index){
                    var callbacks = $.Callbacks();
                    
                    
                     if(!$(this).hasClass('choose')&&target.find('.block_item.seat.choose').length>=inst.settings.maxselect)
                     {
                         return false;
                     }
                     if(!$(this).hasClass('selected'))
                     {
                        $(this).toggleClass("choose");
                     }
                     
                     callbacks.add(inst.settings.callbacks.onclickseat );
                    callbacks.fire($.creteseat.getListSeatNumber(target,inst,true),inst.settings.areturn ); 
                    //target.find('input[name="'+inst.settings.hidden_input_submit+'"]').val( $.creteseat.getListSelected(target,inst));
                    target.find('input[name="'+inst.settings.hidden_input_submit+'"]').val( $.creteseat.getListSeatNumber(target,inst));
                    
                    $(inst.settings.show_lable).html($.creteseat.getListSeatNumber(target,inst));
                    
                 });
                 if(inst.settings.selected=!null)
                 {
                     
                 }
                  //target.html(this._generateContent(target[0],inst));
                target.focus();
              }
          }
         
       },
       _attachments: function(target, inst) {
            if (inst.trigger) {
                inst.trigger.remove();
            }
            target.html('hello');
            
           
       },
       _changeStatus: function(target,inst) {
            alert('hello');
       },
       _generateContent: function(target,inst) {
            $html='<div class="create-block"></div>';
       },
       _keyDown: function(event) {
           alert(1);
       }, 
       _keyPress: function(event) {
       },
       _keyUp: function(event) {
           
       },
       destroy: function(target) {
           target = $(target);
           if (!target.hasClass(this.markerClass)) {
                return;
            }
           var inst = $.data(target[0], this.dataName);
           for(selected in inst.settings.listselected){
               
                //target.find('.block_item:nth-child('+selected+')').addClass('selected');
           }
       },
       /* Apply multiple event functions.
       Usage, for example: onShow: multipleEvents(fn1, fn2, ...)
       @param  fns  (function...) the functions to apply */
        multipleEvents: function(fns) {
            var funcs = arguments;
            return function(args) {
                for (var i = 0; i < funcs.length; i++) {
                    funcs[i].apply(this, arguments);
                }
            };
        },
       options: function(target, name) {
            var inst = $.data(target, this.dataName);
            return (inst ? (name ? (name == 'all' ?
                inst.settings : inst.settings[name]) : $.creteseat._defaults) : {});
        },
        option: function(target, settings, value) {
            
             
            target = $(target);
            if (!target.hasClass(this.markerClass)) {
                return;
            }
            settings = settings || {};
            if (typeof settings == 'string') {
                var name = settings;
                settings = {};
                settings[name] = value;
            }
           
            var inst = $.data(target[0], this.dataName);
            extendRemove(inst.settings, settings);
            if (!inst.inline) {
                this._attachments(target, inst);
            }
            if (inst.inline) {
                this._update(target[0]);
            }
        }   
    });
    /* jQuery extend now ignores nulls!
       @param  target  (object) the object to extend
       @param  props   (object) the new settings
       @return  (object) the updated object */
    function extendRemove(target, props) {
        $.extend(target, props);
        for (var name in props)
            if (props[name] == null || props[name] == undefined)
                target[name] = props[name];
        return target;
    };

    $.fn.creteseat = function(options) {
        var otherArgs = Array.prototype.slice.call(arguments, 1);
        if ($.inArray(options, ['getDate', 'isDisabled', 'isSelectable', 'options', 'retrieveDate']) > -1) {
            return $.creteseat[options].apply($.creteseat, [this[0]].concat(otherArgs));
        }
        return this.each(function() {
            if (typeof options == 'string') {
                $.creteseat[options].apply($.creteseat, [this].concat(otherArgs));
            }
            else {
                $.creteseat._attachCreteseat(this, options || {});
            }
        });
    };
    $.creteseat = new creteseat(); // singleton instance
    /*
    $(function() {
        $(document).mousedown($.creteseat._checkExternalClick).
            resize(function() { $.creteseat.hide($.creteseat.curInst); });
    });
    */
})(jQuery);