<?php
date_default_timezone_set("Asia/Kolkata");
$today = date("d-m-Y");
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
            <td class="text-center"><?= $value->student_mobile; ?></td>

            <td class="text-center">
                <?php
                    $data = $this->work->select_data("subject", ["id"=>$value->subject_id]);
                    echo $data[0]->subject_name;
                ?>
            </td>
            <td class="text-center">
                <?php
                    $data = $this->work->select_data("classes", ["id"=>$value->class_id]);
                    echo $data[0]->class_name;
                ?>
            </td>
            <td class="text-center"> <?= $value->inquiry_purpose?> </td>
            <td class="text-center">
                <?php

                    if($value->inquiry_status == 1){
                        $status = 1;
                        echo"<button onclick=statusChange('".$value->id."','0') class='badge badge-info rounded-0 border-0'>Resolved</button>";
                    }else{
                        $status = 0;
                        echo"<button onclick=statusChange('".$value->id."','1') class='badge badge-danger rounded-0 border-0'>Pending</button>";
                    }

                ?>
            </td>

            <td class="text-center">
                <?php  
                    if(date("d-m-Y", strtotime($value->created_date)) == $today):
                        echo"Today";
                    else:
                        echo date("d-m-Y", strtotime($value->created_date));
                    endif;
                ?>
            </td>



            <td class="text-center">
                <button class="btn btn-info px-2 py-1" onclick="getId('<?= $value->id?>')"> <i class="fa fa-edit"></i> </button>

                <button class="btn btn-success px-2 py-1" onclick="viewId('<?= $value->id?>')"> <i class="fa fa-eye"></i> </button>

                <button class="btn btn-danger px-2 py-1" onclick="deleteData('<?= $value->id?>')"> <i class="fa fa-trash"></i> </button>

                <button class="btn btn-warning px-2 py-1" onclick="sendSms('<?= $value->id?>')"> <i class="fa fa-envelope"></i> </button>


            </td>
            
        <?
    }
}
//view
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
                                    <h6 class='font-weight-bold text-muted'>Address</h6>
                                    <h6 class='font-weight-bold text-muted'>State</h6>
                                </div>
                                <div class="col-md-8 float-right">
                                    <h6 class="text-muted"><?= $value->address?></h6>
                                    <h6 class="text-muted"><?= $value->state?></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4 float-left">
                                    <h6 class='font-weight-bold text-muted'>Dist</h6>
                                    <h6 class='font-weight-bold text-muted'>Status</h6>
                                </div>
                                <div class="col-md-8 float-right">
                                    <h6 class="text-muted"><?= $value->dist?></h6>
                                    <h6 class="text-muted">
                                        <?php
                                            if($value->inquiry_status == 1){
                                                $status = 1;
                                                echo"<span class='badge badge-info'>Resolved</span>";
                                            }else{
                                                $status = 0;
                                                echo"<span class='badge badge-danger'>Pending</span>";
                                            }

                                        ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Batch Details--->
                <div class="col-md-12 shadow-sm py-2 mb-1">
                    <h5 class="text-info"> <i class="fa fa-book" bg-white></i> Inquiry Details</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4 float-left">
                                    <h6 class='font-weight-bold text-muted'>Class</h6>
                                    <h6 class='font-weight-bold text-muted'>Subject</h6>
                                </div>
                                <div class="col-md-8 float-right">
                                    <h6 class="text-muted">
                                        <?php
                                            $batch_info = $this->work->select_data("classes", ["id"=>$value->class_id]);
                                            echo $batch_info[0]->class_name;
                                        ?>
                                    </h6>
                                    <h6 class="text-muted">
                                        <?php
                                            $class_info = $this->work->select_data("subject", ["id"=>$value->subject_id]);
                                            echo $class_info[0]->subject_name;
                                        ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4 float-left">
                                    <h6 class='font-weight-bold text-muted'>Medium</h6>
                                    
                                </div>
                                <div class="col-md-8 float-right">
                                    <h6 class="text-muted"><?= $value->medium?></h6>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                  
            </div>
        <?
    }
}
?>