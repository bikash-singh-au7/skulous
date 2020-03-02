<?php
    date_default_timezone_set("Asia/Kolkata");
    $today = date("Y-m-d");
?>   

<div class="container-fluid">
    <div class="row p-0">
        <div class="col-md-11 m-auto">
            <div class="page-header">
               <div class="inner-content">
                   <!-- Registration Details --> 
                   <div class="row">
                        <div class="col-md-12 p-0 m-0" id="alert">
                            
                        </div>
                        <div class="col-md-12 p-0 m-0" id="payment_alert">
                            
                        </div>
                        <div class="col-md-12 p-0 m-0 border">
                            <div class="float-left px-2 py-2">
                                <span class="text-muted font-weight-bold"> <i class="fa fa-users"></i> Students inquiry </span>
                            </div>
                            <div class="float-right px-2">
                                <a href="<?= base_url('inquirysetup/inquiry/manage')?>">
                                    <button class="btn btn-info px-2 my-1" type="button"> <i class="fa fa-cog"></i> Manage Inquiry </button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <form method="post" action="" class="" id="addForm" enctype="multipart/form-data" class="bg-white">
                       <div class="bg-white mt-2">
                           <div class="row p-0 bg-white">
                                <div class="col-md-12 border p-0">
                                    <p class="p-1 text-info bg-light" style=""> <strong> <i class="fa fa-user"></i> Personal Details</strong></p>
                                    <div class="row px-2">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Student Name <span class="text-danger">*</span></label>
                                                <input type="text" name="student_name" class="form-control pl-2" value="" placeholder="Student Name">
                                                <span class="text-danger" id="e_student_name"></span>
                                            </div> 
                                        </div> 
                                      
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Student Mobile <span class="text-danger">*</span></label>     
                                                <input type="tel" name="student_mobile" value="" class="form-control" placeholder="8757885800">
                                                <span class="text-danger" id="e_student_mobile"></span>
                                            </div>
                                        </div> 
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Student Email </label>     
                                                <input type="email" name="student_email" value="" class="form-control" placeholder="rahul@abc.com">
                                                <span class="text-danger" id="e_student_email"></span>
                                            </div>
                                        </div> 
                            
                            
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Address </label>     
                                                <input type="text" name="address" value="" class="form-control" placeholder="Enter Address">
                                                <span class="text-danger" id="e_address"></span>
                                            </div>
                                        </div>  
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">State <span class="text-danger">*</span></label>  
                                                <select name="state" class="form-control" id="state">
                                                    <option value="">--Select--</option>
                                                    <option value="Bihar">Bihar</option>
                                                    <option value="Jharkhand">Jharkhand</option>
                                                    <option value="UP">UP</option>
                                                </select>
                                                <span class="text-danger" id="e_state"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Dist <span class="text-danger">*</span></label>
                                                <select name="dist" class="form-control" id="dist">
                                                    <option value="">-Select-</option>
                                                </select>
                                                <span class="text-danger" id="e_dist"></span>
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
                                            <label for="" class="font-weight-bold">Select Class<span class="text-danger">*</span></label>
                                            <select id="class_id" class="form-control" name="class_id">
                                                <option value="">--Select--</option>
                                                <?php
                                                    foreach($class as $value){
                                                        ?>
                                                        <option value="<?= $value->id?>"> <?= $value->class_name?> </option>
                                                        <?
                                                    }

                                                ?>
                                            </select>
                                            <span class="text-danger" id="e_class_id"></span>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="" class="font-weight-bold">Select Subject<span class="text-danger">*</span></label>
                                            <select id="subject_id" class="form-control" name="subject_id">
                                                <option value="">--Select--</option>
                                                <?php
                                                    foreach($subject as $value){
                                                        ?>
                                                        <option value="<?= $value->id?>"> <?= $value->subject_name?> </option>
                                                        <?
                                                    }

                                                ?>
                                            </select>
                                            <span class="text-danger" id="e_subject_id"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="" class="font-weight-bold">Select Medium<span class="text-danger">*</span></label>
                                            <select id="medium" class="form-control" name="medium">
                                                <option value="">--Select--</option>
                                                <option value="HINDI">HINDI</option>
                                                <option value="ENGLISH">ENGLISH</option>
                                                
                                            </select>
                                            <span class="text-danger" id="e_medium"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="" class="font-weight-bold">Inquiry Purpose</label>
                                            <input type="text" id="inquiry_purpose" name="inquiry_purpose" placeholder="Purpose" class="form-control pl-2"> 
                                            <span class="text-danger" id="e_inquiry_purpose"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Remarks </label>
                                            <input type="text" name="comment" placeholder="Remarks" class="form-control pl-2"> 
                                            <span class="text-danger" id="e_comment"></span>
                                        </div> 
                                    </div> 
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Refreances </label>
                                            <input type="text" id="refrence" name="refrence" placeholder="Refrence" class="form-control pl-2"> 
                                            <span class="text-danger" id="e_refrence"></span>
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
                       </div>
                       
                       
                       
                    </form>
               </div>     
            </div>

        </div>
    </div>
</div>



<!---Ajax here-->
<script>
    $(document).ready(function(){
        var arr = {
            Bihar:["Araria", "Arwal", "Aurangabad","Banka","Begusarai",,"Bhagalpur","Arrah","Buxar","Darbhanga","Motihari","Gaya","Gopalganj","Jamui","Jehanabad","Khagaria","Kishanganj","Bhabua","Katihar","Lakhisarai","Madhubani","Munger","Madhepura","Muzaffarpur","Bihar Sharif","Nawada","Patna","Purnia","Sasaram","Saharsa","Samastipur","Sheohar","Sheikhpura","Chhapra","Dumra,Sitamarhi ","Supaul","Siwan","Hajipur","Bettiah"],
            Jharkhand:["Bokaro","Chatra","Deoghar","Dhanbad","Dumka","Jamshedpur","Garhwa","Giridih","Godda","Gumla","Hazaribagh","Jamtara","Khunti","Koderma","Latehar","Lohardaga","Pakur","Daltonganj","Ramgarh","Ranchi","Sahebganj","Seraikela","Simdega","Chaibasa"],
            UP:["Agra","Aligarh","PrayagRaj","Akbarpur","Amroha","Auraiya","Azamgarh","Badaun","Bahraich","Ballia","Balrampur","Banda","Barabanki","Bareilly","Basti","Bijnor","Bulandshahr","Chandauli","Chitrakoot","Deoria","Etah","Etawah","Faizabad","Fatehgarh","Fatehpur","Firozabad","Noida","Ghaziabad","Ghazipur","Gonda","Gorakhpur","Hamirpur","Hapur","Hardoi","Hathras","Jaunpur","Jhansi","Kannauj","Kanpur","Kasganj","Manjhanpur","Padarauna","Kheri","Lalitpur","Lucknow","Maharajganj","Mahoba","Mainpuri","Mathura","Mau","Meerut","Mirzapur","Moradabad","Muzaffarnagar","Pilibhit","Pratapgarh","Rae Bareli","Rampur","Saharanpur","Khalilabad","Gyanpur","Sambhal","Shahjahanpur","Shamli","Shravasti","Navgarh","Sitapur","Robertsganj","Sultanpur","Unnao","Varanasi","Allahabad","Amethi","Bagpat"]
        };
        
        $("#state").change(function(){
            var val = $(this).val();
            var length = 0;
            if(val == ""){
                length = 0;
            }else{
                length = arr[val].length;
            }
            var select = "<option value=''>--Select--</option>";
            for(i=0; i<length; i++){
                select+="<option value="+arr[val][i]+">"+arr[val][i]+"</option>";
            }
            $("#dist").html(select);
        })
        
        function eraseError(){
            $("#e_student_name").html("");
            $("#e_student_mobile").html("");
            $("#e_student_email").html("");
            $("#e_address").html("");
            $("#e_state").html("");
            $("#e_dist").html("");
            $("#e_class_id").html("");
            $("#e_subject_id").html("");
            $("#e_medium").html("");
            $("#e_enquiry_purpose").html("");
            $("#e_comment").html("");
            $("#e_refrence").html("");
        }
        
        
        $("body").on("submit", "#addForm", function(e){
            e.preventDefault();
            $.ajax({
                url: '<?= base_url("inquirysetup/addInquiry/add")?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){
                    if(response["status"] == 0){
                        //set error message 
                        $("#e_student_name").html(response["student_name"]);
                        $("#e_student_mobile").html(response["student_mobile"]);
                        $("#e_student_email").html(response["student_email"]);
                        $("#e_address").html(response["address"]);
                        $("#e_state").html(response["state"]);
                        $("#e_dist").html(response["dist"]);
                        $("#e_class_id").html(response["class_id"]);
                        $("#e_subject_id").html(response["subject_id"]);
                        $("#e_medium").html(response["medium"]);
                        $("#e_enquiry_purpose").html(response["enquiry_purpose"]);
                        $("#e_comment").html(response["comment"]);
                        $("#e_refrence").html(response["refrence"]);
                        
                    }else if(response["status"] == 1){
                        //set blank value for error message
                        eraseError()
                        //set blank value after inserting the value
                        $(".form-control").val("");
                        //set message for alert box
                        Swal.fire(
                          response["alert"],
                          response["message"],
                          'success'
                        )
                    }else{
                        $(".form-control").val("");
                        
                        //set blank value for error message
                        eraseError()
                        Swal.fire(
                          response["alert"],
                          response["message"],
                          'error'
                        )
                        
                    }
                }
            });
        });

        $(".form-control").focus(function(){
            $("#alert").html("");
        });
        
       
        
    });
    
    
    
    
    
</script>



