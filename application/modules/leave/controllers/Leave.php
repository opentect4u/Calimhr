<?php
	class Leave extends MX_Controller{
		public function __construct(){
			parent::__construct();
			$this->load->model('LeaveModel');
			$this->load->model('AdminProcess');
			$this->load->model('Process');
		}

		public function leaveStatus(){
			$title['title'] 		= 'Claim-View Leave Status';

			$user_id 				= $this->session->userdata('loggedin')->user_id;

			$date					= date('Y-m-d');	

			$data['data_dtls']      = $this->LeaveModel->leaveTrans($user_id,$date);

           	$title['total_claim']   = $this->AdminProcess->countClaim('mm_manager');

           	$title['total_payment'] = $this->AdminProcess->countRow('tm_payment');

           	$title['total_reject']  = $this->Process->countRejClaim('tm_claim');

			$this->load->view('templetes/welcome_header',$title);

			$this->load->view("application/applStatus",$data);

            $this->load->view('templetes/welcome_footer');
		}

		public function applyLeave(){
			if ($_SERVER['REQUEST_METHOD'] == "POST"){

				$userId	= $this->session->userdata('loggedin')->user_id;

				$year   = date('Y');

				$aplNo  = $this->LeaveModel->applNo($userId,$year);

				$aplNo  = $aplNo->appl_no;

				$date	= date('Y-m-d');

				$days   = $this->input->post('days');

				$data_array = array(
					"appl_dt"		=> $date,

					"appl_no"		=> $aplNo,

					"emp_code"		=> $userId,

					"from_dt"		=> $this->input->post('frmdt'),

					"to_dt"			=> $this->input->post('todt'),

					"leave_type"	=> $this->input->post('lvtype'),

					"remarks"		=> trim($this->input->post('rns')),

					"days"			=> $this->input->post('days'),

					"created_by"	=> $userId,

					"created_dt"	=> date("Y-m-d h:i:s")
				);

				$this->LeaveModel->insertData('td_leave_trans',$data_array);
    			
				$this->session->set_flashdata('msg','Save Successful');	

				redirect('leave/leaveStatus');
			}else{
				$title['title']         = 'Claim-Leave Application';

				$title['total_claim']   = $this->AdminProcess->countClaim('mm_manager');

                $title['total_payment'] = $this->AdminProcess->countRow('tm_payment');

				$title['total_reject']  = $this->Process->countRejClaim('tm_claim');

				$this->load->view('templetes/welcome_header',$title);

                $this->load->view("application/apply");

                $this->load->view('templetes/welcome_footer');
			}
		}

		public function delLeave(){
				
				$applDt			= $this->input->get('appl_dt');

				$applNo			= $this->input->get('appl_no');	

				$this->LeaveModel->delete_leave($applDt,$applNo);

				redirect('leave/leaveStatus');			
		}  

		/*public function editLeave(){
				$title['title']         = 'Claim-Leave Application';

                                $title['total_claim']   = $this->AdminProcess->countClaim('mm_manager');

                                $title['total_payment'] = $this->AdminProcess->countRow('tm_payment');

				$title['total_reject']  = $this->Process->countRejClaim('tm_claim');

				$applDt			= $this->input->get('appl_dt');

				$applNo			= $this->input->get('appl_no');		

				$data['row']		= $this->LeaveModel->leaveTransEdit($applDt,$applNo);

                                $this->load->view('templetes/welcome_header',$title);

                                $this->load->view("application/edit",$data);

                                $this->load->view('templetes/welcome_footer');


			
		} */

		public function showLeave(){
			if(($this->session->userdata('is_login')->user_type == 'A') || ($this->session->userdata('is_login')->user_type == 'M') || ($this->session->userdata('is_login')->user_type == 'AC')){
				$title['title']         = 'Claim-Approve Leave';

				$user_id 				= $this->session->userdata('loggedin')->user_id;

				$date					= date('Y-m-d');	

				$data['data_dtls']      = $this->LeaveModel->aprv_list($user_id);   

				$title['total_claim']   = $this->AdminProcess->countClaim('mm_manager');

                $title['total_payment'] = $this->AdminProcess->countRow('tm_payment');

				$title['total_reject']  = $this->Process->countRejClaim('tm_claim');

				$this->load->view('templetes/welcome_header',$title);

                $this->load->view("application/aprvStatus",$data);

                $this->load->view('templetes/welcome_footer');
			}
		}

		public function AprvLeave(){
			if ($_SERVER['REQUEST_METHOD'] == "POST"){

				$userId	= $this->session->userdata('loggedin')->user_id;

				$data_array = array(
					"approval_status"	=> $this->input->post('aprvStatus'),

					"approved_by"		=> $userId,

					"approval_dt"		=> date("Y-m-d h:i:s")
				);

				$where_array = array(
					"appl_no"  => $this->input->post('applno'),

				    "appl_dt"  => $this->input->post('appldt')
				);

				$no = $this->input->post('days');
				$no = -1 * $no;
				
				/*$insert_data	= array(
					"balance_dt"		=> $this->input->post('appldt'),
					"trans_cd"			=> $this->input->post('applno'),
					"emp_no"			=> $this->input->post('empcd'),
					"trans_type"		=> 'A',
					"leave_type"		=> $this->input->post('lvtype'),
					"leave_no"		    => $no,
					"to_dt"				=> $this->input->post('todt')
				);*/

				$this->LeaveModel->editData('td_leave_trans',$data_array,$where_array);

				/*if($this->input->post('aprvStatus')=='A'){
					$this->LeaveModel->insertData('td_leave_balance',$insert_data);
				}	*/
				$this->session->set_flashdata('msg','Save Successful');	

				redirect('leave/showLeave');
			}else{
				$title['title']         = 'Claim-Leave Application';

				$title['total_claim']   = $this->AdminProcess->countClaim('mm_manager');

                $title['total_payment'] = $this->AdminProcess->countRow('tm_payment');

				$title['total_reject']  = $this->Process->countRejClaim('tm_claim');

				$apl_dt = $this->input->get('appl_dt');

				$apl_no = $this->input->get('appl_no');

				$data['leave_dtls']		= $this->LeaveModel->select_leave($apl_dt,$apl_no);

				$this->load->view('templetes/welcome_header',$title);

                $this->load->view("application/aprvLeave",$data);

                $this->load->view('templetes/welcome_footer');
			}
		}

	/************************************Report Section**************************/	

	   //For Leave Details
	    public function leaveDetails() {
			$title['title'] = 'Claim-Leave Details';
			$t_name = 'mm_employee';
			$date1_temp = DateTime::createFromFormat('d/m/Y',$_POST['date1']);
			$from_date = $date1_temp->format('Y-m-d');

			$date2_temp = DateTime::createFromFormat('d/m/Y',$_POST['date2']);
			$to_date = $date2_temp->format('Y-m-d');
			$emp_no = $this->input->post('emp_no');

			$data['alldata']  = $this->LeaveModel->leaveDetails($from_date,$to_date,$emp_no);
			$data['emp_dtls'] = $this->AdminProcess->getDetailsbyEmpNo($t_name,$emp_no);
			$data['date'] = $this->AdminProcess->get_dt();
			$title['total_claim'] = $this->AdminProcess->countClaim('mm_manager');
	    	$title['total_payment'] = $this->AdminProcess->countRow('tm_payment');
	    	$title['total_reject'] = $this->Process->countRejClaim('tm_claim');

			$this->load->view('templetes/welcome_header',$title);
			$this->load->view('SU/leaveDetails',$data);
			$this->load->view('templetes/welcome_footer');
		}
	    public function leave_dtl_ajax(){
	    	$result['dtls'] = $this->AdminProcess->getAll('mm_employee');
			$this->load->view('SU/leaveDtlModal',$result);
	    }

	    //For Leave application
	    public function leaveApplication() {
			$title['title'] = 'Claim-Leave Details';
			$t_name 		= 'mm_employee';

			$date1_temp 	= DateTime::createFromFormat('d/m/Y',$_POST['date1']);
			$from_date 		= $date1_temp->format('Y-m-d');

			$date2_temp 	= DateTime::createFromFormat('d/m/Y',$_POST['date2']);
			$to_date 		= $date2_temp->format('Y-m-d');


			$data['val']  	= $this->LeaveModel->leaveAppl($from_date,$to_date);

			//$data['date'] 	= $this->AdminProcess->get_dt();

			$data['date'] = array($from_date,$to_date);

			$title['total_claim'] 	= $this->AdminProcess->countClaim('mm_manager');
	    	$title['total_payment'] = $this->AdminProcess->countRow('tm_payment');
	    	$title['total_reject'] 	= $this->Process->countRejClaim('tm_claim');

			$this->load->view('templetes/welcome_header',$title);
			$this->load->view('report/leaveAppl',$data);
			$this->load->view('templetes/welcome_footer');
		}

	    public function leave_apl_ajax(){
			$this->load->view('report/leaveAplModal');
	    }

	    public function lv_balance_ajax(){
			$this->load->view('report/lvBalanceModal');
	    }

	    public function lvBalance() {
			$title['title'] = 'Claim-Leave Details';

			$date1_temp 	= DateTime::createFromFormat('d/m/Y',$_POST['date1']);
			$from_date 		= $date1_temp->format('Y-m-d');


			$result['emp_dtls'] = $this->AdminProcess->getAll('mm_employee');
 
			$result['lvBalance'] = $this->LeaveModel->lvBalanceAll($from_date);

			$result['date'] = array($from_date);
		 

			$title['total_claim'] 	= $this->AdminProcess->countClaim('mm_manager');
	    	$title['total_payment'] = $this->AdminProcess->countRow('tm_payment');
	    	$title['total_reject'] 	= $this->Process->countRejClaim('tm_claim');

			$this->load->view('templetes/welcome_header',$title);
			$this->load->view('report/levBalance',$result);
			$this->load->view('templetes/welcome_footer');
		}


}
?>		
