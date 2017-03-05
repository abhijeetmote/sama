<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends MX_Controller {

	function __construct() {
	    parent::__construct();

		$this->load->module('header/header');
		$this->load->module('footer/footer');
		$this->load->model('payment/payment_model');
		$this->load->model('helper/helper_model');
		$this->load->model('helper/selectEnhanced');
		$this->load->model('helper/selectEnhanced_to');
		//SelectEnhanced
		//$this->load->library('session');
	}

	public function expenseMaster()
	{
		$this->header->index();
		$grp_table = LEDGER_TABLE;
		 
		$ledger_data = $this->payment_model->getDataOrder('*',$grp_table,'parent_id','asc');
		//echo "<pre>";
		//print_r($ledger_data);
		$ret_arr = $this->helper_model->_getLedGrpListRecur($ledger_data, array(), 0, array(), $entity_type="");
		$filter_param_from = array('bank','cash');
		
		$filter_ledgers_from = $this->helper_model->sorted_array($ret_arr[0],0,$filter_param_from);
		//echo "test";exit;
		//print_r($filter_ledgers_from);exit;
		$ledger_data = $this->selectEnhanced->__construct("from_ledger", $filter_ledgers_from, array(
                                'useEmpty' => true,
                                'emptyText' => '--Select--',
                                'options' => array(
                                                'children' =>  array(
                                                                "type" => GROUP_CHILDREN_OPTION_DIS,
                                                                'options' => array (
                                                                             'nature' =>  function($arr){return isset($arr['nature'])? $arr['nature']:false;},
                                                                             'entity_type' =>  function($arr){return isset($arr['entity_type'])? $arr['entity_type']:false;},
                                                                             'behaviour' => function($arr){return isset($arr['behaviour'])? $arr['behaviour']:false;}
                                                                  )
                                    
                                                 )                    
                                                         
                                 )), "optgroup");


		$filter_param_to = array('driver','vendor','contractor','siteExpense');

		$filter_ledgers_to = $this->helper_model->sorted_array($ret_arr[0],0,$filter_param_to);
		$ledger_data_to = $this->selectEnhanced_to->__construct("to_ledger", $filter_ledgers_to, array(
                                'useEmpty' => true,
                                'emptyText' => '--Select--',
                                'options' => array(
                                                'children' =>  array(
                                                                "type" => GROUP_CHILDREN_OPTION_DIS,
                                                                'options' => array (
                                                                             'nature' =>  function($arr){return isset($arr['nature'])? $arr['nature']:false;},
                                                                             'entity_type' =>  function($arr){return isset($arr['entity_type'])? $arr['entity_type']:false;},
                                                                             'behaviour' => function($arr){return isset($arr['behaviour'])? $arr['behaviour']:false;}
                                                                  )
                                    
                                                 )                    
                                                         
                                 )), "optgroup");

		
		$data['to_select'] = $this->selectEnhanced->render("to_ledger",'to_ledger','to_ledger','');
		$data['from_select'] = $this->selectEnhanced_to->render("",'from_ledger','from_ledger','');	

		$select = 'site_id,site_name';
		$tableName = 'site_master';
		$column = "isactive";
		$value = "1";
		$data['sitelist'] = $this->payment_model->getData($select, $tableName, $column, $value);
		
		
		$this->load->view('expenseMaster',$data);
		$this->footer->index();
	}

	
	public function expenseMasterSubmit()
	{
		//$this->header->index();
		//echo "<pre>";
		//print_r($_POST);
		//echo "test";
		 $from_ledger = isset($_POST['from_ledger']) ? $_POST['from_ledger'] : "";
		 $to_ledger = isset($_POST['to_ledger']) ? $_POST['to_ledger'] : "";
		 $payment_amount = isset($_POST['payment_amount']) ? $_POST['payment_amount'] : "";
		 $narration = isset($_POST['narration']) ? $_POST['narration'] : "";
		 $payment_mode = isset($_POST['payment_mode']) ? $_POST['payment_mode'] : "";
		 $referance_no = isset($_POST['referance_no']) ? $_POST['referance_no'] : "";
		 $site_id = isset($_POST['site_id']) ? $_POST['site_id'] : "";
		 $cr = CR;
		 $dr = DR;

	 	$select = "*";
		$ledgertable = LEDGER_TABLE ;
		//echo "aa";
 	 	$where =  "ledger_account_id = '$from_ledger'";
 		$ledger_details = $this->payment_model->getwheresingle($select,$ledgertable,$where);
 		//print_r($ledger_details);
 	 	//echo "ee";
 	 	$from_ledger_name = $ledger_details->ledger_account_name;
 	 	 
	 	// transaction data data insertion start
		 $from_data = array(
				'transaction_date' => date('Y-m-d h:i:s'),
				'ledger_account_id' => $from_ledger,
				'ledger_account_name' => $from_ledger_name,
				'transaction_type' => $dr,
				'payment_reference' => $referance_no,
				'transaction_amount' => $payment_amount,
				'site_id' => $site_id,
				'txn_from_id' => 0,
				'memo_desc' => $narration,
				'added_by' => 1,
				'added_on' => date('Y-m-d h:i:s')
			);
	 	$transaction_table =  TRANSACTION_TABLE;

	 	$this->db->trans_begin();
	 	 //From transaction
	 	$from_transaction_id = $this->payment_model->saveData($transaction_table,$from_data);
	 

	 	//to leadger trans data insertion start
	 	if(isset($from_transaction_id) && !empty($from_transaction_id)) {
		 
			 	$select = " * ";
				$ledgertable = LEDGER_TABLE ;

			 	$where =  "ledger_account_id = '$to_ledger'";
				$ledger_details = $this->payment_model->getwheresingle($select,$ledgertable,$where);
				
			 	$to_ledger_name = $ledger_details->ledger_account_name;
			 	 
				  
			 	// transaction data data insertion start
				 $to_data = array(
						'transaction_date' => date('Y-m-d h:i:s'),
						'ledger_account_id' => $to_ledger,
						'ledger_account_name' => $to_ledger_name,
						'transaction_type' => $cr,
						'payment_reference' => $referance_no,
						'transaction_amount' => $payment_amount,
						'txn_from_id' => $from_transaction_id,
						'memo_desc' => $narration,
						'site_id' => $site_id,
						'added_by' => 1,
						'added_on' => date('Y-m-d h:i:s')
					);
				$transaction_table =  TRANSACTION_TABLE;

				 //From transaction
				$to_transaction = $this->payment_model->saveData($transaction_table,$to_data);


		 	 	if(isset($to_transaction) && !empty($to_transaction)){
		 	 		$this->db->trans_commit();
		 	 		$response['error'] = false;
		 	 		$response['success'] = true;
					$response['successMsg'] = "Payment Made SuccsessFully !!!";
					//$response['redirect'] = base_url()."driver/driverList";
							 	 	


		 	 	} else {
			 		$this->db->trans_rollback();
			 		$response['error'] = true;
			 		$response['success'] = false;
					$response['errorMsg'] = "Error!!! Please contact IT Dept";
		 		}

	 	} else {
	 		$this->db->trans_rollback();
	 		$response['error'] = true;
	 		$response['success'] = false;
			$response['errorMsg'] = "Error!!! Please contact IT Dept";
	 	}

	
			//pay out table entry starts
 				$comment="Paid From Payout";
 				$pay_out_data = array(
					'site_id' => $site_id,
					'pay_from' => $from_ledger,
					'pay_to' => $to_ledger,
					'amount' => $payment_amount,
					'narration' => $narration,
					'pay_mode' => $payment_amount,
					'ref_no' => $payment_amount,
					'comment'=> $comment,
					'added_by' => 1,
					'added_on' => date('Y-m-d h:i:s')

 				);
 				$payout_table= PAYOUT_DATA_TABLE;
 				$pay_out_data = $this->payment_model->saveData($payout_table,$pay_out_data);

	
		echo json_encode($response);
 	}

 	
 	public function journalEntry()
	{
		$this->header->index();
		$grp_table = LEDGER_TABLE;
		 

		$ledger_data = $this->payment_model->getDataOrder('*',$grp_table,'parent_id','asc');
		//echo "<pre>";
		//print_r($ledger_data);
		$ret_arr = $this->helper_model->_getLedGrpListRecur($ledger_data, array(), 0, array(), $entity_type="");
		$filter_param_from = array('bank','cash');
		
		$filter_ledgers_from = $this->helper_model->sorted_array($ret_arr[0],0,$filter_param_from);
		//echo "test";exit;
		//print_r($filter_ledgers_from);exit;
		$ledger_data = $this->selectEnhanced->__construct("from_ledger", $filter_ledgers_from, array(
                                'useEmpty' => true,
                                'emptyText' => '--Select--',
                                'options' => array(
                                                'children' =>  array(
                                                                "type" => GROUP_CHILDREN_OPTION_DIS,
                                                                'options' => array (
                                                                             'nature' =>  function($arr){return isset($arr['nature'])? $arr['nature']:false;},
                                                                             'entity_type' =>  function($arr){return isset($arr['entity_type'])? $arr['entity_type']:false;},
                                                                             'behaviour' => function($arr){return isset($arr['behaviour'])? $arr['behaviour']:false;}
                                                                  )
                                    
                                                 )                    
                                                         
                                 )), "optgroup");


		$filter_param_to = array('Staff');

		$filter_ledgers_to = $this->helper_model->sorted_array($ret_arr[0],0,$filter_param_to);
		$ledger_data_to = $this->selectEnhanced_to->__construct("to_ledger", $filter_ledgers_to, array(
                                'useEmpty' => true,
                                'emptyText' => '--Select--',
                                'options' => array(
                                                'children' =>  array(
                                                                "type" => GROUP_CHILDREN_OPTION_DIS,
                                                                'options' => array (
                                                                             'nature' =>  function($arr){return isset($arr['nature'])? $arr['nature']:false;},
                                                                             'entity_type' =>  function($arr){return isset($arr['entity_type'])? $arr['entity_type']:false;},
                                                                             'behaviour' => function($arr){return isset($arr['behaviour'])? $arr['behaviour']:false;}
                                                                  )
                                    
                                                 )                    
                                                         
                                 )), "optgroup");

		
		$data['to_select'] = $this->selectEnhanced->render("to_ledger",'to_ledger','to_ledger','');
		$data['from_select'] = $this->selectEnhanced_to->render("",'from_ledger','from_ledger','');		
		$this->load->view('journalVoucher',$data);
		$this->footer->index();
	}

	
	public function journalentrySubmit()
	{
		//$this->header->index();
		//echo "<pre>";
		//print_r($_POST);
		//echo "test";
		 $from_ledger = isset($_POST['from_ledger']) ? $_POST['from_ledger'] : "";
		 $to_ledger = isset($_POST['to_ledger']) ? $_POST['to_ledger'] : "";
		 $payment_amount = isset($_POST['payment_amount']) ? $_POST['payment_amount'] : "";
		 $narration = isset($_POST['narration']) ? $_POST['narration'] : "";
		 $payment_mode = isset($_POST['payment_mode']) ? $_POST['payment_mode'] : "";
		 $referance_no = isset($_POST['referance_no']) ? $_POST['referance_no'] : "";
		 $cr = CR;
		 $dr = DR;

	 	$select = "*";
		$ledgertable = LEDGER_TABLE ;
		//echo "aa";
 	 	$where =  "ledger_account_id = '$from_ledger'";
 		$ledger_details = $this->payment_model->getwheresingle($select,$ledgertable,$where);
 		//print_r($ledger_details);
 	 	//echo "ee";
 	 	$from_ledger_name = $ledger_details->ledger_account_name;
 	 	 
	 	// transaction data data insertion start
		 $from_data = array(
				'transaction_date' => date('Y-m-d h:i:s'),
				'ledger_account_id' => $from_ledger,
				'ledger_account_name' => $from_ledger_name,
				'transaction_type' => $dr,
				'payment_reference' => $referance_no,
				'transaction_amount' => $payment_amount,
				'txn_from_id' => 0,
				'memo_desc' => $narration,
				'added_by' => 1,
				'added_on' => date('Y-m-d h:i:s')
			);
	 	$transaction_table =  TRANSACTION_TABLE;

	 	$this->db->trans_begin();
	 	 //From transaction
	 	$from_transaction_id = $this->payment_model->saveData($transaction_table,$from_data);
	 

	 	//to leadger trans data insertion start
	 	if(isset($from_transaction_id) && !empty($from_transaction_id)) {
		 

			 	$select = " * ";
				$ledgertable = LEDGER_TABLE ;

			 	$where =  "ledger_account_id = '$to_ledger'";
				$ledger_details = $this->payment_model->getwheresingle($select,$ledgertable,$where);
				
			 	$to_ledger_name = $ledger_details->ledger_account_name;
			 	 
				  
			 	// transaction data data insertion start
				 $to_data = array(
						'transaction_date' => date('Y-m-d h:i:s'),
						'ledger_account_id' => $to_ledger,
						'ledger_account_name' => $to_ledger_name,
						'transaction_type' => $cr,
						'payment_reference' => $referance_no,
						'transaction_amount' => $payment_amount,
						'txn_from_id' => $from_transaction_id,
						'memo_desc' => $narration,
						'added_by' => 1,
						'added_on' => date('Y-m-d h:i:s')
					);
				$transaction_table =  TRANSACTION_TABLE;

				 //From transaction
				$to_transaction = $this->payment_model->saveData($transaction_table,$to_data);


		 	 	if(isset($to_transaction) && !empty($to_transaction)){
		 	 		$this->db->trans_commit();
		 	 		$response['error'] = false;
		 	 		$response['success'] = true;
					$response['successMsg'] = "Payment Made SuccsessFully !!!";
					//$response['redirect'] = base_url()."driver/driverList";
		 	 	} else {
			 		$this->db->trans_rollback();
			 		$response['error'] = true;
			 		$response['success'] = false;
					$response['errorMsg'] = "Error!!! Please contact IT Dept";
		 		}

	 	} else {
	 		$this->db->trans_rollback();
	 		$response['error'] = true;
	 		$response['success'] = false;
			$response['errorMsg'] = "Error!!! Please contact IT Dept";
	 	}

	 	 
		 
		echo json_encode($response);
 	}


	public function advancesalaryMaster()
	{
		
		$this->header->index();
		$grp_table = LEDGER_TABLE;
		 

		$ledger_data = $this->payment_model->getDataOrder('*',$grp_table,'parent_id','asc');
		//echo "<pre>";
		//print_r($ledger_data);
		$ret_arr = $this->helper_model->_getLedGrpListRecur($ledger_data, array(), 0, array(), $entity_type="");
		$filter_param_from = array('bank','cash');
		
		$filter_ledgers_from = $this->helper_model->sorted_array($ret_arr[0],0,$filter_param_from);
		//echo "test";exit;
		//print_r($filter_ledgers_from);exit;
		$ledger_data = $this->selectEnhanced->__construct("from_ledger", $filter_ledgers_from, array(
                                'useEmpty' => true,
                                'emptyText' => '--Select--',
                                'options' => array(
                                                'children' =>  array(
                                                                "type" => GROUP_CHILDREN_OPTION_DIS,
                                                                'options' => array (
                                                                             'nature' =>  function($arr){return isset($arr['nature'])? $arr['nature']:false;},
                                                                             'entity_type' =>  function($arr){return isset($arr['entity_type'])? $arr['entity_type']:false;},
                                                                             'behaviour' => function($arr){return isset($arr['behaviour'])? $arr['behaviour']:false;}
                                                                  )
                                    
                                                 )                    
                                                         
                                 )), "optgroup");


		$filter_param_to = array('staff');

		$filter_ledgers_to = $this->helper_model->sorted_array($ret_arr[0],0,$filter_param_to);
		$ledger_data_to = $this->selectEnhanced_to->__construct("to_ledger", $filter_ledgers_to, array(
                                'useEmpty' => true,
                                'emptyText' => '--Select--',
                                'options' => array(
                                                'children' =>  array(
                                                                "type" => GROUP_CHILDREN_OPTION_DIS,
                                                                'options' => array (
                                                                             'nature' =>  function($arr){return isset($arr['nature'])? $arr['nature']:false;},
                                                                             'entity_type' =>  function($arr){return isset($arr['entity_type'])? $arr['entity_type']:false;},
                                                                             'behaviour' => function($arr){return isset($arr['behaviour'])? $arr['behaviour']:false;}
                                                                  )
                                    
                                                 )                    
                                                         
                                 )), "optgroup");

		
		$data['to_select'] = $this->selectEnhanced->render("to_ledger",'to_ledger','to_ledger','');
		$data['from_select'] = $this->selectEnhanced_to->render("",'from_ledger','from_ledger','');		


		$data['months'] = array('01' => 'JAN','02' => 'FEB','03' => 'MAR','04' => 'APR','05' => 'MAY',
						'06' => 'JUN','07' => 'JUL','08' => 'AUG','09' => 'SEP','10' => 'OCT',
						'11' => 'NOV','12' => 'DEC' );
		$current_year = date('Y');
		$next_year = $current_year + 1;
		$data['years'] =  array($current_year => $current_year, $next_year => $next_year);

		$this->load->view('advanceSalary',$data);
		$this->footer->index();
	}

	
	public function advancesalaryMasterSubmit()
	{
		//$this->header->index();
		//echo "<pre>";
		//print_r($_POST);
		//echo "test";
		error_reporting(E_ALL);
		 $from_ledger = isset($_POST['from_ledger']) ? $_POST['from_ledger'] : "";
		 $to_ledger = isset($_POST['to_ledger']) ? $_POST['to_ledger'] : "";
		 $payment_amount = isset($_POST['payment_amount']) ? $_POST['payment_amount'] : "";
		 $narration = isset($_POST['narration']) ? $_POST['narration'] : "";
		 $payment_mode = isset($_POST['payment_mode']) ? $_POST['payment_mode'] : "";
		 $referance_no = isset($_POST['referance_no']) ? $_POST['referance_no'] : "";
		 $salary_year = isset($_POST['adv_salary_year']) ? $_POST['adv_salary_year'] : date('Y');
		 $salary_month = isset($_POST['adv_salary_month']) ? $_POST['adv_salary_month'] : date('m');
		 $cr = CR;
		 $dr = DR;

	 	$select = "*";
		$ledgertable = LEDGER_TABLE ;
		//echo "aa";
 	 	$where =  "ledger_account_id = '$from_ledger'";
 		$ledger_details = $this->payment_model->getwheresingle($select,$ledgertable,$where);
 		//print_r($ledger_details);
 	 	//echo "ee";
 	 	$from_ledger_name = $ledger_details->ledger_account_name;
 	 	 
	 	// transaction data data insertion start
		 $from_data = array(
				'transaction_date' => date('Y-m-d h:i:s'),
				'ledger_account_id' => $from_ledger,
				'ledger_account_name' => $from_ledger_name,
				'transaction_type' => $dr,
				'payment_reference' => $referance_no,
				'transaction_amount' => $payment_amount,
				'txn_from_id' => 0,
				'memo_desc' => $narration,
				'added_by' => 1,
				'added_on' => date('Y-m-d h:i:s')
			);

		 // advance salary data data prepare
		 $advance_sal_data = array(
				'transaction_date' => date('Y-m-d h:i:s'),
				'ledger_account_id' => $from_ledger,
				'ledger_account_name' => $from_ledger_name,
				'salary_year' => $salary_year,
				'salary_month' => $salary_month,
				'transaction_amount' => $payment_amount,
				'memo_desc' => $narration,
				'added_by' => 1,
				'added_on' => date('Y-m-d h:i:s')
			);
	 	$transaction_table =  TRANSACTION_TABLE;
	 	$advance_salary =  ADVANCE_SALARY;

	 	$this->db->trans_begin();
	 	 //From transaction
	 	$from_transaction_id = $this->payment_model->saveData($transaction_table,$from_data);
	 	$advance_salary_id = $this->payment_model->saveData($advance_salary,$advance_sal_data);
	 

	 	//to leadger trans data insertion start
	 	if(isset($from_transaction_id) && !empty($from_transaction_id) && !empty($advance_salary_id)) {
		 

			 	$select = " * ";
				$ledgertable = LEDGER_TABLE ;

			 	$where =  "ledger_account_id = '$to_ledger'";
				$ledger_details = $this->payment_model->getwheresingle($select,$ledgertable,$where);
				
			 	$to_ledger_name = $ledger_details->ledger_account_name;
			 	 
				  
			 	// transaction data data insertion start
				 $to_data = array(
						'transaction_date' => date('Y-m-d h:i:s'),
						'ledger_account_id' => $to_ledger,
						'ledger_account_name' => $to_ledger_name,
						'transaction_type' => $cr,
						'payment_reference' => $referance_no,
						'transaction_amount' => $payment_amount,
						'txn_from_id' => $from_transaction_id,
						'memo_desc' => $narration,
						'added_by' => 1,
						'added_on' => date('Y-m-d h:i:s')
					);
				$transaction_table =  TRANSACTION_TABLE;

				 //From transaction
				$to_transaction = $this->payment_model->saveData($transaction_table,$to_data);


		 	 	if(isset($to_transaction) && !empty($to_transaction)){
		 	 		$this->db->trans_commit();
		 	 		$response['error'] = false;
		 	 		$response['success'] = true;
					$response['successMsg'] = "Advance salary transaction made SuccsessFully !!!";
					//$response['redirect'] = base_url()."driver/driverList";
		 	 	} else {
			 		$this->db->trans_rollback();
			 		$response['error'] = true;
			 		$response['success'] = false;
					$response['errorMsg'] = "Error!!! Please contact IT Dept";
		 		}

	 	} else {
	 		$this->db->trans_rollback();
	 		$response['error'] = true;
	 		$response['success'] = false;
			$response['errorMsg'] = "Error!!! Please contact IT Dept";
	 	}

	 	 
		 
		echo json_encode($response);
 	}

 	public function staffSal(){
 		$this->header->index();
		$grp_table = LEDGER_TABLE;
		 

		$ledger_data = $this->payment_model->getDataOrder('*',$grp_table,'parent_id','asc');
		//echo "<pre>";
		//print_r($ledger_data);
		$ret_arr = $this->helper_model->_getLedGrpListRecur($ledger_data, array(), 0, array(), $entity_type="");
		$filter_param_from = array('bank','cash');
		
		$filter_ledgers_from = $this->helper_model->sorted_array($ret_arr[0],0,$filter_param_from);
		//echo "test";exit;
		//print_r($filter_ledgers_from);exit;
		$ledger_data = $this->selectEnhanced->__construct("from_ledger", $filter_ledgers_from, array(
                                'useEmpty' => true,
                                'emptyText' => '--Select--',
                                'options' => array(
                                                'children' =>  array(
                                                                "type" => GROUP_CHILDREN_OPTION_DIS,
                                                                'options' => array (
                                                                             'nature' =>  function($arr){return isset($arr['nature'])? $arr['nature']:false;},
                                                                             'entity_type' =>  function($arr){return isset($arr['entity_type'])? $arr['entity_type']:false;},
                                                                             'behaviour' => function($arr){return isset($arr['behaviour'])? $arr['behaviour']:false;}
                                                                  )
                                    
                                                 )                    
                                                         
                                 )), "optgroup");


		

		
		$data['to_select'] = $this->selectEnhanced->render("to_ledger",'to_ledger','to_ledger','');


		$data['months'] = array('01' => 'JAN','02' => 'FEB','03' => 'MAR','04' => 'APR','05' => 'MAY',
						'06' => 'JUN','07' => 'JUL','08' => 'AUG','09' => 'SEP','10' => 'OCT',
						'11' => 'NOV','12' => 'DEC' );
		$current_year = date('Y');
		$next_year = $current_year + 1;
		$data['years'] =  array($current_year => $current_year, $next_year => $next_year);

		if($this->uri->segment(3) != "" && $this->uri->segment(4) != ""){
			$salary_month = $this->uri->segment(3);
 			$salary_year = $this->uri->segment(4);

 			$data['salary_month'] = $salary_month;
 			$data['salary_year'] = $salary_year;

 			$driver_table =  STAFF_MASTER;
	 		$filds = "staff_id,staff_first_name,staff_last_name,staff_badge_number,staff_contact_number,staff_email_id,staff_dob,staff_gender,staff_qualification,staff_profile_photo,ledger_account_id,staff_basic_pay";
	 		$stafflist = $this->payment_model->getStaffLit($filds,$driver_table);

			//echo "<pre>";print_r($stafflist);exit();

	 		$tableName = "company_holidays";
	 		$select = "count(*) as cnt";
	 		$where = "month = '$salary_month' and year = '$salary_year'";
	 		$holidays = $this->payment_model->getwheredata($select,$tableName,$where);

	 		//echo json_encode($driverlist);exit();
			
			$driverAttnData = array();
			for ($i=0; $i < count($stafflist); $i++) { 
				$staffAttnData[$i]['name'] = $stafflist[$i]->staff_first_name." ".$stafflist[$i]->staff_last_name;
				$staffId = $stafflist[$i]->staff_id;
				$ledgerId = $stafflist[$i]->ledger_account_id;
				//echo json_encode($driverAttnData);exit();
				if(!empty($holidays)){
					$staffAttnData[$i]['holidays'] = $holidays[0]->cnt;
				}else{
					$staffAttnData[$i]['holidays'] = 0;
				}

				$staff_fix_pay = $stafflist[$i]->staff_basic_pay;
				$staffPerDaySal = $staff_fix_pay/30;

				$tableName =  'staff_salary_paid';
		 		$select = '*';
		 		$where = "salary_month = '$salary_month' and salary_year = '$salary_year' and ledger_account_id = '$ledgerId'";
				$staffSalPaid = $this->payment_model->getwheredata($select,$tableName,$where);

				$tableName =  "staff_attendance";
		 		$select = 'day_type';
		 		$where = "month = '$salary_month' and year = '$salary_year' and staff_id = '$staffId'";
				$staffAttn = $this->payment_model->getwheredata($select,$tableName,$where);
				
				$fullday= 0;
				$halfday= 0;
				$workingDaysSal = 0;
				foreach ($staffAttn as $key => $val) {
					if($val->day_type == 1){
						$workingDaysSal += $staffPerDaySal/2;
						$halfday++;
					}else{
						$workingDaysSal += $staffPerDaySal;
						$fullday++;
					}
				}

				$workingDaysSal += $holidays[0]->cnt * $staffPerDaySal;

				$staffAttnData[$i]['totalSal'] = $workingDaysSal;

				$staffAttnData[$i]['ledgerId'] = $ledgerId;
				$staffAttnData[$i]['fullday'] = $fullday; 
				$staffAttnData[$i]['halfday'] = $halfday; 
				
				if(empty($staffSalPaid)){	
					$staffAttnData[$i]['paidStatus'] = "unpaid";
				}else{
					$staffAttnData[$i]['paidStatus'] = "paid";
				}
			}
			$data['staffAttnData'] = $staffAttnData;
		}

		/*echo "<pre>";
		print_r($data);
		exit();*/
		$this->load->view('staffSalary',$data);
		$this->footer->index();
 	}

 	public function staffSalPaid()
 	{
 		$staffList = $_POST['data'];
 		$salary_month = $_POST['salary_month'];
 		$salary_year = $_POST['salary_year'];
 		$from_ledger = $_POST['from_ledger'];

 		for ($i= 0; $i < count($staffList); $i++) { 
 			if($staffList[0]['sal'] > 0)
	 		{	
	 			$to_ledger = $staffList[0]['ledgerId'];
	 			$sal = $staffList[0]['sal'];
	 			$tableName = "staff_salary_paid";
		 		$select = "count(*) as cnt";
		 		$where = "salary_month = '$salary_month' and salary_year = '$salary_year' and ledger_account_id = '$to_ledger'";
		 		$alreadyPaid = $this->payment_model->getwheredata($select,$tableName,$where);
		 		if($alreadyPaid[0]->cnt == 0){
		 			$from_data = array(
						'transaction_date' => date('Y-m-d h:i:s'),
						'ledger_account_id' => $to_ledger,
						'transaction_amount' => $sal,
						'memo_desc' => 'Labour Salary Paid',
						'salary_month' => $salary_month,
						'salary_year' => $salary_year,
						'added_by' => 1,
						'added_on' => date('Y-m-d h:i:s')
					);
				 	$tableName =  "staff_salary_paid";

				 	$this->db->trans_begin();

				 	$staffPaid = $this->payment_model->saveData($tableName,$from_data);

				 	if($staffPaid != false){
				 		$cr = CR;
				 		$dr = DR;
				 		$select = "*";
						$ledgertable = LEDGER_TABLE ;
						//echo "aa";
				 	 	$where =  "ledger_account_id = '$from_ledger'";
				 		$ledger_details = $this->payment_model->getwheresingle($select,$ledgertable,$where);

				 		$from_ledger_name = $ledger_details->ledger_account_name;
 	 	 
				 		// transaction data data insertion start
					 	$from_data = array(
							'transaction_date' => date('Y-m-d h:i:s'),
							'ledger_account_id' => $from_ledger,
							'ledger_account_name' => $from_ledger_name,
							'transaction_type' => $cr,
							'payment_reference' => "",
							'transaction_amount' => $sal,
							'txn_from_id' => 0,
							'memo_desc' => SALARY_PAID_NARRATION,
							'added_by' => 1,
							'added_on' => date('Y-m-d h:i:s')
						);
						$transaction_table =  TRANSACTION_TABLE;

						//From transaction
					 	$from_transaction_id = $this->payment_model->saveData($transaction_table,$from_data);
					 

					 	//to leadger trans data insertion start
					 	if(isset($from_transaction_id) && !empty($from_transaction_id)) {
							$select = " * ";
							$ledgertable = LEDGER_TABLE ;

						 	$where =  "ledger_account_id = '$to_ledger'";
							$ledger_details = $this->payment_model->getwheresingle($select,$ledgertable,$where);
							
						 	$to_ledger_name = $ledger_details->ledger_account_name;
						 	 
						 	// transaction data data insertion start
							$to_data = array(
								'transaction_date' => date('Y-m-d h:i:s'),
								'ledger_account_id' => $to_ledger,
								'ledger_account_name' => $to_ledger_name,
								'transaction_type' => $dr,
								'payment_reference' => "",
								'transaction_amount' => $sal,
								'txn_from_id' => $from_transaction_id,
								'memo_desc' => SALARY_PAID_NARRATION,
								'added_by' => 1,
								'added_on' => date('Y-m-d h:i:s')
							);
							$transaction_table =  TRANSACTION_TABLE;

							 //From transaction
							$to_transaction = $this->payment_model->saveData($transaction_table,$to_data);


					 	 	if(isset($to_transaction) && !empty($to_transaction)){
					 	 		$this->db->trans_commit();
					 	 		$response['error'] = false;
						 		$response['success'] = true;
								$response['successMsg'] = "Paid SuccsessFully";
								$response['redirect'] = base_url()."payment/staffSal";
					 	 	} else {
						 		$this->db->trans_rollback();
					 		}

					 	} else {
					 		$this->db->trans_rollback();
					 		$response['error'] = true;
					 		$response['success'] = false;
							$response['errorMsg'] = "Error!!! Please contact IT Dept";
					 	}
				 	}
		 		} else {
	 				//$this->db->trans_commit();
		 	 		$response['error'] = false;
			 		$response['success'] = true;
					$response['successMsg'] = "salary allready paid";
					$response['redirect'] = base_url()."payment/staffSal";
		 		}
		 	}
 		}



 		echo json_encode($response);
 	}
 	
 	public function labourSalPaid()
 	{
 		$labourList = $_POST['data'];
 		$salary_month = $_POST['salary_month'];
 		$salary_year = $_POST['salary_year'];
 		$from_ledger = $_POST['from_ledger'];

 		for ($i= 0; $i < count($labourList); $i++) { 
 			if($labourList[0]['sal'] > 0)
	 		{	
	 			$to_ledger = $labourList[0]['ledgerId'];
	 			$sal = $labourList[0]['sal'];
	 			$tableName = "labour_salary_paid";
		 		$select = "count(*) as cnt";
		 		$where = "salary_month = '$salary_month' and salary_year = '$salary_year' and ledger_account_id = '$to_ledger'";
		 		$alreadyPaid = $this->payment_model->getwheredata($select,$tableName,$where);
		 		if($alreadyPaid[0]->cnt == 0){
		 			$from_data = array(
						'transaction_date' => date('Y-m-d h:i:s'),
						'ledger_account_id' => $to_ledger,
						'transaction_amount' => $sal,
						'memo_desc' => 'Labour Salary Paid',
						'salary_month' => $salary_month,
						'salary_year' => $salary_year,
						'added_by' => 1,
						'added_on' => date('Y-m-d h:i:s')
					);
				 	$tableName =  "labour_salary_paid";

				 	$this->db->trans_begin();

				 	$labourPaid = $this->payment_model->saveData($tableName,$from_data);

				 	if($labourPaid != false){
				 		$cr = CR;
				 		$dr = DR;
				 		$select = "*";
						$ledgertable = LEDGER_TABLE ;
						//echo "aa";
				 	 	$where =  "ledger_account_id = '$from_ledger'";
				 		$ledger_details = $this->payment_model->getwheresingle($select,$ledgertable,$where);

				 		$from_ledger_name = $ledger_details->ledger_account_name;
 	 	 
				 		// transaction data data insertion start
					 	$from_data = array(
							'transaction_date' => date('Y-m-d h:i:s'),
							'ledger_account_id' => $from_ledger,
							'ledger_account_name' => $from_ledger_name,
							'transaction_type' => $cr,
							'payment_reference' => "",
							'transaction_amount' => $sal,
							'txn_from_id' => 0,
							'memo_desc' => SALARY_PAID_NARRATION,
							'added_by' => 1,
							'added_on' => date('Y-m-d h:i:s')
						);
						$transaction_table =  TRANSACTION_TABLE;

						//From transaction
					 	$from_transaction_id = $this->payment_model->saveData($transaction_table,$from_data);
					 

					 	//to leadger trans data insertion start
					 	if(isset($from_transaction_id) && !empty($from_transaction_id)) {
							$select = " * ";
							$ledgertable = LEDGER_TABLE ;

						 	$where =  "ledger_account_id = '$to_ledger'";
							$ledger_details = $this->payment_model->getwheresingle($select,$ledgertable,$where);
							
						 	$to_ledger_name = $ledger_details->ledger_account_name;
						 	 
						 	// transaction data data insertion start
							$to_data = array(
								'transaction_date' => date('Y-m-d h:i:s'),
								'ledger_account_id' => $to_ledger,
								'ledger_account_name' => $to_ledger_name,
								'transaction_type' => $dr,
								'payment_reference' => "",
								'transaction_amount' => $sal,
								'txn_from_id' => $from_transaction_id,
								'memo_desc' => SALARY_PAID_NARRATION,
								'added_by' => 1,
								'added_on' => date('Y-m-d h:i:s')
							);
							$transaction_table =  TRANSACTION_TABLE;

							 //From transaction
							$to_transaction = $this->payment_model->saveData($transaction_table,$to_data);


					 	 	if(isset($to_transaction) && !empty($to_transaction)){
					 	 		$this->db->trans_commit();
					 	 		$response['error'] = false;
						 		$response['success'] = true;
								$response['successMsg'] = "Paid SuccsessFully";
								$response['redirect'] = base_url()."payment/labourSal";
					 	 	} else {
						 		$this->db->trans_rollback();
					 		}

					 	} else {
					 		$this->db->trans_rollback();
					 		$response['error'] = true;
					 		$response['success'] = false;
							$response['errorMsg'] = "Error!!! Please contact IT Dept";
					 	}
				 	}
		 		} else {
	 				//$this->db->trans_commit();
		 	 		$response['error'] = false;
			 		$response['success'] = true;
					$response['successMsg'] = "salary allready paid";
					$response['redirect'] = base_url()."payment/labourSal";
		 		}
		 	}
 		}



 		echo json_encode($response);
 	}
 	 	
 	public function labourSal(){
 		$this->header->index();
		$grp_table = LEDGER_TABLE;
		 

		$ledger_data = $this->payment_model->getDataOrder('*',$grp_table,'parent_id','asc');
		//echo "<pre>";
		//print_r($ledger_data);
		$ret_arr = $this->helper_model->_getLedGrpListRecur($ledger_data, array(), 0, array(), $entity_type="");
		$filter_param_from = array('bank','cash');
		
		$filter_ledgers_from = $this->helper_model->sorted_array($ret_arr[0],0,$filter_param_from);
		//echo "test";exit;
		//print_r($filter_ledgers_from);exit;
		$ledger_data = $this->selectEnhanced->__construct("from_ledger", $filter_ledgers_from, array(
                                'useEmpty' => true,
                                'emptyText' => '--Select--',
                                'options' => array(
                                                'children' =>  array(
                                                                "type" => GROUP_CHILDREN_OPTION_DIS,
                                                                'options' => array (
                                                                             'nature' =>  function($arr){return isset($arr['nature'])? $arr['nature']:false;},
                                                                             'entity_type' =>  function($arr){return isset($arr['entity_type'])? $arr['entity_type']:false;},
                                                                             'behaviour' => function($arr){return isset($arr['behaviour'])? $arr['behaviour']:false;}
                                                                  )
                                    
                                                 )                    
                                                         
                                 )), "optgroup");


		

		
		$data['to_select'] = $this->selectEnhanced->render("to_ledger",'to_ledger','to_ledger','');


		$data['months'] = array('01' => 'JAN','02' => 'FEB','03' => 'MAR','04' => 'APR','05' => 'MAY',
						'06' => 'JUN','07' => 'JUL','08' => 'AUG','09' => 'SEP','10' => 'OCT',
						'11' => 'NOV','12' => 'DEC' );
		$current_year = date('Y');
		$next_year = $current_year + 1;
		$data['years'] =  array($current_year => $current_year, $next_year => $next_year);

		if($this->uri->segment(3) != "" && $this->uri->segment(4) != ""){
			$salary_month = $this->uri->segment(3);
 			$salary_year = $this->uri->segment(4);

 			$data['salary_month'] = $salary_month;
 			$data['salary_year'] = $salary_year;

 			$labour_table =  LABOUR_TABLE;
	 		$filds = "labour_id,labour_fname,labour_lname,labour_bdate,labour_mobno,labour_photo,ledger_id,labour_wages";
	 		$labourlist = $this->payment_model->getlabourLit($filds,$labour_table);

			//echo json_encode($labourlist);exit();

	 		$tableName = "company_holidays";
	 		$select = "count(*) as cnt";
	 		$where = "month = '$salary_month' and year = '$salary_year'";
	 		$holidays = $this->payment_model->getwheredata($select,$tableName,$where);

	 		//echo json_encode($holidays);exit();
			
			$driverAttnData = array();
			for ($i=0; $i < count($labourlist); $i++) { 
				$labourAttnData[$i]['name'] = $labourlist[$i]->labour_fname." ".$labourlist[$i]->labour_lname;
				$labourId = $labourlist[$i]->labour_id;
				$ledgerId = $labourlist[$i]->ledger_id;
				if(!empty($holidays)){
					$labourAttnData[$i]['holidays'] = $holidays[0]->cnt;
				}else{
					$labourAttnData[$i]['holidays'] = 0;
				}

				$labour_fix_pay = $labourlist[$i]->labour_wages;
				
				$tableName =  'labour_salary_paid';
		 		$select = '*';
		 		$where = "salary_month = '$salary_month' and salary_year = '$salary_year' and ledger_account_id = '$ledgerId'";
				$labourSalPaid = $this->payment_model->getwheredata($select,$tableName,$where);

				$tableName =  "labour_attendance";
		 		$select = 'labour_wages, day_type';
		 		$where = "month = '$salary_month' and year = '$salary_year' and labour_id = '$labourId'";
				$labourAttn = $this->payment_model->getwheredata($select,$tableName,$where);
				
				$fullday= 0;
				$halfday= 0;
				$labourAttnData[$i]['totalSal'] = 0;
				foreach ($labourAttn as $key => $val) {
					if($val->day_type == 1){
						$halfday++;
					}else{
						$fullday++;
					}
					$labourAttnData[$i]['totalSal'] += $labourAttn[0]->labour_wages;
				}

				$labourAttnData[$i]['fullday'] = $fullday; 
				$labourAttnData[$i]['halfday'] = $halfday; 

				$labourAttnData[$i]['ledgerId'] = $ledgerId;

				if(empty($labourSalPaid)){	
					$labourAttnData[$i]['paidStatus'] = "unpaid";
				}else{
					$labourAttnData[$i]['paidStatus'] = "paid";
				}
			}
			$data['labourAttnData'] = $labourAttnData;
		}
		/*echo "<pre>";
		print_r($data);
		exit();*/
		$this->load->view('labourSalary',$data);
		$this->footer->index();
 	}
 	public function payreport()
 	{

 		$this->header->index();
 			$data['months'] = array('01' => 'JAN','02' => 'FEB','03' => 'MAR','04' => 'APR','05' => 'MAY',
						'06' => 'JUN','07' => 'JUL','08' => 'AUG','09' => 'SEP','10' => 'OCT',
						'11' => 'NOV','12' => 'DEC' );
		$current_year = date('Y');
		$next_year = $current_year + 1;
		$data['years'] =  array($current_year => $current_year, $next_year => $next_year);

		if($this->uri->segment(3)  != "" && $this->uri->segment(4) != ""){
			$from_date = $this->uri->segment(3);
 			$to_date = $this->uri->segment(4);
 			$siteId = $this->uri->segment(5);
 			$reportType = $this->uri->segment(6);

 			$data['from'] = $from_date;
 			$data['to'] = $to_date;
 			$data['siteId'] = $siteId;
 			$data['reportType'] = $reportType;

 			if($reportType == 'PayIn'){
 				$select = "pay.*, sm.site_name, lm.ledger_account_name, lm.context";
	 			$tableName = "pay_in_data pay, site_master sm, ledger_master lm";
	 			$where = "pay.site_id = sm.site_id and pay.pay_from = lm.ledger_account_id and pay.added_on >= '$from_date' and pay.added_on <= '$to_date' and pay.site_id='$siteId' ORDER BY pay.added_on DESC";

		 		$data['data'] = $this->payment_model->getwheredata($select,$tableName,$where); 
		 		$data['payindata'] = true;
 			}else{
 				$select = "pay.*, sm.site_name, lm.ledger_account_name, lm1.ledger_account_name as to_ledger";
	 			$tableName = "pay_out_data pay, site_master sm, ledger_master lm, ledger_master lm1";
	 			$where = "pay.site_id = sm.site_id and pay.pay_from = lm.ledger_account_id and pay.pay_to = lm1.ledger_account_id and pay.added_on BETWEEN '$from_date' AND '$to_date' and pay.site_id='$siteId' ORDER BY pay.added_on DESC";

	 			$data['payoutdata'] = true;
		 		$data['data'] = $this->payment_model->getwheredata($select,$tableName,$where); 
 			}
 		}
 		$select = 'site_id,site_name';
		$tableName = 'site_master';
		$column = "isactive";
		$value = "1";
		$data['sitelist'] = $this->payment_model->getData($select, $tableName, $column, $value);
			$from_date = date("Y-m-d", strtotime("-1 months"));
 			$to_date = date('Y-m-d');
 			$siteId = $this->uri->segment(5);
 			$reportType = $this->uri->segment(6);

 			$data['from'] = $from_date;
 			$data['to'] = $to_date;
 			$data['siteId'] = $siteId;
 			$data['reportType'] = $reportType;

 			if($reportType == 'PayIn'){
 				$select = "pay.*, sm.site_name, lm.ledger_account_name, lm.context";
	 			$tableName = "pay_in_data pay, site_master sm, ledger_master lm";
	 			$where = "pay.site_id = sm.site_id and pay.pay_from = lm.ledger_account_id and pay.added_on >= '$from_date' and pay.added_on <= '$to_date' and pay.site_id='$siteId' ORDER BY pay.added_on DESC";

		 		$data['data'] = $this->payment_model->getwheredata($select,$tableName,$where); 
		 		$data['payindata'] = true;
 			}else{
 				$select = "pay.*, sm.site_name, lm.ledger_account_name, lm1.ledger_account_name as to_ledger";
	 			$tableName = "pay_out_data pay, site_master sm, ledger_master lm, ledger_master lm1";
	 			$where = "pay.site_id = sm.site_id and pay.pay_from = lm.ledger_account_id and pay.pay_to = lm1.ledger_account_id and pay.added_on BETWEEN '$from_date' AND '$to_date' and pay.site_id='$siteId' ORDER BY pay.added_on DESC";

	 			$data['payoutdata'] = true;
		 		$data['data'] = $this->payment_model->getwheredata($select,$tableName,$where); 
 			}
		$this->load->view('payreport',$data);
		$this->footer->index();
 	}
 	public function payindata()
 	{
 		if($this->uri->segment(3) != "" && $this->uri->segment(4) != ""){
		  $from_date = $this->uri->segment(3);
		  $f_date=date('Y-m-d', strtotime(str_replace('-', '/', $from_date)));
 		  $to_date = $this->uri->segment(4);
 		  $t_date=date('Y-m-d', strtotime(str_replace('-', '/', $to_date)));
 		  $site_id = $this->uri->segment(5);
 			$query=$this->helper_model->selectQuery("SELECT * from ledger_master JOIN ledger_transactions on ledger_master.ledger_account_id=ledger_transactions.ledger_account_id WHERE ledger_master.parent_id='4' AND ledger_transactions.site_id='$site_id' AND ledger_transactions.transaction_date BETWEEN '$f_date' AND '$t_date'");
 			echo "<pre>";
 			print_r($query);
 		if($query == true){
 			$data['payindata']=$query;
 			$this->load->view(PayInreport,$data);
 			
 			$response['success'] = true;
 			$response['successMsg'] = $detail;
 		}else{
 			$response['success'] = false;
			$response['successMsg'] = "Something wrong please try again";
 		}
 		echo json_encode($response);
 	}

}
}
