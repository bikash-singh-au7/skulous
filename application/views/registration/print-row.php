<?php
date_default_timezone_set("Asia/Kolkata");
//It print the data for "manage session" page when add the new session
if($action == "manage-add"){
    foreach($result as $value){
        ?>
            <tr id="row-<?=$value->id?>">
                <td><?=$value->id?></td>
                <td><?=$value->batch_name?></td>
                <td class="text-center">
                    <?php
                        if($value->batch_status == 1){
                            $status = 1;
                            echo"<span class='badge badge-info'>Active</span>";
                        }else{
                            $status = 0;
                            echo"<span class='badge badge-danger'>Disable</span>";
                        }
                    ?>
                </td>
                <td class="text-center">
                    <?php
                        $data = $this->work->select_data("classes", ["id"=>$value->class_id]);
                        echo $data[0]->class_name;
                    ?>
                </td>
                <td class="text-center">
                    <?php
                        $data = $this->work->select_data("subject", ["id"=>$value->subject_id]);
                        echo $data[0]->subject_name;
                    ?>
                </td>
                <td class="text-center"><?=$value->batch_medium?></td>

                <td class="text-center"><?= date("h:m A", strtotime($value->batch_start_time))."-".date("h:m A", strtotime($value->batch_end_time)) ?></td>

                <td class="text-center"><button class="btn btn-info px-2 py-1" onclick="getId('<?= $value->id?>')"> <i class="fa fa-edit"></i> </button></td>

                <td class="text-center"><button class="btn btn-success px-2 py-1" onclick="viewId('<?= $value->id?>')"> <i class="fa fa-eye"></i> </button></td>

                <td class="text-center"><button class="btn btn-danger px-2 py-1" onclick="deleteData('<?= $value->id?>')"> <i class="fa fa-trash"></i> </button></td>
    
            </tr>
        <?
    }
}


//Update
if($action == "update"){
    foreach($result as $value){
        ?>         
            <td><?=$value->id?></td>
            <td><?=$value->student_name?></td>
            <td class="text-center">
                <?= $value->father_name; ?>
            </td>
            <td class="text-center">
                <?php
                    $data = $this->work->select_data("batch", ["id"=>$value->batch_id]);
                    echo $data[0]->batch_name;
                ?>
            </td>
            <td class="text-center"> <?= $value->student_mobile?> </td>
            <td class="text-center">
                <?php

                    if($value->reg_status == 1){
                        $status = 1;
                        echo"<span class='badge badge-info'>Active</span>";
                    }else{
                        $status = 0;
                        echo"<span class='badge badge-danger'>Disable</span>";
                    }

                ?>
            </td>

            <td class="text-center"><?= date("h:m A", strtotime($value->created_date)) ?></td>



            <td class="text-center">
                <button class="btn btn-info px-2 py-1" onclick="getId('<?= $value->id?>')"> <i class="fa fa-edit"></i> </button>

                <button class="btn btn-success px-2 py-1" onclick="viewId('<?= $value->id?>')"> <i class="fa fa-eye"></i> </button>

                <button class="btn btn-danger px-2 py-1" onclick="deleteData('<?= $value->id?>')"> <i class="fa fa-trash"></i> </button>

                <button class="btn btn-warning px-2 py-1" onclick="sendSma('<?= $value->id?>')"> <i class="fa fa-envelope"></i> </button>

                <button class="btn btn-dark px-2 py-1" onclick="makePayment('<?= $value->id?>')"> <i class="fa fa-rupee-sign"></i> </button>


            </td>
            
        <?
    }
}

if($action == "view"){
    foreach($data as $value){
        ?>
            <div class="row px-2">
                <!--Intero-->
                <div class="col-md-12 shadow-sm py-2 mb-1">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="float-left">
                                <img src="https://www.freeiconspng.com/uploads/male-icon-4.jpg" alt="" class="img profile-pic">
                            </div>
                            <div class="float-right">
                                <h5 class="text-info">  <i class="fa fa-user"></i> <?= $value->student_name?></h5>
                                <p class="p-0 m-0"> <i class="fa fa-phone"></i> <?= $value->student_mobile?></p>
                                <p class="p-0 m-0">  <i class="fa fa-envelope"></i> <?= $value->student_email?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            
                        </div>
                    </div>
                </div>
                <!--Personal Details--->
                <div class="col-md-12 shadow-sm py-2 mb-1">
                    <h5 class="text-info"> <i class="fa fa-user"></i> Personal Details</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4 float-left">
                                    <h6 class='font-weight-bold text-muted'>Father</h6>
                                    <h6 class='font-weight-bold text-muted'>Mother</h6>
                                    <h6 class='font-weight-bold text-muted'>Parent Mob</h6>
                                    <h6 class='font-weight-bold text-muted'>Parent Email</h6>
                                </div>
                                <div class="col-md-8 float-right">
                                    <h6 class="text-muted"><?= $value->father_name?></h6>
                                    <h6 class="text-muted"><?= $value->mother_name?></h6>
                                    <h6 class="text-muted"><?= $value->parent_mobile?></h6>
                                    <h6 class="text-muted"><?= $value->parent_email?></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4 float-left">
                                    <h6 class='font-weight-bold text-muted'>Address</h6>
                                    <h6 class='font-weight-bold text-muted'>State</h6>
                                    <h6 class='font-weight-bold text-muted'>Dist</h6>
                                    <h6 class='font-weight-bold text-muted'>Pin Code</h6>
                                </div>
                                <div class="col-md-8 float-right">
                                    <h6 class="text-muted"><?= $value->address?></h6>
                                    <h6 class="text-muted"><?= $value->state?></h6>
                                    <h6 class="text-muted"><?= $value->dist?></h6>
                                    <h6 class="text-muted"><?= $value->pin_code?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Batch Details--->
                <div class="col-md-12 shadow-sm py-2 mb-1">
                    <h5 class="text-info"> <i class="fa fa-book" bg-white></i> Batch Details</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4 float-left">
                                    <h6 class='font-weight-bold text-muted'>Batch Name</h6>
                                    <h6 class='font-weight-bold text-muted'>Class</h6>
                                    <h6 class='font-weight-bold text-muted'>Timing</h6>
                                </div>
                                <div class="col-md-8 float-right">
                                    <h6 class="text-muted">
                                        <?php
                                            $batch_info = $this->work->select_data("batch", ["id"=>$value->batch_id]);
                                            echo $batch_info[0]->batch_name;
                                            $class_id = $batch_info[0]->class_id;
                                            $subject_id = $batch_info[0]->subject_id;
                                            $batch_medium = $batch_info[0]->batch_medium;
                                            $batch_start_time = $batch_info[0]->batch_start_time;
                                            $batch_end_time = $batch_info[0]->batch_end_time;
                                        ?>
                                    </h6>
                                    <h6 class="text-muted">
                                        <?php
                                            $class_info = $this->work->select_data("classes", ["id"=>$class_id]);
                                            echo $class_info[0]->class_name;
                                        ?>
                                    </h6>
                                    <h6 class="text-muted">
                                        <?php
                                            echo date("h:m A", strtotime($batch_start_time))."-".date("h:m A", strtotime($batch_end_time));
                                        ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4 float-left">
                                    <h6 class='font-weight-bold text-muted'>Subject</h6>
                                    <h6 class='font-weight-bold text-muted'>Medium</h6>
                                    
                                </div>
                                <div class="col-md-8 float-right">
                                    <h6 class="text-muted">
                                        <?php
                                            $subject_info = $this->work->select_data("subject", ["id"=>$subject_id]);
                                            echo $subject_info[0]->subject_name;
                                        ?>
                                    </h6>
                                    <h6 class="text-muted"><?= $batch_medium?></h6>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 
                <!--Login Details--->
                <div class="col-md-12 shadow-sm py-2 mb-1">
                    <h5 class="text-info"> <i class="fa fa-lock" bg-white></i> Login Details</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4 float-left">
                                    <h6 class='font-weight-bold text-muted'>User Name</h6>
                                </div>
                                <div class="col-md-8 float-right">
                                    <h6 class="text-muted"> <?= $value->student_email?> </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4 float-left">
                                    <h6 class='font-weight-bold text-muted'>Password</h6>
                                </div>
                                <div class="col-md-8 float-right">
                                    <h6 class="text-muted"><?= $value->password?> </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!--Payment Details--->
                <div class="col-md-12 shadow-sm py-2 mb-1">
                    <h5 class="text-info"> <i class="fa fa-rupee-sign" bg-white></i> Payment Details</h5>
                    <?php
                        $payment_info = $this->work->select_data("payment", ["reg_id"=>$value->id]);
                        if(empty($payment_info)){
                            ?>
                            <div class="alert alert-danger rounded-0">There is No Payment !!</div>
                            <?
                        }else{
                            ?>
                                <div class="row">
                                    <div class="col-md-3"><h6 class='font-weight-bold text-muted'>#Payment Id</h6></div>
                                    <div class="col-md-3"><h6 class='font-weight-bold text-muted'>Mode</h6></div>
                                    <div class="col-md-3"><h6 class='font-weight-bold text-muted'>Payment Date</h6></div>
                                    <div class="col-md-3"><h6 class='font-weight-bold text-muted'>Amount</h6></div>
                                </div>
                                <?
                                $total_payment = 0;
                                foreach($payment_info as $info){
                                    $total_payment += $info->amount;
                                    ?>
                                    <div class="row">
                                        <div class="col-md-3"><h6 class='text-muted'>
                                            <?= $info->id?>
                                        </h6></div>
                                        <div class="col-md-3"><h6 class='text-muted'>
                                            Manual
                                        </h6></div>
                                        <div class="col-md-3"><h6 class='text-muted'>
                                            <?= $info->payment_date?>
                                        </h6></div>
                                        <div class="col-md-3"><h6 class='text-muted'>
                                            <?= $info->amount?>
                                        </h6></div>
                                        
                                    </div>
                                    <?
                                }
                                ?>
                                    <div class="row mt-2">
                                        <div class="col-md-6"></div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6 border-top">Total</div>
                                                <div class="col-md-6 border-top"><?= $total_payment?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 border-top">Total Payble Amount</div>
                                                <div class="col-md-6 border-top"><?= $value->fee_amount?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 border-top">Discount Amount</div>
                                                <div class="col-md-6 border-top"><?= $value->discount?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 border-top">Dues Amount</div>
                                                <div class="col-md-6 border-top">
                                                <?php 
                                                    echo $value->fee_amount."-".$total_payment."+".$value->discount."=";
                                                    echo $value->fee_amount-$total_payment+$value->discount;
                                                ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?
                                
                        }
                    ?>
                    
                </div>
                  
            </div>
        <?
    }
}
?>