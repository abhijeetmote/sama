<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Driver_model extends CI_Model {

	function __construct(){
		// Call the Model constructor
		parent::__construct();
		$this->load->model('helper/helper_model');
	}

	public function saveData($tableName,$data){
		$result = $this->helper_model->insertid($tableName,$data);
		return $result;
	}


	public function updateData($tableName,$data,$columnName,$value){
		$result = $this->helper_model->update($tableName,$data,$columnName,$value);
		return $result;
	}

	public function getDriverLit($data,$table){

		$result = $this->helper_model->selectAll($data,$table);
		return $result;
	}

	public function getGroupId($select,$tableName,$context,$entity_type,$where){

		$result = $this->helper_model->selectGroupId($select,$tableName,$where);
		return $result;
	}
	
	public function getData($select, $tableName, $column, $value) {
		$result = $this->helper_model->select($select, $tableName, $column, $value);
		return $result;
	}

	public function getwheredata($select,$tableName,$where){

		$result = $this->helper_model->selectwhere($select,$tableName,$where);
		//echo $this->db->last_query();
		return $result;
	}
}
