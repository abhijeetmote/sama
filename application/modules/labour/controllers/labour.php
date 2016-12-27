<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Labour extends MX_Controller {

	function __construct() {
	    parent::__construct();

		$this->load->module('header/header');
		$this->load->module('footer/footer');
		$this->load->model('labour/labour_model');
		$this->load->model('helper/helper_model');
		//$this->load->library('session');
		
	}

	public function labourMaster()
	{
		$select = 'site_id,site_name';
		$tableName = 'site_master';
		$column = "isactive";
		$value = "1";
		$data['sitelist'] = $this->labour_model->getData($select, $tableName, $column, $value);
		//echo "<pre>"; print_r($data); exit();
		$this->header->index();
		$this->load->view('labourMaster',$data);
		$this->footer->index();
	}

	public function labourMasterSubmit()
	{
		
		 $labour_fname = isset($_POST['labour_fname']) ? $_POST['labour_fname'] : "";
		 $labour_mname = isset($_POST['labour_mname']) ? $_POST['labour_mname'] : "";
		 $labour_lname = isset($_POST['labour_lname']) ? $_POST['labour_lname'] : "";
		 $labour_dob = isset($_POST['labour_dob']) ? $_POST['labour_dob'] : "";
		 $labour_address = isset($_POST['labour_address']) ? trim($_POST['labour_address']) : "";
		 $labour_mobile = isset($_POST['labour_mobile']) ? $_POST['labour_mobile'] : "";
		 $labour_mobile1 = isset($_POST['labour_mobile1']) ? $_POST['labour_mobile1'] : "";
		 $site_id=isset($_POST['site_id']) ? $_POST['site_id'] : "";

		 
		 //bdate conversion
		 if(isset($labour_dob) && !empty($labour_dob)){
		 	$labour_dob = $this->helper_model->dbDate($labour_dob);
		 }

		 // licence exp date conversion
		 if(isset($labour_licence_exp) && !empty($labour_licence_exp)){
		 	$labour_licence_exp = $this->helper_model->dbDate($labour_licence_exp);
		 }
		 
	 // labour data insertion start
		 $data = array(
				'labour_fname' => $labour_fname,
				'labour_mname' => $labour_mname,
				'labour_lname' => $labour_lname,
				'labour_bdate' => $labour_dob,
				'labour_mobno' => $labour_mobile,
				'labour_mobno1' => $labour_mobile1,
				'labour_add' => $labour_address,
				'site_id'=>$site_id,	
				'isactive' => '1',
				'added_by' => '1',
				'added_on' => date('Y-m-d h:i:s')
			);
 	$labour_table =  LABOUR_TABLE;

 	$this->db->trans_begin();
 	 //labour record insertion
 	$labour_id = $this->labour_model->saveData($labour_table,$data);

 	//diver data insertion end

 	//Ledger data insertion start
 	if(isset($labour_id) && !empty($labour_id)) {
		$select = " ledger_account_id ";
		$ledgertable = LEDGER_TABLE ;
		$context = LABOUR_CONTEXT;
		$entity_type = GROUP_ENTITY;
		$where =  array('context' =>  $context, 'entity_type' => $entity_type);
 	 	$groupid = $this->labour_model->getGroupId($select,$ledgertable,$context,$entity_type,$where
);
 
 	 	$parent_data = $groupid->ledger_account_id;
 	 	$reporting_head = REPORT_HEAD_EXPENSE;
 	 	$nature_of_account = DR;
 	 	$direct = DIRECT;
 	 	// ledger data preparation

 	 	$leddata = array(
		'ledger_account_name' => $labour_fname."_".$labour_id,
		'parent_id' => $parent_data,
		'report_head' => $reporting_head,
		'nature_of_account' => $nature_of_account,
		'context_ref_id' => $labour_id,
		'context' => $context,
		'ledger_start_date' => date('Y-m-d h:i:s'),
		'behaviour' => $reporting_head,
		'operating_type' => $direct,
		'entity_type' => 3,
		'defined_by' => 1,
		'status' => '1',
		'added_by' => '1',
		'added_on' => date('Y-m-d h:i:s'));
 	 	//Insert Ledger data with Deriver Id
 	 	$legertable =  LEDGER_TABLE;
 	 	$ledger_id = $this->labour_model->saveData($legertable,$leddata);

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

 	//labour update with ledger id start
 	$update_data =  array('ledger_id' => $ledger_id);
 	$updat_column_Name = "labour_id";
 	$update_value = $labour_id;
 	$update_id = $this->labour_model->updateData($labour_table,$update_data,$updat_column_Name,$update_value);
 	//end


	if(isset($update_id) && !empty($update_id)){
		//$this->session->set_msg(array('status' => 'success','msg'=>'labour '));
		$this->db->trans_commit();
		$response['success'] = true;
		$response['error'] = false;
		$response['successMsg'] = "labour Added Successfully";
		$response['redirect'] = base_url()."labour/labourList";

	}else{
		$this->db->trans_rollback();
 		$response['error'] = true;
 		$response['success'] = false;
		$response['errorMsg'] = "Error!!! Please contact IT Dept";
	}
	echo json_encode($response);
 	}

 	public function labourList(){
 		$labour_table =  LABOUR_TABLE;
 		$filds = "labour_id,labour_fname,labour_mname,labour_lname,labour_add,labour_photo,labour_bdate,labour_mobno,labour_mobno1,site_id,ledger_id";
 		$data['list'] = $this->labour_model->getLabourLit($filds,$labour_table);
 		//echo "<pre>";print_r($data['list']);
        $this->header->index();
		$this->load->view('labourList', $data);
		$this->footer->index();
 	}

 	public function labourDelete(){
        $labour_id = $_POST['id'];
        $labour_table =  LABOUR_TABLE;
        $resultMaster = $this->helper_model->delete($labour_table,'labour_id',$labour_id);
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
		$tableName = LABOUR_TABLE;
		$column = 'labour_id';
		$value = $id;
		$data['labour'] = $this->labour_model->getData($select, $tableName, $column, $value);
		$data['update'] = true;
		$select = 'site_id,site_name';
		$tableName = 'site_master';
		$column = "isactive";
		$value = "1";
		$data['sitelist'] = $this->labour_model->getData($select, $tableName, $column, $value);
		
		$this->header->index();
		$this->load->view('labourMaster', $data);
		$this->footer->index();
 	}

 	public function labourUpdate(){        

 		 $labour_fname = isset($_POST['labour_fname']) ? $_POST['labour_fname'] : "";
		 $labour_mname = isset($_POST['labour_mname']) ? $_POST['labour_mname'] : "";
		 $labour_lname = isset($_POST['labour_lname']) ? $_POST['labour_lname'] : "";
		 $labour_dob = isset($_POST['labour_dob']) ? $_POST['labour_dob'] : "";
		 $labour_address = isset($_POST['labour_address']) ? trim($_POST['labour_address']) : "";
		 $labour_mobile = isset($_POST['labour_mobile']) ? $_POST['labour_mobile'] : "";
		 $labour_mobile1 = isset($_POST['labour_mobile1']) ? $_POST['labour_mobile1'] : "";
		 $labour_licence = isset($_POST['labour_licence']) ? $_POST['labour_licence'] : "";
		 $labour_licence_exp = isset($_POST['licence_exp']) ? $_POST['licence_exp'] : "";
		 $labour_pan = isset($_POST['labour_pan']) ? $_POST['labour_pan'] : "";
		 $labour_fix_pay = isset($_POST['labour_fix_pay']) ? $_POST['labour_fix_pay'] : "";
		 $labour_da_pay = isset($_POST['labour_da']) ? $_POST['labour_da'] : "";
		 $labour_na_pay = isset($_POST['labour_na']) ? $_POST['labour_na'] : "";
		 $labour_da = isset($_POST['da']) ? 2 : 1;
		 $labour_night = isset($_POST['night']) ? 2 : 1;
		 $ledger_id = isset($_POST['ledger_id']) ? $_POST['ledger_id'] : "";
		 $site_id = isset($_POST['site_id']) ? $_POST['site_id'] : "";
		 //bdate conversion
		 if(isset($labour_dob) && !empty($labour_dob)){
		 	$labour_dob = $this->helper_model->dbDate($labour_dob);
		 }

		 // licence exp date conversion
		 if(isset($labour_licence_exp) && !empty($labour_licence_exp)){
		 	$labour_licence_exp = $this->helper_model->dbDate($labour_licence_exp);
		 }

	 // labour data insertion start
		 $labour_update = array(
				'labour_fname' => $labour_fname,
				'labour_mname' => $labour_mname,
				'labour_lname' => $labour_lname,
				'labour_bdate' => $labour_dob,
				'labour_mobno' => $labour_mobile,
				'labour_mobno1' => $labour_mobile1,
				'labour_add' => $labour_address,
				'labour_licno' => $labour_licence,
				'labour_licexpdate' => $labour_licence_exp,
				'labour_panno' => $labour_pan,
				'labour_fix_pay' => $labour_fix_pay,
				'labour_da' => $labour_da_pay,
				'labour_na' => $labour_na_pay,
				'is_da' => $labour_da,
				'is_night_allowance' => $labour_night,
				'site_id' => $site_id,
				'isactive' => '1',
				'updated_by' => '1',
				'updated_on' => date('Y-m-d h:i:s')
				
			);

    
		$this->db->trans_begin();
		$labour_table = LABOUR_TABLE;
		$labour_column = 'labour_id';
		$labour_id = $_POST['id'];

		$result = $this->labour_model->updateData($labour_table, $labour_update, $labour_column, $labour_id);

		if(isset($result) && $result == true) {
			$ledgertable = LEDGER_TABLE;
			$ledger_column = 'ledger_account_id';
			$ledger_update = array(
			'ledger_account_name' => $labour_fname."_".$labour_id,
			'status' => '1',
			'updated_by' => '1',
			'updated_on' => date('Y-m-d h:i:s')
			);

			$ledger_result = $this->labour_model->updateData($ledgertable, $ledger_update, $ledger_column, $ledger_id);

			if(empty($ledger_result) || $ledger_result == false) {

				$this->db->trans_rollback();
	 	 		$response['error'] = true;
	 	 		$response['success'] = false;
				$response['errorMsg'] = "Error!!! Please contact IT Dept";

			} else{
				$this->db->trans_commit();
				$response['success'] = true;
				$response['error'] = false;
				$response['successMsg'] = "Labour Updated Successfully";
				$response['redirect'] = base_url()."labour/labourList";
			}
		} else {

			$this->db->trans_rollback();
 	 		$response['error'] = true;
 	 		$response['success'] = false;
			$response['errorMsg'] = "Error!!! Please contact IT Dept";
		}

        echo json_encode($response);
 	}

 	public function labourAttend(){

 		$date = date('Y-m-d');
        $data['labourdetails'] = $this->helper_model->selectQuery("SELECT labour_id,labour_fname,labour_lname FROM labour_master where labour_id not in (select labour_id from labour_attendance where DATE_FORMAT(user_check_in, '%Y-%m-%d') = '$date')");
        //echo "<pre>"; print_r($data);exit();
        $this->header->index();
        $this->load->view('labourAttend',$data);
		$this->footer->index();
 	} 

 	public function labourAttnSubmit(){
        $labour_id = $_POST['labour_name'];
        $date = $_POST['labour_in_dt'];

		$d = date_parse_from_format("Y-m-d", $date);
		$daytype= $_POST['daytype'];

		if($d['month'] < 10){
	       	$month = "0".$d['month'];
	       }else{
	       	$month = $d['month'];
	       }
		$data = array(
		'labour_id' => $labour_id,
		'user_check_in' => $date,
		'month' => $month,
		'year' => $d['year'],
		'day_type' => $daytype,
		'added_by' => '1',
		'added_on' => date('Y-m-d h:i:s')
		);
 		$tableName =  LABOUR_ATTENDANCE_TABLE;
		$result = $this->labour_model->saveData($tableName, $data);
		if($result != false){
			$response['success'] = true;
 	 		$response['error'] = false;
 	 		$response['successMsg'] = "Submit Successfully";
		}else{
			$response['error'] = true;
 	 		$response['success'] = false;
			$response['Msg'] = "Error!!! Please contact IT Dept";
		}
		echo json_encode($response);
 	}

 	public function labourAttendReport(){
 		$labour_table =  LABOUR_TABLE;
 		$filds = "labour_id,labour_fname,labour_lname";
 		$data['labour'] = $this->labour_model->getLabourLit($filds,$labour_table);
		//echo "<pre>"; print_r($data);exit();
		$this->header->index();
		$this->load->view('labourAttnReport', $data);
		$this->footer->index();
 	}

 	public function attnReport(){
 		$from_date = date('Y-m-d', strtotime($_POST['from_date']));
 		$to_date = date('Y-m-d', strtotime($_POST['to_date']."+ 1 day"));
 		/*echo json_encode($to_date);
 		exit();*/
 		$labour_id = $_POST['labour'];
 		$labour = $this->helper_model->selectQuery("SELECT labour_id,user_check_in,day_type,DATE_FORMAT(user_check_in, '%Y-%m-%d') as date from labour_attendance where user_check_in >= '$from_date' and user_check_in <= '$to_date' and labour_id = '$labour_id'");

 		

 		$tableName =  "company_holidays";
 		$select = "*";
 		$where = "holiday_date >= '$from_date' and holiday_date <= '$to_date'";
 		$holidays = $this->labour_model->getwheredata($select,$tableName,$where);
		$dateDiff = date_diff(date_create($to_date), date_create($from_date));

		$labourCnt = count($labour);
		$holidayCnt = count($holidays);
		$leaves = $labourCnt - $dateDiff->days;

		$holidayArray = array();
		foreach ($holidays as $key => $value) {
			$holidayArray[$key] = $value->holiday_date;
		}

		$labourArray = array();
		foreach ($labour as $key => $value) {
			$labourArray[$key] = $value['date'];
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

			$key = array_search($from_date, $labourArray);
			if($key !== false){
				if($labour[$key]['day_type']=='2')
				{
				$data .= '<tr>
						<td>'.$from_date.'</td>
						<td>Present at '.$labour[$key]['user_check_in'].'</td>
					</tr>';
				$j++;
				}
				else
				{
					$data .= '<tr>
						<td>'.$from_date.'</td>
						<td>Present at '.$labour[$key]['user_check_in'].'(Half Day)</td>
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
}
