<div class="content-wrapper">
    <div class="container-fluid">
    <h3>View Attendance Status</h3>
    <hr>
      <div class="card mb-3">
        <div class="card-header">
	  <!--<button class="btn btn-success add-btn" data-toggle="tooltip" data-placement="bottom" title="" 
 		  data-original-title="Apply" onclick="location.href='<?php echo site_url("attendance/addStatus"); ?>';">
	    <i class="fa fa-user-plus fa-lg" aria-hidden="true"></i>New
	  </button>-->
	</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Date</th>
    		  		    <th>Status</th>
    		  		    <th>Details</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Date</th>
		  		        <th>Status</th>
		  		        <th>Details</th>
                </tr>
              </tfoot>
              <tbody>
				<?php if($dtls){
                   	foreach ($dtls as $values):?>
                <tr>
					<td><?php echo date('d/m/Y',strtotime($values->attn_dt));?></td> 
		  			<td><?php $stType = $values->status;
			    			if($stType == 'L'){
                  $stType = 'Late In';
                }elseif($stType == 'E'){
                  $stType = 'Early Out';
                }elseif($stType == 'H'){
                  $stType = 'Half';
                }elseif($stType == 'C'){
                  $stType = 'Client Site';
                }else{
                  $stType = 'Absent';
                }
              echo $stType;
		       			?>
		  			</td>
		      <td><button class="btn btn-primary edit-btn" data-toggle="tooltip" 
                       	   data-placement="bottom" title="" data-original-title="Edit Application" 
                           onclick="location.href='<?php echo site_url("attendance/dtlAttn?attn_dt=$values->attn_dt&emp_cd=$values->emp_cd&status=$values->status");?>';">
		           <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
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
