<script type="text/javascript">
 /* $(document).ready(function() {
    $('#dataTable').DataTable( {
       "order": [[ 0, "asc" ]]
    } );
    $('#dataTable_filter').hide();
    $('#dataTable_length').hide();
    $('#dataTable_info').hide();
    $('#dataTable_paginate').hide();
} );*/

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
    		<h5 style="text-align: center;">Leave applications between <?php echo date('d/m/Y', strtotime($date[0])).' to '.date('d/m/Y', strtotime($date[1]));?></h5>
    		
    		<?php
        if ($val && $date) { ?>
    		
	    	<div class="card">
	          	<div class="table">
		           	<table class="table table-bordered width" id="dataTable" cellpadding="4">
	              		<thead>
	                		<tr>
			                	<th>Application Date</th>
                        <th>Application No.</th>
                        <th>Name</th>
                        <th>Leave Type</th>
                        <th>Period</th>
                        <th>No.of Days</th>
	                		</tr>
	              		</thead>
	              		<tbody>
	              			<?php //if($alldata){
			                	foreach ($val as $apl){ ?>
			                <tr>
			                  	<td class="center"><?php echo date('d/m/Y',strtotime($apl->appl_dt));?></td>
                          <td class="center"><?php echo $apl->appl_no; ?></td>
                          <td class="center"><?php echo $apl->emp_name; ?></td>
			                  	<td class="center"><?php if($apl->leave_type=='C'){
                                                      echo "CL";
                                                    }elseif($apl->leave_type=='M'){
                                                      echo "ML";  
                                                    }elseif($apl->leave_type=='E'){
                                                      echo "EL";  
                                                    }else{
                                                      echo "NA";
                                                    }
                                             ?>
                          </td>
                          <td class="center"><?php echo date('d/m/Y',strtotime($apl->from_dt)).' to '.date('d/m/Y',strtotime($apl->to_dt));?></td>
			                  	 
                          <td class="center"><?php echo $apl->days; ?></td>
			                </tr>
			                <?php	 
                        //endforeach;
			                 } 
			                ?>
	             	 	</tbody>
		            </table>
		            <?php }?>
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