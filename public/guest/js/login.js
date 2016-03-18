function check()
{
		uname = $("#user-name").val();
		upass = $("#user-password").val();
		if (uname=="") 
		{
			$("#user-name").css("background","#ffec8e");
		}
		if (upass=="") 
		{
			$("#user-password").css("background","#ffec8e");
		}
		if (uname!="" && upass!="") 
		{
			$.post("users/login",{uname:uname,upass:upass},function(data)
				{
					if (data == "false") 
					{
						alert(1);
					}
					else
					{
						// alert(data);
						window.location = "module/"+data;
					}
				});
		}
}
function pressed(e)
{
    if(e.keyCode === 13)
    {
        check();
    }
}
$(".input").focus(function()
	{
		$(this).css("background","white");
	});
$("input[type='button']").click(function()
	{
		check();
	});
$(document).ready(function()
{

    $(document).bind('keypress',pressed);
});