<div class="content-wrapper">
  <div class="container-fluid">
	<h3>Add Status</h3>
	<hr> 
	<form style="max-width:800px;background:#fafafa;padding:30px;box-shadow: 1px 1px 25px rgba(0,0,0,0.35);border-radius:10px;border: 2px solid #305a72"
	      class="form-style-9" method="POST" action="<?php echo site_url('attendance/addStatus'); ?>">
      <ul>
	 <li>
	    <select class="field-style field-split align-left" style="width:400px;" name="emp_cd">
	    	<option value="">Select Employee</option>
	    	<?php
	    		foreach($emp as $value){
	    			echo "<option value=".$value->emp_no.">".$value->emp_name."</option>"; 
	    		}
	    	?>
	    </select>	
	 </li>
	 <br>
	 <li>
	    <select class="field-style field-split align-left" style="width:400px;" name="status" id="status">
	    	<option value="">Select Attendance Status</option>
	    	<option value="L">Late In</option>
	    	<option value="E">Early Out</option>
	    	<option value="H">Half</option>
	    	<option value="A">Absent</option>
	    	<option value="C">Client Site</option>
	    </select>
	 </li>
	 <br>
	 <li>
	    <input type="date" id="dp1"name="attn_dt" style="width:400px;" class="field-style field-split align-left" placeholder="Date" required>
	    <i class="fa fa-calendar"></i>
	</li>  	
	<br class="attn_br">
	  <li id="time">
	    <input type="text" name="in_out_time" style="width:400px" class="field-style field-split align-left"  placeholder="Time">
	 </li>
	 <br class="hide_br">
	 <li id="days">
	    <input type="text" name="days" id="dys" style="width:400px;" class="field-style field-split align-left" placeholder="No.of Days" onchange="endDt()">
	</li>  	
	 <br class="hide_br">
	 <li id="end_dt">
	    <input type="date" name="end_dt" id="endt" style="width:400px;" class="field-style field-split align-left" placeholder="End Date" readonly>
	    <i class="fa fa-calendar"></i>
	</li>  	
	<br>
	 <li>
		<textarea type="text"class= "field-style field-split align-left" style="width:400px" name = "remarks" placeholder="Remarks"></textarea>       
	</li>	 
	
	<br>
	 <li>
      	    <input type="submit" name="submit" value="Save">
	 </li>
     </ul>	
  
</form>

<script src="<?php echo base_url('js/jquery.maskedinput.js'); ?>"></script>

<script>
  /*$(document).ready(function($){
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
   });*/		

   $(document).ready(function(){
   		$("#status").change(function(){
   			if($("#status").val()=='A' || $("#status").val()=='C'){
   				$("#time").hide();
   				$(".attn_br").hide();
   				$("#days").show();
   				$("#end_dt").show();
   				$(".hide_br").show();
   			}else{
   				$("#days").hide();
   				$("#time").show();
   				$("#end_dt").hide();
   				$(".hide_br").hide();
   			}
   		});

   		$("#dp1").change(function(){
   			$("#dys").val(0);
   		});
   });




   function endDt(){
			var frmDt = document.getElementById("dp1").value;
			var days  = document.getElementById("dys").value;
			var day;

			var year;

			days = (days - 1);
		
			toDt   = new Date(frmDt);

			toDt.setDate(toDt.getDate() + days);

			var dd = toDt.getDate();
    		var mm = toDt.getMonth() + 1;
    		var y  = toDt.getFullYear();

    		if(dd < 9){
    			dd = '0' + dd;
    		}else{
    			dd = dd;
    		}

    		if(mm < 9){
    			mm = '0' + mm;
    		}else{
    			mm = mm;
    		}

			var format = y + '-' + mm + '-' + dd;

			document.getElementById("endt").value = format;
		}


</script>

<style>
.datepicker{z-index:1151 !important;}
</style>

