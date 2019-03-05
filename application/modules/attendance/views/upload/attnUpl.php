<div class="content-wrapper">
    <div class="container-fluid">
    <h3>Manage Attendance Status</h3>
    <hr>
      <div class="card mb-3">
        <div class="card-header">
	  <button class="btn btn-success add-btn" data-toggle="tooltip" data-placement="bottom" title="" 
 		  data-original-title="Apply" onclick="location.href='<?php echo site_url("attendance/addStatus"); ?>';">
	    <i class="fa fa-user-plus fa-lg" aria-hidden="true"></i>New
	  </button>
	</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Date</th>
		  		  <th>Emp.No.</th>
		  		  <th>Name</th>	
		  		  <th>Status</th>
		  		  <th>Option</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Date</th>
		  		  <th>Emp.No.</th>
		  		  <th>Name</th>
		  		  <th>Status</th>
		  		  <th>Option</th>
                </tr>
              </tfoot>
              <tbody>
				<?php if($dtls){
                   	foreach ($dtls as $values):?>
                <tr>
					<td><?php echo date('d/m/Y',strtotime($values->attn_dt));?></td> 
		  			<td><?php echo $values->emp_cd;?></td>
		  			<td><?php echo $values->emp_name;?></td>
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
		     <td><button class="btn btn-primary btn-danger" data-toggle="tooltip" 
                           data-placement="bottom" title="" data-original-title="Delete" 
                           onclick="location.href='<?php echo site_url("attendance/delAttn?attn_dt=$values->attn_dt&emp_cd=$values->emp_cd&status=$values->status");?>';">
               <i class="fa fa-trash-o fa-lg" aria-hidden="true"></i>
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
