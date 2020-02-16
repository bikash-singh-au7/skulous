<div class="container-fluid">
    <div class="row p-0">
        <div class="col-md-11 m-auto">
            <div class="page-header">
               <div class="inner-content">
                   <!-- Subject Details --> 
                   <div class="row">
                        <div class="col-md-12 p-0 m-0">
                            <?= $this->session->flashdata("success")?>
                        </div>
                        <div class="col-md-12 p-0 m-0 border">
                            <div class="float-left px-2 py-2 border-2">
                                <span class="text-muted font-weight-bold">Manage Batch</span>
                            </div>
                            <div class="float-right px-2">
                                <button class="btn btn-info px-2 my-1" type="button" data-toggle="modal" data-target="#addModal"> <i class="fa fa-plus"></i> Add Batch </button>
                            </div>
                        </div>
                    </div>
                    <div class="">
                       <div class="row border">
                        <div class="col-md-12 m-auto p-0 table-responsive">
                            <?php
                            if(empty($data)){
                                ?>
                                    <div class="alert alert-danger rounded-0">There is no data. Please add first!</div>
                                <?
                            }else {
                                ?>
                                <table class="table table-hover m-0">
                                    <tr class="table-bordered text-muted">
                                        <th>#Id</th>
                                        <th>Batch</th>
                                        <th>Status</th>
                                        <th>Class</th>
                                        <th>Subject</th>
                                        <th>Medium</th>
                                        <th>Start_Date</th>
                                        <th>Timing</th>
                                        <th class="text-center">DOC</th>
                                        <th colspan=3 class="text-center">Action</th>
                                    </tr>    
                                    <?
                                        foreach($data as $value){
                                            ?>
                                                <tr>
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
                                                    <td class="text-center"><?= date("d-M-Y", strtotime($value->batch_start_date)) ?></td>
                                                    <td class="text-center"><?= date("h:m A", strtotime($value->batch_start_time))."-".date("h:m A", strtotime($value->batch_end_time)) ?></td>
                                                    <td class="text-center"><?= date("d-M-Y h:m:s A", strtotime($value->created_date)) ?></td>
                                                    
                                                    <td><button class="btn btn-info px-2 py-1" type="button" data-toggle="modal" data-target="#updateModal<?=$value->id?>"> <i class="fa fa-edit"></i> </button></td>
                                                    <td><button class="btn btn-success px-2 py-1" type="button" data-toggle="modal" data-target="#viewModal<?=$value->id?>"> <i class="fa fa-eye"></i> </button></td>
                                                    <td><button class="btn btn-danger px-2 py-1" type="button" data-toggle="modal" data-target="#deleteModal<?=$value->id?>"> <i class="fa fa-trash"></i> </button></td>
                                                </tr>

                                                <!--Delete Modal---->
                                                <div class="modal fade" id="deleteModal<?=$value->id?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h6 class="modal-title" id="deleteModallabel">Delete Subject</h6>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <img class="img img-responsive" height=100 src="<?= base_url('assets/images/danger.png')?>" alt="">
                                                            <h5 class="text-muted">Do you want to delete?</h5>
                                                        </div>
                                                        <div class="m-auto pb-2">
                                                            <form action="<?= base_url('welcome/batch/manage/delete/')?>" method="post">
                                                                <input type="hidden" value="<?= $value->id?>" name="batch_id">
                                                                <button type="submit" class="btn btn-danger" name="delSbmt">Delete</button>
                                                                <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                                                            </form>
                                                            
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!--Update form--->
                                                <div class="modal fade" id="updateModal<?=$value->id?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h6 class="modal-title" id="updateModallabel">Update Batch Information</h6>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= base_url('welcome/batch/manage/update')?>" method="post" id="updateForm<?=$value->id?>">
                                                                <div class="form-group">
                                                                    <label for="">Batch name <span class="text-danger">*</span></label>
                                                                    <input type="text" name="batch_name" class="form-control" value="<?= $value->batch_name?>" placeholder="Enter Batch Name">
                                                                    <input type="hidden" name="batch_id" class="form-control" value="<?= $value->id?>">
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label for="">Status <span class="text-danger">*</span></label>
                                                                    <select name="batch_status" id="" class="form-control">
                                                                        <option value="1" <?php if($status==1){echo'selected';} ?> >Active</option>
                                                                        <option value="0" <?php if($status==0){echo'selected';} ?> >Disable</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">Batch Medium <span class="text-danger">*</span></label>
                                                                    <select name="batch_medium" id="" class="form-control">
                                                                        <option name="" id="">--Select--</option>
                                                                        <option value="HINDI" <?php if($value->batch_medium =="HINDI"){echo'selected';}?> >HINDI</option>
                                                                        <option value="ENGLISH" <?php if($value->batch_medium =="ENGLISH"){echo'selected';}?> >ENGLISH</option>
                                                                    </select>
                                                                    <?= form_error("batch_medium")?>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">Batch Seat <span class="text-danger">*</span></label>
                                                                    <input type="number" name="batch_seat" value="<?= $value->batch_seat?>" class="form-control" placeholder="Enter no of seat">
                                                                    <?= form_error("batch_seat")?>
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label for="">Batch Fee <span class="text-danger">*</span></label>
                                                                    <input type="number" name="batch_fee" value="<?= $value->batch_fee?>" class="form-control" placeholder="Enter fee for this batch">
                                                                    <?= form_error("batch_fee")?>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">Batch Starting Date <span class="text-danger">*</span></label>
                                                                    <input type="date" name="batch_start_date" class="form-control" value="<?= date("Y-m-d", strtotime($value->batch_start_date))?>">
                                                                    <?= form_error("batch_start_date")?>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">Batch Time From <span class="text-danger">*</span></label>
                                                                    <input type="time" name="batch_start_time" class="form-control" value="<?= date("h:m", strtotime($value->batch_start_time))?>">
                                                                    <?= form_error("batch_start_time")?>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">Batch Time End <span class="text-danger">*</span></label>
                                                                    <input type="time" name="batch_end_time" class="form-control" value="<?= date("h:m", strtotime($value->batch_end_time))?>">
                                                                    <?= form_error("batch_end_time")?>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">Select Class <span class="text-danger">*</span></label>
                                                                    <select id="" class="form-control" name="class_id">
                                                                        <option value="">--Select--</option>
                                                                        <?php
                                                                            foreach($classes as $c){
                                                                                ?>
                                                                                <option value="<?= $c->id?>" <?php if($value->class_id == $c->id){echo "selected";} ?> > <?= $c->class_name?> </option>
                                                                                <?
                                                                            }

                                                                        ?>
                                                                    </select>
                                                                    <?= form_error("class_id")?>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">Select Subject<span class="text-danger">*</span></label>
                                                                    <select id="" class="form-control" name="subject_id">
                                                                        <option value="">--Select--</option>
                                                                        <?php
                                                                            foreach($subject as $s){
                                                                                ?>
                                                                                <option value="<?= $s->id?>" <?php if($value->subject_id == $s->id){echo "selected";} ?> > <?= $s->subject_name?> </option>
                                                                                <?
                                                                            }

                                                                        ?>
                                                                    </select>
                                                                    <?= form_error("subject_id")?>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">Comment</label>
                                                                    <input type="text" name="comment" class="form-control" value="<?= $value->comment ?>" placeholder="Comments Here">
                                                                </div>  

                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-info" name="updtSbmt" form="updateForm<?=$value->id?>">Update</button>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!--View Modal--->
                                                <div class="modal fade" id="viewModal<?=$value->id?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h6 class="modal-title" id="updateModallabel"> <i class="fa fa-eye"></i> Batch Information</h6>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
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
                                                                            <h6 class="text-muted"><?= date("d-M-Y", strtotime($value->batch_start_date)) ?></h6>
                                                                            <h6 class="text-muted"><?= date("h:m A", strtotime($value->batch_start_time))."-".date("h:m A", strtotime($value->batch_end_time)) ?></h6>
                                                                            <h6 class="text-muted"><?= date("d-M-Y h:m:s A", strtotime($value->created_date)) ?></h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?
                                        }                                    
                                    
                                    ?>                            
                                </table>
                                <?   
                            }                           
                            
                            ?>
                        </div> 
                        </div>   
                    </div>  
               </div>     
        </div>

        <!--Add Batch form---->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="addModallabel">Add Batch</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('welcome/batch/add/manage')?>" method="post" id="AddModalForm">
                        <div class="form-group">
                            <label for="">Batch name <span class="text-danger">*</span></label>
                            <input type="text" name="batch_name" class="form-control" value="<?= set_value('batch_name')?>" placeholder="Enter Batch Name">
                            <?= form_error("batch_name")?>
                        </div>

                        <div class="form-group">
                            <label for="">Batch Medium <span class="text-danger">*</span></label>
                            <select name="batch_medium" id="" class="form-control">
                                <option name="" id="">--Select--</option>
                                <option value="HINDI" <?= set_select('batch_medium', 'HINDI')?> >HINDI</option>
                                <option value="ENGLISH" <?= set_select('batch_medium', 'ENGLISH')?> >ENGLISH</option>
                            </select>
                            <?= form_error("batch_medium")?>
                        </div>
                            
                        <div class="form-group">
                            <label for="">Batch Seat <span class="text-danger">*</span></label>
                            <input type="number" name="batch_seat" value="<?= set_value('batch_seat')?>" class="form-control" placeholder="Enter no of seat">
                            <?= form_error("batch_seat")?>
                        </div>
                            
                        <div class="form-group">
                            <label for="">Batch Fee <span class="text-danger">*</span></label>
                            <input type="number" name="batch_fee" value="<?= set_value('batch_fee')?>" class="form-control" placeholder="Enter fee for this batch">
                            <?= form_error("batch_fee")?>
                        </div>

                        <div class="form-group">
                            <label for="">Batch Starting Date <span class="text-danger">*</span></label>
                            <input type="date" name="batch_start_date" class="form-control" value="">
                            <?= form_error("batch_start_date")?>
                        </div>

                        <div class="form-group">
                            <label for="">Batch Time From <span class="text-danger">*</span></label>
                            <input type="time" name="batch_start_time" class="form-control" value="">
                            <?= form_error("batch_start_time")?>
                        </div>

                        <div class="form-group">
                            <label for="">Batch Time End <span class="text-danger">*</span></label>
                            <input type="time" name="batch_end_time" class="form-control" value="">
                            <?= form_error("batch_end_time")?>
                        </div>

                        <div class="form-group">
                            <label for="">Select Class <span class="text-danger">*</span></label>
                            <select id="" class="form-control" name="class_id">
                                <option value="">--Select--</option>
                                <?php
                                    foreach($classes as $value){
                                        ?>
                                        <option value="<?= $value->id?>"> <?= $value->class_name?> </option>
                                        <?
                                    }

                                ?>
                            </select>
                            <?= form_error("class_id")?>
                        </div>

                        <div class="form-group">
                            <label for="">Select Subject<span class="text-danger">*</span></label>
                            <select id="" class="form-control" name="subject_id">
                                <option value="">--Select--</option>
                                <?php
                                    foreach($subject as $value){
                                        ?>
                                        <option value="<?= $value->id?>"> <?= $value->subject_name?> </option>
                                        <?
                                    }

                                ?>
                            </select>
                            <?= form_error("subject_id")?>
                        </div>

                        <div class="form-group">
                            <label for="">Comment</label>
                            <input type="text" name="comment" class="form-control" value="<?= set_value('comment')?>" placeholder="Comments Here">
                           <?= form_error("comment")?>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info" form="AddModalForm">Add</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>