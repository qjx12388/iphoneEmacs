$(function(){
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