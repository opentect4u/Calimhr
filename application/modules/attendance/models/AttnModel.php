<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class AttnModel extends CI_MODEL{

		public function f_get_particulars($table_name, $select=NULL, $where=NULL, $flag) {
        
			if(isset($select)) {
	
				$this->db->select($select);
	
			}
	
			if(isset($where)) {
	
				$this->db->where($where);
	
			}
	
			$result		=	$this->db->get($table_name);
	
			if($flag == 1) {
	
				return $result->row();
				
			}else {
	
				return $result->result();
	
			}
	
		}

		public function f_insert($table_name, $data_array) {

			$this->db->insert($table_name, $data_array);
	
			return;
	
		}
		
		public function f_edit($table_name, $data_array, $where) {
	
			$this->db->where($where);
			$this->db->update($table_name, $data_array);
	
			return;
	
		}

		public function f_insert_multiple($table_name, $data_array){

			$this->db->insert_batch($table_name, $data_array);
	
			return;
	
		}
	

		public function AttnTrans(){			/*All Entries entered on a particular date(attn)*/
			$this->db->select('*');
			$this->db->where('adj_flag','U');
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
				              from td_in_out where trans_dt = '$date'");
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

		public function attn_view_all($transDt,$transCd){					/*selects all data from td_in_out*/			
			$this->db->select('*');
			$this->db->where('trans_dt',$transDt);
			$this->db->where('sl_no',$transCd);
			$data = $this->db->get('td_in_out');
			return $data->row();	
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

		public function delete_status($date,$sl_no){	
			$this->db->where('trans_dt',$date);
			$this->db->where('sl_no'   ,$sl_no);
			$this->db->delete('td_in_out');
		}

		public function delete_dates($date,$sl_no){	
			$this->db->where('trans_dt',$date);
			$this->db->where('sl_no'   ,$sl_no);
			$this->db->delete('td_dates');
		}

		public function f_adjustable($last_adjusted_dt){

			// //Counting Late
			$where = array(
				"trans_dt >= '".$last_adjusted_dt."'" => NULL,
				"(status = 'L' OR status = 'R') GROUP BY emp_cd, emp_name" => NULL
			);
			$data['lates'] = $this->f_get_particulars('td_in_out', array('emp_cd', 'emp_name', 'SUM(no_of_days) late'), $where, 0);

			//Counting Half
			$where = array(
				"status = 'H'" => NULL,
				"trans_dt >= '".$last_adjusted_dt."' AND trans_dt < '".date('Y-m-d')."' GROUP BY emp_cd, emp_name" => NULL
			);
			$data['halfs'] = $this->f_get_particulars('td_in_out', array('emp_cd', 'emp_name', 'SUM(no_of_days) half'), $where, 0);

			return $data;
		}

		public function f_closing_leave_bals(){

			$sql = "SELECT a.*, m.emp_name FROM 
					(SELECT `emp_no`, `cl`, `el`, `ml`, `hl`, `lwp`, `balance_dt` FROM td_leave_balance) a,
					(SELECT `emp_no`, MAX(balance_dt) balance_dt FROM td_leave_balance GROUP BY emp_no) b,
					mm_employee m
					WHERE a.emp_no = b.emp_no
					AND a.balance_dt = b.balance_dt
					AND a.emp_no = m.emp_no 
					ORDER BY CAST(a.emp_no as unsigned)";

			return $this->db->query($sql)->result();		

		}

	}
?>