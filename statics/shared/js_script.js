function ajax_search_article(event)
{
	event = event || null;
	
	if(event != null)
	{
		if(event.which != 13)
			return;
	}
		
	var search_str = $('#id_search_str').val();
	
	search_str = search_str.replace(/([~!@$%^*()_+=`{}\[\]\\:;'<>,.\/? ])+/g, ' ');
	search_str = search_str.replace(/^(-)+|(-)+$/g, ' ');
	search_str = search_str.replace(/\s+/g, ' ');
	search_str = $.trim(search_str);
	
	if (search_str.length == 0)
	{
		$('#id_search_str').val('');
		return;
	}
	else if (search_str.length < 2)
	{
		return;
	}
	
	search_str = encodeURIComponent(search_str);
	var FULL_URI = STDIO.SMART_SEARCH_HOME + '/articles' + '/search/' + search_str + '/1';
	window.location = FULL_URI;
}