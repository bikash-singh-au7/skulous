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
            
        <?
    }
}

if($action == "view"){
    foreach($data as $value){
        ?>
            <div class="row px-3">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Batch #Id:</h6>
                            <h6 class="text-muted">Batch Name:</h6>
                            <h6 class="text-muted">Batch Session:</h6>
                            <h6 class="text-muted">Class:</h6>
                            <h6 class="text-muted">Subject:</h6>
                            <h6 class="text-muted">Medium:</h6>
                            <h6 class="text-muted">Status:</h6>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted"><?= $value->id?></h6>
                            <h6 class="text-muted"><?= $value->batch_name?></h6>
                            <h6 class="text-muted">
                                <?php 
                                    $data = $this->work->select_data("session", ["id"=>$value->session_id]);
                                    echo date("M/Y", strtotime($data[0]->start_session))."-".date("M/Y", strtotime($data[0]->end_session));
                                ?>
                            </h6>
                            <h6 class="text-muted">
                                <?php
                                    $data = $this->work->select_data("classes", ["id"=>$value->class_id]);
                                    echo $data[0]->class_name;
                                ?>
                            </h6>
                            <h6 class="text-muted">
                                <?php
                                    $data = $this->work->select_data("subject", ["id"=>$value->subject_id]);
                                    echo $data[0]->subject_name;
                                ?>
                            </h6>
                            <h6 class="text-muted"><?= $value->batch_medium?></h6>
                            <h6 class="text-muted">
                                <?php
                                    if($value->batch_status == 1){
                                        $status = 1;
                                        echo"<span class='badge badge-info'>Active</span>";
                                    }else{
                                        $status = 0;
                                        echo"<span class='badge badge-danger'>Disable</span>";
                                    } 
                                ?>
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Total Seat:</h6>
                            <h6 class="text-muted">Available Seat:</h6>
                            <h6 class="text-muted">Batch Fee:</h6>
                            <h6 class="text-muted">Discount:</h6>
                            <h6 class="text-muted">Batch Start Date:</h6>
                            <h6 class="text-muted">Batch Timing:</h6>
                            <h6 class="text-muted">Date of Creation:</h6>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted"> <span class='badge badge-info'> <?= $value->batch_seat?> </span> </h6>
                            <h6 class="text-muted">
                                <?php 
                                    $available_seat = $value->available_seat;
                                    $total_seat = $value->batch_seat;
                                    $available_precent = ($available_seat*100)/$total_seat;
                                    if($available_precent == 100){
                                        echo "<span class='badge badge-info'> $value->available_seat </span> <i class='text-info small'> $available_precent% Available</i>";
                                    }elseif($available_precent >= 50){
                                        echo "<span class='badge badge-info'> $value->available_seat </span> <i class='text-info small'> $available_precent% Available</i>";
                                    }elseif($available_precent >= 20){
                                        echo "<span class='badge badge-warning'> $value->available_seat </span> <i class='text-warning small'> $available_precent% Available</i>";
                                    }else{
                                        echo "<span class='badge badge-danger'> $value->available_seat </span> <i class='text-danger small'> $available_precent% Available</i> ";
                                    }
                                ?>
                            </h6>
                            <h6 class="text-muted"> <span class="badge badge-info"><?= $value->batch_fee?></span> </h6>
                            <h6 class="text-muted"> <span class="badge badge-warning"><?= $value->discount?></span> </h6>
                            <h6 class="text-muted"><?= date("d-M-Y", strtotime($value->batch_start_date)) ?></h6>
                            <h6 class="text-muted"><?= date("h:m A", strtotime($value->batch_start_time))."-".date("h:m A", strtotime($value->batch_end_time)) ?></h6>
                            <h6 class="text-muted"><?= date("d-M-Y h:m:s A", strtotime($value->created_date)) ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        <?
    }
}
?>