var STDIO = {

KEY_BACKSPACE	: 8,
KEY_TAB			: 9,
KEY_RETURN		: 13,
KEY_SHIFT		: 16,
KEY_END			: 35,
KEY_HOME		: 36,
KEY_LEFT		: 37,
KEY_UP			: 38,
KEY_RIGHT		: 39,
KEY_DOWN		: 40,
KEY_DELETE		: 46,

KEY_NUM_0		: 48,
KEY_NUM_9		: 57,

CHAR_EMPTY		: '',
CHAR_SPACE		: ' ',

SMART_SEARCH_HOME	: 'http://'+window.location.hostname+'/smart-search',

AJAX_DELIMITER	: '~~~',

STRING_MIN_LENGTH	: 8,
STRING_MAX_LENGTH	: 4096,

redirect:function(url)
{
	window.location = url;
},

replace:function(url)
{
	window.location.replace(url); 
},

input_number:function(event)
{
	event = event || window.event;
    var charCode = (event.which) ? event.which : event.keyCode;
    
	return ((charCode >= this.KEY_NUM_0 && charCode <= this.KEY_NUM_9) ||
	 		charCode == this.KEY_BACKSPACE ||
			charCode == this.KEY_TAB ||
			charCode == this.KEY_SHIFT ||
			charCode == this.KEY_END||
			charCode == this.KEY_HOME||
			charCode == this.KEY_LEFT ||
			charCode == this.KEY_UP ||
			charCode == this.KEY_RIGHT ||
			charCode == this.KEY_DOWN ||
			charCode == this.KEY_DELETE);
},

build_element:function(message, className, tag, id)
{
	return '<'+tag+' class="'+className+'"'+(id==this.CHAR_EMPTY?' id="'+id+'"':this.CHAR_EMPTY)+'>'+message+'</'+tag+'>';
},

effect_drunk:function(id, type)
{
	// 0 = GO ARROUND, 1 = GO HOME
	if (type == 0)
	{
		$(id).css({'position':'relative'});
		var randomH = Math.floor(Math.random() * ($(window).height() - 50));
	    var randomW = Math.floor(Math.random() * ($(window).width() - 50));
	
	    $(id).animate({ top: randomH, left: randomW }, function(){
			STDIO.effect_drunk(id, 0);
		});
	}
	else
	{
		
	}
}

};