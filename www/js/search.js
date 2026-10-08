

	$('.open-search').click(function(){
		$('.search-bar').show();
		return false;
	});

	$('.close-search').click(function(){
		$('.search-bar').hide();
		return false;
	});
	
	$('.search-submit').click(function(e){
		if ($('.search-input').val != '')
		{
			window.location.href="/product/search.html?keyword=" + $('.search-input').val();
		}
		return false;
	});
	
	$('.search-submit-m').click(function(e){
		if ($('.search-input-m').val != '')
		{
			window.location.href="/product/search.html?keyword=" + $('.search-input-m').val();
		}
		return false;
	});

	$('.search-input').keypress(function(e){
		if ($(this).val != '')
		{
			if (e.which == 13)
			{
				window.location.href="/product/search.html?keyword=" + $(this).val();
			}
		}
		return false;
	});
	
	$('.search-input-m').keypress(function(e){
		if ($(this).val != '')
		{
			if (e.which == 13)
			{
				window.location.href="/product/search.html?keyword=" + $(this).val();
			}
		}
		return false;
	});