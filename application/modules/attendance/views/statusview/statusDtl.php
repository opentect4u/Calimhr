<div class="content-wrapper">
  <div class="container-fluid">
	<h3>Status Detail</h3>
	<hr> 
	<form style="max-width:800px;background:#fafafa;padding:30px;box-shadow: 1px 1px 25px rgba(0,0,0,0.35);border-radius:10px;border: 2px solid #305a72"
	      class="form-style-9" method="POST" action="<?php echo site_url('attendance/addStatus'); ?>">
      <ul>

    <li>
	    <input type="text" name="attn_dt" 
	           style="width:400px;" 
	           class="field-style field-split align-left" 
	           value= "<?php echo date('d/m/Y',strtotime($dtls->attn_dt)); ?>"
	           readonly>
	</li>  	
	<br>
	 <li>
	    <input type="text" name="emp_cd"
	    	   style="width:400px;" 
	    	   class="field-style field-split align-left" 
	    	   value= "<?php echo $dtls->emp_cd; ?>"
	    	   readonly>
	 </li>
	 <br>
	 <li>
	    <input type="text" name="emp_name"
	    	   style="width:400px;" 
	    	   class="field-style field-split align-left" 
	    	   value= "<?php echo $dtls->emp_name; ?>"
	    	   readonly>
	 </li>
	 <br>
	 <li>
	    <input type="text" name="status"
	    	style="width:400px;" 
	    	class="field-style field-split align-left" 
	    	value= "<?php if($dtls->status=='L'){
	    						echo "Late In";
	    				  }elseif($dtls->status=='E'){
	    				  		echo "Early Out";
	    				  }elseif($dtls->status=='H'){
	    				  	    echo "Half";
	    				  }elseif($dtls->status=='C'){
                  				echo "Client Site";		
	    				  }else{
	    				  	    echo "Absent"; 	
	    				  }
	    			?>"
	    	readonly >
	 </li>
	 <br>
	  <li>
	    <input type="text" name="in_out_time"
	    	style="width:400px;" 
	    	class="field-style field-split align-left" 
	    	value= "<?php echo $dtls->in_out_time; ?>"
	    	readonly >
	 </li>
	 </li>
	 <br>
	 <li>
		<textarea type="text"class= "field-style field-split align-left" style="width:400px" name = "remarks" placeholder="Remarks" readonly><?php echo $dtls->remarks; ?></textarea>       
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

