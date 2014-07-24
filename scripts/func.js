$(document).ready(function()
{
	$('#addtoright').after('<div id="addedtoright">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Show all milestones</b></div>');
	
	var image = 'up.png';

	if($('.trialtitles').length)
	{
		var updown = $('.trialtitles').find('td').css('background-image').replace(/^url\((.*?)\)$/, '$1');		
		var s = updown.split("/");
		var filename = s[s.length-1].split('.')[0];
		
		if(filename == 'down')
		{
			image = 'down.png';
		}
	}
	
	$('#addedtoright').css('background-image','url(\'./images/'+image+'\')')
	.css('background-repeat','no-repeat')
	.css('background-position','left center')
	.css('border','1px solid')
	.css('padding','2px')
	
	if($('.trialtitles').length>0)
	{
		$('#addedtoright').click(function(){sh(this,0,1);}).css('cursor','pointer');	
	}
	else
	{
		//$('#addedtoright').css('background-color','#DDDDDD').css('cursor','default').css('color','#777777');
		//We remove the .milestones container div so that we can utilise screen space
		$('#addtoright').parent().remove();
	}

});

function sh(obj,key,all)
{
	var updown = $(obj).css('background-image').toString().search(/up.png/i);
	if(updown>0)
	{
		dir = 'url(\'./images/down.png\')';
	}
	else
	{
		dir = 'url(\'./images/up.png\')';
	}
	if(all==undefined)
	{	
		$(obj).css('background-image',dir);
		$('#addedtoright').css('background-image',scansh());
		if(updown>0)
		{	
			$('.upms.'+key).show();
		}
		else
		{
			$('.upms.'+key).hide();	
		}
	}
	if(all==1)
	{
		$('.upmpointer').css('background-image',dir);
		$('#addedtoright').css('background-image',scansh());
		if(updown>0)
		{
			$('.upms').show();
		}
		else
		{
			$('.upms').hide();
		}
	}
}
function scansh()
{
	var upflag=0;
	var downflag=0;
	$('.upmpointer').each(function(){
		var dir = $(this).css('background-image').toString().search(/up.png/i);
		if(dir>0)
		{
			upflag=1;
			dir = 'url(\'./images/down.png\')';
		}
		else
		{
			downflag=1;
			dir = 'url(\'./images/up.png\')';
		}
	});
	if(downflag==1)
	{
		dir = 'url(\'./images/down.png\')';
		return dir;
	}
	if(upflag==1)
	{
		dir = 'url(\'./images/up.png\')';
		return dir;
	}	
}