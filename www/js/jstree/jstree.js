/**
 * @package 侏儸紀寶石
 *
 *
 */

$(function(){

	$('#add_node').click(function(){
		tree_create();
	});
	
	$('#edit_node').click(function(){
		tree_rename();
	})
	
	$('#edit_node_info').click(function(){
		tree_node_info();
	});
	
	$('#del_node').click(function(){
		if (!confirm('確定要刪除嗎？')) return false;
		tree_delete();
	});
	
	$('#reload_node').click(function(){
		location.reload();
	});
	
	$('#save_node').click(function(){
		if (!confirm('確定要儲存了嗎？')) return false;
		
		var url = $(this).data('saveurl');
		
		var ref = $('#tree_menu').jstree(true);
		var val = JSON.stringify(ref.get_json());
		
		$.ajax({
			url:url,
			type:'post',
			dataType:'json',
			data:{
				'menu':val
			},
			success:function(data){
				
				console.log(data);
				
				if (data.status='T')
				{
					alert(data.msg);
					location.reload();
				}
				else if(data.status='F')
				{
					alert(data.msg);
					return false;
				}
			},
			error:function(e)
			{
				console.log(e);
				alert('unknow error!');
				return false;
			}
		});
		
		console.log(val[0].children);
		
		return false;
	});
	
	$('#edit_submit').click(function(){
		
		set_node_url();
		
		$('#edit_panel').modal('hide');
	});
	
	function tree_create()
	{
		var ref = $('#tree_menu').jstree(true);
		var sel = ref.get_selected();
		if(!sel.length) { return false; }
		sel = sel[0];
		sel = ref.create_node(sel, {"icon":"fa fa-folder-o c-primary", "text": "請輸入選單名稱", "a_attr": {"style": "color: red"} , "data":{"url":"#"}});
		if(sel) {
			ref.edit(sel);
		}
		
	}

	function tree_rename()
	{
		var ref = $('#tree_menu').jstree(true);
		var sel = ref.get_selected();
		if (!sel.length) { return false; }
		if (!sel.length || sel[0] == 'j1_1') { return false;}
		sel = sel[0];
		$(ref.get_node(sel, true)).find('>a').css('color', 'green');
		ref.edit(sel);
		
	}

	function tree_delete()
	{
		var ref = $('#tree_menu').jstree(true);
		var sel = ref.get_selected();
		if(!sel.length || sel[0] == 'j1_1') { return false; }
		ref.delete_node(sel);
		
	}
	
	function tree_node_info()
	{
		var ref = $('#tree_menu').jstree(true);
		var sel = ref.get_selected();
		
		if (!sel.length || sel[0] == 'j1_1') { return false; }
		
		var selobj = ref.get_node(sel);
		
		$('#edit_id').val(selobj.id);
		$('#edit_title').val(selobj.text);
		$('#edit_url').val(selobj.data.url);
		
	}
	
	function set_node_url(url)
	{
		var ref = $('#tree_menu').jstree(true);
		var sel = ref.get_selected();
		if (!sel.length || sel[0] == 'j1_1') { return false; }
		var id = $('#edit_id').val();
		var url = $('#edit_url').val();		
		var row = ref.get_node(id);
		row.data.url = url;
		ref.set_id(row , id);
	}
});

