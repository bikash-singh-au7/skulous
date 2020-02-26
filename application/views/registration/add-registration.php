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
                                <span class="text-muted font-weight-bold"> <i class="fa fa-users"></i> Students Registration </span>
                            </div>
                            <div class="float-right px-2">
                                <a href="<?= base_url('regsetup/registration/manage')?>">
                                    <button class="btn btn-info px-2 my-1" type="button"> <i class="fa fa-cog"></i> Manage Student </button>
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
                                                <label class="font-weight-bold">Gender <span class="text-danger">*</span></label>     
                                                <select name="gender" class="form-control">
                                                    <option value="">--Select--</option>
                                                    <option value="MALE">MALE</option>
                                                    <option value="FEMALE">FEMALE</option>
                                                </select>
                                                <span class="text-danger" id="e_gender"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Categoty <span class="text-danger">*</span></label>     
                                                <select name="category" class="form-control">
                                                    <option value="">--Select--</option>
                                                    <option value="GEN">GEN</option>
                                                    <option value="SC">SC</option>
                                                    <option value="ST">ST</option>
                                                    <option value="BC-I">BC-I</option>
                                                    <option value="BC-II">BC-II</option>
                                                    <option value="OTHER">OTHER</option>
                                                </select>
                                                <span class="text-danger" id="e_category"></span>
                                            </div>
                                        </div> 
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Date Of Birth <span class="text-danger">*</span></label>     
                                                <input type="date" name="dob" value=""  class="form-control m-0">
                                                <span class="text-danger" id="e_dob"></span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Father Name <span class="text-danger">*</span></label>     
                                                <input type="text" class="form-control" value="" name="father_name" placeholder="Father Name">
                                                <span class="text-danger" id="e_father_name"></span>
                                            </div>
                                        </div> 
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Mother Name <span class="text-danger">*</span></label>     
                                                <input type="text" class="form-control" value="" name="mother_name" placeholder="Mother Name">
                                                <span class="text-danger" id="e_mother_name"></span>
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
                            
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Parent Mobile </label>     
                                                <input type="tel" name="parent_mobile" value="" class="form-control" placeholder="8757885800">
                                                <span class="text-danger" id="e_parent_mobile"></span>
                                            </div>
                                        </div> 
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Parent Email </label>     
                                                <input type="email" name="parent_email" value="" class="form-control" placeholder="rahul-father@abc.com">
                                                <span class="text-danger" id="e_parent_email"></span>
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
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Pin Code <span class="text-danger">*</span></label>  
                                                <input type="text" name="pin_code" value="<?= set_value("pin_code")?>" class="form-control" placeholder="Pin Code">
                                                <span class="text-danger" id="e_pin_code"></span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Profile Picture</label>  
                                                <input type="file" name="profile_pic" class="form-control">
                                                <span class="text-danger" id="e_profile_pic"></span>
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
                                                <span class="text-danger" id="e_school"></span>
                                            </div> 
                                        </div> 
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Board/University</label>
                                                <input type="text" name="board" value="" class="form-control pl-2" placeholder="Enter Board Name"> 
                                                <span class="text-danger" id="e_board"></span>
                                            </div> 
                                        </div> 
                                
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="" class="font-weight-bold">Select Batch<span class="text-danger">*</span></label>
                                            <select id="batch_id" class="form-control" name="batch_id">
                                                <option value="">--Select--</option>
                                                <?php
                                                    foreach($batch as $value){
                                                        ?>
                                                        <option value="<?= $value->id?>"> <?= $value->batch_name.' ('.date('h:m A', strtotime($value->batch_start_time)).'-'.date('h:m A', strtotime($value->batch_end_time)).')'?> </option>
                                                        <?
                                                    }

                                                ?>
                                            </select>
                                            <span class="text-danger" id="e_batch_id"></span>
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Payble Amount </label>
                                            <input type="hidden" name="fee_amount" placeholder="Total Fee Amount" class="form-control pl-2" readonly id="fee_amount"> 
                                            <input type="text" id="payble_amount" name="payble_amount" class="form-control" readonly>
                                            <span class="text-danger" id="e_payble_amount"></span>
                                        </div> 
                                    </div> 
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Discount </label>
                                            <input type="text" name="discount" placeholder="Discount Amount" class="form-control pl-2" id="discount" readonly> 
                                            <span class="text-danger" id="e_discount"></span>
                                        </div> 
                                    </div> 
                                   
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Remarks </label>
                                            <input type="text" name="comment" placeholder="Remarks" class="form-control pl-2"> 
                                            <span class="text-danger" id="e_comment"></span>
                                        </div> 
                                    </div> 
                                    
                                </div>   
                           </div>   
                            
                        </div> 
                       </div>
                       
                       
                       <div class="bg-white mt-2">
                           <div class="row p-0 bg-white">
                                <div class="col-md-12 border p-0">
                                    <p class="p-1 text-info bg-light" style=""> <strong> <span class="fa fa-rupee-sign"></span> Payment Details</strong></p>
                                    <div class="row px-2">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Total Payable Amount</label>
                                                <input type="number" value="" name="amount" class="form-control pl-2" placeholder="Total Payable Amount" readonly> 
                                                <span class="text-danger" id="e_amount"></span>
                                            </div> 
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Payment Amount</label>
                                                <input type="number" value="" name="payment_amount" class="form-control pl-2" placeholder="Enter Amount"> 
                                                <span class="text-danger" id="e_payment_amount"></span>
                                            </div> 
                                        </div> 
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Payment Date</label>
                                                <input type="date" value="<?= $today?>" name="payment_date" class="form-control pl-2"> 
                                                <span class="text-danger" id="e_payment_date"></span>
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
        
        
        
        
        $("body").on("submit", "#addForm", function(e){
            e.preventDefault();
            $.ajax({
                url: '<?= base_url("regsetup/addReg/add")?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){
                    if(response["status"] == 0){
                        //set error message 
                        $("#e_student_name").html(response["student_name"]);
                        $("#e_gender").html(response["gender"]);
                        $("#e_category").html(response["category"]);
                        $("#e_dob").html(response["dob"]);
                        $("#e_father_name").html(response["father_name"]);
                        $("#e_mother_name").html(response["mother_name"]);
                        $("#e_student_mobile").html(response["student_mobile"]);
                        $("#e_student_email").html(response["student_email"]);
                        $("#e_parent_mobile").html(response["parent_mobile"]);
                        $("#e_parent_email").html(response["parent_email"]);
                        $("#e_address").html(response["address"]);
                        $("#e_state").html(response["state"]);
                        $("#e_dist").html(response["dist"]);
                        $("#e_pin_code").html(response["pin_code"]);
                        $("#e_profile_pic").html(response["profile_pic"]);
                        //Other details
                        $("#e_school").html(response["school"]);
                        $("#e_board").html(response["board"]);
                        $("#e_batch_id").html(response["batch_id"]);
                        $("#e_payble_amount").html(response["payble_amount"]);
                        $("#e_discount").html(response["discount"]);
                        $("#e_comment").html(response["comment"]);
                        //Payment Detaile
                        $("#e_payment_amount").html(response["payment_amount"]);
                        $("#e_payment_date").html(response["payment_date"]);
                        
                        
                    }else if(response["status"] == 1){
                        //set blank value for error message
                        $("#e_student_name").html("");
                        $("#e_gender").html("");
                        $("#e_category").html("");
                        $("#e_dob").html("");
                        $("#e_father_name").html("");
                        $("#e_mother_name").html("");
                        $("#e_student_mobile").html("");
                        $("#e_student_email").html("");
                        $("#e_parent_mobile").html("");
                        $("#e_parent_email").html("");
                        $("#e_address").html("");
                        $("#e_state").html("");
                        $("#e_dist").html("");
                        $("#e_pin_code").html("");
                        $("#e_profile_pic").html("");
                        //Other details
                        $("#e_school").html("");
                        $("#e_board").html("");
                        $("#e_batch_id").html("");
                        $("#e_payble_amount").html("");
                        $("#e_discount").html("");
                        $("#e_comment").html("");
                        //Payment Detaile
                        $("#e_payment_amount").html("");
                        $("#e_payment_date").html("");
                        

                        //set blank value after inserting the value
                        $(".form-control").val("");
                        //set message for alert box
                        $("#alert").html(response["alert"]);
                        $("#payment_alert").html(response["payment_alert"]);
                    }else{
                        $(".form-control").val("");
                        $("#alert").html(response["alert"]);
                    }
                }
            });
        });

        $(".form-control").focus(function(){
            $("#alert").html("");
        });
        
        
        
        //fill batch fee
        $("#batch_id").on("change", function(){
            var batchId = $(this).val()
            if (batchId == ""){
                $("#fee_amount").val("");
                $("#discount").attr("readonly", "readonly");
                $("#payble_amount").val("");
            }else{
                $.ajax({
                    url:"<?= base_url('regsetup/batchFee')?>",
                    data:{batch_id:batchId},
                    type:"POST",
                    dataType:"json",
                    success:function(response){
                        $("#fee_amount").val(response["fee"]);
                        $("#payble_amount").val(response["fee"]);
                        $("#discount").removeAttr("readonly");
                    }
                });
            }
            
        });
        
        
        
    });
    
    
    
    
    
</script>



