$(".trk").click(function() 
{
	trk = $(this).attr("trk");
	rtc_list = "trk_"+trk;
	if ($(this).hasClass('rtc_show')) 
	{
		$("#"+rtc_list).html("");
		$(this).removeClass('rtc_show');
	}
	else
	{
		$(this).addClass('rtc_show');
		$.post("/SWC/index/articls_list",{trk:trk},function(data)
			{
				list = "";
				data = JSON.parse(data);
				for (i = 0; i <= data.length ; i++) 
				{
					list+="<li>&emsp;&emsp;<a onclick='get_rtc(\""+data[i].identifier+"\")' href='javascript:void(0);' class='rtc' rtc='"+data[i].title+"'> ــ "+data[i].title+"</a></li>";
					i++;
				}
				$("#"+rtc_list).html(list);
			});
	}
});
$(".sign").click(function() 
{
	if ($(this).hasClass('login')) 
	{
		$("#uname").hide('slow/400/fast');
		$(this).removeClass('login');
		$(this).html("Sign Up");
		$("#sulog").val("Login");
		$("#form").attr('action', '/SWC/index/login');
		$("#uname input").remove();
	}
	else
	{
		$("#uname").show('slow/400/fast');
		$(this).addClass('login');
		$(this).html("Login");
		$("#sulog").val("Sign Up");
		$("#form").attr('action', '/SWC/index/signup');
		
		$("#uname").html('<input type="text" name="name" id="name" value="" placeholder="Name" required />');
	}
});
$("#close").click(function() 
{
	$("#theater").fadeOut('fast');
	$("#shower").fadeOut('fast');
	$("#close").fadeOut('fast');
	$("#shower").attr('src', "");
});
function get_rtc(identifier) 
{
	$("#theater").fadeIn('slow');
	$("#shower").fadeIn('slow');
	$("#close").fadeIn('slow');
	$.post("/SWC/index/get_rtc/"+identifier,{},function(data)
	{
		$("#shower").attr('src', data);
	});
}