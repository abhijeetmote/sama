<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends MX_Controller {

	function __construct() {
	    parent::__construct();

		$this->load->module('header/header');
		$this->load->module('footer/footer');
		$this->load->model('Site_model');
		$this->load->model('helper/helper_model');
	}

	public function index()
	{
		
		$this->header->index();
		$this->load->view('SiteAdd');
		$this->footer->index();
	}
	public function addsite()
	{	
		 $site_name = isset($_POST['site_name']) ? $_POST['site_name'] : "";
		 $site_address = isset($_POST['address']) ? $_POST['address'] : "";
		 $total_amount = isset($_POST['total_amount']) ? $_POST['total_amount'] : "";
		 $spend_amount = isset($_POST['spend_amount']) ? $_POST['spend_amount'] : "";
		 $slabs = isset($_POST['slabs']) ? $_POST['slabs'] : "";
		 $comment = isset($_POST['comment']) ? trim($_POST['comment']) : "";
		 $start_date = isset($_POST['start_date']) ? trim($_POST['start_date']) : "";
		 $end_date = isset($_POST['end_date']) ? trim($_POST['end_date']) : "";
		
		 //startdate conversion
		 if(isset($start_date) && !empty($start_date)){
		 	$start_date = $this->helper_model->dbDate($start_date);
		 }

		 // end date conversion
		 if(isset($end_date) && !empty($end_date)){
		 	$end_date = $this->helper_model->dbDate($end_date);
		 }
			$site = array(
			'site_name' => $site_name,
			'address' => $site_address,
			'start_date' => $start_date,
			'end_date' => $end_date,
			'total_amount' => $total_amount,
			'spend_amount' => $spend_amount,
			'pay_slabs' => $slabs,
			'comment' => $comment,
			'created_by' => 1,
			'added_on' => date('Y-m-d')
		);
		
		$select = 'site_id';
		$tableName = 'site_master';
		$column = 'site_id';
		$value = $_POST['site_id'];

		 //$check = $this->helper_model->select($select, $tableName, $column, $value);
		
			$result = $this->helper_model->insert($tableName,$site);
			if($result == true){
				
			    $response['success'] = true;
				$response['error'] = false;
				$response['successMsg'] = "Successfully Submit";
				$response['redirect'] = base_url()."site/viewsite";
			} else{
				$response['success'] = false;
				$response['error'] = true;
				$response['errorMsg'] = "Please contact IT Dept";
			}
		
		echo json_encode($response);
		
	}
	public function viewsite()
	{
		
		$site_table =  SITE_MASTER;
 		$filds = "site_id,site_name,address,start_date,end_date,comment";
 		$data['list'] = $this->Site_model->getSiteLit($filds,$site_table);
		
 		/*echo "<pre>";
 		print_r($data);
 		exit();*/

        $this->header->index();
		$this->load->view('sitelist', $data);
		$this->footer->index();
	}
	public function editsite()
	{
		$siteid=$_GET['id'];
		$result = $this->Site_model->viewsitedet($siteid);
		$result['sitedata']=$result;
		$this->header->index();
		$this->load->view('editsite',$result);
		$this->footer->index();
	}
	public function update($id)
	{        
        $select = '*';
		$tableName = 'site_master';
		$column = 'site_id';
		$value = $id;
		$data['site'] = $this->helper_model->select($select, $tableName, $column, $value);
		$data['update'] = true;
		$this->header->index();
		$this->load->view('SiteAdd', $data);
		$this->footer->index();
 	}
	public function siteUpdate(){        
        
		 $site_name = isset($_POST['site_name']) ? $_POST['site_name'] : "";
		 $site_address = isset($_POST['address']) ? $_POST['address'] : "";
		 $total_amount = isset($_POST['total_amount']) ? $_POST['total_amount'] : "";
		 $spend_amount = isset($_POST['spend_amount']) ? $_POST['spend_amount'] : "";
		 $comment = isset($_POST['comment']) ? trim($_POST['comment']) : "";
		 $slabs = isset($_POST['slabs']) ? trim($_POST['slabs']) : "";
		 $start_date = isset($_POST['start_date']) ? trim($_POST['start_date']) : "";
		 $end_date = isset($_POST['end_date']) ? trim($_POST['end_date']) : "";
		
		 //startdate conversion
		 if(isset($start_date) && !empty($start_date)){
		 	$start_date = $this->helper_model->dbDate($start_date);
		 }

		 // end date conversion
		 if(isset($end_date) && !empty($end_date)){
		 	$end_date = $this->helper_model->dbDate($end_date);
		 }
			$site = array(
			'site_name' => $site_name,
			'address' => $site_address,
			'start_date' => $start_date,
			'end_date' => $end_date,
			'total_amount' => $total_amount,
			'spend_amount' => $spend_amount,
			'pay_slabs' => $slabs,
			'comment' => $comment,
			'updated_by' => 1,
			'updated_on' => date('Y-m-d')
		);

		$tableName = 'site_master';
		$column = 'site_id';
		$value = $_POST['site_id'];

		$result = $this->helper_model->update($tableName, $site, $column, $value);
		if($result == true){
			$response['success'] = true;
			$response['successMsg'] = "Record Updated";
			$response['redirect'] = base_url()."site/viewsite";
        }else{
        	$response['success'] = false;
			$response['successMsg'] = "Something wrong please try again";
        }

        echo json_encode($response);
 	}
	 	public function siteDelete(){
        $site_id = $_POST['site_id'];
        $resultMaster = $this->helper_model->delete('site_master','site_id',$site_id);
        if($resultMaster != false){
        	//$resultDetails = $this->helper_model->delete('vehicle_details','vehicle_id',$vehicle_id);
        	$response['success'] = true;
			$response['successMsg'] = "Record Deleted";
        }else{
        	$response['success'] = false;
			$response['successMsg'] = "Something wrong please try again";
        }
        echo json_encode($response);
 	}
}
