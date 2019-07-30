<div class="content-wrapper">
  <div class="container-fluid">
    <form action="<?php echo site_url('attendance/lopenbal');?>" method="POST">
        <div class="form-row"> 
            <div class="form-group col-md-3">
                <label>Employees:</label>
                <select name="emp_code" class="form-control" id="emp" required>
                    <option value="">Select</option>
                    <?php
                        foreach($emp_list as $list){
                    ?>

                        <option value="<?php echo $list->emp_no; ?>"><?php echo $list->emp_name; ?></option>

                    <?php
                        }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>Date:</label>
                <input type="date" name="date" class="form-control" id="date" required>
            </div>
            <div class="form-group col-md-3">
            </div>
            <div class="form-group col-md-3">
                <?php 
                    if($this->session->flashdata('msg')){
                ?>
                    <div class="alert alert-success">
                        Successfully Added!
                    </div>
                <?php
                    }
                ?>
            </div>
        </div>
        <div class="form-row"> 
            <div class="form-group col-md-3">
                <label>CL:</label>
                <input type="text" class="form-control" name="cl" value="0">
            </div>
            <div class="form-group col-md-3">
                <label>EL:</label>
                <input type="text" class="form-control" name="el" value="0">
            </div>
            <div class="form-group col-md-3">
                <label>ML:</label>
                <input type="text" class="form-control" name="ml" value="0">
            </div>
            <div class="form-group col-md-3">
                <label>Holiday:</label>
                <input type="text" class="form-control" name="hl" value="0">
            </div>
            <div class="form-group col-md-3">
                <label>LWP:</label>
                <input type="text" class="form-control" name="lwp" value="0">
            </div>
        </div>
        <div class="form-row"> 
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
  </div>
</div>  

<script>
    $(document).ready(function(){
        $('#emp').change(function(){
            $.get('<?php echo site_url('attendance/getdoj'); ?>',
            {
                emp_cd: $('#emp').val()
            })
            .done(function(data){
                $('#date').val(data);
            });
        });
    });
</script>