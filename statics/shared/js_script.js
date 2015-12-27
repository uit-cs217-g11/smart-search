function ajax_search_article(event)
{
	event = event || null;
	
	if(event != null)
	{
		if(event.which != 13)
			return;
	}
		
	var search_str = $('#id_search_str').val();
	
	search_str = search_str.replace(/([~!@$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])+/g, ' ');
	search_str = search_str.replace(/^(-)+|(-)+$/g, ' ');
	search_str = search_str.replace(/\s+/g, ' ');
	search_str = $.trim(search_str);
	
	var request = $.ajax({
		url:"/articles/ajax_search_article",
  		type:"POST",
  		data:{a_search_str:search_str},
  		dataType:"html"
	})
	.done(function(msg) {
		var result = msg.split(STDIO.AJAX_DELIMITER);
		if (result[0]==true)
		{
			
		}
	});
}