<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class AttnModel extends CI_MODEL{
		public function AttnTrans($date){			/*All Entries entered on a particular date(attn)*/
			$this->db->select('*');
			$this->db->where('attn_dt',$date);
			$data = $this->db->get('td_in_out');
			return $data->result();	
		}

		public function emp(){						/*Selects All Active Employees*/
			$this->db->select('*');
			$this->db->where('status_flag',1);
			$data = $this->db->get('mm_employee');
			return $data->result();
		}

		public function emp_name($empNo){			/*Selects employee name for a particular Employee*/
			$this->db->select('emp_name');
			$this->db->where('emp_no',$empNo);
			$data = $this->db->get('mm_employee');
			return $data->row();
		}

		public function max_sl($date){									/*Maximum SL No for a particular date*/
			$sl = $this->db->query("select ifnull(max(sl_no),0) + 1 sl_no
				              from td_in_out where attn_dt = '$date'");
			return $sl->row();
		}

		public function insert_status($table,$data){		/*Inserts data in td_in_out*/
			$this->db->insert($table,$data);
		}

		public function insert_dates($table,$data){		/*Inserts data in td_dates*/
			$this->db->insert_batch($table,$data);
		}

		public function attn_view($empCd){					/*Employee wise selects data from td_in_out*/			
			$this->db->select('*');
			$this->db->where('emp_cd',$empCd);
			$this->db->order_by('attn_dt');
			$data = $this->db->get('td_in_out');
			return $data->result();	
		}

		/*Employee wise,date wise and statuswise selects a particular data from td_in_out*/

		public function attn_view_dtls($date,$empCd,$status){	
			$this->db->select('*');
			$this->db->where('attn_dt',$date);
			$this->db->where('emp_cd' ,$empCd);
			$this->db->where('status' ,$status);
			$data = $this->db->get('td_in_out');
			return $data->row();	
		}

		public function delete_status($date,$empCd,$status){	
			$this->db->where('attn_dt',$date);
			$this->db->where('emp_cd' ,$empCd);
			$this->db->where('status' ,$status);
			$this->db->delete('td_in_out');
		}
	}
?>