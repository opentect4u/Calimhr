<script type="text/javascript">
  $(document).ready(function() {
    $('#dataTable').DataTable( {
       "order": [[ 0, "asc" ]]
    } );
    $('#dataTable_filter').hide();
    $('#dataTable_length').hide();
    $('#dataTable_info').hide();
    $('#dataTable_paginate').hide();
} );

  function printClaimDtls() {    
  var divToPrint = document.getElementById('divToPrint');

  var WindowObject = window.open('','Print-Window');
        WindowObject.document.open();
        WindowObject.document.writeln('<!DOCTYPE html>');
        WindowObject.document.writeln('<html><head><title></title>');

        WindowObject.document.writeln('<style type="text/css">@media print { .center { text-align: center;} .underline { text-decoration: underline; } p { display:inline; } .left { margin-left: 315px; text-align="left"; display: inline; } .right { margin-right: 375px; display: inline; } td.left_algn { text-align: left; } td.right_algn { text-align: right; } td.hight { hight: 15px; } table.width { width: 100%; } table.noborder { border: 0px solid black; } th.noborder { border: 0px solid black; } .border { border: 1px solid black; } .bottom { position: absolute; bottom: 5px; width: 100%; } .tValHide { display:none; } } </style>');
       // WindowObject.document.writeln('<style type="text/css">@media print{p { color: blue; }}');
        WindowObject.document.writeln('</head><body onload="window.print()">');
        WindowObject.document.writeln(divToPrint.innerHTML);
        WindowObject.document.writeln('</body></html>');
        WindowObject.document.close();
        setTimeout(function(){WindowObject.close();},10);
    }
</script>
<div id="divToPrint">
	<div class="content-wrapper">
    	<div class="container-fluid">
    		<h3 style="text-align: center;">SYNERGIC SOFTEK SOLUTIONS PVT. LTD.</h3>
    		<h4 style="text-align: center;">55 D, DESAPRAN SASHMAL ROAD</h4>
    		<h5 style="text-align: center;">KOLKATA-33</h5>
    		<h5 style="text-align: center;">Leave & Attendance Between <?php echo date('d/m/Y', strtotime($date->from_date)).' to '.date('d/m/Y', strtotime($date->to_date));?></h5>
    		<hr>
    		<?php
        if ($alldata && $emp_dtls && $date) {
    			foreach ($emp_dtls as $alldta) {
    		?>
    		<div style="margin-left: 20px;">
				Employee Name : <?php echo $alldta->emp_name;?><?php }?><br style="line-height: 28px;">
			</div>
			<hr>
      <div class="card">
        <div class="table">
          <table class="table table-bordered width" id="dataTable" cellpadding="4">
            <thead>
              <tr>
                <th>Date</th>
                <th>CL</th>
                <th>EL</th>
                <th>ML</th>
                <th>Holiday</th>
                <th>LWP</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?php echo date('d/m/Y',strtotime($opndata->balance_dt)); ?>
                <td><?php echo $opndata->cl; ?>
                <td><?php echo $opndata->el; ?>
                <td><?php echo $opndata->ml; ?>
                <td><?php echo $opndata->hl; ?>
                <td><?php echo $opndata->lwp; ?>
              </tr>
            </tbody>
          </table>  
        </div>
      </div>
      <hr>
	    	<div class="card">
	          	<div class="table">
		           	<table class="table table-bordered width" id="dataTable" cellpadding="4">
	              		<thead>
	                		<tr>
			                	<th>Date</th>
                        <th>Type</th>
                        <!-- <th>Time</th>
			                  <th>Remarks</th> -->
                        <th>In/Out Time</th>
                        <th>No of days</th>
                        <th>Status</th>
	                		</tr>
	              		</thead>
	              		<tbody>
	              			<?php if($alldata){
			                	foreach ($alldata as $aldta):?>
			                <tr>
			                  	<td class="center"><?php echo date('d/m/Y',strtotime($aldta->attn_dt));?></td>
			                  	<td class="center"><?php if($aldta->status=='C'){
                                                      echo "CL";
                                                    }elseif($aldta->status=='M'){
                                                      echo "ML";  
                                                    }elseif($aldta->status=='E'){
                                                      echo "EL";  
                                                    }elseif($aldta->status=='R'){
                                                      echo "Early Out";
                                                    }elseif($aldta->status=='L'){
                                                      echo "Late In";
                                                    }elseif($aldta->status=='H'){
                                                      echo "Half";
                                                    }elseif($aldta->status=='I'){
                                                      echo "Client Site";
                                                    }elseif($aldta->status=='W'){
                                                      echo "LWP";
                                                    }elseif($aldta->status=='O'){
                                                      echo "Holiday Half";
                                                    }elseif($aldta->status=='F'){
                                                      echo "Holiday Full";
                                                    }
                                                    elseif($aldta->status=='A'){
                                                      echo "Adjustment";
                                                    }
                                             ?>
                          </td>
			                  	<td class="center"><?php echo $aldta->in_out_time;?></td>   
			                  	<td class="center"><?php echo $aldta->no_of_days;?></td>   
                          <td class="center"><?php if(($aldta->adj_flag == 'U') && ($aldta->no_of_days == 0)){
                                                    echo ''; 
                                                  }
                                                  else if(($aldta->adj_flag == 'U') && ($aldta->no_of_days > 0)){
                                                    echo 'Unadjusted';
                                                  }else{
                                                    echo 'Adjusted';
                                                  } ?></td>
			                </tr>
			                <?php	 
                        endforeach;
			                 } 
			                ?>
	             	 	</tbody>
		            </table>
		            <?php }?>
	          	</div>
    		</div>
        <hr>
        <div class="card">
        <div class="table">
          <table class="table table-bordered width" id="dataTable" cellpadding="4">
            <thead>
              <tr>
                <th>Date</th>
                <th>CL</th>
                <th>EL</th>
                <th>ML</th>
                <th>Holiday</th>
                <th>LWP</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?php echo date('d/m/Y',strtotime($clsdata->balance_dt)); ?>
                <td><?php echo $clsdata->cl; ?>
                <td><?php echo $clsdata->el; ?>
                <td><?php echo $clsdata->ml; ?>
                <td><?php echo $clsdata->hl; ?>
                <td><?php echo $clsdata->lwp; ?>
              </tr>
            </tbody>
          </table>  
        </div>
        <div class="card-footer">
                <button class="btn print-btn tValHide" type="button" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Print" style="width: 95px;" id="" onclick="printClaimDtls();"><i class="fa fa-print fa-lg" aria-hidden="true"></i></button>
              </div>
      </div>
    	</div>
	</div>
</div>
		    		
    <div class="modal fade" id="clIndDtl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="dtl-show">
          
        </div>
      </div>
    </div>
  
    <!--<script type="text/javascript">

      $('.show-btn').click(function(){
        var claim_cd = $(this).attr('id');
        $.get( "<?php echo base_url().'index.php/admin/ind_claim_dtl_ajax'?>", { id: claim_cd } )
          .done(function( data ) {
            $('#dtl-show').html(data);
            $('#clIndDtl').modal('show');
          });
      });
    </script>-->