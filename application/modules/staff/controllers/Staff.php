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
		 $profilephoto = isset($_FILES['profilephoto']) ? $_FILES['profilephoto'] : "";

		 $select = "staff_id";
		 $tableName = "staff_master";
		 $column = "staff_email_id";
		 $value = $staff_email;
		 $staffResult = $this->Staff_model->getData($select,$tableName,$column, $value);

		 if(!empty($staffResult)){
		 	$response['error'] = true;
		 	$response['success'] = false;
			$response['errorMsg'] = "Error!!! Staff already exist";			
			echo json_encode($response);
			exit();	
		 }

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
		 
		 //file upload
		  $_FILES['profilephoto']['name']."<br>";
			$_FILES['profilephoto']['tmp_name'];
			$isfile=basename($_FILES['profilephoto']['name']);
			$newname=$isfile;
			$sizeinmb=25;
			$staff_profile_photo=FILE_UPLOAD.$staff_f_name."_".$newname;

		 $data = array(
			'staff_first_name' => $staff_f_name,
			'staff_last_name' => $staff_l_name,
			'staff_badge_number' => $staff_badge,
			'staff_contact_number' => $staff_contact_number,
			'staff_email_id' => $staff_email,
			'staff_profile_photo' => isset($_FILES['profilephoto']) ? $staff_profile_photo : "",
			'staff_address_1' => $staff_add1,
			'staff_address_2' => $staff_add2,
			'staff_gender' => $staff_gen,
			'staff_dob' => date('Y-m-d h:i:s'),
			'staff_qualification' => $staff_qual,
			'staff_basic_pay' => $basic_pay,
			'status' => $staff_status,
			'added_on' => date('Y-m-d h:i:s')
		);


			if($isfile!=''){

			$imgerr=$this->helper_model->do_upload($_FILES['profilephoto']['name'],$_FILES['profilephoto']['tmp_name'],$sizeinmb,$newname,$staff_f_name);


			}
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
		 $staff_profile_photo = isset($_POST['staff_profile_photo']) ? $_POST['staff_profile_photo'] : "";
		
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

		if($_FILES['profilephoto']['name'] != ''){
			$_FILES['profilephoto']['name']."<br>";
			$_FILES['profilephoto']['tmp_name'];
			$isfile=basename($_FILES['profilephoto']['name']);
			$newname=$isfile;
			$sizeinmb=25;
			$staff_profile_photo=FILE_UPLOAD.$staff_f_name."_".$newname;

			$imgerr=$this->helper_model->do_upload($_FILES['profilephoto']['name'],$_FILES['profilephoto']['tmp_name'],$sizeinmb,$newname,$staff_f_name);
			$staff_update['staff_profile_photo'] = $staff_profile_photo;
		}
     
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
	/*public function staffAtten()
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
	}*/
	public function staffAtten()
	{
		$date = date('Y-m-d');
        $data['staffdetails'] = $this->helper_model->selectQuery("SELECT staff_id,staff_first_name,staff_last_name FROM staff_master where staff_id not in (select staff_id from staff_attendance where DATE_FORMAT(user_check_in, '%Y-%m-%d') = '$date')");
        //echo "<pre>"; print_r($data);exit();
        $this->header->index();
        $this->load->view('staffAttend',$data);
		$this->footer->index();
	}
	
	public function staffAttnSubmit(){
        @$staff_id = $_POST['staff_name'];
        @$date = $_POST['staff_in_dt'];

		$d = date_parse_from_format("Y-m-d", $date);
		@$daytype= $_POST['daytype'];

		if($staff_id == ""){
        	$response['error'] = true;
		 	$response['success'] = false;
			$response['errorMsg'] = "Error!!! Select staff";			
			echo json_encode($response);
			exit();	
        }
        if($date == ""){
        	$response['error'] = true;
		 	$response['success'] = false;
			$response['errorMsg'] = "Error!!! Select date";			
			echo json_encode($response);
			exit();	
        }
        if($daytype == ""){
        	$response['error'] = true;
		 	$response['success'] = false;
			$response['errorMsg'] = "Error!!! Select daytype";			
			echo json_encode($response);
			exit();	
        }

		if($d['month'] < 10){
	       	$month = "0".$d['month'];
	       }else{
	       	$month = $d['month'];
	       }
		$data = array(
		'staff_id' => $staff_id,
		'user_check_in' => $date,
		'month' => $month,
		'year' => $d['year'],
		'day_type' => $daytype,
		'added_by' => '1',
		'added_on' => date('Y-m-d h:i:s')
		);
 		$tableName =  STAFF_ATTENDANCE_TABLE;
		$result = $this->Staff_model->saveData($tableName, $data);
		if($result != false){
			$response['success'] = true;
 	 		$response['error'] = false;
 	 		$response['successMsg'] = "Submit Successfully";
 	 		$response['redirect'] = base_url()."staff/staffAtten";
		}else{
			$response['error'] = true;
 	 		$response['success'] = false;
			$response['Msg'] = "Error!!! Please contact IT Dept";
		}
		echo json_encode($response);
 	}
		

	public function staffAttendReport(){
 		$staff_table =  STAFF_MASTER;
 		$filds = "staff_id,staff_first_name,staff_last_name";
 		$data['staff'] = $this->Staff_model->getStaffList($filds,$staff_table);
		//echo "<pre>"; print_r($data);exit();
		$this->header->index();
		$this->load->view('staffAttnReport', $data);
		$this->footer->index();
 	}

 	public function attnReport(){
 		$from_date = date('Y-m-d', strtotime($_POST['from_date']));
 		$to_date = date('Y-m-d', strtotime($_POST['to_date']."+ 1 day"));
 		/*echo json_encode($to_date);
 		exit();*/
 		$staff_id = $_POST['staff'];
 		$staff = $this->helper_model->selectQuery("SELECT staff_id,user_check_in,day_type,DATE_FORMAT(user_check_in, '%Y-%m-%d') as date from staff_attendance where user_check_in >= '$from_date' and user_check_in <= '$to_date' and staff_id = '$staff_id'");

 		

 		$tableName =  "company_holidays";
 		$select = "*";
 		$where = "holiday_date >= '$from_date' and holiday_date <= '$to_date'";
 		$holidays = $this->Staff_model->getwheredata($select,$tableName,$where);
		$dateDiff = date_diff(date_create($to_date), date_create($from_date));

		$staffCnt = count($staff);
		$holidayCnt = count($holidays);
		$leaves = $staffCnt - $dateDiff->days;

		$holidayArray = array();
		foreach ($holidays as $key => $value) {
			$holidayArray[$key] = $value->holiday_date;
		}

		$staffArray = array();
		foreach ($staff as $key => $value) {
			$staffArray[$key] = $value['date'];
		}

		$data = "";
		for ($i=0; $i < $dateDiff->days; $i++) 
		{ 
			$j = 0;
			$key = array_search($from_date, $holidayArray);
			if($key !== false){
				
				$data .= '<tr>
						<td>'.$from_date.'</td>
						<td>Holiday</td>
					</tr>';
				$j++;
			}

			$key = array_search($from_date, $staffArray);
			if($key !== false){
				if($staff[$key]['day_type']=='2')
				{
				$data .= '<tr>
						<td>'.$from_date.'</td>
						<td>Present at '.$staff[$key]['user_check_in'].'</td>
					</tr>';
				$j++;
				}
				else
				{
					$data .= '<tr>
						<td>'.$from_date.'</td>
						<td>Present at '.$staff[$key]['user_check_in'].'(Half Day)</td>
					</tr>';
				$j++;
				}
			}
			if($j == 0){
				$data .= '<tr>
						<td>'.$from_date.'</td>
						<td>Leave</td>
					</tr>';
			}
			$from_date = date('Y-m-d', strtotime('+1 day', strtotime($from_date)));
		}
		$response['response'] = $data;
		$response['labour'] = $holidays;
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
