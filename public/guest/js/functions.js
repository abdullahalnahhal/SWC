function edit_req(req_id)
{
	request_id = req_id;
		$.post("../customer/req_info/"+request_id,{},function(data)
		{
			data = JSON.parse(data);
			$("#maint_cname").val(data['cname']);
			$("#maint_rcode").val(data['req_code']);
			$("#maint-type-edit").val(data['maint_type']);
			$("#req-type").val(data['req_type']);
			$("#req-model").val(data['model']);
			$("#req-notes").val(data['notes']);
			$("#req-type-edit").html(data['req_type_options']);
		});
		$( "#edit-request" ).fadeIn(500);
}
function complete_req(req_id)
{
	request_id = req_id;
	$.post("../customer/complete_req/"+request_id,{},function(data)
		{
			alert(data);
		});
}
function select_customer(id)
{
	$.post("../customer/get_customer_by_id/"+id ,{},function(data)
	{
		data = JSON.parse(data);
		$("#cus-prior").val(data['shortcut']);
		$("#auto-id").val(data['cname']);
		selected_person = 1;
		customer_id = data['id'];
	});
}
function set_codes(path)
{
	$("#textfile").attr("src",path);	
}
function print_codes()
{
	var iframe = document.getElementById('textfile');
    iframe.contentWindow.print();	
}
function maint_select()
{
	maint_type = $("#maint-type").val();
	model_options = "<option value=\"0\"> اختر موديل الجهاز </option>";
	req_options = "<option value=\"0\"> نوع الــطــلــب </option>";
	if (maint_type != 0) 
	{
		$.post("../customer/get_model_option/"+maint_type ,{},function(data)
		{
			model_options = model_options + data;
			$("#model-type").html(model_options);
			$("#model-type").attr("disabled",false);
		});
		$.post("../customer/get_req_options/"+maint_type ,{},function(data)
		{
			req_options = req_options + data;
			$("#request-type").html(req_options);
			$("#request-type").attr("disabled",false);
		});
	}
	else
	{
			$("#model-type").attr("disabled",true);
			$("#request-type").attr("disabled",true);
	}
}
function make_table(tname , table)
{
	str = "";
	if (tname == "required_request-shower-table") 
	{
		table =JSON.parse(table);
		length = table.length;
		str = "<table id=\"required_request-shower-table\" class=\"ptable table\">"+
		"<thead>"+
			"<th> اسم العميل (شخص / مؤسسة)</th>"+
			"<th> رقم الصيانة </th>"+
			"<th> نوع الصيانة </th>"+
			"<th> الصيتنة المطلوبة </th>"+
			"<th> ملاحظات </th>"+
			"<th> التكلفة </th>"+
			"<th> المدفوع </th>"+
			"<th> المتبقي </th>"+
			"<th> العمليات </th>"+
		"</thead>"+
		"<tbody>";
		for (i = 0; i < length; i++) 
		{
			str = str + "<tr><td>"+table[i]["cname"]+"</td><td> "+table[i]['request-code']+"</td><td>"+table[i]['maint-type']+"</td><td>"+table[i]['request-type']+"</td><td>"+table[i]['notes']+"</td><td>"+table[i]['credit']+"</td><td>"+table[i]['debit']+"</td><td>"+(Number(table[i]['debit']) - Number(table[i]['credit']))+"</td><td><a href=\"javascript:void(0)\" title=\"إنهاء الخدمة\" ><span class=\"glyphicon glyphicon-share\" ></span></a> <a href=\"javascript:void(0)\" title=\"تعديل الخدمة\" onclick=\" edit_req("+table[i]['request_id']+") \" class=\"edit-req\"><span class=\"glyphicon glyphicon-edit\" ></span></a> <a href=\"javascript:void(0)\" title=\"إتمام الخدمة\"onclick=\"complete_req("+table[i]['request_id']+")\" class=\"complete-req\" ><span class=\"glyphicon glyphicon-check\" ></span></a></td></tr>";
		}
		str = str+"</tbody>"+
			"</table>";
	}
	else if (tname == "customer-shower-table")
	{
		table =JSON.parse(table);
		length = table.length;
		str = "<table id=\"customer-shower-table\" class=\"ptable table\">"+
		"<thead>"+
			"<th> اسم العميل</th>"+
			"<th> الكود </th>"+
			"<th> درجة العميل </th>"+
			"<th> الهاتف </th>"+
			"<th> الجوال </th>"+
			"<th> طريقة التعارف </th>"+
			"<th> العمليات</th>"+
		"</thead>"+
		"<tbody>";
		for (i = 0; i < length; i++) 
		{
			str = str + "<tr><td>"+table[i]["cname"]+"</td><td> "+table[i]['ccode']+"</td><td>"+table[i]['category']+"</td><td>"+table[i]['phone']+"</td><td>"+table[i]['mobile']+"</td><td>"+table[i]['method']+"</td><td><a><span class=\"glyphicon glyphicon-check\" ></span></a></td></tr>";
		}
		str = str+"</tbody>"+
			"</table>";
	}

	return str;
}