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

	
	<li>
		<label for=lvtype class = "field-split align-left labelstyle">
			Type of Leave
		</label>

		<select name = "lvtype" style="width:325px;display:inline" 
                        class="field-style field-split align-left" required>

			<option value = "">Select</option>
			<option value = "C">CL</option>
			<option value = "E">EL</option>
			<option value = "M">ML</option>
			<option value = "H">HL</option>
		</select>

		<input type="hidden" name="lvno" style="width:300px;display:inline;margin-left:5px" 
		       class = "field-style field-split " readonly
		/> 

	</li>
	

	<li>
		<label for = "frmdt" class="field-split align-left labelstyle">
			Start Date
		</label>

		<!--<label for="days" style = "display:inline;margin-left:19px;display:none"
						  class="field-split align-left labelstyle">
                 No.of Days
        </label>-->

        <input type = "date" name="frmdt" id="dp1" style="width:325px;" 
		       class="field-style field-split align-left" required onchange="showDay()"
		/>

        <input type="number" name="days" id="days" style="width:300px;display:inline;margin-left:10px;display:none" 
		       class = "field-style field-split align-left" 
		       placeholder = "No. of Days of Leave" onchange="endDt()"
		       required
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
                       class="field-style field-split" readonly required
        />	
	</li>


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

<script>
		function endDt(){
			var frmDt = document.getElementById("dp1").value;
			var days  = document.getElementById("days").value;
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

			document.getElementById("dp2").value = format;
			
		}

		/*function chkDt(){
			var endDt	=	document.getElementById("dp2").value;

			if(endDt=""){
				document.getElementById("lbl").style.visibility="visible";
            	document.getElementById("lbl").innerHTML="Invalid end date";
            	document.getElementById("lbl").style.color="blue";
            	document.getElementById("dp2").style.border="solid 3px red";
            	return false;
			}else{
				document.getElementById("lbl").style.visibility="hidden";
            	document.getElementById("lbl").innerHTML="";
            	document.getElementById("lbl").style.color="";
            	document.getElementById("cust_per_ph").style.border="";
            	return true;
			}
		}*/

		function showDay(){
			document.getElementById("days").style.display = 'block';
		}
</script>


