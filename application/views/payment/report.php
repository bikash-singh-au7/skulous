<?php
    date_default_timezone_set("Asia/Kolkata");
    $today = date("Y-m-d");
    if(set_value("date") != ""){
        $date = date('Y-m-d', strtotime(set_value('date')));
    }else{
        $date = "";
    }

?>
<div class="container-fluid">
    <div class="row p-0">
        <div class="col-md-11 m-auto">
            <div class="page-header">
               <div class="inner-content">
                   <!-- Class Details --> 
                   <div class="row">
                        <div class="col-md-12 p-0 m-0" id="alert">
                            
                        </div>
                        
                        <div class="col-md-12 p-0 m-0 border">
                            <div class="float-left mt-2 pl-2">
                                Report
                            </div>
                            <div class="px-2 mt-1">
                                <form method="post" action="<?= base_url("paymentsetup/payment/report/generate")?>" id="reportForm">
                                    <div class="form-row float-right">
                                        <div class="col-3">
                                            <select name="batch_id" id="" class="form-control">
                                                <option value="">--Batch--</option>
                                                <?php
                                                    foreach($batch as $v){
                                                        ?>    
                                                        <option <?= set_select('batch_id', $v->id)?> value="<?= $v->id?>"> <?= $v->batch_name."(".date("h:m A", strtotime($v->batch_start_time))."-".date("h:m A", strtotime($v->batch_end_time)).")" ?> </option>
                                                        <?
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        
                                        <div class="col-3">
                                            <select name="amount" id="" class="form-control">
                                                <option value="">--Amount--</option>
                                                <option value="fullpaid" <?= set_select('amount', "fullpaid")?> >Full Paid</option>
                                                <option value="unpaid" <?= set_select('amount', "unpaid")?> >Unpaid</option>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <input type="date" class="form-control" name="date" value="<?= $date?>">
                                            
                                        </div>
                                        <div class="col-2">
                                            <button class="btn btn-info rounded-0 py-1" type="submit" id="reportbmt">Report</button>
                                        </div>
                                        
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!--Data Table-->
                    <div class="">
                       <div class="row border">
                        <div class="col-md-12 m-auto p-2 table-responsive">
                            <table id="dataTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#Id</th>
                                        <th>Name</th>
                                        <th>Father</th>
                                        <th>Subject</th>
                                        <th>Class</th>
                                        <th>Batch</th>
                                        <th>Paid</th>
                                        <th>Due</th>
                                        
                                        <th class="text-center" style="width: 120px">Action</th>
                                    </tr> 
                                </thead>
                                <?php 
                                if($action == "unpaid"){
                                    ?>
                                    <tbody>
                                    <?php
                                        foreach($data as $value){
                                            
                                            $student_name = $value->student_name;
                                            // Full Paid
                                            $full_paid = $value->full_paid;
                                            //Father name
                                            $father_name = $value->father_name;
                                            //Registration Id
                                            $reg_id = $value->id; 
                                            //Discount amount from Registration Table
                                            $reg_discount = $value->discount;
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
                                            $batch_fee = $batch_data[0]->batch_fee;
                                            //Batch Discount amount from Batch Table
                                            $batch_discount = $batch_data[0]->discount;
                                            
                                            
                                        ?>
                                            <tr id="row-<?=$reg_id?>">
                                                <td><?=$reg_id?></td>
                                                <td><?php echo $student_name = $student_name;?></td>
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
                                                        if(empty($sum_payment[0])){
                                                            echo 0;
                                                        }else{
                                                            $total_paid_amount = $sum_payment[0]->amount;
                                                            if($full_paid){
                                                                echo "<span class='badge badge-info'> Full Paid</span>";
                                                            }else{
                                                                echo "<span class='badge badge-success'>".$total_paid_amount."</span>";
                                                            }
                                                        }
                                                        
                                                    
                                                    ?>
                                                </td>
                                                
                                                <td>
                                                    <?php
                                                        //Find Due amount   
                                                        $dues_amount = $batch_fee - ($reg_discount+$batch_discount+$total_paid_amount);
                                                        if($full_paid){
                                                            echo "<span class='badge badge-danger'> No Dues</span>";
                                                        }else{
                                                            echo "<span class='badge badge-danger'>".$dues_amount."</span>";
                                                        }
                                                        
                                                    ?>
                                                </td>
                                                
                                                <td class="text-center">
                                                    <button class="btn btn-info px-2 py-1" onclick="makePayment('<?= $reg_id?>')"> <i class="fa fa-rupee-sign"></i> </button>
                                                    
                                                    <button class="btn btn-success px-2 py-1" onclick="viewId('<?= $reg_id?>')"> <i class="fa fa-eye"></i> </button>
                                                    
                                                    <button class="btn btn-danger px-2 py-1" onclick="deleteData('<?= $reg_id?>','all')"> <i class="fa fa-trash"></i> </button>
                                                    
                                                    <button class="btn btn-warning px-2 py-1" onclick="sendSms('<?= $reg_id?>')"> <i class="fa fa-envelope"></i> </button>
                                                    
                                                
                                                </td>
                                            </tr>
                                            <?
                                        } 
                                    ?>
                                </tbody>
                                    <?
                                    
                                }
                                elseif($action == "date"){
                                    
                                ?>
                                <tbody>
                                    <?php
                                        foreach($data as $value){
                                            //get Regitration data
                                            $reg_data = $this->work->select_data("registration", ["id"=>$value->reg_id]);
                                            $student_name = $reg_data[0]->student_name;
                                            // Full Paid
                                            $full_paid = $reg_data[0]->full_paid;
                                            //Father name
                                            $father_name = $reg_data[0]->father_name;
                                            //Registration Id
                                            $reg_id = $reg_data[0]->id; 
                                            //Discount amount from Registration Table
                                            $reg_discount = $reg_data[0]->discount;
                                            //Batch id
                                            $batch_id = $reg_data[0]->batch_id; 
                                            
                                            //Batch information
                                            $batch_data = $this->work->select_data("batch", ["id"=>$batch_id]);
                                            $batch_name = $batch_data[0]->batch_name;
                                            $batch_start_time = $batch_data[0]->batch_start_time;
                                            $batch_end_time = $batch_data[0]->batch_end_time;
                                            $class_id = $batch_data[0]->class_id;
                                            $subject_id = $batch_data[0]->subject_id;
                                            //Batch Fee amount from Batch Table
                                            $batch_fee = $batch_data[0]->batch_fee;
                                            //Batch Discount amount from Batch Table
                                            $batch_discount = $batch_data[0]->discount;
                                            
                                            
                                        ?>
                                            <tr id="row-<?=$reg_id?>">
                                                <td><?=$reg_id?></td>
                                                <td><?php echo $student_name = $reg_data[0]->student_name;?></td>
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
                                                        $sum_payment = $this->work->select_sum("payment", ["reg_id"=>$value->reg_id], "amount");
                                                        $total_paid_amount = $sum_payment[0]->amount;
                                                        
                                                        $payment_of_day = $value->amount;
                                                        
                                                        
                                                        echo "<span class='badge badge-success'>".$payment_of_day."</span>";
                                                        
                                                    
                                                    ?>
                                                </td>
                                                
                                                <td>
                                                    <?php
                                                        //Find Due amount   
                                                        $dues_amount = $batch_fee - ($reg_discount+$batch_discount+$total_paid_amount);
                                                        if($full_paid){
                                                            echo "<span class='badge badge-danger'> No Dues</span>";
                                                        }else{
                                                            echo "<span class='badge badge-danger'>".$dues_amount."</span>";
                                                        }
                                                        
                                                    ?>
                                                </td>
                                                
                                                <td class="text-center">
                                                    <button class="btn btn-info px-2 py-1" onclick="makePayment('<?= $reg_id?>')"> <i class="fa fa-rupee-sign"></i> </button>
                                                    
                                                    <button class="btn btn-success px-2 py-1" onclick="viewId('<?= $reg_id?>')"> <i class="fa fa-eye"></i> </button>
                                                    
                                                    <button class="btn btn-danger px-2 py-1" onclick="deleteData('<?= $reg_id?>','all')"> <i class="fa fa-trash"></i> </button>
                                                    
                                                    <button class="btn btn-warning px-2 py-1" onclick="sendSms('<?= $reg_id?>')"> <i class="fa fa-envelope"></i> </button>
                                                    
                                                
                                                </td>
                                            </tr>
                                            <?
                                        } 
                                    ?>
                                </tbody>
                                <?
                                }
                                else{
                                    
                                ?>
                                <tbody>
                                    <?php
                                        foreach($data as $value){
                                            //get Regitration data
                                            $reg_data = $this->work->select_data("registration", ["id"=>$value->reg_id]);
                                            $student_name = $reg_data[0]->student_name;
                                            // Full Paid
                                            $full_paid = $reg_data[0]->full_paid;
                                            //Father name
                                            $father_name = $reg_data[0]->father_name;
                                            //Registration Id
                                            $reg_id = $reg_data[0]->id; 
                                            //Discount amount from Registration Table
                                            $reg_discount = $reg_data[0]->discount;
                                            //Batch id
                                            $batch_id = $reg_data[0]->batch_id; 
                                            
                                            //Batch information
                                            $batch_data = $this->work->select_data("batch", ["id"=>$batch_id]);
                                            $batch_name = $batch_data[0]->batch_name;
                                            $batch_start_time = $batch_data[0]->batch_start_time;
                                            $batch_end_time = $batch_data[0]->batch_end_time;
                                            $class_id = $batch_data[0]->class_id;
                                            $subject_id = $batch_data[0]->subject_id;
                                            //Batch Fee amount from Batch Table
                                            $batch_fee = $batch_data[0]->batch_fee;
                                            //Batch Discount amount from Batch Table
                                            $batch_discount = $batch_data[0]->discount;
                                            
                                            
                                        ?>
                                            <tr id="row-<?=$reg_id?>">
                                                <td><?=$reg_id?></td>
                                                <td><?php echo $student_name = $reg_data[0]->student_name;?></td>
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
                                                        $sum_payment = $this->work->select_sum("payment", ["reg_id"=>$value->reg_id], "amount");
                                                        $total_paid_amount = $sum_payment[0]->amount;
                                                        
                                                        
                                                        if($full_paid){
                                                            echo "<span class='badge badge-info'> Full Paid</span>";
                                                        }else{
                                                            echo "<span class='badge badge-success'>".$total_paid_amount."</span>";
                                                        }
                                                    
                                                    ?>
                                                </td>
                                                
                                                <td>
                                                    <?php
                                                        //Find Due amount   
                                                        $dues_amount = $batch_fee - ($reg_discount+$batch_discount+$total_paid_amount);
                                                        if($full_paid){
                                                            echo "<span class='badge badge-danger'> No Dues</span>";
                                                        }else{
                                                            echo "<span class='badge badge-danger'>".$dues_amount."</span>";
                                                        }
                                                        
                                                    ?>
                                                </td>
                                                
                                                <td class="text-center">
                                                    <button class="btn btn-info px-2 py-1" onclick="makePayment('<?= $reg_id?>')"> <i class="fa fa-rupee-sign"></i> </button>
                                                    
                                                    <button class="btn btn-success px-2 py-1" onclick="viewId('<?= $reg_id?>')"> <i class="fa fa-eye"></i> </button>
                                                    
                                                    <button class="btn btn-danger px-2 py-1" onclick="deleteData('<?= $reg_id?>','all')"> <i class="fa fa-trash"></i> </button>
                                                    
                                                    <button class="btn btn-warning px-2 py-1" onclick="sendSms('<?= $reg_id?>')"> <i class="fa fa-envelope"></i> </button>
                                                    
                                                
                                                </td>
                                            </tr>
                                            <?
                                        } 
                                    ?>
                                </tbody>
                                <?
                                }
                                ?>
                            </table> 
                                
                        </div> 
                        </div>   
                    </div>  
               </div>     
        </div>
        
       
        <!--Delete Data Modal---->
        <div class="modal fade" id="deleteModal" style="z-index:9999" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="deleteModallabel">Delete Batch</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img class="img img-responsive" height=100 src="<?= base_url('assets/images/danger.png')?>" alt="">
                    <h5 class="text-muted">Do you want to delete?</h5>
                    <span class="badge badge-danger" id="deleteAlert"></span>
                </div>
                <div class="m-auto pb-2">
                    <form action="" method="post" id="deleteForm">
                        <input type="hidden" value="" name="payment_id" id="delete_payment_id">
                        <input type="hidden" value="" name="number" id="number">
                        <button type="submit" class="btn btn-danger" name="delSbmt">Delete</button>
                        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    </form>
                                                            
                </div>
                </div>
            </div>
        </div>

        <!--Update Modal Form-->
        <div class="modal fade" style="z-index:9999" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="updateModallabel">Update Batch Information</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-5">
                    <form method="post" action="" class="" id="updateForm" class="bg-white">
                       <div class="bg-white mt-2">
                           <div class="row p-0 bg-white">
                                <div class="col-md-12 border p-0">
                                    <p class="p-1 text-info bg-light" style=""> <strong> <i class="fa fa-user"></i> Personal Details</strong></p>
                                    <div class="row px-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Student Name <span class="text-danger">*</span></label>
                                                <input type="text" name="student_name" class="form-control pl-2" value="" placeholder="Student Name" id="update_student_name">
                                                <input type="hidden" name="inquiry_id" class="form-control pl-2" id="update_inquiry_id">
                                                <span class="text-danger" id="e_update_student_name"></span>
                                            </div> 
                                        </div> 
                                      
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Student Mobile <span class="text-danger">*</span></label>     
                                                <input type="tel" name="student_mobile" value="" class="form-control" placeholder="8757885800" id="update_student_mobile">
                                                <span class="text-danger" id="e_update_student_mobile"></span>
                                            </div>
                                        </div> 
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Student Email </label>     
                                                <input type="email" name="student_email" value="" class="form-control" placeholder="rahul@abc.com" id="update_student_email">
                                                <span class="text-danger" id="e_update_student_email"></span>
                                            </div>
                                        </div> 
                            
                            
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Address </label>     
                                                <input type="text" name="address" value="" id="update_address" class="form-control" placeholder="Enter Address">
                                                <span class="text-danger" id="e_update_address"></span>
                                            </div>
                                        </div>  
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">State <span class="text-danger">*</span></label>  
                                                <select name="state" class="form-control" id="update_state">
                                                    <option value="">--Select--</option>
                                                    <option value="Bihar">Bihar</option>
                                                    <option value="Jharkhand">Jharkhand</option>
                                                    <option value="UP">UP</option>
                                                </select>
                                                <span class="text-danger" id="e_update_state"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Dist <span class="text-danger">*</span></label>
                                                <select name="dist" class="form-control" id="update_dist">
                                                    <option value="">-Select-</option>
                                                </select>
                                                <span class="text-danger" id="e_update_dist"></span>
                                            </div>
                                        </div>
                                        
                                       
                                       
                                    </div> 
                                </div>   
                           </div>   
                            
                       </div>



                       <div class="bg-white mt-2">
                           <div class="row p-0 bg-white">
                                <div class="col-md-12 border p-0">
                                    <p class="p-1 text-info bg-light" style=""> <strong> <i class="fa fa-bars"></i> Other Details</strong></p>
                                    <div class="row px-2">
                                        
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="font-weight-bold">Select Class<span class="text-danger">*</span></label>
                                            <select id="update_class_id" class="form-control" name="class_id">
                                                <option value="">--Select--</option>
                                                <?php
                                                    foreach($class as $value){
                                                        ?>
                                                        <option value="<?= $value->id?>"> <?= $value->class_name?> </option>
                                                        <?
                                                    }

                                                ?>
                                            </select>
                                            <span class="text-danger" id="e_update_class_id"></span>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="font-weight-bold">Select Subject<span class="text-danger">*</span></label>
                                            <select id="update_subject_id" class="form-control" name="subject_id">
                                                <option value="">--Select--</option>
                                                <?php
                                                    foreach($subject as $value){
                                                        ?>
                                                        <option value="<?= $value->id?>"> <?= $value->subject_name?> </option>
                                                        <?
                                                    }

                                                ?>
                                            </select>
                                            <span class="text-danger" id="e_update_subject_id"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="font-weight-bold">Select Medium<span class="text-danger">*</span></label>
                                            <select id="update_medium" class="form-control" name="medium">
                                                <option value="">--Select--</option>
                                                <option value="HINDI">HINDI</option>
                                                <option value="ENGLISH">ENGLISH</option>
                                                
                                            </select>
                                            <span class="text-danger" id="e_update_medium"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="font-weight-bold">Inquiry Purpose</label>
                                            <input type="text" id="update_inquiry_purpose" name="inquiry_purpose" placeholder="Purpose" class="form-control pl-2"> 
                                            <span class="text-danger" id="e_update_inquiry_purpose"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Remarks </label>
                                            <input type="text" name="comment" placeholder="Remarks" class="form-control pl-2" id="update_comment"> 
                                            <span class="text-danger" id="e_update_comment"></span>
                                        </div> 
                                    </div> 
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Refreances </label>
                                            <input type="text" id="update_refrence" name="refrence" placeholder="Refrence" class="form-control pl-2"> 
                                            <span class="text-danger" id="e_update_refrence"></span>
                                        </div> 
                                    </div> 
                                    
                                </div>   
                           </div>   
                            
                        </div> 
                       </div>
                       
                       
                       
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info" name="updtSbmt" form="updateForm">Update</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>

        <!--Make Payment--->
        <div class="modal fade" id="makePaymentModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="updateModallabel"> <i class="fa fa-rupee-sign"></i> Make Payment</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" id="paymentForm">
                            <div class="form-group">
                                <label for="" class="text-muted">Payment Amount </label>
                                <input type="hidden" class="form-control" id="reg_id" name='reg_id'>
                                <input type="number" class="form-control" maxlength="6" name="amount" id="amount">
                                <span class="text-danger" id="e_amount"></span>
                            </div>
                            <div class="form-group">
                                <label for="" class="text-muted">Payment Date <span class="text-danger">*</span> </label>
                                <input type="date" class="form-control" value="<?= $today?>" id="payment_date" name='payment_date'>
                                <span class="text-danger" id="e_payment_date"></span>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info" form="paymentForm">Send</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div> 
        
        <!--View Data Modal--->
        <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="updateModallabel"> <i class="fa fa-rupee-sign"></i> Payment Information</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body px-4">
                        <div class="text-center" id="loader" style="display:none">
                            <img src="<?= base_url('assets/images/loader/ajax-loader.gif')?>" alt="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    
        <!--Send SMS Modal--->
        <div class="modal fade" id="smsModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="updateModallabel"> <i class="fa fa-eye"></i> Send SMS</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" id="smsForm">
                            <div class="form-group">
                                <label for="" class="text-muted">Sender Id </label>
                                <input type="text" class="form-control" maxlength="6" name="sender" id="sender">
                                <span class="text-danger" id="e_sender"></span>
                            </div>
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="sms_reg_id" name='reg_id'>
                                <label for="" class="text-muted">Write Message <span class="text-danger">*</span> </label>
                                <textarea name="message" id="message" cols="30" rows="5" class="form-control"></textarea>
                                <span class="text-danger" id="e_message"></span>
                            </div>
                        </form>
                        <div class="">
                            <span class="text-info">@name: for Name</span> | 
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info" form="smsForm">Send</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!---Ajax here-->

<script>
    //For send sms
    function sendSms(id){
        $("#sms_reg_id").val(id);
        $("#sender").val("");
        $("#message").val("");
        $("#e_message").html("");
        
        $("#smsModal").modal("show");
    }
    $("body").on("submit", "#smsForm", function(e){
        e.preventDefault();
        $.ajax({
            url: "<?= base_url('paymentsetup/sendsms')?>",
            data: $(this).serialize(),
            type: "POST",
            dataType: "json",
            success: function(response){
                if(response["status"] == 0){
                    $("#e_message").html(response["message"]);
                    $("#e_sender").html(response["sender"]);
                }else{
                    $("#e_message").html("");
                    $("#e_sender").html("");
                    //hide modal
                    $("#smsModal").modal("hide");
                    Swal.fire(
                      response["alert"],
                      response["message"],
                      response["modal"]
                    )
                }
            }
        });
    });
    

    //view modal
    function viewId(id){
        $("#viewModal").modal("show"); 
        $.ajax({
            url: "<?= base_url('paymentsetup/viewInfo')?>", //https://jsonplaceholder.typicode.com/users
            type: "POST",
            data: {reg_id:id},
            dataType: "json",
            beforeSend: function(){
                $("#loader").show();
            },
            complete: function(){
                $("#loader").hide();
            },
            success: function(response){
                $("#viewModal .modal-body").html(response["html"]);
            }
            
        });
    }
    
    //All delete
    function deleteData(id, number){
        $("#deleteModal").modal("show");
        $("#delete_payment_id").val(id);
        $("#number").val(number);
        if(number == "all"){
            $("#deleteAlert").html("In this Case all payment will deleted of this student!!")
        }else{
            $("#deleteAlert").html("")
        }
        
    }
    $(document).ready(function(){
        $("body").on("submit", "#deleteForm", function(e){
            e.preventDefault();
            if($("#number").val() == "one"){
                var base_url = '<?= base_url("paymentsetup/deleteSinglePayment")?>';
            }else{
                var base_url = '<?= base_url("paymentsetup/deleteAllPayment")?>';
            }
            
            $.ajax({
                url: base_url,
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){
                    if(response["number"] == "all"){
                        $("#"+response["rowId"]).remove();
                        alert(response["rowId"]);
                    }else{
                        $("#"+response["rowId"]).html(response["html"]);
                        $("#"+response["delRowId"]).remove();
                    }
                    
                    $("#deleteModal").modal("hide");
                    Swal.fire(
                      response["alert"],
                      response["message"],
                      response["modal"]
                    )
                }
            });
        })
    });

    //Get id for updating the data
    function getId(id){
        $("#updateModal").modal("show");
        $("#e_update_student_name").html("");
        $("#e_update_student-mobile").html("");
        $("#e_update_student_email").html("");
        
        $("#e_update_address").html("");
        $("#e_update_state").html("");
        $("#e_update_dist").html("");
        
        $("#e_update_class_id").html("");
        $("#e_update_subject_id").html("");
        $("#e_update_medium").html("");
        $("#e_update_enquiry_purpose").html("");
        $("#e_update_comment").html("");
        $("#e_update_refrence").html("");
        $.ajax({
                url: '<?= base_url("inquirysetup/getData")?>',
                type: 'POST',
                data: {inquiry_id:id},
                dataType: 'json',
                success: function(response){
                    //remove selected attribute from select box
                    $("#update_state option").removeAttr("selected")
                    $("#update_dist option").removeAttr("selected")
                    $("#update_class_id option").removeAttr("selected")
                    $("#update_subject_id option").removeAttr("selected")
                    $("#update_medium option").removeAttr("selected")
                    
                    
                    $("#update_inquiry_id").val(response["inquiry_id"]);
                    $("#update_student_name").val(response["student_name"]);
                    $("#update_student_mobile").val(response["student_mobile"]);
                    $("#update_student_email").val(response["student_email"]);
                    $("#update_address").val(response["address"]);
                    
                    $("#update_state option[value="+response["state"]+"]").attr('selected', 'selected');
                    //For district
                    
                    for(i=0; i<arr[response["state"]].length; i++){
                        select+="<option value="+arr[response["state"]][i]+">"+arr[response["state"]][i]+"</option>";
                    }
                    $("#update_dist").html(select);
                    
                    $("#update_dist option[value="+response["dist"]+"]").attr('selected', 'selected');
                   
                    $("#update_class_id option[value="+response["class_id"]+"]").attr('selected', 'selected');
                    $("#update_subject_id option[value="+response["subject_id"]+"]").attr('selected', 'selected');
                    $("#update_medium option[value="+response["medium"]+"]").attr('selected', 'selected');
                    $("#update_inquiry_purpose").val(response["inquiry_purpose"]);
                    $("#update_comment").val(response["comment"]);
                    $("#update_refrence").val(response["refrence"]);
                    
                }
        });
    }

    //Make Payment
    function makePayment(x){
        $("#reg_id").val(x);
        $("#amount").val("");
        $("#e_amount").html("");
        $("#e_payment_date").html("");
        $("#makePaymentModal").modal("show");
    }
    
    $(function(){
        $("#paymentForm").on("submit", function(e){
            e.preventDefault();
            $.ajax({
                url: "<?= base_url('paymentSetup/makePayment/manage')?>",
                type: "POST",
                data : $(this).serialize(),
                dataType: "json",
                success: function(response){
                    if(response["status"]==0){
                        $("#e_amount").html(response["amount"]);
                        $("#e_payment_date").html(response["payment_date"]);
                    }else{
                        $("#makePaymentModal").modal("hide");
                        Swal.fire(
                          response["alert"],
                          response["message"],
                          response["modal"]
                        )
                        
                        //Update payment row
                        $("#"+response["rowId"]).html(response["html"]);
                    }
                }
            });
        })
    });
    
    //Update Data
    $(document).ready(function(){
        $("body").on("submit", "#updateForm", function(e){
            e.preventDefault();
            $.ajax({
                url: '<?= base_url("inquirysetup/updateData")?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){
                    if(response["status"] == 0){
                        //set error message 
                        $("#e_update_student_name").html(response["student_name"]);
                        $("#e_update_student_mobile").html(response["student_mobile"]);
                        $("#e_update_student_email").html(response["student_email"]);
                        $("#e_update_address").html(response["address"]);
                        $("#e_update_state").html(response["state"]);
                        $("#e_update_dist").html(response["dist"]);
                        $("#e_update_class_id").html(response["class_id"]);
                        $("#e_update_subject_id").html(response["subject_id"]);
                        $("#e_update_medium").html(response["medium"]);
                        $("#e_update_inquiry_purpose").html(response["inquiry_purpose"]);
                        $("#e_update_comment").html(response["comment"]);
                        $("#e_update_refrence").html(response["refrence"]);
                        
                        
                        
                    }else if(response["status"] == 1){
                        //set blank value for error message
                        $("#e_update_student_name").html("");
                        $("#e_update_student_email").html("");
                        $("#e_update_student_mobile").html("");
                        $("#update_state option").removeAttr("selected")
                        $("#update_dist option").removeAttr("selected")
                        $("#update_class_id option").removeAttr("selected")
                        $("#update_subject_id option").removeAttr("selected")
                        $("#update_medium option").removeAttr("selected")
                        
                        $("#update_address").html("");
                        $("#update_inquiry_purpose").html("");
                        $("#update_comment").html("");
                        $("#update_refrence").html("");
                        
                        
                        
                        //hide modal box
                        $("#updateModal").modal("hide");
                        
                        //set message for alert box
                        Swal.fire(
                          response["alert"],
                          response["message"],
                          'success'
                        )
                        
                        $("#"+response["rowId"]).html(response["updatedRow"]);

                    }else{
                        $("#updateModal").modal("hide");
                        $("#e_update_student_name").html("");
                        $("#e_update_student_email").html("");
                        $("#e_update_student_mobile").html("");
                        $("#update_state option").removeAttr("selected")
                        $("#update_dist option").removeAttr("selected")
                        $("#update_class_id option").removeAttr("selected")
                        $("#update_subject_id option").removeAttr("selected")
                        $("#update_medium option").removeAttr("selected")
                        
                        $("#update_address").html("");
                        $("#update_inquiry_purpose").html("");
                        $("#update_comment").html("");
                        $("#update_refrence").html("");
                        //set message for alert box
                        Swal.fire(
                          response["alert"],
                          response["message"],
                          'error'
                        )
                    }
                }
            });
        });
        
        $("#addBtn").click(function(){
            $("#alert").html("");
        });
        $(".updateBtn").click(function(){
            $("#alert").html("");
        });

    });
</script>