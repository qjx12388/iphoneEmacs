function add_jp(){
	var c=parseInt($('#c_jp').val());
	var html='<tr id="jp_'+c+'">';
	html+='<td><input name="jp_z_'+c+'" class="form_si" size="5"></td>';
	html+='<td><input name="jp_n_'+c+'" class="form_si" size="15"></td>';
	html+='<td><input name="jp_c_'+c+'" class="form_si" size="5"></td>';
	html+='<td><a href="#" onclick="$(\'#jp_'+c+'\').remove();return false;">X</a></td>';
	html+='</tr>';
	$('#jp_table').append(html);
	c++;
	$('#c_jp').val(c);
}

function to_txt(str){
	var RexStr =/\<|\>|\"|\'|\&/g;
	str=str.replace(RexStr, function(MatchStr){
		switch(MatchStr){
			case "<":
				return "&lt;";
				break;
			case ">":
				return "&gt;";
				break;
			case "\"":
				return "&quot;";
				break;
			case "'":
				return "&#39;";
				break;
			case "&":
				return "&amp;";
				break;
			default:
				break;
		}
	});
	str=str.replace('\n', ' ');
	return str;
}

$(function(){
	if($('.bottom_menu').length>0){
		$('input, select, textarea').focus(function(){
			$('.bottom_menu').hide();
			$('.foot_smenu').hide();
		}).blur(function(){
			$('.bottom_menu').show();
		});
	}
	$('input').blur(function(){
		if($(this).val()!=''){
			$(this).removeClass('error');
		}
	});
	$('select').change(function(){
		if($(this).val()!='0'){
			$(this).removeClass('error');
		}
	});
});