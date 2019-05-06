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
			$data = $this->db->query("select * from td_leave_trans
				  	  				  where  emp_code   = $empNo
					  				  and    (to_dt    	>= '$date'
					  				  or    approval_status = 'U')");


			return $data->result();
		}

		public function applNo($emp_no,$year){
			$data = $this->db->query("select IfNull(max(appl_no),0) + 1 appl_no
					  	  			  from   td_leave_trans 
						              where  year(appl_dt) = $year");


			return $data->row();
		}

		public function delete_leave($appl_dt,$appl_no){
			$this->db->where('appl_dt',$appl_dt);
			$this->db->where('appl_no',$appl_no);
			$this->db->delete('td_leave_trans');
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

		public function aprv_list($mng_no){
				$data = $this->db->query("Select a.appl_dt appl_dt,a.appl_no appl_no,
										         a.emp_code emp_code,a.leave_type,b.emp_name emp_name
										  From   td_leave_trans a,
										  		 mm_employee b
									      WHERE  a.emp_code = b.emp_no
									      and    a.emp_code In (select manage_no from mm_manager where emp_no = $mng_no) 
									      And    a.approval_status = 'U'");
				return $data->result();
		}

		public function select_leave($apl_dt,$apl_no){
			$data= $this->db->query("SELECT a.appl_dt appl_dt,a.appl_no appl_no,a.emp_code emp_code,
							         a.leave_type leave_type,a.from_dt from_dt,
									 a.to_dt to_dt,a.days days,a.remarks remarks,b.emp_name emp_name
							  FROM   td_leave_trans a,mm_employee b 
							  WHERE a.emp_code = b.emp_no
							  And   a.appl_dt  = '$apl_dt'
							  And   a.appl_no  =  $apl_no");
			return $data->row();
		}

		public function set_dt($date1,$date2){
		$value = array(
			'from_date' => $date1,
			'to_date' =>$date2
		);
		$this->db->select('*');
		$this->db->where('id',$this->session->userdata('is_login')->emp_no);
		$query = $this->db->get('tt');
		if($query->num_rows() > 0){
			$this->db->where('id',$this->session->userdata('is_login')->emp_no);
			$this->db->update('tt',$value);
		}
		else{
			$value = array(
				'id' =>  $this->session->userdata('is_login')->emp_no,
				'from_date' => $date1,
				'to_date' => $date2
			);
			$this->db->insert('tt',$value);
		}

		
		return 1;
	}

	public function leaveDetails($from_date,$to_date,$emp_no){
			$query = $this->db->query("select a.attn_dt attn_dt,a.status status,a.sl_no,a.emp_cd,
									          b.in_out_time ent_time,b.remarks remarks
									   from   td_dates a,td_in_out b
									   where  a.attn_dt = b.attn_dt
									   and    a.sl_no   = b.sl_no
									   and    a.emp_cd  = $emp_no
									   and    a.attn_dt between '$from_date' and '$to_date'");

			$this->set_dt($from_date,$to_date);

			if($query->num_rows() > 0) {
	       		foreach ($query->result() as $row) {
    	        $data[] = $row;
        	}
        	return $data;
    	}
	}

	public function leaveAppl($from_date,$to_date){

		$sql   = "select a.appl_dt appl_dt,a.appl_no appl_no,a.emp_code emp_code,a.leave_type leave_type,
					     a.from_dt from_dt,a.to_dt to_dt,a.days days,a.remarks remarks,b.emp_name emp_name
				  from   td_leave_trans a,mm_employee b
				  where  a.emp_code = b.emp_no
				  and    a.approval_status = 'A'
				  and    a.from_dt between '$from_date' and '$to_date'
				  order by a.appl_dt,a.appl_no";

		$query = $this->db->query($sql);

		if($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
	}

	public function lvBalanceAll($from_date){
		$sql = "select emp_no,max(balance_dt)balance_dt from td_leave_balance where balance_dt<='$from_date' and emp_no in(select emp_no from mm_employee where status_flag = 1) group by emp_no";

		$query = $this->db->query($sql);

		foreach ($query->result() as $row) {
            $data[] = $row;
        }
        for ($i=0; $i < sizeof($data); $i++) { 
			$this->db->select('emp_no');
			$this->db->select('cl');
			$this->db->select('el');
			$this->db->select('ml');
			$this->db->select('hl');
			$this->db->select('lwp');
			$this->db->where('emp_no', $data[$i]->emp_no);
			$this->db->where('balance_dt', $data[$i]->balance_dt);
			$result = $this->db->get('td_leave_balance');
    		$count[] = $result->row();
    	}
		return $count;
         
	}

	public function lvopn_bal($from_dt,$emp_no){
		$sql = "select * from td_leave_balance
				where  balance_dt = (select max(balance_dt) from td_leave_balance
									 where  balance_dt < '$from_dt'
									 and    emp_no     = $emp_no)
				and    emp_no     = $emp_no";

		$query = $this->db->query($sql);

		return $query->row();
	}

	public function lvcls_bal($to_dt,$emp_no){
		$sql = "select * from td_leave_balance
				where  balance_dt = (select max(balance_dt) from td_leave_balance
									 where  balance_dt <= '$to_dt'
									 and    emp_no     = $emp_no)
				and    emp_no     = $emp_no";

		$query = $this->db->query($sql);

		return $query->row();
	}

}

?>
