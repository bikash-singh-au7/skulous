<?php
date_default_timezone_set("Asia/Kolkata");

//To show searched data
if($action == 'search'){
    foreach($result as $data){
        ?>
            <tr>
                <td><?= $data->student_name?></td>
                <td><?= $data->father_name?></td>
                <td>
                    <?php
                        $batch = $this->work->select_data("batch", ["id"=>$data->batch_id]);
                        echo date("h:m A", strtotime($batch[0]->batch_start_time))."-".date("h:m A", strtotime($batch[0]->batch_end_time));
                    ?>
                </td>
                <td>
                    <?php
                        $payment = $this->work->select_data("payment", ["reg_id"=>$data->id]);
                        $total_amount  = 0;
                        foreach($payment as $p){
                            $total_amount += $p->amount;
                        }
                        echo $total_amount;
                    ?>
                </td>
                <td>
                    <button class="btn btn-warning" type="button" onclick="makePayment(<?= $data->id?>)"> <i class="fa fa-rupee-sign"></i> </button>
                </td>
            </tr>
        <?
    }
}

//To show each Payment
if($action == "show_payment"){
    ?>
    <div class="row border">
        <div class="col-md-3 mt-1 font-weight-bold text-muted">#Id</div>
        <div class="col-md-3 mt-1 font-weight-bold text-muted">Paid Amount </div>
        <div class="col-md-3 mt-1 font-weight-bold text-muted">Payment Date </div>
        <div class="col-md-3 mt-1 font-weight-bold text-muted">Action</div>
    </div>
    <?
    foreach($data as $result){
        ?>
        <div class="row border" id="<?="pay".$result->id?>">
            <div class="col-md-3 mt-1 text-muted"> <?= $result->id?> </div>
            <div class="col-md-3 mt-1 text-muted"> <?= $result->amount?> </div>
            <div class="col-md-3 mt-1 text-muted"> <?= date("d-M-Y", strtotime($result->payment_date))?> </div>
            <div class="col-md-3 mt-1 text-muted">
                <button class="btn btn-info px-2 py-1"> <i class="fa fa-edit"></i> </button>
                <button class="btn btn-danger px-2 py-1" onclick="deleteData('<?= $result->id?>', 'one')"> <i class="fa fa-trash"></i> </button>
            </div>
        </div>
        <?
    }
}

//To update payment row when making new payment from manage Page
if($action == "manage-update"){
    foreach($data as $value){
        //get Regitration data
        $student_name = $value->student_name;
        //Father name
        $father_name = $value->father_name;
        //Registration Id
        $reg_id = $value->id; 
        //Discount amount from Registration Table
        $student_discount_amount = $value->discount;
        //Batch id
        $batch_id = $value->batch_id; 
        //Batch information
        $batch_data = $this->work->select_data("batch", ["id"=>$batch_id]);
        $batch_name = $batch_data[0]->batch_name;
        $batch_start_time = $batch_data[0]->batch_start_time;
        $batch_end_time = $batch_data[0]->batch_end_time;
        $class_id = $batch_data[0]->class_id;
        $subject_id = $batch_data[0]->subject_id;
        //Batch Fee amount from Batch Table
        $fee_amount = $batch_data[0]->batch_fee;
        //Batch Discount amount from Batch Table
        $batch_discount_amount = $batch_data[0]->discount;


    ?>
        
            <td><?=$reg_id?></td>
            <td><?php echo $student_name;?></td>
            <td class="text-center"><?= $father_name ?></td>

            <td class="text-center">
                <?php

                    $data = $this->work->select_data("subject", ["id"=>$subject_id]);
                    echo $data[0]->subject_name;
                ?>
            </td>
            <td class="text-center">
                <?php
                    $data = $this->work->select_data("classes", ["id"=>$class_id]);
                    echo $data[0]->class_name;
                ?>
            </td>
            <td class="text-center">
                <?php
                    echo date("h:m A", strtotime($batch_start_time))."-".date("h:m A", strtotime($batch_end_time))
                ?>
            </td>

            <td class="text-center">
                <?php 
                    $sum_payment = $this->work->select_sum("payment", ["reg_id"=>$value->id], "amount");
                    $paid_amount = $sum_payment[0]->amount;

                    $batch_fee_after_disc = $fee_amount - ($student_discount_amount+$batch_discount_amount);

                    if($paid_amount >= $batch_fee_after_disc){
                        echo "<span class='badge badge-info'> Full Paid</span>";
                    }else{
                        echo "<span class='badge badge-success'>".$paid_amount."</span>";
                    }

                ?>
            </td>

            <td>
                <?php
                    //Find Due amount   
                    $due_amount = $fee_amount - ($student_discount_amount+$paid_amount+$batch_discount_amount);
                    if($due_amount <= 0){
                        echo "<span class='badge badge-info'> No Dues</span>";
                    }else{
                        echo "<span class='badge badge-danger'>".$due_amount."</span>";
                    }

                ?>
            </td>

            <td class="text-center">
                <button class="btn btn-info px-2 py-1" onclick="makePayment('<?= $reg_id?>')"> <i class="fa fa-rupee-sign"></i> </button>

                <button class="btn btn-success px-2 py-1" onclick="viewId('<?= $reg_id?>')"> <i class="fa fa-eye"></i> </button>

                <button class="btn btn-danger px-2 py-1" onclick="deleteData('<?= $reg_id?>','all')"> <i class="fa fa-trash"></i> </button>

                <button class="btn btn-warning px-2 py-1" onclick="sendSms('<?= $reg_id?>')"> <i class="fa fa-envelope"></i> </button>


            </td>
        
        <?
    } 

}
?>