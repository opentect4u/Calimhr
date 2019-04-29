<?php
	class Attendance extends MX_Controller{
		public function __construct(){
			parent::__construct();
			$this->load->model('AttnModel');
			$this->load->model('AdminProcess');
			$this->load->model('Process');
		}
/***********************List of Entries entered by Sanjay on a particular day(only Sanjay can view)***************/
		public function attn(){
			$title['title']      	= 'Claim-View Attendance Status';
			$user_id 			 	= $this->session->userdata('loggedin')->user_id;
			$date				 	= date('Y-m-d');

			$data['dtls']   	 	= $this->AttnModel->AttnTrans();

			$title['total_claim']   = $this->AdminProcess->countClaim('mm_manager');

			$title['total_payment'] = $this->AdminProcess->countRow('tm_payment');

			$title['total_reject']  = $this->Process->countRejClaim('tm_claim');

			$this->load->view('templetes/welcome_header',$title);

			$this->load->view("upload/attnUpl",$data);

            $this->load->view('templetes/welcome_footer');
		}

/***********************List of Entries(user can view)*************************************/
		public function viewAttn(){
			$title['title']      	= 'Claim-View Attendance Status';
			$user_id 			 	= $this->session->userdata('loggedin')->user_id;
			$date				 	= date('Y-m-d');

			$data['dtls']   	 	= $this->AttnModel->attn_view($user_id);

			$title['total_claim']   = $this->AdminProcess->countClaim('mm_manager');

			$title['total_payment'] = $this->AdminProcess->countRow('tm_payment');

			$title['total_reject']  = $this->Process->countRejClaim('tm_claim');

			$this->load->view('templetes/welcome_header',$title);

			$this->load->view("statusview/viewStatus",$data);

            $this->load->view('templetes/welcome_footer');
		}

/***********************Details of Entry(user can view)*************************************/
		public function dtlAttn(){
			$title['title']      	= 'Claim-View Attendance Status';
			$user_id 			 	= $this->session->userdata('loggedin')->user_id;
			$date				 	= date('Y-m-d');

			$attnDt 				= $this->input->get('attn_dt');
			$empNo					= $this->input->get('emp_cd');
			$status 				= $this->input->get('status');

			$data['dtls']   	 	= $this->AttnModel->attn_view_dtls($attnDt,$empNo,$status);

			$title['total_claim']   = $this->AdminProcess->countClaim('mm_manager');

			$title['total_payment'] = $this->AdminProcess->countRow('tm_payment');

			$title['total_reject']  = $this->Process->countRejClaim('tm_claim');

			$this->load->view('templetes/welcome_header',$title);

			$this->load->view("statusview/statusDtl",$data);

            $this->load->view('templetes/welcome_footer');
		}

/**************************Addintion of Status (Sanjay Can Enter)*************************************/
		public function addStatus(){
			if ($_SERVER['REQUEST_METHOD'] == "POST"){

				$userId			= $this->session->userdata('loggedin')->user_id;
				$empCd  		= $this->input->post('emp_cd');

				/*$attnDtTemp		= DateTime::createFromFormat('d/m/Y',$this->input->post('attn_dt'));
				$attnDt         = $attnDtTemp->format('Y-m-d');*/

				$date   = date('Y-m-d');

				$attnDt = $this->input->post('attn_dt');

				$eName  = $this->AttnModel->emp_name($empCd);

				$maxSl  = $this->AttnModel->max_sl($date)->sl_no;

				$days   = $this->input->post('days');


				$data_array = array(
					"trans_dt"    		=> $date,

					"attn_dt"			=> $attnDt,

					"sl_no"				=> $maxSl,

					"emp_cd"			=> $empCd,

					"emp_name"			=> $eName->emp_name,

					"status"			=> $this->input->post('status'),

					"in_out_time"		=> $this->input->post('in_out_time'),

					"no_of_days"		=> $this->input->post('days'),

					"remarks"			=> trim($this->input->post('remarks')),

					"adj_flag"			=> 'U',

					"created_by"		=> $userId,

					"created_dt"		=> date("Y-m-d h:i:s")
				);

				$this->AttnModel->insert_status('td_in_out',$data_array);


				if($this->input->post('status')=='A'||$this->input->post('status')=='C'){

					for($i=0; $i < $days; $i++){

						$attnDt1 = date('Y-m-d', strtotime($attnDt. ' + '.$i.' days'));

						$date_array[]	=	array(
							    "trans_dt"    	=> $date,

								"attn_dt"	    => $attnDt1,

								"sl_no"			=> $maxSl,

								"emp_cd"		=> $empCd,

								"status"		=> $this->input->post('status')
						);	
					}

				}else{
					$date_array[]	=	array(
							"trans_dt"    	=> $date,

							"attn_dt"		=>	$attnDt,

							"sl_no"			=> $maxSl,

							"emp_cd"		=> $empCd,

							"status"		=> $this->input->post('status')
					);
				}

				$this->AttnModel->insert_dates('td_dates',$date_array);


				$this->session->set_flashdata('msg','Save Successful');	

				redirect('attendance/attn');
			}else{
				$title['title']         = 'Claim-Attendance Status';

				$title['total_claim']   = $this->AdminProcess->countClaim('mm_manager');

                $title['total_payment'] = $this->AdminProcess->countRow('tm_payment');

				$title['total_reject']  = $this->Process->countRejClaim('tm_claim');

				$data['emp']  			= $this->AttnModel->emp();

				$this->load->view('templetes/welcome_header',$title);

                $this->load->view("upload/addTrans",$data);

                $this->load->view('templetes/welcome_footer');
			}
		}

	/****************************View Entered Status(For Sanjay)****************************/
		public function viewAllstatus(){
				$title['title']      	= 'Claim-View Attendance Status';
				$user_id 			 	= $this->session->userdata('loggedin')->user_id;
				$date				 	= date('Y-m-d');

				$transDt 				= $this->input->get('trans_dt');
				$slNo					= $this->input->get('sl_no');

				$data['dtls']   	 	= $this->AttnModel->attn_view_all($transDt,$slNo);

				$title['total_claim']   = $this->AdminProcess->countClaim('mm_manager');

				$title['total_payment'] = $this->AdminProcess->countRow('tm_payment');

				$title['total_reject']  = $this->Process->countRejClaim('tm_claim');

				$this->load->view('templetes/welcome_header',$title);

				$this->load->view("statusview/viewAllstatus",$data);

	            $this->load->view('templetes/welcome_footer');
		}	

	/***********************Delete Entry(Sanjay can view)*************************************/
		public function delAttn(){
			$title['title']      	= 'Claim-View Attendance Status';
			$user_id 			 	= $this->session->userdata('loggedin')->user_id;
			$date				 	= date('Y-m-d');

			$transDt 				= $this->input->post('trans_dt');
			$slNo					= $this->input->post('sl_no');

			$this->AttnModel->delete_status($transDt,$slNo);

			$this->AttnModel->delete_dates($transDt,$slNo);

			redirect('attendance/attn');
		}
	}
?>