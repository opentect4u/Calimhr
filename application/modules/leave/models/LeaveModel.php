<?php
	defined('BASEPATH') or exit('No direct script access allowed');
	class LeaveModel extends CI_Model{
		public function selectAll($tableName){
			$this->db->select('*');
			$data = $this->db->get($tableName);
			return $data->result();	
		}

		public function insertData($tableName,$val){
			$this->db->insert($tableName,$val);
			return;
		}

		public function editData($tableName,$val,$where){
			$this->db->where($where);
			$this->db->update($tableName,$val);
		}

		public function leaveTrans($empNo,$date){

			$data = $this->db->query("select * from tm_leave
				  	  where  emp_cd   = $empNo
					  and    to_dt   >= $date");

			return $data->result();
		}

		public function applNo($emp_no,$year){
			$data = $this->db->query("select IfNull(max(appl_no),0) + 1 appl_no
					  	  from   tm_leave 
						  where  year(appl_dt) = $year");


			return $data->row();
		}

		public function empData($tableName,$emp_no){
			$this->db->where('emp_no',$emp_no);

			$this->db->select('*');

			$data = $this->db->get($tableName);

			return $data->row();
		}

		public function leaveTransEdit($appl_dt,$appl_no){
			$this->db->select('*');

			$this->db->where('appl_dt',$appl_dt);

			$this->db->where('appl_no',$appl_no);

			$data = $this->db->get('tm_leave');

			return $data->row();
		}
	}

?>
