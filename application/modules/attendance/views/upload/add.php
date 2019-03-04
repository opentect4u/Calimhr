<div class="content-wrapper">
  <div class="container-fluid">
	<h3>Leave Application Form</h3>
	<hr> 
	    <form style="max-width:700px;background:#fafafa;
	    	         padding:30px;box-shadow:1px 1px 25px rgba(0,0,0,0.35);
                         border-radius:10px;border: 2px solid #305a72"
		  class="form-style-9" method="POST" action="<?php echo site_url('leave/applyLeave');?>"
	    />
      <ul>
      	<li>
      		<label for="appldt" class="field-split align-left labelstyle">
		       Application Date
		</label>
      	
		<input type="text" name="appldt" style="width:325px;" 
		       class = "field-style field-split align-left" 
		       value ="<?php echo date('d/m/Y');?>" readonly
		/>

	 </li>

	 <br><br>
	
	<li>
		<label for=lvtype class = "field-split align-left labelstyle">
			Type of Leave
		</label>

		<label for  ="lvno" style = "display:inline;margin-left:18px" 
                       class="field-split align-left labelstyle">
                        Balance Leave
                </label>


		<select name = "lvtype" style="width:325px;display:inline" 
                        class="field-style field-split align-left" required>

			<option value = "">Select</option>
			<option value = "C">Casual Leave</option>
			<option value = "E">Earn Leave</option>
		</select>

		<input type="text" name="lvno" style="width:300px;display:inline;margin-left:5px" 
		       class = "field-style field-split " readonly
		/> 

	</li>
	
	<br>

	<li>
		<label for = "frmdt" class="field-split align-left labelstyle">
			Date From
		</label>

		<label for  ="todt" style = "display:inline;margin-left:19px" 
                       class="field-split align-left labelstyle">
                        Date To
                </label>
 

		<input type = "date" name="frmdt" id="dp1" style="width:325px" 
		       class="field-style field-split align-left" required
		/>

		<input type = "date" name="todt" style = "width:300px;display:inline;margin-left:10px" 
                       class="field-style field-split" required
                />

	</li>
	
	<br>

	<li>
		<label for="rns" class="field-split align-left labelstyle">
                       Reason
                </label>

		<textarea name="rns" style="width:630px;"class="field-style field-split align-left"rows="2"cols="40"required></textarea> 

	</li>
	    
	<li>
      	    <input type="submit" name="submit" value="Save">
	</li>
    </ul>	 
</form>


