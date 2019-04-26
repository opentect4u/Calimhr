for($i = 0; $i <= $diff_period; $i++){

    $date = strtotime("+".$i." day", strtotime($date));
    
    
    $data_array[]     =   array(

        "trans_cd"  =>  $maxCode,

        "emp_code"  =>  $this->session->userdata('loggedin')->user_id,
        
        "leave_dt"  =>  date("Y-m-d", $date)
    );

}