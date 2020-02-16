<div class="container-fluid">
    <div class="row p-0">
        <div class="col-md-11 m-auto">
            <div class="page-header">
               <div class="inner-content">
                   <!-- Registration Details --> 
                   <div class="row">
                        <div class="col-md-12 p-0 m-0">
                            <?= $this->session->flashdata("success")?>
                        </div>
                        <div class="col-md-12 p-0 m-0 border">
                            <div class="float-left px-2 py-2">
                                <span class="text-muted font-weight-bold"> <i class="fa fa-users"></i> Students Registration </span>
                            </div>
                            <div class="float-right px-2">
                                <a href="<?= base_url('welcome/registration/manage')?>">
                                    <button class="btn btn-info px-2 my-1" type="button"> <i class="fa fa-cog"></i> Manage Student </button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <form method="post" action="" class="" enctype="multipart/form-data" class="bg-white">
                       <div class="bg-white mt-2">
                           <div class="row p-0 bg-white">
                                <div class="col-md-12 border p-0">
                                    <p class="p-1 text-info bg-light" style=""> <strong> <i class="fa fa-user"></i> Personal Details</strong></p>
                                    <div class="row px-2">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Student Name <span class="text-danger">*</span></label>
                                                <input type="text" name="student_name" class="form-control pl-2" value="<?= set_value('student_name')?>" placeholder="Student Name">
                                                <?= form_error('student_name')?>
                                            </div> 
                                        </div> 
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Gender <span class="text-danger">*</span></label>     
                                                <select name="gender" class="form-control">
                                                    <option value="" <?= set_select("gender", "")?> >--Select--</option>
                                                    <option value="MALE" <?= set_select("gender", "MALE")?> >MALE</option>
                                                    <option value="FEMALE" <?= set_select("gender", "FEMALE")?> >FEMALE</option>
                                                </select>
                                                <?= form_error('gender')?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Categoty <span class="text-danger">*</span></label>     
                                                <select name="category" class="form-control">
                                                    <option value="">--Select--</option>
                                                    <option value="GEN" <?= set_select("category", "GEN")?> >GEN</option>
                                                    <option value="SC" <?= set_select("category", "SC")?> >SC</option>
                                                    <option value="ST" <?= set_select("category", "ST")?> >ST</option>
                                                    <option value="BC-I" <?= set_select("category", "BC-I")?> >BC-I</option>
                                                    <option value="BC-II" <?= set_select("category", "BC-II")?> >BC-II</option>
                                                    <option value="OTHER" <?= set_select("category", "OTHER")?> >OTHER</option>
                                                </select>
                                                <?= form_error("category")?>
                                            </div>
                                        </div> 
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Date Of Birth <span class="text-danger">*</span></label>     
                                                <input type="date" name="dob" value="<?= set_value("dob")?>"  class="form-control m-0">
                                                <?= form_error("dob")?>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Father Name <span class="text-danger">*</span></label>     
                                                <input type="text" class="form-control" value="<?= set_value("father_name")?>" name="father_name" placeholder="Father Name">
                                                <?= form_error("father_name")?>
                                            </div>
                                        </div> 
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Mother Name <span class="text-danger">*</span></label>     
                                                <input type="text" class="form-control" value="<?= set_value("mother_name")?>" name="mother_name" placeholder="Mother Name">
                                                <?= form_error("mother_name")?>
                                            </div>
                                        </div> 
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Student Mobile <span class="text-danger">*</span></label>     
                                                <input type="tel" name="student_mobile" value="<?= set_value("student_mobile")?>" class="form-control" placeholder="8757885800">
                                                <?= form_error("student_mobile")?>
                                            </div>
                                        </div> 
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Student Email </label>     
                                                <input type="email" name="student_email" value="<?= set_value("student_email")?>" class="form-control" placeholder="rahul@abc.com">
                                                <?= form_error("student_email")?>
                                            </div>
                                        </div> 
                            
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Parent Mobile <span class="text-danger">*</span></label>     
                                                <input type="tel" name="parent_mobile" value="<?= set_value("perent_mobile")?>" class="form-control" placeholder="8757885800">
                                                <?= form_error("parent_mobile")?>
                                            </div>
                                        </div> 
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Parent Email </label>     
                                                <input type="email" name="parent_email" value="<?= set_value("parent_email")?>" class="form-control" placeholder="rahul-father@abc.com">
                                                <?= form_error("parent_email")?>
                                            </div>
                                        </div>
                            
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Address </label>     
                                                <input type="text" name="address" value="<?= set_value("address")?>" class="form-control" placeholder="Enter Address">
                                                <?= form_error("address")?>
                                            </div>
                                        </div>  
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">State <span class="text-danger">*</span></label>  
                                                <select name="state" class="form-control" id="state">
                                                    <option value="">--Select--</option>
                                                    <option value="BIHAR" <?= set_select("BIHAR")?> >BIHAR</option>
                                                    <option value="JHARKHAND" <?= set_select("JHARKHAND")?> >JHARKHAND</option>
                                                    <option value="HARIYANA" <?= set_select("HARIYANA")?>  >HARIYANA</option>
                                                    <option value="UP" <?= set_select("UP")?>  >UP</option>
                                                    <option value="MP" <?= set_select("MP")?>  >MP</option>
                                                </select>
                                                <?= form_error("state")?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Dist <span class="text-danger">*</span></label>  
                                                <select name="dist" class="form-control" id="dist">
                                                    <option value="">-Select-</option>
                                                </select>
                                                <?= form_error("dist")?>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Pin Code <span class="text-danger">*</span></label>  
                                                <input type="text" name="pin_code" value="<?= set_value("pin_code")?>" class="form-control" placeholder="Pin Code">
                                                <?= form_error("pin_code")?>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Profile Picture</label>  
                                                <input type="file" name="profile_pic" class="form-control">
                                                <?= $error?>
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
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">School/College</label>
                                                <input type="text" value="" name="school" class="form-control pl-2" placeholder="Enter School/College Name"> 
                                            </div> 
                                        </div> 
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Board/University</label>
                                                <input type="text" name="board" value="" class="form-control pl-2" placeholder="Enter Board Name"> 
                                            </div> 
                                        </div> 
                                
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Batch <span class="text-danger">*</span></label>
                                            <select name="batch" id="" class="form-control">
                                                <option value="">--Select--</option>
                                                <option value="1"  > 08:00-09:00 </option> 
                                            </select> 
                                            <label class="font-weight-bold text-danger py-1" id="batch"></label>
                                        </div> 
                                    </div> 
                                   
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Remarks </label>
                                            <input type="text" name="remarks" placeholder="Remarks" class="form-control pl-2"> 
                                        </div> 
                                    </div> 
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="submit" name="sbmt" class="btn btn-info">
                                            <input type="reset" name="reset" class="btn btn-danger">
                                        </div>
                                    </div>
                                </div>   
                           </div>   
                            
                       </div>
                    </form>
               </div>     
            </div>

        </div>
    </div>
</div>
