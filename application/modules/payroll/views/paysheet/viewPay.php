<div class="content-wrapper">
    <div class="container-fluid">
      <h3>View Paysheet</h3>
      <hr>
        <div class="card mb-3">
	<div class="card-header">
	     <!--<button class="btn btn-success add-btn" data-toggle="tooltip" data-placement="bottom" 
        title="" data-original-title="Upload Paysheet" onclick="location.href='<?php //echo site_url("payroll/uplPay"); ?>';">
               <a><i class="fa fa-user-plus fa-lg" aria-hidden="true"></i> Upload .csv File</a> 
      </button>-->
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Year</th>
                  <th>Month</th>
                  <th>Gross Amount</th>
                  <th>Net Amount</th>
                  <th>Print</th> 
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Date</th>
                  <th>Year</th>
                  <th>Month</th>
                  <th>Gross Amount</th>
                  <th>Net Amount</th>
                  <th>Print</th> 
                </tr>
              </tfoot>
              <tbody>
	      <?php if($data_dtls){
	      	    foreach ($data_dtls as $values):
              ?>
                <tr>
		  <td><?php echo date('d/m/Y',strtotime($values->trans_dt));?></td>
                  <td><?php echo $values->sal_year;?></td>
		  <td><?php
		    $mth=$values->sal_month;
		    switch($mth){
		    	case 1:
			 $month='January';
			 break;
			case 2:
			 $month="February";
			 break;
			case 3:
                         $month="March";
                         break;
 			case 4:
			 $month="April";
		 	 break;
			case 5:
                         $month="May";
                         break;
	 		case 6:
                         $month="June";
                         break;
			case 7:
                         $month="July";
                         break;
			case 8:
                         $month="August";
                         break;
			case 9:
                         $month="September";
                         break;
			case 10:
                         $month="October";
                         break;
			case 11:
                         $month="November";
                         break;
 			case 13:
                         $month="December";
			 break;
		    } 
		      echo $month;?></td>
                  <td><?php echo $values->tot_ear;?></td>
		  <td><?php echo $values->net_amt;?></td>            
                  <td><button class="btn print-btn onClick" data-toggle="tooltip" data-placement="bottom" title="" 
		       data-original-title="Print" 
		       onclick="location.href='<?php echo site_url("payroll/finalPrintPs?trans_dt=$values->trans_dt&emp_no=$values->emp_no");?>'">

                      <i class="fa fa-print fa-lg" aria-hidden="true"></i>
		      </button>
		  </td>
                </tr>
                <?php
                endforeach;
                } 
              ?>
              </tbody>
            </table>
          </div>
      </div>
        <div class="card-footer small text-muted"></div>
      </div>
      </div>
      </div>
    </div>
 </div>
</div>			

<script>

    $(document).ready(function() {

    <?php if($this->session->flashdata('msg')){ ?>
	window.alert("<?php echo $this->session->flashdata('msg'); ?>");
    });

    <?php } ?>
</script>

