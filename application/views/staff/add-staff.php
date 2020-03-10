<div class="container-fluid">
    <div class="row p-0">
        <div class="col-md-10 m-auto">
            <div class="page-header">
               <div class="inner-content">
                   <!-- Staff Details --> 
                   <div class="row">
                        <div class="col-md-12 p-0 m-0" id="alert">
                            
                        </div>
                        <div class="col-md-12 p-0 m-0 border">
                            <div class="float-left px-2 py-2">
                                <span class="text-muted font-weight-bold"> <i class="fa fa-plus"></i> Add Staff </span>
                            </div>
                            <div class="float-right px-2">
                                <a href="<?= base_url('staffsetup/staff/manage')?>">
                                    <button class="btn btn-info px-2 my-1" type="button"> <i class="fa fa-cog"></i> Manage Staff </button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <form method="post" action="" class="" enctype="multipart/form-data" id="addForm">
                        <div class="row border pt-2">
                            <div class="col-md-4">
                             <div class="form-group">
                              <!--Months-->     
                              <label class="font-weight-bold">Staff Name <span class="text-danger">*</span></label>
                              <input type="text" name="staff_name" value="" class="form-control block pl-2" placeholder="First Name"> 
                              <span class="text-danger" id="e_staff_name"></span>
                             </div> 
                            </div> 
                            
                            <div class="col-md-4">
                             <div class="form-group">
                               <label class="font-weight-bold">Gender <span class="text-danger">*</span></label>     
                                 <select name="gender" class="form-control" >
                                     <option value="">--Select--</option>
                                     <option value="MALE">MALE</option>
                                     <option value="FEMALE">FEMALE</option>
                                 </select>
                                 <span class="text-danger" id="e_gender"></span>
                             </div>
                            </div> 
                            <div class="col-md-4">
                             <div class="form-group">
                                 <label class="font-weight-bold">Mobile <span class="text-danger">*</span></label>     
                                 <input type="tel" name="mobile_number" value="" class="form-control" placeholder="9934568954">
                                 <span class="text-danger" id="e_mobile_number"></span>
                             </div>
                            </div> 
                            <div class="col-md-4">
                             <div class="form-group">
                                 <label class="font-weight-bold">Email </label>     
                                 <input type="email" name="email" value="" class="form-control" placeholder="auxous@abc.com">
                                 <span class="text-danger" id="e_email"></span>
                             </div>
                            </div> 
                            <div class="col-md-8">
                             <div class="form-group">
                               <label class="font-weight-bold">Address <span class="text-danger">*</span></label>  
                                 <input type="text" name="address" value="" class="form-control" placeholder="Full Address">
                                 <span class="text-danger" id="e_address"></span>
                             </div>
                            </div>
                            <!--
                            <div class="col-md-4">
                             <div class="form-group">
                               <label class="font-weight-bold">Profile Picture </label>  
                                 <input type="file" name="profile_pic" class="form-control" >
                                 <label class="text-danger font-weight-bold" id="profileImgError"></label>
                                 <div class="text-danger"><?// $error?></div>
                                 <?// form_error("profile_pic")?>
                             </div>
                            </div> 
                            -->
                            <div class="col-md-12">
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


<!---Ajax here-->
<script>
    $(document).ready(function(){
        $("body").on("submit", "#addForm", function(e){
            e.preventDefault();
            $.ajax({
                url: '<?= base_url("staffsetup/addStaff/add")?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){
                    if(response["status"] == 0){
                        //set error message 
                        $("#e_staff_name").html(response["staff_name"]);
                        $("#e_gender").html(response["gender"]);
                        $("#e_mobile_number").html(response["mobile_number"]);
                        $("#e_email").html(response["email"]);
                        $("#e_address").html(response["address"]);
                        
                    }else{
                        //set blank value for error message
                        $("#e_staff_name").html("");
                        $("#e_gender").html("");
                        $("#e_mobile_number").html("");
                        $("#e_email").html("");
                        $("#e_address").html("");
                        

                        //set blank value after inserting the value
                        $(".form-control").val("");
                        //set message for alert box
                        Swal.fire(
                          response["alert"],
                          response["message"],
                          response["modal"]
                        );
                    }
                }
            });
        });

        $(".form-control").focus(function(){
            $("#alert").html("");
        });
        
    });
</script>
