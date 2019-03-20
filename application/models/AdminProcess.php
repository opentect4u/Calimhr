<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class adminProcess extends CI_Model {


	public function get_host_name(){
		$host_name = gethostname();
		return $host_name;
	}

	public function get_time(){
		date_default_timezone_set('Asia/kolkata');
		$time = date("Y-m-d H:i:sa");
		return $time;
	}


// For Claim Approve Process.................................................
    
    public function checkStatus($claim_cd){
		$this->db->select('approval_status');
		$this->db->select('rejection_status');
		$this->db->where('claim_cd', $claim_cd);
		$result = $this->db->get('tm_claim');
		return $result->row();
	}
	
	public function approveClaimProcess($claimCode,$approval_status){
		$value = $this->getDetailsbyEmpNo('mm_employee',$this->session->userdata('is_login')->emp_no);
		foreach ($value as $key) {
			$emp_name = $key->emp_name;
		}
		$value = array(
	        'approval_status' => $approval_status,
	        'approved_by' => $emp_name,
	        'approval_dt' => $this->get_time()
		);
		$this->db->where('claim_cd',$claimCode);
		$this->db->update('tm_claim', $value);
		return 1;
	}

// For Claim Approve Process.................................................

	public function rejectClaimProcess($claimCode,$rejection_status,$rejection_remarks){
		$value = $this->getDetailsbyEmpNo('mm_employee',$this->session->userdata('is_login')->emp_no);
		foreach ($value as $key) {
			$emp_name = $key->emp_name;
		}
		$value = array(
	        'rejection_status' => $rejection_status,
	        'rejection_remarks' => $rejection_remarks,
	        'rejected_by' => $emp_name,
	        'rejected_dt' => $this->get_time()
		);
		$this->db->where('claim_cd',$claimCode);
		$this->db->update('tm_claim', $value);
		return 2;
	}


// For Payment Process.................................................

	public function addPaymentProcess($trans_cd,$emp_no,$chq_dt,$pay_mode,$pay_type,$chq_no,$bank,$amount){
		$value = $this->getDetailsbyEmpNo('mm_employee',$this->session->userdata('is_login')->emp_no);
		foreach ($value as $key) {
			$created_by = $key->emp_name;
		}
		$time = $this->get_time();

		$data = array(
	        'trans_dt' => $time,
	        'trans_cd' => $trans_cd,
	        'emp_no' => $emp_no,
	        'payment_mode' => $pay_mode,
	        'payment_type' => $pay_type,
	   		'chq_dt' => $chq_dt,
	   		'chq_no' => $chq_no,
	   		'bank' => $bank,
	   		'paid_amt' => $amount,
	   		'created_by' => $created_by,
	   		'created_dt' => $time
		);

		$this->db->insert('tm_payment', $data);
		return true;
	}

	public function editPaymentProcess($trans_cd,$emp_no,$chq_dt,$pay_mode,$pay_type,$chq_no,$bank,$amount){
        $value = $this->getDetailsbyEmpNo('mm_employee',$this->session->userdata('is_login')->emp_no);
		foreach ($value as $key) {
			$emp_name = $key->emp_name;
		}
		$time = $this->get_time();

		$data = array(
	        'emp_no' => $emp_no,
	        'payment_mode' => $pay_mode,
	        'payment_type' => $pay_type,
	   		'chq_dt' => $chq_dt,
	   		'chq_no' => $chq_no,
	   		'bank' => $bank,
	   		'paid_amt' => $amount,
	   		'modified_by' => $emp_name,
	   		'modified_dt' => $time
		);
		$this->db->where('trans_cd',$trans_cd);
		$this->db->update('tm_payment', $data);
		return true;
	}
	
	public function deletePaymentProcess($trans_cd, $t_name){
		$this->db->where('trans_cd', $trans_cd);
		$this->db->delete($t_name);
		return true;
	}

	public function approvePaymentProcess($trans_cd,$status){
		$value = $this->getDetailsbyEmpNo('mm_employee',$this->session->userdata('is_login')->emp_no);
		foreach ($value as $key) {
			$emp_name = $key->emp_name;
		}
		$value = array(
	        //'claim_cd' => $claimCode,
	        'approval_status' => $status,
	        'approved_by' => $emp_name,
	        'approval_dt' => $this->get_time()
		);
		$this->db->where('trans_cd',$trans_cd);
		$this->db->update('tm_payment', $value);
		return true;
	}


// For Employee Process.................................................


	public function addEmpProcess($emp_no,$emp_name,$status,$date1,$date2,$sector,$designation){
		$value = $this->getDetailsbyEmpNo('mm_employee',$this->session->userdata('is_login')->emp_no);
		foreach ($value as $key) {
			$created_by = $key->emp_name;
		}
		$data = array(
	        'emp_no' => $emp_no,
	        'emp_name' => $emp_name,
	        'designation' => $designation,
	        'sector' => $sector,
	        'date_of_joining' => $date1,
	   		'status_flag' => $status,
	   		'date_of_termination' => $date2,
	   		'created_by' => $created_by,
	   		'created_dt' => $this->get_time()
		);

		$this->db->insert('mm_employee', $data);
		return true;
		
	}


// getAll returns select * ................................................
	
	public function getAll($t_name){
		$this->db->select('*');
		$this->db->where('status_flag',1);
		$result = $this->db->get($t_name);
		if( $result->num_rows() > 0) {
	        foreach ($result->result() as $row) {
	            $data[] = $row;
    	    }
    	    return $data;
    	}
    	else{
    		return false;
    	}
	}

	public function editEmployeeProcess($emp_no,$emp_name,$status,$date1,$date2,$sector,$designation){
		$value = $this->getDetailsbyEmpNo('mm_employee',$this->session->userdata('is_login')->emp_no);
		foreach ($value as $key) {
			$modified_by = $key->emp_name;
		}
		$value = array(
	        'emp_name' => $emp_name,
	        'designation' => $designation,
	        'sector' => $sector,
	        'date_of_joining' => $date1,
	        'status_flag' => $status,
	        'date_of_termination' => $date2,
	        'modified_by' => $modified_by,
	        'modified_dt'=> $this->get_time()
		);
		$this->db->where('emp_no',$emp_no);
		$this->db->update('mm_employee', $value);
		return true;
	}

//For User...........................................................................

	public function addUserProcess($emp_no,$user_type,$user_id,$pass,$status){
		$value = $this->getDetailsbyEmpNo('mm_employee',$this->session->userdata('is_login')->emp_no);
		foreach ($value as $key) {
			$created_by = $key->emp_name;
		}
		$value = $this->getDetailsbyEmpNo('mm_employee',$emp_no);
		foreach ($value as $key) {
			$emp_name = $key->emp_name;
		}
		$value = array(
	        'emp_no' => $emp_no,
	        'user_id' => $user_id,
	        'password' => $pass,
	        'user_type' => $user_type,
	        'emp_name' => $emp_name,
	        'user_status' => $status,
	        'created_by' => $created_by,
	        'created_dt' => $this->get_time()
		);
		$this->db->insert('m_user_master',$value);
		return true;
	}	

// For Managers.................................................

	public function addManager($manager_no,$emp_no){
		$value = $this->getDetailsbyEmpNo('mm_employee',$this->session->userdata('is_login')->emp_no);
		foreach ($value as $key) {
			$emp_name = $key->emp_name;
		}
			$value = array(
	        'emp_no' => $manager_no,
	        'manage_no' => $emp_no,
	        'created_by' => $emp_name,
	        'created_dt' => $this->get_time()
		);
		$this->db->insert('mm_manager',$value);
		return true;
	}

	public function editUserProcess($emp_no,$user_type,$user_id,$status,$defaultPassword){
		$value = $this->getDetailsbyEmpNo('mm_employee',$this->session->userdata('is_login')->emp_no);
		foreach ($value as $key) {
			$modified_by = $key->emp_name;
		}
		$value = $this->getDetailsbyEmpNo('mm_employee',$emp_no);
		foreach ($value as $key) {
			$emp_name = $key->emp_name;
		}
		if($defaultPassword){
		    $value = array(
	        'emp_no' => $emp_no,
	        'user_id' => $user_id,
	        'password' => $defaultPassword,
	        'user_type' => $user_type,
	        'emp_name' => $emp_name,
	        'user_status' => $status,
	        'modified_by' => $modified_by,
	        'modified_dt' => $this->get_time()
		);
		}
		else{
		  $value = array(
	        'emp_no' => $emp_no,
	        'user_id' => $user_id,
	        'user_type' => $user_type,
	        'emp_name' => $emp_name,
	        'user_status' => $status,
	        'modified_by' => $modified_by,
	        'modified_dt' => $this->get_time()
		);  
		}
		
		$this->db->where('emp_no',$emp_no);
		$this->db->update('m_user_master',$value);
		return true;
	}	

	public function delRow($emp_no){
		$this->db->where('emp_no',$emp_no);
		$this->db->delete('mm_manager');
		return true;
	}


// For Project Process................................................................


	public function addProjectProcess($project_cd,$project_name,$project_type,$district){
		$value = $this->getDetailsbyEmpNo('mm_employee',$this->session->userdata('is_login')->emp_no);
		foreach ($value as $key) {
			$created_by = $key->emp_name;
		}
		$value = array(
	        'project_cd' => $project_cd,
	        'project_name' => $project_name,
	        'project_type' => $project_type,
	        'dist' => $district,
	        'created_by' => $created_by,
	        'created_dt' => $this->get_time()
		);
		$this->db->insert('mm_project', $value);
		return true;
	}

	public function editProjectProcess($id,$project_cd,$project_name,$project_type,$district){
		$time = $this->get_time();
		$value = $this->getDetailsbyEmpNo('mm_employee',$this->session->userdata('is_login')->emp_no);
		foreach ($value as $key) {
			$modified_by = $key->emp_name;
		}
		$value = array(
	        'project_cd' => $project_cd,
	        'project_name' => $project_name,
	        'project_type' => $project_type,
	        'dist' => $district,
	        'modified_by' => $modified_by,
	        'modified_dt' => $time
		);
		$this->db->where('id',$id);
		$this->db->update('mm_project', $value);
		return true;
	}

	public function addProjectTypeProcess($type_cd,$type_desc){
		$value = $this->getDetailsbyEmpNo('mm_employee',$this->session->userdata('is_login')->emp_no);
		foreach ($value as $key) {
			$created_by = $key->emp_name;
		}
		$value = array(
	        'type_cd' => $type_cd,
	        'type_desc' => $type_desc,
	        'created_by' => $created_by,
	        'created_dt' => $this->get_time()
		);
		$this->db->insert('mm_project_type', $value);
		return true;
	}

	public function editProjectTypeProcess($id,$type_cd,$type_desc){
		$value = $this->getDetailsbyEmpNo('mm_employee',$this->session->userdata('is_login')->emp_no);
		foreach ($value as $key) {
			$modified_by = $key->emp_name;
		}
		$time = $this->get_time();
		$value = array(
	        'type_cd' => $type_cd,
	        'type_desc' => $type_desc,
	        'modified_by' => $modified_by,
	        'modified_dt' => $time
		);
		$this->db->where('id',$id);
		$this->db->update('mm_project_type', $value);
		return true;
	}

//For Purpose.................................................................

	public function addPurposeProcess($purpose_id,$purpose_desc){
		$value = array(
	        'id' => $purpose_id,
	        'purpose_desc' => $purpose_desc,
		);

		$this->db->insert('mm_purpose', $value);
		return true;
	}

	public function editPurposeProcess($purpose_id,$purpose_desc){

		$value = array(

	        'purpose_desc' => $purpose_desc
		);

		$this->db->where('id',$purpose_id);
		$this->db->update('mm_purpose', $value);
		return true;
	}


//For Claim Head.................................................................

	public function addClaimHeadProcess($head_cd,$head_desc){
		$value = array(
	        'head_cd' => $head_cd,
	        'head_desc' => $head_desc,
		);

		$this->db->insert('mm_claim_head', $value);
		return true;
	}

	public function editClaimHeadProcess($head_cd,$head_desc){

		$value = array(
	        'head_desc' => $head_desc
		);

		$this->db->where('head_cd',$head_cd);
		$this->db->update('mm_claim_head', $value);
		return true;
	}


// For Report........................................................

	public function reportProcess($date1,$date2){

			$this->db->where('emp_no' , $this->session->userdata('is_login')->emp_no);
		$this->db->where('claim_dt >= ' , $date1);
		$this->db->where('claim_dt <= ' , $date2);
		
		$query = $this->db->get('tm_claim');
		$this->set_dt($date1,$date2);
		if( $query->num_rows() > 0) {
	        foreach ($query->result() as $row) {
    	        $data[] = $row;
        	}
        	return $data;
    	}
    	else{
    		return 0;
    	}
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

	public function get_dt(){
		$this->db->select('*');
		$this->db->where('id',$this->session->userdata('is_login')->emp_no);
		$query = $this->db->get('tt');

		return $query->row();
	}

	public function pwExpence($project_name,$from_date,$to_date){
	    $from_date = $from_date.' 00:00:01';
		$to_date = $to_date.' 23:59:59';
		$this->db->distinct();
		$this->db->select('emp_no');
		$this->db->where('approval_dt >= ' , $from_date);
		$this->db->where('approval_dt <= ' , $to_date);
		$this->db->where('approval_status',1);
		$this->db->where('project_name', $project_name);
		$this->db->order_by('emp_no', 'asc');
		
		$query = $this->db->get('tm_claim');
		$this->set_dt($from_date,$to_date);
		//var_dump($query->result());die;
		if($query->num_rows() > 0) {
	       foreach ($query->result() as $row) {
    	        $data[] = $this->indPwExpence($row->emp_no, $from_date, $to_date, $project_name);
        	}
        	return $data;
    	}
	}


	public function indPwExpence($emp_no, $from_date, $to_date, $project_name){
	    $from_date = $from_date.' 00:00:01';
		$to_date = $to_date.' 23:59:59';
		$this->db->select('emp_no, claim_dt, amount');
		$this->db->where('emp_no' , $emp_no);
		$this->db->where('approval_dt >= ' , $from_date);
		$this->db->where('approval_dt <= ' , $to_date);
		$this->db->where('approval_status',1);
		$this->db->where('project_name', $project_name);
		$this->db->order_by('emp_no', 'asc');
		$this->db->order_by('claim_dt', 'asc');
		$query = $this->db->get('tm_claim');

		if($query->num_rows() > 0) {
	       foreach ($query->result() as $row) {
    	        $data[] = $row;
        	}
        	return $data;
    	}
	}

	public function countPRWE($from_date,$to_date){
	    $from_date = $from_date.' 00:00:01';
		$to_date = $to_date.' 23:59:59';
		$sql = "SELECT DISTINCT t.emp_no,m.emp_name FROM tm_claim t, mm_employee m WHERE t.approval_status = 1 AND t.approval_dt BETWEEN '$from_date' AND '$to_date' AND t.emp_no = m.emp_no";
		
		$query = $this->db->query($sql);
		if($query->num_rows() > 0) {
	       foreach ($query->result() as $row) {
    	        $data[] = $row;
        	}
        	return $data;
    	}
	}

	public function prwExpence($from_date,$to_date){
	   // $this->set_dt($from_date,$to_date);
        //$from_date = $from_date.' 00:00:01';
		//$to_date = $to_date.' 23:59:59';
		$sql = "SELECT date(a.approval_dt) approval_dt,
		     		   a.emp_no emp_no, 
		  			   b.emp_name emp_name,
		               a.purpose purpose, 
		               SUM(a.amount) amount 
		        FROM   tm_claim a,
		               mm_employee b
		        WHERE  a.emp_no = b.emp_no  
		        AND    a.approval_status = 1 
		        AND    date(a.approval_dt) BETWEEN '$from_date' AND '$to_date' 
		        GROUP BY date(a.approval_dt),a.emp_no, b.emp_name,a.purpose
		        order by date(a.approval_dt),a.emp_no";
		$query = $this->db->query($sql);

		return $query->result();
	}


	public function claimDetails($from_date,$to_date,$emp_no){
		$from_date = $from_date.' 00:00:01';
		$to_date = $to_date.' 23:59:59';
		
		$this->db->where('emp_no' , $emp_no);
		$this->db->where('approval_status' , 1);
		$this->db->where('approval_dt >= ' , $from_date);
		$this->db->where('approval_dt <= ' , $to_date);		
		$query = $this->db->get('tm_claim');

		$this->set_dt($from_date,$to_date);
		if($query->num_rows() > 0) {
	       foreach ($query->result() as $row) {
    	        $data[] = $row;
        	}
        	return $data;
    	}
	}

	public function closingBalance($from_date,$to_date){
		$sql = "SELECT t1.emp_no,t1.bl_dt,t2.balance_amt FROM (SELECT emp_no,max(balance_dt) bl_dt from tm_balance_amt where balance_dt BETWEEN '$from_date' AND '$to_date' GROUP BY emp_no ) t1, tm_balance_amt t2 WHERE t1.emp_no = t2.emp_no AND t1.bl_dt = t2.balance_dt";
		/*$emp = $this->session->userdata('is_login')->emp_no;
		$sql = "SELECT balance_amt 
                FROM  tm_balance_amt 
                WHERE balance_dt = (SELECT MAX(balance_dt) 
                                    FROM tm_balance_amt 
                                    WHERE emp_no = $emp 
                                    AND balance_dt <= '2018-06-01')
                and emp_no = $emp";*/
		$query = $this->db->query($sql);
		$this->set_dt($from_date,$to_date);
		if($query->num_rows() > 0) {
	       foreach ($query->result() as $row) {
    	        $data[] = $row;
        	}
        	return $data;
    	}
	}

	public function totalClaimDetails($from_date,$to_date){
	    $from_date = $from_date.' 00:00:01';
		$to_date = $to_date.' 23:59:59';
		$sql = "SELECT emp_no,SUM(amount) total_amount from tm_claim
					where approval_status = 1 AND approval_dt BETWEEN '$from_date' and '$to_date'
					GROUP BY emp_no";		
		$query = $this->db->query($sql);
		$this->set_dt($from_date,$to_date);
		if($query->num_rows() > 0) {
	       foreach ($query->result() as $row) {
    	        $data[] = $row;
        	}
        	return $data;
    	}
	}

    public function allPaymentDetails($from_date, $to_date){
		$this->db->distinct();
		$this->db->select('emp_no');
		$this->db->where('approval_status' , 1);
		$this->db->where('trans_dt >= ', $from_date);
		$this->db->where('trans_dt <= ', $to_date);
		$this->db->order_by('emp_no', 'asc');
		$query = $this->db->get('tm_payment');
		$this->set_dt($from_date,$to_date);

		if($query->num_rows() > 0) {
	       foreach ($query->result() as $row) {
    	        $data[] = $this->paymentDetails($from_date, $to_date, $row->emp_no);
        	}
        	return $data;
    	}

	}
    

	public function paymentDetails($from_date,$to_date,$emp_no){
		$this->db->where('emp_no' , $emp_no);
		$this->db->where('approval_status' , 1);
		$this->db->where('trans_dt >= ' , $from_date);
		$this->db->where('trans_dt <= ' , $to_date);		
		$query = $this->db->get('tm_payment');
		$this->set_dt($from_date,$to_date);
		if($query->num_rows() > 0) {
	       foreach ($query->result() as $row) {
    	        $data[] = $row;
        	}
        	return $data;
    	}
	}

	public function getDetailsbyId($id,$t_name){
		$this->db->where('id',$id);
		$query = $this->db->get($t_name);
		return $query->row();
	}

	public function getDetailsbyClaimCd($id,$t_name){
		$this->db->where('claim_cd',$id);
		$query = $this->db->get($t_name);
		return $query->row();
	}

	public function getDetailsbyTransCd($id,$t_name){
		$this->db->where('trans_cd',$id);
		$query = $this->db->get($t_name);
		return $query->row();
	}

	public function getClTransbyClaimCd($id,$t_name){
		$this->db->where('claim_cd',$id);
		$query = $this->db->get($t_name);
		if( $query->num_rows() > 0) {
        foreach ($query->result() as $row) {
            $data[] = $row;
        }
    }
		return $data;
	}

public function getDetailsbyEmpNo($t_name,$emp_no){
		$this->db->select('*');
		$this->db->where('emp_no',$emp_no);
		$result = $this->db->get($t_name);
		if( $result->num_rows() > 0) {
        foreach ($result->result() as $row) {
            $data[] = $row;
        }
        return $data;
    	}
    	else{
    		return false;
    	}
    }

    public function getEmpForManager() {

    	$this->db->select('manage_no');
		$this->db->where('emp_no', $this->session->userdata('is_login')->emp_no);
		$query = $this->db->get('mm_manager');
		
		foreach ($query->result_array() as $row) { 
			$this->db->select('emp_no'); 
			$this->db->select('emp_name');
			$this->db->where_in('emp_no', $row);
			$result = $this->db->get('mm_employee');
			$name[] = $result->result();
		}
		return $name;
    }

    public function getEmp($t_name,$id){
		$this->db->select('*');
		$this->db->where('claim_cd', $id);
		$result = $this->db->get('tm_claim');

		if( $result->num_rows() > 0) {
        	foreach ($result->result() as $row) {
            	$data[] = $row;
        	}
        	foreach ($data as $key) {
    			$emp_no = $key->emp_no;
    			$data1 = $this->getDetailsbyEmpNo($t_name,$emp_no);
			}	
		}
		return $data1;
    }
    
    public function getProject_type($project_name) {
    	$this->db->select('project_type');
    	$this->db->where('project_name', $project_name);
    	$result = $this->db->get('mm_project');

    	if ($result->num_rows() > 0) {
    		return $result->row();
    	}
    	else
    		return false;
    }

    public function adminlogin($t_name){
    	$user_emp = $this->session->userdata('is_login')->emp_no;

    	$this->db->select('*');
		$this->db->where('emp_no <>',$user_emp);
		$result = $this->db->get($t_name);
		if( $result->num_rows() > 0) {
        foreach ($result->result() as $row) {
            $data[] = $row;
        }
        return $data;
    	}
    }

    public function maxCode($t_name, $var){
    	$this->db->select_max($var);
    	$this->db->where('year(trans_dt)',date("Y"));
    	$result = $this->db->get($t_name);
    	return $result->row();
    	
    }

    public function editNameProcess($name){
    	$value = array('emp_name' => $name );
    	$this->db->where('emp_no', $this->session->userdata('is_login')->emp_no);
    	$this->db->update('mm_employee',$value);
    	return true;
    }

    public function empBalance($from_date){
        
        $emp_list   =   $this->getEmpForManager();
        
        foreach ($emp_list as $row1 => $val) {
             
            $emp_no_list[]   =  $val[0]->emp_no;
        }
        
        $emp_no_list   =   implode(",", $emp_no_list);
       
		$sql = "SELECT emp_no, max(balance_dt) balance_dt FROM tm_balance_amt WHERE emp_no in ($emp_no_list) and balance_dt <= '$from_date' GROUP BY emp_no";

		$query = $this->db->query($sql);

		foreach ($query->result() as $row) {
            $data[] = $row;
        }
        
       
		for ($i=0; $i < sizeof($data); $i++) { 
			$this->db->select('emp_no');
			$this->db->select('balance_amt');
			$this->db->where('emp_no', $data[$i]->emp_no);
			$this->db->where('balance_dt', $data[$i]->balance_dt);
			$result = $this->db->get('tm_balance_amt');
    		$count[] = $result->row();
    	}
		return $count;
	}

	public function empBalanceAll($from_date){
		$sql = "select emp_no,max(balance_dt)balance_dt from tm_balance_amt where balance_dt<='$from_date' and emp_no in(select emp_no from mm_employee where status_flag = 1) group by emp_no";

		$query = $this->db->query($sql);

		foreach ($query->result() as $row) {
            $data[] = $row;
        }
        for ($i=0; $i < sizeof($data); $i++) { 
			$this->db->select('emp_no');
			$this->db->select('balance_amt');
			$this->db->where('emp_no', $data[$i]->emp_no);
			$this->db->where('balance_dt', $data[$i]->balance_dt);
			$result = $this->db->get('tm_balance_amt');
    		$count[] = $result->row();
    	}
		return $count;
         
	}

    public function closing_balance(){
		$emp_no = $this->session->userdata('is_login')->emp_no;
		$this->db->select("balance_amt FROM tm_balance_amt
						 	 WHERE emp_no = $emp_no and
							 balance_dt = (select max(balance_dt)
	                    	 from   tm_balance_amt)");
		$query = $this->db->get();
        return $query->row();
	}
    
    public function admin_closing_balance($emp_no){
    	$this->db->select("* FROM tm_balance_amt
			WHERE emp_no = $emp_no and
					balance_dt = (select MAX(balance_dt)
                    from   tm_balance_amt WHERE emp_no = $emp_no)");
		$query = $this->db->get();
        return $query->row();
    }
    
	public function countRow($t_name){
		$this->db->select('count(*) as count');
		$this->db->where('emp_no <>', $this->session->userdata('is_login')->emp_no);
		$this->db->where('approval_status <> 1');
		$query = $this->db->get($t_name);
		 return $query->row();
	}

	public function countClaim($t_name){

		$this->db->select('manage_no');
		$this->db->where('emp_no', $this->session->userdata('is_login')->emp_no);
		$query = $this->db->get($t_name);
		$count = 0;
		if($query->num_rows() > 0) {
        foreach ($query->result() as $row) {
            $data[] = $row;
        }
        
        for ($i=0; $i < sizeof($data); $i++) { 
    		$count += $this->claimCount($data[$i]->manage_no);
    	}
    	return $count;
    }
    	else{
    		$count = ' ';
    		return $count;
    	}
	}

	public function claimCount($emp_no){
		$this->db->select('count(*) count');
		$this->db->where('emp_no',$emp_no);
		$this->db->where('approval_status <>', 1);
		$this->db->where('rejection_status <>', 1);
		$result = $this->db->get('tm_claim');
		return $result->row()->count;
	}

	public function matchPass($oldPass){
    	$this->db->select('password');
    	$this->db->where('emp_no', $this->session->userdata('is_login')->emp_no);
    	
    	$query = $this->db->get('m_user_master');
    	if ($query->num_rows() == 1) {
    		return $query->row();
    	}
    	else{
    		return false;
    	}
    }

    public function getAllClaim(){
    	$this->db->select('manage_no');
    	$this->db->where('emp_no', $this->session->userdata('is_login')->emp_no);
    	$query = $this->db->get('mm_manager');

    	if($query->num_rows() > 0) {
	        foreach ($query->result() as $row) {
	            $data[] = $row;
	        }
    	}

    	for ($i=0; $i < sizeof($data); $i++) { 
    		$count[] = $this->claimDtls($data[$i]->manage_no);
    	}
    	return $count;
    }

    public function claimDtls($emp_no){
    	$this->db->select('*');
    	$this->db->where('emp_no', $emp_no);
    	$this->db->where('approval_status <> 1');
    	$this->db->where('rejection_status <> 1');
    	$query = $this->db->get('tm_claim');

    	return $query->result();
    }
    
        public function distWiseExpence($from_date,$to_date) {

    	$this->set_dt($from_date,$to_date);
    	$sql = "SELECT m.dist, t.amount FROM tm_claim t, mm_project m WHERE t.approval_status = 1 AND t.claim_dt BETWEEN '$from_date' AND '$to_date' AND m.project_name = t.project_name";

		$result = $this->db->query($sql);

		return $result->result();				
    }

    public function distinctDist() {

    	
    	$sql = "SELECT DISTINCT dist FROM mm_project";

		$result = $this->db->query($sql);

		return $result->result();				
    }
    
    public function editPassProcess($newPass){
    	$value = array('password' => $newPass );
    	$this->db->where('emp_no', $this->session->userdata('is_login')->emp_no);
    	$this->db->update('m_user_master',$value);
    	return true;
    }
    
    public function personalLedger($from_date,$to_dt, $emp_no){

		$this->set_dt($from_date,$to_dt);
        
        $sql = "SELECT * FROM tm_balance_amt WHERE emp_no = $emp_no AND balance_dt BETWEEN '$from_date' AND '$to_dt' ORDER BY balance_dt";
		$query = $this->db->query($sql);
		
		if( $query -> num_rows() > 0) {
	        foreach ($query->result() as $row) {
    	        $data[] = $row;
        	}
        	return $data;
    	}
    	else{
    		return 0;
    	}
	}
	
	public function opening_balance($from_date, $emp_no) {
		$sql = "SELECT * FROM tm_balance_amt
			WHERE emp_no = $emp_no and
					balance_dt = (SELECT min(balance_dt)
                    from   tm_balance_amt
                    WHERE  balance_dt <= '$from_date')";
		                    
		$query = $this->db->query($sql);
		
        return $query->row();
    	
	}

	public function attnDetails($from_date,$to_date,$emp_no){
		$this->db->where('emp_cd' , $emp_no);
		$this->db->where('attn_dt >= ' , $from_date);
		$this->db->where('attn_dt <= ' , $to_date);		
		$query = $this->db->get('td_in_out');
		$this->set_dt($from_date,$to_date);
		if($query->num_rows() > 0) {
	       foreach ($query->result() as $row) {
    	        $data[] = $row;
        	}
        	return $data;
    	}
	}
}
