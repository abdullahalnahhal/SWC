var ans_counter = 0;
$("#add-ans").click(function()
{
	ans_counter++;
	temp = "<div class=\"input-group\" id=\"ans-"+ans_counter+"\" ><span class=\"input-group-addon\"><input type=\"checkbox\" name = \"ans_check_"+ans_counter+"\" value=\""+ans_counter+"\"></span>	<input type=\"text\" class=\"form-control\" name=\"answer-"+ans_counter+"\" placeholder=\"Write Answer Alternative Here ...\"><span class=\"input-group-addon btn del-ans\" onclick =\"delete_question("+ans_counter+")\" \" ><i class=\"fa fa-close\" ></i></span></div>";
	$("#answers-zone").append(temp);
	
	$("#answers").val(ans_counter);
});
function delete_question(q_num)
{
	$("#ans-"+q_num).remove();
	ans_counter--;
	$("#answers").val(ans_counter);
}