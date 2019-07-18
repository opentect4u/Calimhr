<div class="content-wrapper">
  <div class="container-fluid">
    <div class="form-row"> 
        <div class="form-group col-md-3">
            <label>Last Adjusment Date:</label>
            <input type="text" class="form-control" value="<?php echo date('d-m-Y', strtotime($adjustment_date->adjustment_date)); ?>" readonly/>
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
                <th>Holiday Full</th>
                <th>Holiday Half</th>
                <th>LWP</th>
            </thead>
            <tbody>
            <?php
                foreach($leave_bals as $balance){
            ?>
                <tr>
                    <td><?php echo $balance->emp_no; ?></td>
                    <td><?php echo $balance->emp_name; ?></td>
                    <td><?php echo date('d-m-Y', strtotime($balance->balance_dt)); ?></td>
                    <td><?php echo $balance->cl; ?></td>
                    <td><?php echo $balance->el; ?></td>
                    <td><?php echo $balance->ml; ?></td>
                    <td><?php echo $balance->hl; ?></td>
                    <td>
                        <?php
                            foreach($adjustable['lates'] as $late){
                                if($late->emp_cd == $balance->emp_no){
                                    echo $late->late;
                                }
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            foreach($adjustable['halfs'] as $half){
                                if($half->emp_cd == $balance->emp_no){
                                    echo $half->half;
                                }
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            foreach($adjustable['holiday_fulls'] as $holiday_full){
                                if($holiday_full->emp_cd == $balance->emp_no){
                                    echo $holiday_full->holiday_full;
                                }
                            }
                            ?>
                    </td>
                    <td>
                        <?php
                            foreach($adjustable['holiday_halfs'] as $holiday_half){
                                if($holiday_half->emp_cd == $balance->emp_no){
                                    echo $holiday_half->holiday_half;
                                }
                            }
                        ?>
                    </td>
                    <td><?php echo $balance->lwp; ?></td>
                </tr>
            <?php        
                }
            ?>
            </tbody>
        </table>
        <button type="button" class="btn btn-primary">Adjustment</button>
    </div>
  </div>
</div>  