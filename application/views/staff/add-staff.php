<div class="container-fluid">
    <div class="row p-0">
        <div class="col-md-10 m-auto">
            <div class="page-header">
               <div class="inner-content">
                   <!-- Staff Details --> 
                   <div class="row">
                        <div class="col-md-12 p-0 m-0">
                            <?= $this->session->flashdata("success")?>
                        </div>
                        <div class="col-md-12 p-0 m-0 border">
                            <div class="float-left px-2 py-2">
                                <span class="text-muted font-weight-bold">Add Staff </span>
                            </div>
                            <div class="float-right px-2">
                                <a href="<?= base_url('welcome/staff/manage')?>">
                                    <button class="btn btn-info px-2 my-1" type="button"> <i class="fa fa-cog"></i> Staff </button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <form method="post" action="<?= base_url('welcome/staff/add')?>" class="" enctype="multipart/form-data">
                        <div class="row border pt-2">
                            <div class="col-md-4">
                             <div class="form-group">
                              <!--Months-->     
                              <label class="font-weight-bold">First Name <span class="text-danger">*</span></label>
                              <input type="text" name="first_name" value="<?= set_value("first_name")?>" class="form-control block pl-2" placeholder="First Name"> 
                              <?= form_error("first_name")?>
                             </div> 
                            </div> 
                            <div class="col-md-4">
                             <div class="form-group">
                               <label class="font-weight-bold">Middle Name </label>     
                               <input type="text" name="middle_name" value="<?= set_value("middle_name")?>" class="form-control" placeholder="Middle Name">
                               <?= form_error("middle_name")?>
                             </div>
                            </div>
                            <div class="col-md-4">
                             <div class="form-group">
                               <label class="font-weight-bold">Last Name <span class="text-danger">*</span></label>     
                               <input type="text" name="last_name" value="<?= set_value("last_name")?>" class="form-control" placeholder="Last Name" >
                               <?= form_error("last_name")?>
                             </div>
                            </div> 
                            <div class="col-md-4">
                             <div class="form-group">
                               <label class="font-weight-bold">Gender <span class="text-danger">*</span></label>     
                                 <select name="gender" class="form-control" >
                                     <option value="">--Select--</option>
                                     <option value="MALE" <?= set_select("gender", "MALE")?> >MALE</option>
                                     <option value="FEMALE" <?= set_select("gender", "FEMALE")?> >FEMALE</option>
                                 </select>
                                 <?= form_error("gender")?>
                             </div>
                            </div> 
                            <div class="col-md-4">
                             <div class="form-group">
                               <label class="font-weight-bold">Mobile <span class="text-danger">*</span></label>     
                                 <input type="tel" name="mobile_number" value="<?= set_value("mobile_number")?>" class="form-control" placeholder="9934568954">
                                 <?= form_error("mobile_number")?>
                             </div>
                            </div> 
                            <div class="col-md-4">
                             <div class="form-group">
                               <label class="font-weight-bold">Email </label>     
                                 <input type="email" name="email" value="<?= set_value("email")?>" class="form-control" placeholder="auxous@abc.com">
                                 <?= form_error("email")?>
                             </div>
                            </div> 
                            <div class="col-md-8">
                             <div class="form-group">
                               <label class="font-weight-bold">Address <span class="text-danger">*</span></label>  
                                 <input type="text" name="address" value="<?= set_value("address")?>" class="form-control" placeholder="Full Address">
                                 <?= form_error("address")?>
                             </div>
                            </div>
                            <div class="col-md-4">
                             <div class="form-group">
                               <label class="font-weight-bold">Profile Picture </label>  
                                 <input type="file" name="profile_pic" class="form-control" >
                                 <label class="text-danger font-weight-bold" id="profileImgError"></label>
                                 <div class="text-danger"><?= $error?></div>
                                 <?= form_error("profile_pic")?>
                             </div>
                            </div> 
                            <div class="col-md-4">
                             <div class="form-group">
                                <input type="submit" name="sbmt" class="btn btn-info">
                                <input type="reset" name="reset" class="btn btn-danger">
                             </div>
                            </div>
                           </div>   
                        </div>
                        <!--
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
                        -->
                    </form>  
               </div>     
        </div>

    </div>
</div>
