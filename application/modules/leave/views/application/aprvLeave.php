<div class="content-wrapper">
  <div class="container-fluid">
	<h3>Approve Leave Application</h3>
	<hr> 
	    <form style="max-width:700px;background:#fafafa;
	    	         padding:30px;box-shadow:1px 1px 25px rgba(0,0,0,0.35);
                         border-radius:10px;border: 2px solid #305a72"
		  class="form-style-9" method="POST" action="<?php echo site_url('leave/AprvLeave');?>"
	      />
      <ul>
      	<li>
      		<label for="appldt" class="field-split align-left labelstyle">
		       Application Date
		    </label>

		    <label for="applno" class="field-split align-left labelstyle" style="display:inline;margin-left:19px">
		       Application No.
		    </label>
      	
		<input type="date" name="appldt" style="width:325px;" 
		       class = "field-style field-split align-left" 
		       value ="<?php echo $leave_dtls->appl_dt; ?>" readonly
		/>

		<input type="number" name="applno" style="width:300px;display:inline;margin-left:10px;" 
		       class = "field-style field-split align-left" value="<?php echo $leave_dtls->appl_no; ?>"
		       readonly
		/>

	 </li>

	
	<li>
		<label for=lvtype class = "field-split align-left labelstyle">
			Type of Leave
		</label>

		<input type="text" name="lvtype" style="width:325px;" 
		       class = "field-style field-split " 
		       value = "<?php if($leave_dtls->leave_type=='C'){
		       			        echo "CL";
		       			      }elseif($leave_dtls->leave_type=='E'){
		       			      	echo "EL";
		       			      }elseif($leave_dtls->leave_type=='M'){
		       			      	echo "ML";		
		       			      }else{
		       			      	echo "HL";	
		       			      }
		       			      ?>"readonly
		/> 

		<input type="hidden" name="lvno" style="width:300px;display:inline;margin-left:5px" 
		       class = "field-style field-split " readonly
		/> 

	</li>
	

	<li>
		<label for = "frmdt" class="field-split align-left labelstyle">
			Start Date
		</label>

		<label for="applno" class="field-split align-left labelstyle" style="display:inline;margin-left:19px">
		       No.of Days
		    </label>

        <input type = "date" name="frmdt" id="dp1" style="width:325px;" 
		       class="field-style field-split align-left" 
		       value="<?php echo $leave_dtls->from_dt;?>" readonly
		/>

        <input type="number" name="days" id="days" style="width:300px;display:inline;margin-left:10px;" 
		       class = "field-style field-split align-left" 
		       value="<?php echo $leave_dtls->days;?>"
		       readonly
		/>
	</li>
	
	

	<li>

		<label for  ="todt" class="field-split align-left labelstyle">
            End Date
        </label>

        <label id="lbl" style = "visibility:hidden;display:inline;margin-left:19px" 
               class="field-split align-left labelstyle">
        </label>
 
		<input type = "date" name="todt" id="dp2" style = "width:325px;" 
                       class="field-style field-split" 
                       value="<?php echo $leave_dtls->to_dt;?>"readonly
        />	
	</li>

	<li>

		<label for  ="aprvStatus" class="field-split align-left labelstyle">
            Status
        </label>
 
		<select name = "aprvStatus" style="width:325px;display:inline" 
                        class="field-style field-split align-left" required>
			<option value = "U">Unapprove</option>
			<option value = "A">Approve</option>
			<option value = "R">Reject</option>
		</select>
	</li>


	<li>	

		<label for="rns" class="field-split align-left labelstyle">
                 Reason
        </label>

		<textarea name="rns" style="width:625px;"class="field-style field-split align-left"rows="2"cols="40"readonly><?php echo $leave_dtls->remarks;?></textarea> 

	</li>
	    
	<li>
      	    <input type="submit" name="submit" value="Save">
	</li>
    </ul>	 
</form>