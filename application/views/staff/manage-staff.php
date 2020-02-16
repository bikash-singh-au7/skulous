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
                                <span class="text-muted font-weight-bold">Manage Staff</span>
                            </div>
                            <div class="float-right px-2">
                                <a href="<?= base_url('welcome/staff/add')?>">
                                    <button class="btn btn-info px-2 my-1" type="button" data-toggle="modal" data-target=""> <i class="fa fa-plus"></i> Add Staff </button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="">
                       <div class="row border">
                        <div class="col-md-12 m-auto p-0">
                            <?php
                            if(empty($data)){
                                ?>
                                    <div class="alert alert-danger rounded-0">There is no data. Please add first!</div>
                                <?
                            }else {
                                foreach($data as $value){
                                    ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card m-1">
                                                    <div class="card-body p-2 m-0">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="div-inline float-left">
                                                                    <img src="<?= base_url('./assets/images/staff/'.$value->profile_pic)?>" alt="" class="img img-thumbnail" height=150, width=140>
                                                                </div>
                                                                <div class="div-inline float-left ml-2 mt-2">
                                                                    <h5 class="m-0"><?= $value->first_name." ".$value->middle_name." ".$value->last_name?></h5>
                                                                    <span class="badge badge-info"> <i>Staff/Worker</i> </span>
                                                                    <?php
                                                                        if($value->staff_status == 1){
                                                                            ?><span class="badge badge-info">Active</span><?
                                                                        }else {
                                                                            ?><span class="badge badge-danger">Disabled</span><?
                                                                        }
                                                                    ?>
                                                                    <p class="m-0"> <span class="fa fa-phone"></span> <?= $value->mobile_number?> </p>
                                                                    <p class="m-0"> <span class="fa fa-envelope"></span> <?= $value->email?> </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 text-right">
                                                                <p><button class="btn btn-info px-2 py-1" type="button" data-toggle="modal" data-target="#updateModal<?=$value->id?>"> <i class="fa fa-edit"></i> Edit Profile </button></p>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                                
                                        <!--<td class="text-center"><?= date("d-M-Y h:m:s A", strtotime($value->created_date)) ?></td>-->
                                                    
                                        
                                                

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
                                     <?
                                }                                    
                            }                            
                            ?>
                         
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