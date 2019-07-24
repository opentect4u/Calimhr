<div class="content-wrapper">
  <div class="container-fluid">
    <form action="<?php echo site_url('attendance/adjustment');?>" method="POST">
        <div class="form-row"> 
            <div class="form-group col-md-3">
                <label>Last Adjusment Date:</label>
                <input type="date" name="last_adjust_date" id="date1" class="form-control" value="<?php echo $adjustment_date->adjustment_date; ?>" readonly/>
            </div>
            <div class="form-group col-md-3">
                <label>Adjusment Date:</label>
                <input type="date" name="latest_adjust_date" id="date2" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly/>
            </div>
            <table class="table table-hover table-striped">
                <thead>
                    <th>Emp No</th>
                    <th>Emp Name</th>
                    <th>Date</th>
                    <th>CL</th>
                    <th>EL</th>
                    <th>ML</th>
                    <th>Holiday</th>
                    <th>Late</th>
                    <th>Half</th>
                    <th>LWP</th>
                </thead>
                <tbody>
                <?php
                    foreach($leave_bals as $balance){
                ?>
                    <tr>
                        <td><input type="hidden" name="emp_code[]" value="<?php echo $balance->emp_no; ?>"><?php echo $balance->emp_no; ?></td>
                        <td><input type="hidden" name="emp_name[]" value="<?php echo $balance->emp_name; ?>"><?php echo $balance->emp_name; ?></td>
                        <td><input type="hidden" name="balance_dt[]" value="<?php echo $balance->balance_dt; ?>"><?php echo date('d-m-Y', strtotime($balance->balance_dt)); ?></td>
                        <td><input type="hidden" name="cl[]" value="<?php echo ($balance->cl=='')? '0': $balance->cl; ?>"><?php echo $balance->cl; ?></td>
                        <td><input type="hidden" name="el[]" value="<?php echo ($balance->el=='')? '0': $balance->el; ?>"><?php echo $balance->el; ?></td>
                        <td><input type="hidden" name="ml[]" value="<?php echo ($balance->ml=='')? '0': $balance->ml; ?>"><?php echo $balance->ml; ?></td>
                        <td><input type="hidden" name="hl[]" value="<?php echo ($balance->hl=='')? '0': $balance->hl; ?>"><?php echo $balance->hl; ?></td>
                        <td class="late">
                            <?php
                                foreach($adjustable['lates'] as $late){
                                    if($late->emp_cd == $balance->emp_no){
                            ?>
                                        <input type="hidden" name="late[]" value="<?php echo $late->late; ?>">
                                        <p>
                            <?php
                                        echo $late->late."</p>";
                                    }
                                }
                            ?>
                        </td>
                        <td class="half">
                            <?php
                                foreach($adjustable['halfs'] as $half){
                                    if($half->emp_cd == $balance->emp_no){
                            ?>
                                    <input type="hidden" name="half[]" value="<?php echo $half->half; ?>">
                                    <p>
                            <?php
                                        echo $half->half."</p>";
                                    }
                                }
                            ?>
                        </td>
                        <td><input type="hidden" name="lwp[]" value="<?php echo $balance->lwp; ?>"><?php echo $balance->lwp; ?></td>
                    </tr>
                <?php        
                    }
                ?>
                </tbody>
            </table>
            <div class="row" style="margin-left: 45%;">
                <button type="submit" class="btn btn-primary">Adjustment</button>
            </div>
        </div>
    </form>
  </div>
</div>  

<script>
    $(document).ready(function(){

        $('.late p').each(function(){
            $(this).text($.trim($(this).text()));
        });

        $('.late').each(function(){
            if($(this).find("p").length === 0){
                $(this).append("<input type='hidden' name='late[]' value='0'>0");
            }
        });

        $('.half p').each(function(){
            $(this).text($.trim($(this).text()));
        });

        $('.half').each(function(){
            if($(this).find("p").length === 0){
                $(this).append('<input type="hidden" name="half[]" value="0">0');
            }
        });

        if($('#date1').val() == $('#date2').val()){
            $('button').hide();
        }
        
    });
</script>