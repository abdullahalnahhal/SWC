var selected_person = 0;
var customer_id = 0;
var request_id = 0;
var selected_items = [];
var codes_file ="http://localhost:8444/engineer/public/files/code.txt";
$(".new-maint").click(function()
	{
		$( "#add-maint" ).fadeIn(500);
	});
$("#close-request").click(function()
	{
		$( "#add-maint" ).fadeOut(500);
		$("input,textarea").val("");
		$("select").val(0);
		$(".disabled-input").attr("disabled",true);
	});
$("#close-maint").click(function()
	{
		$( "#edit-request" ).fadeOut(500);
		$("input,textarea").val("");
		$("select").val(0);
		$(".disabled-input").attr("disabled",true);
	});
$(".list-item ,.add").click(function()
	{
		wind_name = $(this).attr("wind");
		if (wind_name == "add-client") 
			{
				$.post("../customer/get_all_ccats_options/",{},function(data)
				{
					// alert(data);
					$("#cus-cat").html(data);
				});
			}
		if($( "#"+wind_name ).hasClass("active-wind")== false)
		{
			$(".wind").fadeOut(500);
			$( "#"+wind_name ).fadeIn(500);
			$( "#"+wind_name ).addClass("active-wind");
			$(".selected-items").remove();

		}		
	});
$(".close-win-btn").click(function()
	{
		wind_name = $(this).attr("wind");
		$(".wind").fadeOut(500);
		$( "#"+wind_name ).removeClass("active-wind");
		$("input").val("");
		$("select").val("0");
		$("textarea").val("");
		$("input").css("background","white");
		$("select").css("background","white");
		$("textarea").css("background","white");
	});
$("input").focus(function()
	{
		$(this).css("background","white");
		$(this).css("color","black");
	});
$("#add-cust").click(function()
	{
		customer_name = $("#cust-name-input").val();
		customer_cagtegory = $("#cus-cat").val();
		customer_phone = $("#cus-phone").val();
		customer_mobile = $("#cus-mobile").val();
		kn_method = $("#cus-kn-method").val();
		phone = 0;
		if (customer_name == "" || customer_name == "0") 
		{
			$("#cust-name-input").css("background","#FFAAAA");
		}
		if (customer_name == "" || customer_name == "0") 
		{
			$("#cus-cat").css("background","#FFAAAA");
		}
		if ((customer_phone == "" || customer_phone == "0") && (customer_mobile =="" || customer_mobile == "0") ) 
		{
			$("#cus-phone").css("background","#FFAAAA");
			$("#cus-mobile").css("background","#FFAAAA");
		}
		else if( isNaN(customer_phone) && customer_phone != "")
		{
			$("#cus-phone").css("background","#FFAAAA");
		}
		else if( isNaN(customer_mobile) && customer_mobile != "")
		{
			$("#cus-phone").css("background","#FFAAAA");
		}
		else
		{
			$("#cus-phone").css("background","white");
			$("#cus-mobile").css("background","white");
			phone = 1;
		}
		if (customer_name && customer_name!= "0" && customer_cagtegory && customer_cagtegory != "0" && phone != 0) 
		{
			$.post("../customer/add_customer",{cname:customer_name,ccat:customer_cagtegory,phone:customer_phone,mobile:customer_mobile,kn_method:kn_method},function(data)
				{
					$("#add-topic").html("العميل");
					$("#add-completed").fadeIn(500);
					$("#add-completed").fadeOut(1000);
					set_codes(codes_file) ;
				});
		}
	});
$("#auto-id").keyup(function()
	{
		selected_person = 0;
		search = $("#auto-id").val();
		$.post("../customer/search_customer/"+search,{},function(data)
		{
			data = JSON.parse(data);
			count = data.length;
			str = '';
			for (i = 0; i < count; i++) 
			{
				str = str+'<a class="list-link" onclick=\"select_customer('+data[i]['id']+')\"><div class="dl-element">'+data[i]['cname']+','+data[i]['ccode']+'</div></a>'
			}
			$("#datalist").html(str);
		});
		$("#datalist").slideDown(100);
	});
$("#auto-id").focusout(function()
	{
		$("#datalist").slideUp(200);
	});
$("#add-request").click(function()
	{
		notes = $("#request-notes").val();
		maint_type = $("#maint-type").val();
		request_type = $("#request-type").val();
		model_type = $("#model-type").val();
		cost = $("#cost").val();
		payed = $("#payed").val();
		discount = $("#discount").val();
		if (selected_person == 0) 
		{
			$("#auto-id").css("background","#FFAAAA");
			$("#auto-id").css("color","red");
		}
		if ($("#maint-type").val() == 0) 
		{
			$("#maint-type").css("background","#FFAAAA");
		}
		if ($("#request-type").val() == 0) 
		{
			$("#request-type").css("background","#FFAAAA");
		}
		if ($("#model-type").val() == 0) 
		{
			$("#model-type").css("background","#FFAAAA");
		}
		if ((selected_person !=0) /*&& (notes != "") */&& (maint_type != 0) && (request_type != 0) && (model_type != 0)) 
		{
			$.post("../customer/add_customer_request/",{cost:cost,payed:payed,discount:discount,customer_id:customer_id,notes:notes,maint_type:maint_type,request_type:request_type,model_type:model_type},function(data)
				{
					// $("#test").html(data);
					// alert(data);
					$("#add-topic").html("الطلب");
					$("#add-completed").fadeIn(500);
					$("#add-completed").fadeOut(1000);
					$("input").val("");
					$("textarea").val("");
					$("select").val("0");
					selected_person = 0;
					set_codes(codes_file) ;
					// alert(data);
				});
		}
	});
$("#req-type-edit").change(function()
	{
		selected = $("#req-type-edit").val();
		there = selected_items.indexOf(selected);

		if (selected != 0 && there == -1) 
		{
			selected_items.push(selected);
			text = $("#req-type-edit option[value=\""+(Number(selected))+"\"] ").text();
			// alert($("#req-type-edit option[value=\""+(Number(selected))+"\"] ").text());
			$("#selected-maints").append("<span id='item-"+selected+"' class='selected-items'>"+text+"</span>");
		}
		
	});
$("#empty-selected-maint").click(function()
	{
		$(".selected-items").remove();
		selected_items=[];
	});
$("#add-maint-btn").click(function()
	{
		length = selected_items.length;	 
		if (length == 0) 
		{
			alert( "اختر الصيانة اللازمة اولا من فضلك ... " );
		}
		else
		{
			$.post("../customer/add_mentain/",{selected_items:selected_items,request_id:request_id},function(data)
			{
				$("#empty-selected-maint").click();
				$("#add-topic").html("الصيانة");
				$("#add-completed").fadeIn(500);
				$("#add-completed").fadeOut(1000);
				set_codes(codes_file) ;
			});
		}
	});
$(".printcode").click(function()
	{
		print_codes();
		$("input").val("");
		$("textarea").val("");
		$("select").val("0");
	});
$("#initiate-request").click(function()
	{
		maint_type = $("#maint-initiator").val();
		models = [];
		requests = [];
		$("#req-initiator-box .selected-items").each(function()
			{
				requests.push($(this).text());
			});
		$("#mod-initiator-box .selected-items").each(function()
			{
				models.push($(this).text());
			});
		if (requests.length == 0) 
		{
			alert("يجب أن تضع نوع الطلب لهذه الصيانة.");
		}
		else if (models.length == 0) 
		{
			alert("يجب أن بضع الموديلات التي يحدث لها هذه الصيانة");
		}
		else
		{
			$.post("../customer/initiate_maint/",{maint_type:maint_type,models:models,requests:requests},function(data)
				{
					$(".empty-box").click();
					$("#add-topic").html("نوع الصيانة الجديد");
					$("#add-completed").fadeIn(500);
					$("#add-completed").fadeOut(1000);
					$("input").val("");
				});
		}
	});
$("#add-cat").click(function()
	{
		fullcat = $("#full-cat-input").val();
		shortcut = $("#shortcut-cat-input").val();
		if (fullcat == "") 
		{
			$("#full-cat-input").css("background","#FFAAAA");
		}
		if (shortcut == "") 
		{
			$("#shortcut-cat-input").css("background","#FFAAAA");
		}
		if (fullcat != "" && shortcut != "") 
		{
			$.post("../customer/add_cat/",{fullcat:fullcat,shortcut:shortcut},function(data)
			{
				$("#add-topic").html("التصنيف");
				$("#add-completed").fadeIn(500);
				$("#add-completed").fadeOut(1000);
				$("input").val("");
			});
		}
	});