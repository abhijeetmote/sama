<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventory extends MX_Controller {

	function __construct() {
	    parent::__construct();

		$this->load->module('header/header');
		$this->load->module('footer/footer');
		$this->load->model('inventory_model');
		$this->load->model('helper/helper_model');
	}

	public function index()
	{
		$this->header->index();
		$this->load->view('productAdd');
		$this->footer->index();
	}

	public function addItem()
	{
		$data = array(
			'p_name' => $_POST['p_name'],
			'p_desc' => $_POST['p_desc'],
			'p_unit' => $_POST['p_unit'],
			'p_unit_price' => $_POST['p_price'],
			'added_by' => '1',
			'added_on' => date('Y-m-d h:i:s')
		);

		$tableName = 'product_master';

		$result = $this->helper_model->insert($tableName,$data);
		if($result){
			$response['error'] = false;
	 		$response['success'] = true;
			$response['errorMsg'] = "Successfully added";
			$response['redirect'] = base_url()."inventory/productList";
		}else{
			$response['error'] = true;
	 		$response['success'] = false;
			$response['errorMsg'] = "Error!!! Please contact IT Dept";
		}

		echo json_encode($response);
 	}

 	public function productList()
	{
		$tableName = 'product_master';
		$select = '*';
		$data['list'] = $this->helper_model->selectAll($select,$tableName);

		$this->header->index();
		$this->load->view('productList', $data);
		$this->footer->index();
 	}

 	public function update($id)
	{
		$tableName = 'product_master';
		$select = '*';
		$column = "p_id";
		$value = $id;
		$data['product'] = $this->helper_model->select($select, $tableName, $column, $value);
		$data['update'] = true;

		$this->header->index();
		$this->load->view('productAdd', $data);
		$this->footer->index();
 	}

 	public function productUpdate()
	{
		$data = array(
			'p_name' => $_POST['p_name'],
			'p_desc' => $_POST['p_desc'],
			'p_unit' => $_POST['p_unit'],
			'p_unit_price' => $_POST['p_price'],
			'updated_by' => '1',
			'updated_on' => date('Y-m-d h:i:s')
		);

		$columnName = "p_id";
		$tableName = 'product_master';
		$value = $_POST['p_id'];

		$result = $this->helper_model->update($tableName,$data,$columnName,$value);
		if($result){
			$response['error'] = false;
	 		$response['success'] = true;
			$response['errorMsg'] = "Successfully updated";
			$response['redirect'] = base_url()."inventory/productList";
		}else{
			$response['error'] = true;
	 		$response['success'] = false;
			$response['errorMsg'] = "Error!!! Please contact IT Dept";
		}

		echo json_encode($response);
 	}

 	public function inventoryList(){
 		

 		$inventory_type = $this->uri->segment(3);
		$from_date = $this->uri->segment(4);
		$to_date = $this->uri->segment(5);

		if($inventory_type){
 			$inventory_status = $inventory_type;
 			$data['i_type'] = $inventory_type;
 		}else{
 			$inventory_status = 1;
 		}
 		$where_extra = "";

 		if(($from_date!="" && $to_date!="") && ($from_date!="0" && $to_date!="0"))   {
			
			$data['from_date'] = $from_date;
			$data['to_date'] = $to_date;
			$from_date = date("Y-m-d", strtotime($from_date));
			$to_date = date("Y-m-d", strtotime($to_date));
			$where_extra .= " and im.added_on between '$from_date' and '$to_date'";
		}

 		$tableName = 'product_master';
		$select = 'p_id,p_name';
		$data['product_list'] = $this->helper_model->selectAll($select,$tableName);

		$tableName = 'site_master';
		$select = 'site_id,site_name';
		$data['site_list'] = $this->helper_model->selectAll($select,$tableName);

		$tableName = 'vendors_master';
		$select = 'vendor_id,vendor_name';
		$data['vendor_list'] = $this->helper_model->selectAll($select,$tableName);

		$tableName =  'inventory im, product_master pm, site_master sm, vendors_master vm';
 		$select = 'im.qty,im.price,im.total_amt,im.inventory_status,pm.p_name,sm.site_name,vm.vendor_name';
 		$where =  "im.product_id = pm.p_id and im.site_id = sm.site_id and im.vendor_id = vm.vendor_id and im.inventory_status = '$inventory_status'";
 		$where .= $where_extra;
		$data['inventory'] = $this->helper_model->selectwhere($select,$tableName,$where);

		/*echo "<pre>";
		print_r($data);
		exit();*/

		$this->header->index();
		$this->load->view('inventoryList', $data);
		$this->footer->index();
 	}

 	public function productDetails(){
 		$id = $this->input->post('id');

 		$tableName = 'product_master';
		$select = 'p_unit_price';
		$columnName = 'p_id';
		$value = $id;
		$product = $this->helper_model->select($select,$tableName,$columnName,$value);

		$response['success'] = true;
 		$response['error'] = false;
 		$response['successMsg'] = $product[0]->p_unit_price;

 		echo json_encode($response);

 	}

 	public function inwardSubmit(){
 		$p_id = $this->input->post('product');
 		$s_id = $this->input->post('site');
 		$v_id = $this->input->post('vendor');
 		$qty = $this->input->post('qty');

 		$tableName = 'product_master';
		$select = 'p_unit_price';
		$columnName = 'p_id';
		$value = $p_id;
		$product = $this->helper_model->select($select,$tableName,$columnName,$value);

		$price = $product[0]->p_unit_price;
		$total_amt = $price * $qty;

 		$tableName = 'inventory_map';
		$select = 'inventory_map_id,qty';
		$where = "p_id = '$p_id' and s_id = '$s_id' and v_id = '$v_id'";
		$inventoryExist = $this->helper_model->selectwhere($select,$tableName,$where);

		if($inventoryExist){
			$inventory_map_id = $inventoryExist[0]->inventory_map_id;
			$qtyExist = $inventoryExist[0]->qty;
			
			$this->db->trans_begin(); // transaction begin

			$tableName = 'inventory_map';
			$data = array(
				'qty' => $qtyExist + $qty,
				'updated_by' => 1,
				'updated_on' => date('Y-m-d h:i:s')
			);
			$columnName = "inventory_map_id";
			$value = $inventory_map_id;
			$inventory_map = $this->helper_model->update($tableName,$data,$columnName,$value);
			if($inventory_map){
				$tableName = 'inventory';
				$data = array(
					'product_id' => $p_id,
					'site_id' => $s_id,
					'vendor_id' => $v_id,
					'qty' => $qty,
					'price' => $price,
					'total_amt' => $total_amt,
					'inventory_status' => 1, //inward
					'added_by' => 1,
					'added_on' => date('Y-m-d h:i:s')
				);
				$inventory = $this->helper_model->insert($tableName,$data);
				if($inventory){
					$result = $this->addToVendorBill($p_id,$s_id,$v_id,$total_amt,$inventory);
					if($result){

						$this->db->trans_commit(); // transaction commit
						
						$response['success'] = true;
			 			$response['error'] = false;
			 			$response['successMsg'] = "Successfully Inward";
					}else{
						$response['success'] = false;
			 			$response['error'] = true;
			 			$response['errorMsg'] = "Please contact IT dept";
					}
				}else{
					$response['success'] = false;
		 			$response['error'] = true;
		 			$response['errorMsg'] = "Please contact IT dept";
				}
			}else{
				$response['success'] = false;
		 		$response['error'] = true;
		 		$response['errorMsg'] = "Please contact IT dept";
			}
		}else{

			$this->db->trans_begin(); // transaction begin

			$tableName = 'inventory_map';
			$data = array(
				'p_id' => $p_id,
				's_id' => $s_id,
				'v_id' => $v_id,
				'qty' => $qty,
				'added_by' => 1,
				'added_on' => date('Y-m-d h:i:s')
			);
			$inventory_map = $this->helper_model->insert($tableName,$data);
			
			if($inventory_map){
				$tableName = 'inventory';
				$data = array(
					'product_id' => $p_id,
					'site_id' => $s_id,
					'vendor_id' => $v_id,
					'qty' => $qty,
					'price' => $price,
					'total_amt' => $total_amt,
					'inventory_status' => 1, //inward
					'added_by' => 1,
					'added_on' => date('Y-m-d h:i:s')
				);
				$inventory = $this->helper_model->insert($tableName,$data);
				if($inventory){
					$result = $this->addToVendorBill($p_id,$s_id,$v_id,$total_amt,$inventory);
					if($result){

						$this->db->trans_commit(); // transaction commit

						$response['success'] = true;
			 			$response['error'] = false;
			 			$response['successMsg'] = "Successfully Inward";
					}else{
						$response['success'] = false;
			 			$response['error'] = true;
			 			$response['errorMsg'] = "Please contact IT dept";
					}
				}else{
					$response['success'] = false;
		 			$response['error'] = true;
		 			$response['errorMsg'] = "Please contact IT dept";
				}

			}else{
				$response['success'] = false;
		 		$response['error'] = true;
		 		$response['errorMsg'] = "Please contact IT dept";
			}
		}

 		echo json_encode($response);

 	}

 	public function addToVendorBill($p_id,$s_id,$v_id,$total_amt,$in_id)
 	{
 		$tableName = 'vendor_bill_payment_details';
		$data = array(
			'product_id' => $p_id,
			'inventory_id' => $in_id,
			'site_id' => $s_id,
			'vendor_id' => $v_id,
			'vendor_bill_payment_amount' => $total_amt,
			'status' => '1',
			'added_by' => 1,
			'added_on' => date('Y-m-d h:i:s')
		);
		return $this->helper_model->insert($tableName,$data);
 	}

 	public function outwardSubmit(){
 		$p_id = $this->input->post('product');
 		$s_id = $this->input->post('site');
 		$qty = $this->input->post('qty');

 		$tableName = 'product_master';
		$select = 'p_unit_price';
		$columnName = 'p_id';
		$value = $p_id;
		$product = $this->helper_model->select($select,$tableName,$columnName,$value);

		$price = $product[0]->p_unit_price;
		$total_amt = $price * $qty;

 		$tableName = 'inventory_map';
		$select = 'inventory_map_id,qty,v_id';
		$where = "p_id = '$p_id' and s_id = '$s_id'";
		$inventoryExist = $this->helper_model->selectwhere($select,$tableName,$where);

		if($inventoryExist){
			$inventory_map_id = $inventoryExist[0]->inventory_map_id;
			$qtyExist = $inventoryExist[0]->qty;
			$v_id = $inventoryExist[0]->v_id;
			if($qtyExist >= $qty){
				$tableName = 'inventory_map';
				$data = array(
					'qty' => $qtyExist - $qty,
					'updated_by' => 1,
					'updated_on' => date('Y-m-d h:i:s')
				);
				$columnName = "inventory_map_id";
				$value = $inventory_map_id;
				$inventory_map = $this->helper_model->update($tableName,$data,$columnName,$value);
				if($inventory_map){
					$tableName = 'inventory';
					$data = array(
						'product_id' => $p_id,
						'site_id' => $s_id,
						'vendor_id' => $v_id,
						'qty' => $qty,
						'price' => $price,
						'total_amt' => $total_amt,
						'inventory_status' => 2, //inward
						'added_by' => 1,
						'added_on' => date('Y-m-d h:i:s')
					);
					$inventory = $this->helper_model->insert($tableName,$data);
					if($inventory){
						$response['success'] = true;
			 			$response['error'] = false;
			 			$response['successMsg'] = "Successfully Outward";
					}else{
						$response['success'] = false;
			 			$response['error'] = true;
			 			$response['errorMsg'] = "Please contact IT dept";
					}
				}
			}else{
				$response['success'] = false;
			 	$response['error'] = true;
			 	$response['errorMsg'] = "Product quantity does not available";
			}
		}else{
			$response['success'] = false;
		 	$response['error'] = true;
		 	$response['errorMsg'] = "Product does not exist agaist this site";
		}

		echo json_encode($response);
 	}
}
