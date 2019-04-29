<div class="content-wrapper">
  <div class="container-fluid">
	<h3>View Attendance Status</h3>
	<hr> 
	    <form style="max-width:700px;background:#fafafa;
	    	         padding:30px;box-shadow:1px 1px 25px rgba(0,0,0,0.35);
                     border-radius:10px;border: 2px solid #305a72"
	          class="form-style-9" method="POST" action="<?php echo site_url('attendance/delAttn');?>">
      <ul>
      	<li>

      		<input type="hidden" name="trans_dt" style="width:300px;display:inline;" class="field-style
	    	       field-split align-left" value="<?php echo($dtls->trans_dt); ?>" readonly>

	    	<input type="hidden" name="sl_no" style="width:300px;display:inline;margin-left:20px" 
	    	       class="field-style field-split align-left"value="<?php echo($dtls->sl_no);?>" readonly> 


      		<label for="emp_no" style="display:inline;"class="field-split align-left labelstyle">
      		       Employee No.</label>
      		<label for="emp_name" style="display:inline;margin-left:211px;" class="field-split 
      		       align-left labelstyle">Name</label>	
      	
	    	<input type="text" name="emp_no" style="width:300px;display:inline;" class="field-style
	    	       field-split align-left" value="<?php echo($dtls->emp_cd); ?>" readonly>

	    	<input type="text" name="emp_name" style="width:300px;display:inline;margin-left:20px" 
	    	       class="field-style field-split align-left"value="<?php echo($dtls->emp_name);?>" readonly>      
	    </li>
	    <br><br>
	    <li>
	 	    <label for="attn_dt" style="display:inline;" class="field-split align-left labelstyle">
	 	           Date</label> 
	 	    <label for="status" style="display:inline;margin-left:279px;" class="field-split align-left
	 	           labelstyle">Status</label>
	
	        <input type="text" name="attn_dt" style="width:300px;display:inline;" class="field-style
	               field-split align-left" value="<?php echo date('d/m/Y',strtotime($dtls->attn_dt)); ?>" readonly>
	          
	        <input type="text" name="status" style="width:300px;display:inline;margin-left:20px" 
	               class="field-style field-split align-left"value="<?php if($dtls->status =='H'){
																				echo "Half";	
																		  }elseif($dtls->status =='A'){
																		  		echo "Absent";
																		  }elseif($dtls->status =="E"){
																		  		echo "Early Out";
																		  }elseif($dtls->status=="L"){
																		  		echo "Late In";
																		  }else{
																		  		echo "Client Site";
																		  }
	               													?>" readonly>
	    </li>
	    <br><br>
	    <li>
	        <label for="in_out_time" style="display:inline;"class="field-split align-left labelstyle">
	        	   Time </label> 
	        <label for="no_of_days" style="display:inline;margin-left:280px;" class="field-split align-left
	               labelstyle">Days</label> 

	        <input type="text" name="in_out_time" id="dp1" style="width:300px" class="field-style field-split
	               align-left" value="<?php echo $dtls->in_out_time;?>" readonly>

	        <input type="text" name="no_of_days"id=dp2 style="width:300px;display:inline;margin-left:20px" 
	               class="field-style field-split align-left" 
                   value="<?php echo $dtls->no_of_days;?>" readonly>
	    </li>
	    <br><br>
		<li>
	    	<label for="remarks" class="field-split align-left labelstyle">Remarks </label> 
	    	<textarea type="text"class= "field-style field-split align-left" style="width:620px" name = "remarks" readonly><?php echo $dtls->remarks;?></textarea> 
	    </li>
	    
	    <li>
      	   <input type="submit" name="del" id="del" value="Delete">
	    </li>
    </ul>	 
</form>




