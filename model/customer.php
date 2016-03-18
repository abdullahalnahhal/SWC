<?php
/**
* 
*/
class Model_Customer extends Model
{
	
	function __construct()
	{
		parent::__construct();	//for consructing the Model default actions
	}
	/* 
		get and check the username and user password 
		if they are correct return user information if not return false
	*/
		//customer info operations
	public function add_customer($cname , $ccat , $phone , $mobile , $kn_method = 0)
	{
		$this::$tableName = "ccategory";
		$cat = $ccat;
		$ccat = $this->select("*","`id` = \"".$ccat."\"");
		$ccat = $this->assoc($ccat);
		// print_r($ccat);
		$this::$tableName = "customer";
		$last_id = $this->freeQuery("SELECT `id` FROM `customer` ORDER BY  `id` DESC LIMIT 1");
		$last_id = $this->assoc($last_id);
		if ($last_id) 
		{
			$last_id = $last_id[0]['id'];
		}
		else
		{
			$last_id = 0;
		}
		$ccode = "cust-".($last_id + 1)."-".$ccat[0]['shortcut']."-".time();
		// print_r($ccode);die;
		$query = $this->insert(array('ccode', 'cname', 'ccatgory', 'phone', 'mobile', 'knowing-method'),array($ccode , $cname , $cat , $phone , $mobile , $kn_method));
		return $ccode;
	}
	public function search_customer($search)
	{
		$this::$tableName = "customer";
		$search_str = "";
		foreach ($search as $key ) 
		{
			$search_str = $search_str."LIKE \"%".$key."%\"";
		}
		$search_str = "`ccode` ".$search_str." OR `cname` ".$search_str;
		$search_result = $this->select("*",$search_str);
		$search_result = $this->assoc($search_result);
		return $search_result;
	}
	public function search_customer_by_id($search)
	{
		$this::$tableName = "v_customer";
		$search_result = $this->select("*","`id`='".$search."'");
		$search_result = $this->assoc($search_result);
		return $search_result;
	}
	// requests and accounts operations
	public function add_customer_request($cost,$payed,$discount,$customer_id , $notes, $maint_type , $request_type , $model_type)
	{
		$this::$tableName = "customer";
		$customer = $this->select("*","`id` = \"".$customer_id."\"");
		$customer = $this->assoc($customer);
		$customer =$customer[0];

		$this::$tableName = "ccategory";
		$ccat = $this->select("*","`id` = \"".$customer['ccatgory']."\"");
		$ccat = $this->assoc($ccat);
		$ccat = $ccat[0];

		$this::$tableName = "requests";
		$last_id = $this->freeQuery("SELECT `id` FROM `requests` ORDER BY  `id` DESC LIMIT 1");
		$last_id = $this->assoc($last_id);
		if ($last_id) 
		{
			$last_id = $last_id[0]['id'];
		}
		else
		{
			$last_id = 0;
		}
		$this_id = $last_id + 1;
		$reqcode = "req-".($this_id)."-".$ccat['shortcut']."-".time();
		$this::$tableName = "requests";
		$insert = $this->insert(array('request-code','customer_id','notes' , 'maint-id' , 'request-type', 'model-id','status'),array($reqcode,$customer_id,$notes ,$maint_type ,$request_type,$model_type,1));
		if ($cost) 
		{
			$this::$tableName = "caccounts";
			$insert = $this->insert(array('request-id', 'debit', 'credit', 'balance', 'status'),array($this_id,0,$cost,0,10));
		}
		if ($payed) 
		{
			$this::$tableName = "caccounts";
			$insert = $this->insert(array('request-id', 'debit', 'credit', 'balance', 'status'),array($this_id,$payed,0,0,6));
		}
		if ($discount) 
		{
			$this::$tableName = "caccounts";
			$insert = $this->insert(array('request-id', 'debit', 'credit', 'balance', 'status'),array($this_id,$discount,0,0,7));
		}
		if ($cost == NULL && $payed == NULL && $discount == NULL) 
		{
			$this::$tableName = "caccounts";
			$insert = $this->insert(array('request-id', 'debit', 'credit', 'balance', 'status'),array($this_id,0,0,0,9));
		}
		return $reqcode;
	}
	public function get_all_requests()
	{
		$this::$tableName = "v_cust_request";
		$request = $this->select("*","`delete`='0'");
		$request = $this->assoc($request);
		return $request;		
	}
	public function get_request_credits($id)
	{
		$this::$tableName = "v_request";
		$tableName = $this::$tableName;
		$request = $this->freeQuery("select sum(credit) As credit from `".$tableName."` where `request-id`='".$id."';");
		$request = $this->assoc($request);
		return $request;
	}
	public function get_request_debits($id)
	{
		$this::$tableName = "v_request";
		$tableName = $this::$tableName;
		$request = $this->freeQuery("select sum(debit) As debit from `".$tableName."` where `request-id`='".$id."';");
		$request = $this->assoc($request);
		return $request;
	}
	public function complete_req($id)
	{
		$this::$tableName = "requests";
		$request = $this->update("delete" , "1" , "id" , $id);
		return $request;
	}
	public function req_info($id)
	{
		$this::$tableName = "requests";
		$request = $this->select("*" , "`id` = '".$id."'");
		$request = $this->assoc($request);
		$request = $request[0];

		$this::$tableName = "customer";
		$customer = $this->select("*" , "`id` = '".$request['customer_id']."'");
		$customer = $this->assoc($customer);
		$customer = $customer[0];

		$this::$tableName = "maint_type";
		$maint = $this->select("*" , "`id` = '".$request['maint-id']."'");
		$maint = $this->assoc($maint);
		$maint = $maint[0];

		$this::$tableName = "request-type";
		$req_type = $this->select("*" , "`id` = '".$request['request-type']."'");
		$req_type = $this->assoc($req_type);
		$req_type = $req_type[0];

		$req_type_options = $this->select("*" , "`maint-id` = '".$request['maint-id']."'");
		$req_type_options = $this->assoc($req_type_options);
		$options="<options value=\"0\">الإصلاحات</option>";
		foreach ($req_type_options as $key => $value) 
		{
			$options=$options."<option value=\"".$value['id']."\">".$value['request-type']."</option>";
		}
		// echo $options;
		$this::$tableName = "models";
		$model = $this->select("*" , "`id` = '".$request['model-id']."'");
		$model = $this->assoc($model);
		$model = $model[0];

		$req_info = array('req_id' => $id, 'req_code' => $request['request-code'] , 
			'customer_id'=>$customer['id'] , 'cname'=>$customer['cname'],
			'ccode'=>$customer['ccode'] , 'notes'=>$request['notes'],'req_type'=>$req_type['request-type'],
			'model'=>$model['model'],'maint_type'=>$maint['maint-type'],
			'req_type_options'=>$options);

		return $req_info;
	}
	public function add_mentain($selected_items,$request_id)
	{
		$this::$tableName = "requests";
		$rcode = $this->select("request-code"," `id`='".$request_id."'");
		$rcode = $this->assoc($rcode);
		$rcode = $rcode[0];
		$mcode = $rcode['request-code'];
		foreach ($selected_items as $key) 
		{
			$mcode = 'maint-'.$key."-".$request_id."-".time();
			$this::$tableName = "mentainance";
			$request = $this->insert(array('request-id','req-type-id','maint-code'),array($request_id,$key,$mcode));
		}
		return $mcode;
	}
	///////////////////////////////////////////////////////////////////////
	////// FOR YSTEM ADMIN IT MUST By Changed In ANOTHER Model///////
	/////////////////////////////////////////////////////////////////////
	public function initiate_maint($maint_type ,$models ,$requests)
	{
		$secure = new Lib_secure();
		$maint_type = $secure->T($maint_type);
		$this::$tableName = "maint_type";
		$query = $this->insert("maint-type",$maint_type);
		$last_id = $this->last("id");

		$this::$tableName = "request-type";
		foreach ($requests as $key) 
		{
			$query = $this->insert(array("maint-id","request-type"),array($last_id , $secure->T($key)));
		}
		$this::$tableName = "models";
		foreach ($models as $key) 
		{
			$query = $this->insert(array("maint_id","model"),array($last_id , $secure->T($key)));
		}
	}
	public function add_cat($fullcat ,$shortcut)
	{
		$secure = new Lib_secure();
		$fullcat = $secure->T($fullcat);
		$shortcut = $secure->T($shortcut);
		$this::$tableName = "ccategory";
		$query = $this->insert(array("category","shortcut"),array($fullcat,$shortcut));
		return $query;
	}
	public function get_all_maint_type()
	{
		$this::$tableName = "maint_type";
		$request = $this->select("*");
		$request = $this->assoc($request);
		return $request;
	}
	public function get_model_option($maint_type_id)
	{
		$this::$tableName = "models";
		$request = $this->select("*","`maint_id` = ".$maint_type_id);
		$request = $this->assoc($request);
		return $request;
	}
	public function get_req_options($maint_type_id)
	{
		$this::$tableName = "request-type";
		$request = $this->select("*","`maint-id` = ".$maint_type_id);
		$request = $this->assoc($request);
		return $request;
	}
	public function get_all_customers()
	{
		$this::$tableName = "v_customer";
		$search_result = $this->select("*");
		$search_result = $this->assoc($search_result);
		return $search_result;
	}
	public function get_all_ccats()
	{
		$this::$tableName = "ccategory";
		$search_result = $this->select("*");
		$search_result = $this->assoc($search_result);
		return $search_result;
	}

}