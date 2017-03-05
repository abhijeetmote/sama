<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contractor extends MX_Controller {

	function __construct() {
	    parent::__construct();

		$this->load->module('header/header');
		$this->load->module('footer/footer');
		$this->load->model('Contractor/Contractor_model');
		$this->load->model('helper/helper_model');
	}

	public function contractorMaster()
	{	
/*		$select = 'site_id,site_name';
		$tableName = 'site_master';
		$column = "isactive";
		$value = "1";
		$data['sitelist'] = $this->Contractor_model->getData($select, $tableName, $column, $value);*/
		$this->header->index();
		$this->load->view('contractorAdd');
		$this->footer->index();
	}
	public function addcontractor()
	{	
		
		
		 $contractor_name = isset($_POST['contractor_name']) ? $_POST['contractor_name'] : "";
		 $contractor_mobile_number = isset($_POST['contractor_contact_number']) ? $_POST['contractor_contact_number'] : "";
		 $contractor_phone_number = isset($_POST['contractor_phone_number']) ? $_POST['contractor_phone_number'] : "";
		 $contractor_email = isset($_POST['contractor_email']) ? $_POST['contractor_email'] : "";
		 $contractor_notes = isset($_POST['contractor_notes']) ? $_POST['contractor_notes'] : "";
		 $contractor_service_regn = isset($_POST['contractor_service_regn']) ? $_POST['contractor_service_regn'] : "";
		 $contractor_pan_num = isset($_POST['contractor_pan_num']) ? $_POST['contractor_pan_num'] : "";
		 $contractor_section_code = isset($_POST['contractor_section_code']) ? $_POST['contractor_section_code'] : "";
		 $contractor_payee_name = isset($_POST['contractor_payee_name']) ? $_POST['contractor_payee_name'] : "";
		 $contractor_address = isset($_POST['contractor_address']) ? $_POST['contractor_address'] : "";

		 $contractor_vat = isset($_POST['contractor_vat']) ? $_POST['contractor_vat'] : "";
		 $contractor_cst = isset($_POST['contractor_cst']) ? $_POST['contractor_cst'] : "";
		 $contractor_gst = isset($_POST['contractor_gst']) ? $_POST['contractor_gst'] : "";
		 //$site_id = isset($_POST['site_id']) ? $_POST['site_id'] : "";

		 $select = "contractor_id";
		 $tableName = CONTRACTOR_TABLE;
		 $column = "contractor_pan_num";
		 $value = $contractor_pan_num;
		 $contractorResult = $this->Contractor_model->getData($select,$tableName,$column, $value);
		 if(!empty($contractorResult)){
		 	$response['error'] = true;
		 	$response['success'] = false;
			$response['errorMsg'] = "Error!!! Contractor already exist";			
			echo json_encode($response);
			exit();	
		 }

		 $data = array(
			'contractor_name' => $contractor_name,
			'contractor_contact_number' => $contractor_mobile_number,
			'contractor_phone_number' => $contractor_phone_number,
			'contractor_email' => $contractor_email,
			'contractor_notes' => $contractor_notes,
			'contractor_service_regn' => $contractor_service_regn,
			'contractor_pan_num' => $contractor_pan_num,
			'contractor_section_code' => $contractor_section_code,
			'contractor_payee_name' => $contractor_payee_name,
			'contractor_address' => $contractor_address,
			'contractor_vat' => $contractor_vat,
			'contractor_cst' => $contractor_cst,
			'contractor_gst' => $contractor_gst,
			'status' => '1',
			'added_by' => '1',
			'added_on' => date('Y-m-d h:i:s')
		);
/*
		  $select = "contractor_id";
		 $contractor_table = CONTRACTOR_TABLE;
		 $column = "contractor_pan_num";
		 $value = $contractor_pan_num;
		 $contractorResult = $this->Contractor_model->getData($select,$contractor_table,$column, $value);
		 if(!empty($contractorResult)){
		 	$response['error'] = true;
		 	$response['success'] = false;
			$response['errorMsg'] = "Error!!! Contractor already exist";			
			echo json_encode($response);
			exit();	
		 }*/

 		$contractor_table =  CONTRACTOR_TABLE;

 		$this->db->trans_begin();
 		 //contractor record insertion
 		$contractor_id = $this->Contractor_model->saveData($contractor_table,$data);

 	//contractor data insertion end

 	//Ledger data insertion start
 	if(isset($contractor_id) && !empty($contractor_id)) {
		$select = " ledger_account_id ";
		$ledgertable = LEDGER_TABLE ;
		$context = CONTRACTOR_CONTEXT;
		$entity_type = GROUP_ENTITY;
		$where =  array('context' =>  $context, 'entity_type' => $entity_type);
 	 	$groupid = $this->Contractor_model->getGroupId($select,$ledgertable,$context,$entity_type,$where);
 	 	$parent_data = $groupid->ledger_account_id;
 	 	$reporting_head = REPORT_HEAD_EXPENSE;
 	 	$nature_of_account = DR;
 	 	$direct = DIRECT;
 	 	// ledger data preparation

 	 	$leddata = array(
		'ledger_account_name' => $contractor_name."_".$contractor_id,
		'parent_id' => $parent_data,	
		'report_head' => $reporting_head,
		'nature_of_account' => $nature_of_account,
		'context_ref_id' => $contractor_id,
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
 	 	$ledger_id = $this->Contractor_model->saveData($legertable,$leddata);

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
 	$update_data =  array('contractor_ledger_id' => $ledger_id);
 	$updat_column_Name = "contractor_id";
 	$update_value = $contractor_id;
 	$update_id = $this->Contractor_model->updateData($contractor_table,$update_data,$updat_column_Name,$update_value);
 	//end


	if(isset($update_id) && !empty($update_id)){
		$this->db->trans_commit();
		$response['success'] = true;
		$response['error'] = false;
		$response['successMsg'] = "Contractor Added Successfully";
		$response['redirect'] = base_url()."contractor/contractorList";

	}else{
		$this->db->trans_rollback();
 		$response['error'] = true;
 		$response['success'] = false;
		$response['errorMsg'] = "Error!!! Please contact IT Dept";
	}
	echo json_encode($response);
 	}


 	public function contractorList(){
 		$contractor_table =  CONTRACTOR_TABLE;
 		$filds = "contractor_id,contractor_name,contractor_contact_number,contractor_phone_number,contractor_address,contractor_email,contractor_pan_num,contractor_payee_name";
 		$data['list'] = $this->Contractor_model->getVendorLit($filds,$contractor_table);
 		//echo "<pre>";print_r($data['list']);
        $this->header->index();
		$this->load->view('ContractorList', $data);
		$this->footer->index();
 	}

 	public function contractorDelete(){
        $contractor_id = $_POST['id'];
        $contractor_table =  CONTRACTOR_TABLE;
        $resultMaster = $this->helper_model->delete($contractor_table,'contractor_id',$contractor_id);
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
		$tableName = CONTRACTOR_TABLE;
		$column = 'contractor_id';
		$value = $id;
		$data['contractor'] = $this->Contractor_model->getData($select, $tableName, $column, $value);
		$data['update'] = true;
/*		$select = 'site_id,site_name';
		$tableName = 'site_master';
		$column = "isactive";
		$value = "1";
		$data['sitelist'] = $this->Contractor_model->getData($select, $tableName, $column, $value);*/
		$this->header->index();
		$this->load->view('contractorAdd', $data);
		$this->footer->index();
 	}

 	public function contractorUpdate(){        

 		 $contractor_name = isset($_POST['contractor_name']) ? $_POST['contractor_name'] : "";
		 $contractor_mobile_number = isset($_POST['contractor_contact_number']) ? $_POST['contractor_contact_number'] : "";
		 $contractor_phone_number = isset($_POST['contractor_phone_number']) ? $_POST['contractor_phone_number'] : "";
		 $contractor_email = isset($_POST['contractor_email']) ? $_POST['contractor_email'] : "";
		 $contractor_notes = isset($_POST['contractor_notes']) ? $_POST['contractor_notes'] : "";
		 $contractor_service_regn = isset($_POST['contractor_service_regn']) ? $_POST['contractor_service_regn'] : "";
		 $contractor_pan_num = isset($_POST['contractor_pan_num']) ? $_POST['contractor_pan_num'] : "";
		 $contractor_section_code = isset($_POST['contractor_section_code']) ? $_POST['contractor_section_code'] : "";
		 $contractor_payee_name = isset($_POST['contractor_payee_name']) ? $_POST['contractor_payee_name'] : "";
		 $contractor_address = isset($_POST['contractor_address']) ? $_POST['contractor_address'] : "";
		 $contractor_vat = isset($_POST['contractor_vat']) ? $_POST['contractor_vat'] : "";
		 $contractor_cst = isset($_POST['contractor_cst']) ? $_POST['contractor_cst'] : "";
		 $contractor_gst = isset($_POST['contractor_gst']) ? $_POST['contractor_gst'] : "";

		 $contractor_ledger_id = isset($_POST['contractor_ledger_id']) ? $_POST['contractor_ledger_id'] : "";

		 $contractor_update = array(
			'contractor_name' => $contractor_name,
			'contractor_contact_number' => $contractor_mobile_number,
			'contractor_phone_number' => $contractor_phone_number,
			'contractor_email' => $contractor_email,
			'contractor_notes' => $contractor_notes,
			'contractor_service_regn' => $contractor_service_regn,
			'contractor_pan_num' => $contractor_pan_num,
			'contractor_section_code' => $contractor_section_code,
			'contractor_payee_name' => $contractor_payee_name,
			'contractor_address' => $contractor_address,
			'contractor_vat' => $contractor_vat,
			'contractor_cst' => $contractor_cst,
			'contractor_gst' => $contractor_gst,
			'status' => '1',
			'updated_by' => '1',
			'updated_on' => date('Y-m-d h:i:s')
		);
     
		$this->db->trans_begin();
		$contractor_table = CONTRACTOR_TABLE;
		$contractor_column = 'contractor_id';
		$contractor_id = $_POST['id'];

		$result = $this->Contractor_model->updateData($contractor_table, $contractor_update, $contractor_column, $contractor_id);

		if(isset($result) && $result == true) {
			$ledgertable = LEDGER_TABLE;
			$ledger_column = 'ledger_account_id';
			$ledger_update = array(
			'ledger_account_name' => $contractor_name."_".$contractor_id,
			'status' => '1',
			'updated_by' => '1',
			'updated_on' => date('Y-m-d h:i:s')
			);

			$ledger_result = $this->Contractor_model->updateData($ledgertable, $ledger_update, $ledger_column, $contractor_ledger_id);

			if(empty($ledger_result) || $ledger_result == false) {

				$this->db->trans_rollback();
	 	 		$response['error'] = true;
	 	 		$response['success'] = false;
				$response['errorMsg'] = "Error!!! Please contact IT Dept";

			} else{
				$this->db->trans_commit();
				$response['success'] = true;
				$response['error'] = false;
				$response['successMsg'] = "Contractor Updated Successfully";
				$response['redirect'] = base_url()."contractor/contractorList";
			}
		} else {

			$this->db->trans_rollback();
 	 		$response['error'] = true;
 	 		$response['success'] = false;
			$response['errorMsg'] = "Error!!! Please contact IT Dept";
		}

        echo json_encode($response);
 	}

	public function contractortask()
	{	
		$select = 'site_id,site_name';
		$tableName = 'site_master';
		$column = "isactive";
		$value = "1";
		$data['sitelist'] = $this->Contractor_model->getData($select, $tableName, $column, $value);
		$select = 'contractor_id,contractor_name';
		$tableName = 'contractors_master';
		$column = "status";
		$value = "1";
		$data['contractorlist'] = $this->Contractor_model->getData($select, $tableName, $column, $value);
		$this->header->index();
		$this->load->view('contractortask',$data);
		$this->footer->index();
	}
	public function assigncontract()
	{
		 $contractor_id = isset($_POST['contractor_id']) ? $_POST['contractor_id'] : "";
		 $site_id = isset($_POST['site_id']) ? $_POST['site_id'] : "";
		 $contract_amount = isset($_POST['contract_amount']) ? $_POST['contract_amount'] : "";
		 $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : "";
		 $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : "";
		 $remark = isset($_POST['other_remark']) ? $_POST['other_remark'] : "";

		 	if(isset($start_date) && !empty($start_date)){
		 	$start_date = $this->helper_model->dbDate($start_date);
			 }

			if(isset($end_date) && !empty($end_date)){
		 	$end_date = $this->helper_model->dbDate($end_date);
			 }

			 $data = array(
			'contractor_id' => $contractor_id,
			'site_id' => $site_id,
			'contract_amt' => $contract_amount,
			'start_date' => $start_date,
			'end_date' => $end_date,
			'remark' => $remark,
			'status' => '1',
			'added_by' => '1',
			'added_on' => date('Y-m-d h:i:s')
		);

		$contract_table =  CONTRACTDET_TABLE;

 		$this->db->trans_begin();
 		 //contractor record insertion
 		$contractor_id = $this->Contractor_model->saveData($contract_table,$data);

		 
	if(isset($contractor_id) && !empty($contractor_id)){
		$this->db->trans_commit();
		$response['success'] = true;
		$response['error'] = false;
		$response['successMsg'] = "Contract Assigned Successfully";
		$response['redirect'] = base_url()."contractor/contractList";

	}else{
		$this->db->trans_rollback();
 		$response['error'] = true;
 		$response['success'] = false;
		$response['errorMsg'] = "Error!!! Please contact IT Dept";
	}
	echo json_encode($response);
		

	}

	public function contractList()
	{
		/*$contract_table =  CONTRACTDET_TABLE;
 		$filds = "contract_id,contract_id,site_id,contract_amount,start_date,end_date";
 		$data['list'] = $this->Contractor_model->getVendorLit($filds,$contractor_table);*/
 		//echo "<pre>";print_r($data['list']);
 		$date = date('Y-m-d');
 	
        $data['contractdetails'] = $this->helper_model->selectQuery("SELECT site_master.site_name,contractors_master.contractor_name,contractor_details.* FROM site_master,contractors_master,contractor_details where site_master.site_id=contractor_details.site_id AND contractors_master.contractor_id=contractor_details.contractor_id");
     /*   echo "<pre>";print_r($data['contractdetails']);
        exit();*/
        $this->header->index();
		$this->load->view('contractList', $data);
		$this->footer->index();
	}

	public function updatecontractdet($id)
	{
		 $select = '*';
		$tableName = CONTRACTDET_TABLE;
		$column = 'contract_id';
		$value = $id;
		$data['contract'] = $this->Contractor_model->getData($select, $tableName, $column, $value);
		$data['update'] = true;
		$select = 'site_id,site_name';
		$tableName = 'site_master';
		$column = "isactive";
		$value = "1";
		$data['sitelist'] = $this->Contractor_model->getData($select, $tableName, $column, $value);
		$select = 'contractor_id,contractor_name';
		$tableName = CONTRACTOR_TABLE;
		$column = "status";
		$value = "1";
		$data['contractorlist'] = $this->Contractor_model->getData($select, $tableName, $column, $value);
		/*print_r($data);
		exit();*/
		$this->header->index();
		$this->load->view('contractortask', $data);
		$this->footer->index();
	

	}
}