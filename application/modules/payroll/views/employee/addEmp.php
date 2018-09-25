<div class="content-wrapper">
  <div class="container-fluid">
	<h3>Add New Employee</h3>
	<hr> 
	<form style="max-width:800px;background:#fafafa;padding:30px;box-shadow: 1px 1px 25px rgba(0,0,0,0.35);
                     border-radius:10px;border: 2px solid #305a72"
	      class="form-style-9" method="POST" action="<?php echo site_url('payroll/addEmp'); ?>">
      <ul>
	 <li>
	    <input type="text" name="emp_no" style="width:350px;display:inline" class="field-style field-split align-left" 
		   placeholder="Employee No." required>
	 
	    <input type="text" name="emp_name" style="width:350px;display:inline;margin-left:20px" class="field-style field-split align-left" 
		   placeholder="Name" required>
	 </li>
	 <li>
	    <select type="text" name="emp_dept" style="width:350px;display:inline" class="field-style field-split align-left custom-select">
		   	<option value="0">Select</option>
 		 	<?php
 		 		foreach ($dept as $value) {?>
 		 			<option value="<?php echo $value->sl_no;?>"><?php echo $value->department;?></option>
 		 	<?php  
 		 	    }
 		 	?>
	    </select>

	    <select type="text" name="emp_desg" style="width:350px;display:inline;margin-left:16px;" class="field-style field-split align-left custom-select">
		   	<option value="0">Select</option>
		   	<?php
 		 		foreach ($desg as $value) {?>
 		 			<option value="<?php echo $value->designation;?>"><?php echo $value->designation;?>
 		 		    </option>
 		 	<?php  
 		 	    }
 		 	?>
		</select>   
	 </li>

	  <li>
	    <input type="text" name="doj" id="dp1" style="width:350px" class="field-style field-split align-left"  placeholder="Joining Date">
		<i class="fa fa-calendar"></i>
		
	 </li>
	 <li>
	    <input type="text" name="pan_no" style="width:350px;display:inline" class="field-style field-split align-left" 
		   placeholder="PAN No.">
	
	    <input type="text" name="ac_no" style="width:350px;display:inline;margin-left:20px" class="field-style field-split align-left" 
		   placeholder="Account No.">	       
	</li>	 
	<br>
	 <li>
      	    <input type="submit" name="submit" value="Save">
	 </li>
     </ul>	
  
</form>

<script src="<?php echo base_url('js/jquery.maskedinput.js'); ?>"></script>

<script>
  $(document).ready(function($){
      $('#dp1').datepicker({
          format: 'dd/mm/yyyy',
          endDate: "today"
        });
  });

  $(document).ready(function($){
      $("#dp1").mask("99/99/9999");
  });

  $(document).ready(function($){
	  $("#dp1").css({"placeholder":"opacity:0.4"});	
   });		  
</script>

<style>
.datepicker{z-index:1151 !important;}
</style>

