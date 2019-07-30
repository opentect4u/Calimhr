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

					"no_of_days"		=> ($this->input->post('status') == 0)? 1 : $this->input->post('status'),

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

		public function adjustment(){

			if($_SERVER['REQUEST_METHOD'] == 'POST'){

				$this->AttnModel->f_edit('td_in_out', array('adj_flag' => 'A'), array("trans_dt BETWEEN '".$this->input->post('last_adjust_date')."' AND '".$this->input->post('latest_adjust_date')."'" => NULL));
				$maxSl  = $this->AttnModel->max_sl(date('Y-m-d'))->sl_no;

				for($i = 0; $i < count($this->input->post('emp_code')); $i++){
					
					$data_array[] = (object) array(
						"emp_code" => $this->input->post('emp_code')[$i],
						"balance_dt" => $this->input->post('balance_dt')[$i],
						"cl" => (float)$this->input->post('cl')[$i],
						"el" => (float)$this->input->post('el')[$i],
						"ml" => (float)$this->input->post('ml')[$i],
						"hl" => (float)$this->input->post('hl')[$i],
						"late" => (float)$this->input->post('late')[$i],
						"half" => (float)$this->input->post('half')[$i],
						"lwp" => (float)$this->input->post('lwp')[$i]
					);

				}

				for($i = 0; $i < count($this->input->post('emp_code')); $i++){
					++$maxSl;
					$adjustable_leave_amt = 0;
					$adjustable_leave_amt += floor((($data_array[$i]->late >= 3)? ($data_array[$i]->late / 3) : 0));
					$adjustable_leave_amt += $data_array[$i]->half * 0.5;
					
					if($adjustable_leave_amt > 0){
						$data_array[$i] = $this->leave_adjust($data_array[$i], $adjustable_leave_amt);
						$data_array[$i]->late = ($data_array[$i]->late % 3);
						$data_array[$i]->half = 0;
					}

					if(($data_array[$i]->hl > 0) && ($data_array[$i]->hl > $data_array[$i]->lwp)){
						$data_array[$i]->hl = $data_array[$i]->hl - $data_array[$i]->lwp;
						$data_array[$i]->lwp = 0;
					}
					if(($data_array[$i]->hl > 0) && ($data_array[$i]->hl < $data_array[$i]->lwp)){
						$data_array[$i]->lwp = $data_array[$i]->lwp - $data_array[$i]->hl;
						$data_array[$i]->hl = 0;
					}
					if(($data_array[$i]->hl > 0) && ($data_array[$i]->hl == $data_array[$i]->lwp)){
						$data_array[$i]->lwp = 0;
						$data_array[$i]->hl = 0;
					}
					
					$new_balance[] = array(
						
						"balance_dt" => date('Y-m-d'),
						"emp_no" => $this->input->post('emp_code')[$i],
						"cl" => $data_array[$i]->cl,
						"el" => $data_array[$i]->el,
						"ml" => $data_array[$i]->ml,
						"hl" => $data_array[$i]->hl,
						"lwp" => $data_array[$i]->lwp
					);
					
					$new_data[] = array(
						
						"trans_dt"    		=> date('Y-m-d'),
						
						"attn_dt"			=> date('Y-m-d'),
						
						"sl_no"				=> $maxSl,
						
						"emp_cd"			=> $data_array[$i]->emp_code,
						
						"emp_name"			=> $this->input->post('emp_name')[$i],
						
						"status"			=> ($data_array[$i]->late > 0)? 'L':'A',
						
						"no_of_days"		=> $data_array[$i]->late,
						
						"remarks"			=> "Adjustment",
						
						"adj_flag"			=> 'U',
						
						"created_by"		=> $this->session->userdata('loggedin')->emp_name,
						
						"created_dt"		=> date("Y-m-d h:i:s")
						
					);
					
					if($data_array[$i]->late > 0){
						
						$new_td_dates[] = array(
	
							"trans_dt"    	=> date('Y-m-d'),

							"attn_dt"		=>	date('Y-m-d'),

							"sl_no"			=> $maxSl,

							"emp_cd"		=> $data_array[$i]->emp_code,

							"status"		=> 'L'
	
						);

					}
	
				}
				
				$this->AttnModel->f_insert_multiple('td_in_out', $new_data);
				$this->AttnModel->f_insert_multiple('td_leave_balance', $new_balance);
				$this->AttnModel->f_insert_multiple('td_dates', $new_td_dates);
				$this->AttnModel->f_insert('td_adjustment_dates', array("adjustment_date" => date('Y-m-d')));
				
				redirect('attendance/adjustment');
			}
			else{

				$title['title']      	= 'Claim-View Attendance Status';
				$title['total_claim']   = $this->AdminProcess->countClaim('mm_manager');
				$title['total_payment'] = $this->AdminProcess->countRow('tm_payment');
				$title['total_reject']  = $this->Process->countRejClaim('tm_claim');

				//Last adjustment date
				$data['adjustment_date'] = $this->Process->f_get_particulars('td_adjustment_dates', array('max(adjustment_date) adjustment_date'), NULL, 1);

				//All employee's unadjusted total late, half, lwp, holiday
				$data['adjustable'] = $this->AttnModel->f_adjustable($data['adjustment_date']->adjustment_date);

				//All employee's closing leave balances
				$data['leave_bals'] = $this->AttnModel->f_closing_leave_bals();

				$this->load->view('templetes/welcome_header',$title);
				$this->load->view('adjustment/form', $data);
	            $this->load->view('templetes/welcome_footer');

			}
		}

		public function leave_adjust($emp_details, $deduct_amt){
			$temp = 0;
			if($emp_details->cl > 0){
				$temp = $emp_details->cl;
				$emp_details->cl = (($emp_details->cl - $deduct_amt) >= 0)? ($emp_details->cl - $deduct_amt) : 0;
				$deduct_amt = (($deduct_amt - $temp) >= 0)? $deduct_amt - $temp : 0;
			}
			if($emp_details->el > 0 && ($deduct_amt > 0)){
				$temp = $emp_details->el;
				$emp_details->el = (($emp_details->el - $deduct_amt) >= 0)? ($emp_details->el - $deduct_amt) : 0;
				$deduct_amt = (($deduct_amt - $temp) >= 0)? $deduct_amt - $temp : 0;								
			}
			if($emp_details->hl > 0 && ($deduct_amt > 0)){
				$temp = $emp_details->hl;
				$emp_details->hl = (($emp_details->hl - $deduct_amt) >= 0)? ($emp_details->hl - $deduct_amt) : 0;
				$deduct_amt = (($deduct_amt - $temp) >= 0)? $deduct_amt - $temp : 0;								
			}
			if($deduct_amt > 0){
				$emp_details->lwp = $emp_details->lwp + $deduct_amt;
			}
			
			return $emp_details;
		}

		public function lopenbal(){
			
			if($_SERVER['REQUEST_METHOD'] == 'POST'){

				$data_array = array(
					"balance_dt" => $this->input->post('date'),
					"emp_no" => $this->input->post('emp_code'),
					"cl" => $this->input->post('cl'),
					"el" => $this->input->post('el'),
					"ml" => $this->input->post('ml'),
					"hl" => $this->input->post('hl'),
					"lwp" => $this->input->post('lwp')
				);

				$this->AttnModel->f_insert('td_leave_balance', $data_array);

				$this->session->set_flashdata('msg', 'success');

				redirect('attendance/lopenbal');

			}
			else {

				$title['title']      	= 'Leave-Opening Balance';
				$title['total_claim']   = $this->AdminProcess->countClaim('mm_manager');
				$title['total_payment'] = $this->AdminProcess->countRow('tm_payment');
				$title['total_reject']  = $this->Process->countRejClaim('tm_claim');

				//Employee List
				$data['emp_list'] = $this->AttnModel->f_get_particulars('mm_employee', array('emp_no', 'emp_name'), NULL, 0);

				$this->load->view('templetes/welcome_header', $title);
				$this->load->view('openingbal/openingbal', $data);
	            $this->load->view('templetes/welcome_footer');
			}
		}

		public function getdoj(){
			echo $this->AttnModel->f_get_particulars('mm_employee', array('date_of_joining'), array('emp_no' => $this->input->get('emp_cd')), 1)->date_of_joining;
			exit();	 
		}
	}
?>