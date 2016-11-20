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
			$site = array(
			'site_name' => $_POST['site_name'],
			'address' => $_POST['address'],
			'start_date' => $_POST['start_date'],
			'end_date' => $_POST['end_date'],
			'total_amount' => $_POST['total_amount'],
			'spend_amount' => $_POST['spend_amount'],
			'comment' => $_POST['comment'],
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
			} else{
				$response['success'] = false;
				$response['error'] = true;
				$response['errorMsg'] = "Please contact IT Dept";
			}
		
		echo json_encode($response);
		
	}
	public function viewsite()
	{
		
		$data['list'] = $this->helper_model->selectAll('site_id,site_name,address,start_date,end_date,total_amount,spend_amount,comment', 'site_master');

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
	 	public function update($id){        
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
        $site = array(
			'site_id' => $_POST['site_id'],
			'site_name' => $_POST['site_name'],
			'start_date' => $_POST['start_date'],
			'end_date' => $_POST['end_date'],
			'total_amount' => $_POST['total_amount'],
			'spend_amount' => $_POST['spend_amount'],
			'comment' => $_POST['comment'],
			'updated_by' => '1',
			'updated_on' => date('Y-m-d h:i:s')
		);

		$tableName = 'site_master';
		$column = 'site_id';
		$value = $_POST['site_id'];

		$result = $this->helper_model->update($tableName, $site, $column, $value);
		if($result == true){
			$response['success'] = true;
			$response['successMsg'] = "Record Updated";
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
