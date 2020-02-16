<div class="container-fluid">
    <div class="row p-0">
        <div class="col-md-6 m-auto">
            <div class="page-header">
               <div class="inner-content">
                   <!-- Batch Details --> 
                   <div class="row">
                        <div class="col-md-12 p-0 m-0">
                            <?= $this->session->flashdata("success")?>
                        </div>
                        <div class="col-md-12 p-0 m-0 border">
                            <div class="float-left px-2 py-2">
                                <span class="text-muted font-weight-bold">Add Batch </span>
                            </div>
                            <div class="float-right px-2">
                                <a href="<?= base_url('welcome/batch/manage')?>">
                                    <button class="btn btn-info px-2 my-1" type="button"> <i class="fa fa-cog"></i> Batch </button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <form method="post" action="<?= base_url('welcome/batch/add')?>" class="">
                       <div class="row border pt-2">
                         <div class="col-md-12 m-auto">
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
                            <div class="form-group">
                                <input type="submit" name="sbmt" class="btn btn-info">
                                <input type="reset" name="reset" class="btn btn-danger">
                            </div>
                          </div> 
                        </div>   
                    </form>  
               </div>     
        </div>

    </div>
</div>