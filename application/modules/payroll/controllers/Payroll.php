<?php
	class Payroll extends MX_Controller{
	   public function __construct(){
		parent::__construct();
		$this->load->model('PayrollModel');
		$this->load->model('AdminProcess');
		$this->load->model('Process');
	   }

	   public function employee(){									 /*Employee Dashboard*/
		   if($this->session->userdata('is_login')->user_type == 'A'){
                   	$title['title']         = 'Claim-Manage Employee Details';
                   	$data['data_dtls']      = $this->PayrollModel->select_all('mm_employee');
                   	$title['total_claim']   = $this->AdminProcess->countClaim('mm_manager');
           	   	$title['total_payment'] = $this->AdminProcess->countRow('tm_payment');
           	   	$title['total_reject']  = $this->Process->countRejClaim('tm_claim');
                   	$this->load->view('templetes/welcome_header',$title);
                   	$this->load->view("employee/viewEmployee",$data);
                   	$this->load->view('templetes/welcome_footer');
                }				
	   } 	
		
	   public function addEmp(){									/*Add Employee*/
                   if($_SERVER['REQUEST_METHOD']=="POST"){
			   $empno 	= $this->input->post('emp_no');
			   $empname	= $this->input->post('emp_name');
			   $empdept     = $this->input->post('emp_dept');
			   $empdesg	= $this->input->post('emp_desg');
			   $dojtemp     = DateTime::createFromFormat('d/m/Y',$this->input->post('doj'));
			   $doj		= $dojtemp->format('Y-m-d');
			   $emppan      = $this->input->post('pan_no');
			   $empacno     = $this->input->post('ac_no');
			   $emppf       = $this->input->post('pf_no');
			   $empesi      = $this->input->post('esi_no');
			   $status	= 1;
			   $user_id 	= $this->session->userdata('loggedin')->user_id;
			   $time    	= date("Y-m-d h:i:s");
			   $data_array  = array(
			      	"emp_no"  		=> $empno,
			      	"emp_name"		=> $empname,
			      	"emp_catg"		=> 0,
			      	"designation"		=> $empdesg,
    			    	"sector"		=> $empdept,
	 		      	"date_of_joining"	=> $doj,
		    	    	"status_flag"		=> $status,
			      	"pan_no"		=> $emppan,
	 		      	"bank_ac_no"		=> $empacno,
	 		      	"pf_AC_no"		=> $emppf,
	 		      	"esi_no"  		=> $empesi,
			      	"created_by"		=> $user_id,
				"created_dt"		=> $time		      
				);
			   	   
			 $this->PayrollModel->insert_data('mm_employee',$data_array);
                         $this->session->set_flashdata('msg','Save Successful');
                         redirect('payroll/employee');
		   }else{
                    $title['title']         = 'Claim-Add New Employee';
                    $title['total_claim']   = $this->AdminProcess->countClaim('mm_manager');
                    $title['total_payment'] = $this->AdminProcess->countRow('tm_payment');
             	    $title['total_reject']  = $this->Process->countRejClaim('tm_claim');
             	    $data['dept'] 	    = $this->PayrollModel->select_all('mm_department');
             	    $data['desg'] 	    = $this->PayrollModel->select_all('mm_designation');

                    $this->load->view('templetes/welcome_header',$title);
                    $this->load->view("employee/addEmp",$data);
                    $this->load->view('templetes/welcome_footer');
                 }
	   }

	   public function editEmp(){									/*Edit Employee*/
		   if($_SERVER['REQUEST_METHOD']=="POST"){
			   $empno	= $this->input->post('emp_no');
                           $empname     = $this->input->post('emp_name');
                           $empdept     = $this->input->post('emp_dept');
                           $empdesg     = $this->input->post('emp_desg');
                           $doj         = $this->input->post('doj');
                           $emppan      = $this->input->post('pan_no');
                           $empacno     = $this->input->post('ac_no');
			   $status      = $this->input->post('status');
			   $emppf       = $this->input->post('pf_no');
			   $empesi      = $this->input->post('esi_no');
			   $dot         = $this->input->post('dot');
                           $user_id     = $this->session->userdata('loggedin')->user_id;
			   $time        = date("Y-m-d h:i:s");
			   $data_array  = array(
                                "emp_name"              => $empname,
                                "emp_catg"              => 0,
                                "designation"           => $empdesg,
                                "sector"                => $empdept,
                                "date_of_joining"       => $doj,
                                "date_of_termination"   => $dot,
                                "status_flag"           => $status,
                                "pan_no"                => $emppan,
                                "bank_ac_no"            => $empacno,
                                "pf_AC_no"		=> $emppf,
	 		      	"esi_no"  		=> $empesi,
                                "modified_by"           => $user_id,
                                "modified_dt"           => $time
				);
			 $where_array    = array("emp_no" => $empno);
			 $this->PayrollModel->edit_data('mm_employee',$data_array,$where_array);
                         $this->session->set_flashdata('msg','Save Successful');
                         redirect('payroll/employee');
		   }else{   
	   		$title['title']		= 'Edit Employee Details';
			$title['total_claim']	= $this->AdminProcess->countClaim('mm_manager');
			$title['total_payment'] = $this->AdminProcess->countRow('tm_payment');
			$title['total_reject']  = $this->Process->countRejClaim('tm_claim');

			$params=$this->input->get('emp_no');
			$data['data_dtls']      = $this->PayrollModel->select_emp('mm_employee',$params);

                	$this->load->view('templetes/welcome_header',$title);
                	$this->load->view('employee/editEmp',$data);
                	$this->load->view('templetes/welcome_footer');
		 }
	   }

	   												/*Upload Employee CSV File*/
	   public function uplEmp(){
		   if($_SERVER['REQUEST_METHOD']=="POST"){
			   if($_POST['importSubmit']){						//validate whether uploaded file is a csv file
				   $csvMimes = array('text/x-comma-separated-values',
					   'text/comma-separated-values',
					   'application/octet-stream',
					   'application/vnd.ms-excel',
					   'application/x-csv',
					   'text/x-csv',
					   'text/csv',
					   'application/csv',
					   'application/excel',
					   'application/vnd.msexcel',
					   'text/plain');

				   if(!empty($_FILES['upemp']['name']) && in_array($_FILES['upemp']['type'],$csvMimes)){
					   
					   if($_FILES['upemp']['tmp_name']){
						   
						   $csvFile = fopen($_FILES['upemp']['tmp_name'], 'r');
						   
						   while(($line = fgetcsv($csvFile)) !== FALSE){
							   
							   if($line[0]!='' && $line[0]!='Employee No.'){
								   $user_id = $this->session->userdata('loggedin')->user_id;
								   $time    = date('Y-m-d h:i:s');
														//echo"<pre>";
														//var_dump($line);
								   $data = array(
									    "emp_no"   		  => $line[0],
  									    "emp_name"		  => $line[1],
				   			   		    "emp_catg"   	  => 0,
						   			    "designation"	  => $line[2],
			   			   			    "sector"		  => $line[3],
						   			    "date_of_joining"	  => $line[4],		   
					   	   			    "status_flag" 	  => 1,
			   			   			    "date_of_termination" => NULL,
						   			    "pan_no"		  => $line[5],
						   			    "bank_ac_no" 	  => $line[6],
						   			    "pf_ac_no"		  => $line[7],
						   			    "esi_no"		  => $line[8],
						   			    "created_by"   	  => $user_id,
									    "created_dt"   	  => $time,
									    "modified_by"         => NULL,
									    "modified_dt"         => NULL
					   			  );
					 	                  $this->PayrollModel->insert_data('mm_employee',$data);
							   }  
						   }
						   $this->session->set_flashdata('msg', 'Successfully Added!');
						   redirect('payroll/employee');			
						   fclose($csvFile);
						   $qstring = '?status=succ';
					   }else{
						   $qstring = '?status=err';
					   }
				   }else{
					   $qstring = '?status=invalid_file';
				   }			   				   
			   }
		   }else{    
			   $title['title']         = 'Claim-Upload Employee Details';
            		   $title['total_claim']   = $this->AdminProcess->countClaim('mm_manager');
            		   $title['total_payment'] = $this->AdminProcess->countRow('tm_payment');
            		   $title['total_reject']  = $this->Process->countRejClaim('tm_claim');
            		   $this->load->view('templetes/welcome_header',$title);
            		   $this->load->view('employee/uploadEmp');
			   $this->load->view('templetes/welcome_footer');
		   }	
	   }														

	   public function dwnEmp(){
		   $this->load->helper('download');
		   $path = file_get_contents(base_url('/application/modules/payroll/views/employee/sample_Employee_details.csv'));
		   force_download('sample_Employee_details.csv', $path);
	   }

	   public function printPs(){
		   $title['title']         = 'Claim-View Paysheet';
		   $user_id 		   = $this->session->userdata('loggedin')->user_id;
		   $data['data_dtls']      = $this->PayrollModel->print_ps($user_id);	
                   $title['total_claim']   = $this->AdminProcess->countClaim('mm_manager');
                   $title['total_payment'] = $this->AdminProcess->countRow('tm_payment');
                   $title['total_reject']  = $this->Process->countRejClaim('tm_claim');
                   $this->load->view('templetes/welcome_header',$title);
                   $this->load->view("paysheet/viewPay",$data);
                   $this->load->view('templetes/welcome_footer');
	   }

	   public function finalPrintPs(){
                   $title['title']         = 'Claim-View Paysheet';
				   $emp_no   = $this->input->get('emp_no'); 
				   $trans_dt = $this->input->get('trans_dt');	

                   $data['data_dtls']      = $this->PayrollModel->payslip($emp_no,$trans_dt);

                   $data['emp_dtls'] 	   = $this->PayrollModel->getEmp($emp_no);

                   $title['total_claim']   = $this->AdminProcess->countClaim('mm_manager');
                   $title['total_payment'] = $this->AdminProcess->countRow('tm_payment');
                   $title['total_reject']  = $this->Process->countRejClaim('tm_claim');
                   $this->load->view('templetes/welcome_header',$title);
                   $this->load->view("paysheet/printPay",$data);
                   $this->load->view('templetes/welcome_footer');
           }

	  				
	   public function paysheet(){
		   if($this->session->userdata('is_login')->user_type == 'A' || $this->session->userdata('is_login')->user_type == 'AC'){
			   $title['title']	   =	'Claim-Manage Paysheets';
			   $data['data_dtls']      = $this->PayrollModel->select_paysheet();
                           $title['total_claim']   = $this->AdminProcess->countClaim('mm_manager');
                           $title['total_payment'] = $this->AdminProcess->countRow('tm_payment');
                           $title['total_reject']  = $this->Process->countRejClaim('tm_claim');
                           $this->load->view('templetes/welcome_header',$title);
                           $this->load->view("paysheet/viewPaysheet",$data);
                           $this->load->view('templetes/welcome_footer');

		   }
	   }
												/*Upload Paysheet*/
	   public function uplPay(){
		   if($_SERVER['REQUEST_METHOD']=="POST"){
			   if($_POST['importSubmit']){						//validate whether uploaded file is a csv file
				   $csvMimes = array('text/x-comma-separated-values',
					   'text/comma-separated-values',
					   'application/octet-stream',
					   'application/vnd.ms-excel',
					   'application/x-csv',
					   'text/x-csv',
					   'text/csv',
					   'application/csv',
					   'application/excel',
					   'application/vnd.msexcel',
					   'text/plain');
				   $salmonth = $this->input->post('sal_mth');
				   $salyear  = $this->input->post('sal_yr');

				   if(!empty($_FILES['upemp']['name']) && in_array($_FILES['upemp']['type'],$csvMimes)){

					   if($_FILES['upemp']['tmp_name']){

						   $csvFile = fopen($_FILES['upemp']['tmp_name'], 'r');

						   while(($line = fgetcsv($csvFile)) !== FALSE){

							   if($line[0]!='' && $line[0]!='Employee No.'){
								   $user_id = $this->session->userdata('loggedin')->user_id;
								   $time    = date('Y-m-d h:i:s');
														//echo"<pre>";
														//var_dump($line);
								   $data = array(
									    "trans_dt"		  => date('Y-m-d'),
								   	    "sal_month"		  => $salmonth,
									    "sal_year"      	  => $salyear,
									    "emp_no"   		  => $line[0],
  									    "emp_name"		  => $line[1],
						   			    "basic_sal"	  	  => $line[2],
			   			   			    "conv_allow"	  => $line[3],
						   			    "da_amt"	  	  => $line[4],
					   	   			    "hra_amt"		  => $line[5],
						   			    "inc_amt" 	  	  => $line[6],
						   			    "lta_amt"		  => $line[7],
									    "med_amt"		  => $line[8],
									    "misc_amt"            => $line[9],
									    "out_amt"             => $line[10],
									    "proj_amt"            => $line[11],
									    "var_amt"             => $line[12],
									    "tot_ear"             => $line[13],
									    "arr_pf"              => $line[14],
									    "epf_amt"             => $line[15],
									    "adv_amt"             => $line[16],
									    "esi_amt"             => $line[17],
									    "med_ins"             => $line[18],
									    "mob_amt"             => $line[19],
									    "ptax_amt"            => $line[20],
								    	    "tds_amt"             => $line[21],
									    "tot_ded"             => $line[22],
									    "net_amt"             => $line[23],		    
						   			    "created_by"   	  => $user_id,
									    "created_dt"   	  => $time,
									    "modified_by"         => NULL,
									    "modified_dt"         => NULL
					   			  );
					 	                  $this->PayrollModel->insert_data('tm_paysheet',$data);
							   }
						   }
						   $this->session->set_flashdata('msg', 'Successfully Added!');
						   redirect('payroll/paysheet');
						   fclose($csvFile);
						   $qstring = '?status=succ';
					   }else{
						   $qstring = '?status=err';
					   }
				   }else{
					   $qstring = '?status=invalid_file';
				   }
			   }
		   }else{
			   $title['title']         = 'Claim-Upload Paysheets';
            		   $title['total_claim']   = $this->AdminProcess->countClaim('mm_manager');
            		   $title['total_payment'] = $this->AdminProcess->countRow('tm_payment');
            		   $title['total_reject']  = $this->Process->countRejClaim('tm_claim');
            		   $this->load->view('templetes/welcome_header',$title);
            		   $this->load->view('paysheet/uploadPay');
			   $this->load->view('templetes/welcome_footer');
		   }
	   }
												/*Download Sample Paysheet*/
	   public function dwnPay(){
		   $this->load->helper('download');
		   $path = file_get_contents(base_url('/application/modules/payroll/views/paysheet/sample_paysheet.csv'));
		   force_download('sample_paysheet.csv', $path);
	   }
	   /*****************************/
    }