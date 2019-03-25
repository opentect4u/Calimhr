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


				$this->LeaveModel->editData('td_leave_trans',$data_array,$where_array);

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
	}
?>		
