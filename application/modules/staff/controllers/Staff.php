<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Staff extends MX_Controller {

	function __construct() {
	    parent::__construct();

		$this->load->module('header/header');
		$this->load->module('footer/footer');
		$this->load->model('staff/Staff_model');
		$this->load->model('helper/helper_model');
	}

	

	public function staffMaster()
	{
		$this->header->index();
		$this->load->view('staffAdd');
		$this->footer->index();
	}
	public function addstaff()
	{	
		
		
		 $staff_f_name = isset($_POST['staff_f_name']) ? $_POST['staff_f_name'] : "";
		 $staff_l_name = isset($_POST['staff_l_name']) ? $_POST['staff_l_name'] : "";
		 $staff_badge = isset($_POST['staff_badge']) ? $_POST['staff_badge'] : "";
		 $staff_contact_number = isset($_POST['staff_contact_number']) ? $_POST['staff_contact_number'] : "";
		 $staff_email = isset($_POST['staff_email']) ? $_POST['staff_email'] : "";
		 $staff_add1 = isset($_POST['staff_add1']) ? $_POST['staff_add1'] : "";
		 $staff_add2 = isset($_POST['staff_add2']) ? $_POST['staff_add2'] : "";
		 $staff_gen = isset($_POST['staff_gen']) ? $_POST['staff_gen'] : "";
		 $staff_dob = isset($_POST['staff_dob']) ? $_POST['staff_dob'] : "";
		 $staff_qual = isset($_POST['staff_qual']) ? $_POST['staff_qual'] : "";
		 $basic_pay = isset($_POST['basic_pay']) ? $_POST['basic_pay'] : "";
		 $staff_status = isset($_POST['staff_status']) ? $_POST['staff_status'] : "";

		  //bdate conversion
		 if(isset($staff_dob) && !empty($staff_dob)){
		 	$staff_dob = $this->helper_model->dbDate($staff_dob);
		 }
		 
		 if(isset($staff_gen) && $staff_gen == "male"){
		 	$staff_gen = 1;
		 }
		 if(isset($staff_gen) && $staff_gen == "male"){
		 	$staff_gen = 1;
		 }
		 if(isset($staff_gen) && $staff_gen == "female"){
		 	$staff_gen = 2;
		 }
		 
		 $data = array(
			'staff_first_name' => $staff_f_name,
			'staff_last_name' => $staff_l_name,
			'staff_badge_number' => $staff_badge,
			'staff_contact_number' => $staff_contact_number,
			'staff_email_id' => $staff_email,
			'staff_address_1' => $staff_add1,
			'staff_address_2' => $staff_add2,
			'staff_gender' => $staff_gen,
			'staff_dob' => date('Y-m-d h:i:s'),
			'staff_qualification' => $staff_qual,
			'staff_basic_pay' => $basic_pay,
			'status' => $staff_status,
			'added_on' => date('Y-m-d h:i:s')
		);
 	$staff_table =  "staff_master";

 	$this->db->trans_begin();
 	 //driver record insertion
 	$staff_id = $this->Staff_model->saveData($staff_table,$data);

 	//diver data insertion end

 	//Ledger data insertion start
 	if(isset($staff_id) && !empty($staff_id)) {
		$select = " ledger_account_id ";
		$ledgertable = LEDGER_TABLE ;
		$context = STAFF_CONTEXT;
		$entity_type = GROUP_ENTITY;
		$where =  array('context' =>  $context, 'entity_type' => $entity_type);
 	 	$groupid = $this->Staff_model->getGroupId($select,$ledgertable,$context,$entity_type,$where);
 	 	
 	 	$parent_data = $groupid->ledger_account_id;
 	 	$reporting_head = REPORT_HEAD_EXPENSE;
 	 	$nature_of_account = DR;
 	 	// ledger data preparation

 	 	$leddata = array(
		'ledger_account_name' => $staff_f_name."_".$staff_id,
		'parent_id' => $parent_data,	
		'report_head' => $reporting_head,
		'nature_of_account' => $nature_of_account,
		'context_ref_id' => $staff_id,
		'context' => $context,
		'ledger_start_date' => date('Y-m-d h:i:s'),
		'behaviour' => $reporting_head,
		'entity_type' => 2,
		'defined_by' => 1,
		'status' => '1',
		'added_by' => '1',
		'added_on' => date('Y-m-d h:i:s'));
 	 	//Insert Ledger data with staff Id
 	 	$legertable =  LEDGER_TABLE;
 	 	$ledger_id = $this->Staff_model->saveData($legertable,$leddata);

 	 	if(!isset($ledger_id) || empty($ledger_id)){
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

 	//Vndor update with ledger id start
 	$update_data =  array('ledger_account_id' => $ledger_id);
 	$updat_column_Name = "staff_id";
 	$update_value = $staff_id;
 	$update_id = $this->Staff_model->updateData($staff_table,$update_data,$updat_column_Name,$update_value);
 	//end


	if(isset($update_id) && !empty($update_id)){
		
		$this->db->trans_commit();
		$response['success'] = true;
		$response['error'] = false;
		$response['successMsg'] = "Staff Added Successfully";
		$response['redirect'] = base_url()."staff/staffList";

	}else{
		$this->db->trans_rollback();
 		$response['error'] = true;
 		$response['success'] = false;
		$response['errorMsg'] = "Error!!! Please contact IT Dept";
	}
	echo json_encode($response);
 	}


 	public function staffList(){
 		$staff_table ='staff_master';
 		$fields = "staff_id,staff_first_name,staff_last_name,staff_contact_number,staff_email_id,staff_address_1,staff_gender";
 		$data['list'] = $this->Staff_model->getStaffList($fields,$staff_table);
        $this->header->index();
		$this->load->view('staffList', $data);
		$this->footer->index();
 	}

 	public function staffDelete(){
        $staff_id = $_POST['id'];
        $staff_table = 'staff_master';
        $resultMaster = $this->helper_model->delete($staff_table,'staff_id',$staff_id);
        if($resultMaster != false){
        	$response['success'] = true;
			$response['successMsg'] = "Record Deleted";
        }else{
        	$response['success'] = false;
			$response['successMsg'] = "Something wrong please try again";
        }
        echo json_encode($response);
 	}


 	public function update($id){        
        $select = '*';
		$tableName = STAFF_MASTER;
		$column = 'staff_id';
		$value = $id;
		$data['staff'] = $this->Staff_model->getData($select, $tableName, $column, $value);
		$data['update'] = true;
		$this->header->index();
	
		$this->load->view('StaffAdd', $data);
		$this->footer->index();
 	}

 	public function staffUpdate(){        

 		 
		 $staff_f_name = isset($_POST['staff_f_name']) ? $_POST['staff_f_name'] : "";
		 $staff_l_name = isset($_POST['staff_l_name']) ? $_POST['staff_l_name'] : "";
		 $staff_badge = isset($_POST['staff_badge']) ? $_POST['staff_badge'] : "";
		 $staff_contact_number = isset($_POST['staff_contact_number']) ? $_POST['staff_contact_number'] : "";
		 $staff_email = isset($_POST['staff_email']) ? $_POST['staff_email'] : "";
		 $staff_add1 = isset($_POST['staff_add1']) ? trim($_POST['staff_add1']) : "";
		 $staff_add2 = isset($_POST['staff_add2']) ? trim($_POST['staff_add2']) : "";
		 $staff_gen = isset($_POST['staff_gen']) ? $_POST['staff_gen'] : "";
		 $staff_dob = isset($_POST['staff_dob']) ? $_POST['staff_dob'] : "";
		 $staff_qual = isset($_POST['staff_qual']) ? $_POST['staff_qual'] : "";
		 $basic_pay = isset($_POST['basic_pay']) ? $_POST['basic_pay'] : "";
		 $staff_status = isset($_POST['staff_status']) ? $_POST['staff_status'] : "";
		
		  //bdate conversion
		 if(isset($staff_dob) && !empty($staff_dob)){
		 	$staff_dob = $this->helper_model->dbDate($staff_dob);
		 }
		 
		 if(isset($staff_gen) && $staff_gen == "Male"){
		 	$staff_gen = 0;
		 }
		 if(isset($staff_gen) && $staff_gen == "Female"){
		 	$staff_gen = 1;
		 }
		 if(isset($staff_gen) && $staff_gen == "female"){
		 	$staff_gen = 2;
		 }

		 $ledger_acount_id = isset($_POST['ledger_acount_id']) ? $_POST['ledger_acount_id'] : "";

		  $staff_update = array(
			'staff_first_name' => $staff_f_name,
			'staff_last_name' => $staff_l_name,
			'staff_badge_number' => $staff_badge,
			'staff_contact_number' => $staff_contact_number,
			'staff_email_id' => $staff_email,
			'staff_address_1' => $staff_add1,
			'staff_address_2' => $staff_add2,
			'staff_gender' => $staff_gen,
			'staff_dob' => $staff_dob,
			'staff_qualification' => $staff_qual,
			'staff_basic_pay' => $basic_pay,
			'status' => $staff_status,
			'added_on' => date('Y-m-d h:i:s')
		);
     
		$this->db->trans_begin();
		$staff_table = STAFF_MASTER;
		$staff_column = 'staff_id';
		$staff_id = $_POST['id'];

		$result = $this->Staff_model->updateData($staff_table, $staff_update, $staff_column, $staff_id);

		if(isset($result) && $result == true) {
			$ledgertable = LEDGER_TABLE;
			$ledger_column = 'ledger_account_id';
			$ledger_update = array(
			'ledger_account_name' => $staff_f_name."_".$staff_id,
			'status' => '1',
			'updated_by' => '1',
			'updated_on' => date('Y-m-d h:i:s')
			);

			$ledger_result = $this->Staff_model->updateData($ledgertable, $ledger_update, $ledger_column, $ledger_acount_id);

			if(empty($ledger_result) || $ledger_result == false) {

				$this->db->trans_rollback();
	 	 		$response['error'] = true;
	 	 		$response['success'] = false;
				$response['errorMsg'] = "Error!!! Please contact IT Dept";

			} else{
				$this->db->trans_commit();
				$response['success'] = true;
				$response['error'] = false;
				$response['successMsg'] = "Staff Updated Successfully";
				$response['redirect'] = base_url()."staff/staffList";
			}
		} 
		else 
		{

			$this->db->trans_rollback();
 	 		$response['error'] = true;
 	 		$response['success'] = false;
			$response['errorMsg'] = "Error!!! Please contact IT Dept";
		}

        echo json_encode($response);
 	}
	public function staffAtten()
	{
		$select = 'staff_id,staff_first_name';
		$tableName = 'staff_attendance';
		$column = '1';
		$value = '1';
		$data1['site'] = $this->helper_model->selectAll($select, $tableName);
		$select = 'staff_id,staff_first_name,staff_last_name';
		$tableName = 'staff_master';
		$column = '1';
		$value = '1';
		$data['staffDrop'] = $this->helper_model->selectAll($select, $tableName);
		$data['staffdata'] = $this->helper_model->selectAll($select, $tableName);
		
		$this->header->index();
		$this->load->view('staffAttend',$data);
		$this->footer->index();
	}
	
	public function addattend()
	{		$temp_data='';
			$staff_id = isset($_POST['id']) ? $_POST['id'] : "";
			$tableName = 'staff_attendance';
			if(isset($staff_id) && !empty($staff_id)) {
			$select = "staff_id,staff_check_in,staff_check_out";
			$columnName = 'staff_id';
			$value = $staff_id;
			$temp_data = $this->helper_model->select($select, $tableName,$columnName,$value);
			
			/*yete check kar data ahi ka chek in madhe flag true bhetla ter msg de allready checkied in ani break kar flow other wise insert karun ghe kk ok*/
			}
			//print_r($temp_data);exit;
			$staff1 = array(
			'staff_id' => $_POST['id'],
			'staff_first_name' => $_POST['staff_f_name'],
			'staff_last_name' => $_POST['staff_l_name'],
			'staff_type'=>'1',
			'staff_check_in' => $_POST['staff_in_dt'],
			//'staff_check_out' => $_POST['staff_out_dt'],
			'added_on' => date('Y-m-d H:i:s')
		);
		
		$select = 'staff_id';
		
		$column = 'staff_id';
		//$value = $_POST['site_id'];

		 //$check = $this->helper_model->select($select, $tableName, $column, $value);
		
			$result = $this->helper_model->insert($tableName,$staff1);
			if($result == true){
				
			    $response['success'] = true;
				$response['error'] = false;
				$response['successMsg'] = "Successfully Submit";
			} else{
				$response['success'] = false;
				$response['error'] = true;
				$response['errorMsg'] = "Please contact IT Dept";
			}
		
		echo json_encode($response);
		
	}
		public function staffpaymaster()
	{
		$select = 'staff_id,staff_first_name';
		$tableName = 'staff_attendance';
		$column = '1';
		$value = '1';
		$data1['site'] = $this->helper_model->selectAll($select, $tableName);
		$select = 'staff_id,staff_first_name,staff_last_name';
		$tableName = 'staff_master';
		$column = '1';
		$value = '1';
		$data['staffDrop'] = $this->helper_model->selectAll($select, $tableName);
		$data['staffdata'] = $this->helper_model->selectAll($select, $tableName);
		
		$this->header->index();
		$this->load->view('staffPayAdd',$data);
		$this->footer->index();
	}
}
