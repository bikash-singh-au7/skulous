<?php
    date_default_timezone_set("Asia/Kolkata");
    $today = date("Y-m-d");
?>
<div class="container-fluid">
    <div class="row p-0">
        <div class="col-md-11 m-auto">
            <div class="page-header">
               <div class="inner-content">
                   <!-- Class Details --> 
                   <div class="row">
                        <div class="col-md-12 p-0 m-0" id="alert">
                            
                        </div>
                        <div class="col-md-12 p-0 m-0 border">
                            <div class="float-left px-2 py-2">
                                <span class="text-muted font-weight-bold"> <i class="fa fa-cog"></i> Manage Registration</span>
                            </div>
                            <div class="float-right px-2">
                                <button class="btn btn-info px-2 my-1" type="button" data-toggle="modal" data-target="#addModal" id="addBtn"> <i class="fa fa-plus"></i> Student Registration </button>
                            </div>
                        </div>
                    </div>
                    <div class="">
                       <div class="row border">
                        <div class="col-md-12 m-auto p-2 table-responsive">
                            <table id="dataTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#Id</th>
                                        <th>Name</th>
                                        <th>Father</th>
                                        <th>Batch</th>
                                        <th>Mobile</th>
                                        <th>Status</th>
                                        <th>Reg Date</th>
                                        
                                        <th class="text-center" style="width: 120px">Action</th>
                                    </tr> 
                                </thead>
                                <tbody>
                                    <?php
                                        foreach($data as $value){
                                        ?>
                                            <tr id="row-<?=$value->id?>">
                                                <td><?=$value->id?></td>
                                                <td><?=$value->student_name?></td>
                                                <td>
                                                    <?= $value->father_name; ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        $data = $this->work->select_data("batch", ["id"=>$value->batch_id]);
                                                        echo $data[0]->batch_name;
                                                    ?>
                                                </td>
                                                <td class="text-center"> <?= $value->student_mobile?> </td>
                                                <td class="text-center">
                                                    <?php
                                                        
                                                        if($value->reg_status == 1){
                                                            $status = 1;
                                                            echo"<span class='badge badge-info'>Active</span>";
                                                        }else{
                                                            $status = 0;
                                                            echo"<span class='badge badge-danger'>Disable</span>";
                                                        }
                                                        
                                                    ?>
                                                </td>

                                                <td class="text-center"><?= date("d-M-Y", strtotime($value->created_date)) ?></td>
                                                
                                                
                                                
                                                <td class="text-center">
                                                    <button class="btn btn-info px-2 py-1" onclick="getId('<?= $value->id?>')"> <i class="fa fa-edit"></i> </button>
                                                    
                                                    <button class="btn btn-success px-2 py-1" onclick="viewId('<?= $value->id?>')"> <i class="fa fa-eye"></i> </button>
                                                    
                                                    <button class="btn btn-danger px-2 py-1" onclick="deleteData('<?= $value->id?>')"> <i class="fa fa-trash"></i> </button>
                                                    
                                                    <button class="btn btn-warning px-2 py-1" onclick="sendSma('<?= $value->id?>')"> <i class="fa fa-envelope"></i> </button>
                                                    
                                                    <button class="btn btn-dark px-2 py-1" onclick="makePayment('<?= $value->id?>')"> <i class="fa fa-rupee-sign"></i> </button>
                                                    
                                                
                                                </td>
                                            </tr>
                                            <?
                                        } 
                                    ?>
                                </tbody>
                            </table> 
                                
                        </div> 
                        </div>   
                    </div>  
               </div>     
        </div>
        
        <!--Delete Data Modal---->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="deleteModallabel">Delete Batch</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img class="img img-responsive" height=100 src="<?= base_url('assets/images/danger.png')?>" alt="">
                    <h5 class="text-muted">Do you want to delete?</h5>
                </div>
                <div class="m-auto pb-2">
                    <form action="" method="post" id="deleteForm">
                        <input type="hidden" value="" name="reg_id" id="delete_reg_id">
                        <button type="submit" class="btn btn-danger" name="delSbmt">Delete</button>
                        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    </form>
                                                            
                </div>
                </div>
            </div>
        </div>

        <!--Update Modal Form-->
        <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="updateModallabel">Update Batch Information</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-5">
                    <form method="post" action="" class="" id="updateForm" enctype="multipart/form-data" class="bg-white">
                       <div class="bg-white mt-2">
                           <div class="row p-0 bg-white">
                                <div class="col-md-12 border p-0">
                                    <p class="p-1 text-info bg-light" style=""> <strong> <i class="fa fa-user"></i> Personal Details</strong></p>
                                    <div class="row px-2">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Student Name <span class="text-danger">*</span></label>
                                                <input type="text" name="student_name" class="form-control pl-2" value="" placeholder="Student Name" id="student_name">
                                                <input type="hidden" name="reg_id" class="form-control" value="" id="reg_id">
                                                <span class="text-danger" id="e_student_name"></span>
                                            </div> 
                                        </div> 
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Gender <span class="text-danger">*</span></label>     
                                                <select name="gender" class="form-control" id="gender">
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
                                                <select name="category" class="form-control" id="category">
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
                                                <input type="date" name="dob" value=""  class="form-control m-0" id="dob">
                                                <span class="text-danger" id="e_dob"></span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Father Name <span class="text-danger">*</span></label>     
                                                <input type="text" class="form-control" value="" name="father_name" placeholder="Father Name" id="father_name">
                                                <span class="text-danger" id="e_father_name"></span>
                                            </div>
                                        </div> 
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Mother Name <span class="text-danger">*</span></label>     
                                                <input type="text" class="form-control" value="" name="mother_name" placeholder="Mother Name" id="mother_name">
                                                <span class="text-danger" id="e_mother_name"></span>
                                            </div>
                                        </div> 
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Student Mobile <span class="text-danger">*</span></label>     
                                                <input type="tel" name="student_mobile" value="" class="form-control" placeholder="8757885800" id="student_mobile">
                                                <span class="text-danger" id="e_student_mobile"></span>
                                            </div>
                                        </div> 
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Student Email </label>     
                                                <input type="email" name="student_email" value="" class="form-control" placeholder="rahul@abc.com" id="student_email">
                                                <span class="text-danger" id="e_student_email"></span>
                                            </div>
                                        </div> 
                            
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Parent Mobile </label>     
                                                <input type="tel" name="parent_mobile" value="" class="form-control" placeholder="8757885800" id="parent_mobile">
                                                <span class="text-danger" id="e_parent_mobile"></span>
                                            </div>
                                        </div> 
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Parent Email </label>     
                                                <input type="email" name="parent_email" value="" class="form-control" placeholder="rahul-father@abc.com" id="parent_email">
                                                <span class="text-danger" id="e_parent_email"></span>
                                            </div>
                                        </div>
                            
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Address </label>     
                                                <input type="text" name="address" value="" class="form-control" placeholder="Enter Address" id="address">
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
                                                <input type="text" name="pin_code" value="" class="form-control" placeholder="Pin Code" id="pin_code">
                                                <span class="text-danger" id="e_pin_code"></span>
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
                                                <input type="text" value="" name="school" class="form-control pl-2" placeholder="Enter School/College Name" id="school"> 
                                                <span class="text-danger" id="e_school"></span>
                                            </div> 
                                        </div> 
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Board/University</label>
                                                <input type="text" name="board" value="" class="form-control pl-2" placeholder="Enter Board Name" id="board"> 
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
                                            <label class="font-weight-bold">Discount </label>
                                            <input type="text" name="discount" placeholder="Discount Amount" class="form-control pl-2" id="discount"> 
                                            <span class="text-danger" id="e_discount"></span>
                                        </div> 
                                    </div> 
                                   
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Remarks </label>
                                            <input type="text" name="comment" placeholder="Remarks" class="form-control pl-2" id="comment"> 
                                            <span class="text-danger" id="e_comment"></span>
                                        </div> 
                                    </div> 
                                    
                                </div>   
                           </div>   
                            
                        </div> 
                       </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info" name="updtSbmt" form="updateForm">Update</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>

        <!--Add Modal form---->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="addModallabel">Student Regitration</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>Comming Soon <img src="<?= base_url('assets/images/loader/ajax-loader.gif')?>" alt=""> </h5>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info" form="addForm">Add</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>
        
        <!--View Data Modal--->
        <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="updateModallabel"> <i class="fa fa-eye"></i> Student Information</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center" id="loader" style="display:none">
                            <img src="<?= base_url('assets/images/loader/ajax-loader.gif')?>" alt="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    
        <!--Send SMS Modal--->
        <div class="modal fade" id="smsModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="updateModallabel"> <i class="fa fa-eye"></i> Send SMS</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" id="smsForm">
                            <div class="form-group">
                                <label for="" class="text-muted">Sender Id </label>
                                <input type="text" class="form-control" maxlength="6" name="sender" id="sender">
                                <span class="text-danger" id="e_sender"></span>
                            </div>
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="sms_reg_id" name='reg_id'>
                                <label for="" class="text-muted">Write Message <span class="text-danger">*</span> </label>
                                <textarea name="message" id="message" cols="30" rows="5" class="form-control"></textarea>
                                <span class="text-danger" id="e_message"></span>
                            </div>
                        </form>
                        <div class="">
                            <span class="text-info">@name: for Name</span> | 
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info" form="smsForm">Send</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!--Make Payment--->
        <div class="modal fade" id="makePaymentModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="updateModallabel"> <i class="fa fa-rupee-sign"></i> Make Payment</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" id="paymentForm">
                            <div class="form-group">
                                <label for="" class="text-muted">Payment Amount </label>
                                <input type="hidden" class="form-control" id="payment_reg_id" name='reg_id'>
                                <input type="number" class="form-control" maxlength="6" name="amount" id="amount">
                                <span class="text-danger" id="e_amount"></span>
                            </div>
                            <div class="form-group">
                                <label for="" class="text-muted">Payment Date <span class="text-danger">*</span> </label>
                                <input type="date" class="form-control" value="<?= $today?>" id="payment_date" name='payment_date'>
                                <span class="text-danger" id="e_payment_date"></span>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info" form="paymentForm">Send</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>


<!---Ajax here-->

<script>
    //Make Payment
    function makePayment(x){
        $("#payment_reg_id").val(x);
        $("#amount").val("");
        $("#e_amount").html("");
        $("#e_payment_date").html("");
        $("#makePaymentModal").modal("show");
    }
    
    $(function(){
        $("#paymentForm").on("submit", function(e){
            e.preventDefault();
            $.ajax({
                url: "<?= base_url('regSetup/makePayment/manage')?>",
                type: "POST",
                data : $(this).serialize(),
                dataType: "json",
                success: function(response){
                    if(response["status"]==0){
                        $("#e_amount").html(response["amount"]);
                        $("#e_payment_date").html(response["payment_date"]);
                    }else{
                        $("#makePaymentModal").modal("hide");
                        Swal.fire(
                          response["alert"],
                          response["message"],
                          response["modal"]
                        )
                        
                        //Update payment row
                        $("#"+response["rowId"]).html(response["html"]);
                    }
                }
            });
        })
    });
    
    
    //For send sms
    function sendSma(id){
        $("#sms_reg_id").val(id);
        $("#sender").val("");
        $("#message").val("");
        $("#e_message").html("");
        
        $("#smsModal").modal("show");
    }
    $("body").on("submit", "#smsForm", function(e){
        e.preventDefault();
        $.ajax({
            url: "<?= base_url('regsetup/sendsms')?>",
            data: $(this).serialize(),
            type: "POST",
            dataType: "json",
            success: function(response){
                if(response["status"] == 0){
                    $("#e_message").html(response["reg_id"]);
                    $("#e_message").html(response["message"]);
                    $("#e_sender").html(response["sender"]);
                }else if(response["status"] == 1){
                    $("#e_message").html("");
                    $("#e_sender").html("");
                    //hide modal
                    $("#smsModal").modal("hide");
                    Swal.fire(
                      response["alert"],
                      response["message"],
                      'success'
                    )
                }else{
                    $("#e_message").html("");
                    $("#e_sender").html("");
                    //hide modal
                    $("#smsModal").modal("hide");
                    Swal.fire(
                      response["alert"],
                      response["message"],
                      'error'
                    )
                }
            }
        });
    });
    
    
    //Fill the District
    var arr = {
            Bihar:["Araria", "Arwal", "Aurangabad","Banka","Begusarai",,"Bhagalpur","Arrah","Buxar","Darbhanga","Motihari","Gaya","Gopalganj","Jamui","Jehanabad","Khagaria","Kishanganj","Bhabua","Katihar","Lakhisarai","Madhubani","Munger","Madhepura","Muzaffarpur","Bihar Sharif","Nawada","Patna","Purnia","Sasaram","Saharsa","Samastipur","Sheohar","Sheikhpura","Chhapra","Dumra,Sitamarhi ","Supaul","Siwan","Hajipur","Bettiah"],
            Jharkhand:["Bokaro","Chatra","Deoghar","Dhanbad","Dumka","Jamshedpur","Garhwa","Giridih","Godda","Gumla","Hazaribagh","Jamtara","Khunti","Koderma","Latehar","Lohardaga","Pakur","Daltonganj","Ramgarh","Ranchi","Sahebganj","Seraikela","Simdega","Chaibasa"],
            UP:["Agra","Aligarh","PrayagRaj","Akbarpur","Amroha","Auraiya","Azamgarh","Badaun","Bahraich","Ballia","Balrampur","Banda","Barabanki","Bareilly","Basti","Bijnor","Bulandshahr","Chandauli","Chitrakoot","Deoria","Etah","Etawah","Faizabad","Fatehgarh","Fatehpur","Firozabad","Noida","Ghaziabad","Ghazipur","Gonda","Gorakhpur","Hamirpur","Hapur","Hardoi","Hathras","Jaunpur","Jhansi","Kannauj","Kanpur","Kasganj","Manjhanpur","Padarauna","Kheri","Lalitpur","Lucknow","Maharajganj","Mahoba","Mainpuri","Mathura","Mau","Meerut","Mirzapur","Moradabad","Muzaffarnagar","Pilibhit","Pratapgarh","Rae Bareli","Rampur","Saharanpur","Khalilabad","Gyanpur","Sambhal","Shahjahanpur","Shamli","Shravasti","Navgarh","Sitapur","Robertsganj","Sultanpur","Unnao","Varanasi","Allahabad","Amethi","Bagpat"]
        };
    var select = ""
        
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
    
     //view modal
    function viewId(id){
        $("#viewModal").modal("show");  
        $.ajax({
            url: "<?= base_url('regsetup/viewInfo')?>", //https://jsonplaceholder.typicode.com/users
            type: "POST",
            data: {reg_id:id},
            dataType: "json",
            beforeSend: function(){
                $("#loader").show();
            },
            complete: function(){
                $("#loader").hide();
            },
            success: function(response){
                $("#viewModal .modal-body").html(response["html"]);
            }
            
        });
    }
    
    //delete
    function deleteData(id){
        $("#deleteModal").modal("show");
        $("#delete_reg_id").val(id);
        
        $("#alert").html("");
        
    }
    $(document).ready(function(){
        $("body").on("submit", "#deleteForm", function(e){
            e.preventDefault();
            $.ajax({
                url: '<?= base_url("regsetup/deleteData")?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){
                    $("#"+response["rowId"]).remove();
                    $("#deleteModal").modal("hide");
                    Swal.fire(
                      response["alert"],
                      response["message"],
                      response["modal"]
                    );
                }
            });
        })
    });

    //Get id for updating the data
    function getId(id){
        $("#updateModal").modal("show");
        $("#alert").html("");
        $("#e_student_name").html("");
        $("#e_gender").html("");
        $("#e_category").html("");
        $("#e_dob").html("");
        $("#e_father_name").html("");
        $("#e_mother_name").html("");
        $("#e_student-mobile").html("");
        $("#e_student_email").html("");
        $("#e_parent_mobile").html("");
        $("#e_parent_email").html("");
        $("#e_address").html("");
        $("#e_state").html("");
        $("#e_dist").html("");
        $("#e_pin_code").html("");
        $("#e_school_name").html("");
        $("#e_school").html("");
        $("#e_board").html("");
        $("#e_batch_id").html("");
        $("#e_payble_amount").html("");
        $("#e_discount").html("");
        $("#e_comment").html("");
        $.ajax({
                url: '<?= base_url("regsetup/getData")?>',
                type: 'POST',
                data: {reg_id:id},
                dataType: 'json',
                success: function(response){
                    //remove selected attribute from select box
                    $("#gender option").removeAttr("selected")
                    $("#category option").removeAttr("selected");
                    $("#state option").removeAttr("selected");
                    $("#dist option").removeAttr("selected");
                    
                    
                    $("#student_name").val(response["student_name"]);
                    $("#reg_id").val(response["reg_id"]);
                    $("#gender option[value="+response["gender"]+"]").attr('selected', 'selected');
                    $("#category option[value="+response["category"]+"]").attr('selected', 'selected');
                    $("#dob").val(response["dob"]);
                    $("#father_name").val(response["father_name"]);
                    $("#mother_name").val(response["mother_name"]);
                    $("#student_mobile").val(response["student_mobile"]);
                    $("#student_email").val(response["student_email"]);
                    $("#parent_mobile").val(response["parent_mobile"]);
                    $("#parent_email").val(response["parent_email"]);
                    $("#address").val(response["address"]);
                    $("#state option[value="+response["state"]+"]").attr('selected', 'selected');
                    //For district
                    
                    for(i=0; i<arr[response["state"]].length; i++){
                        select+="<option value="+arr[response["state"]][i]+">"+arr[response["state"]][i]+"</option>";
                    }
                    $("#dist").html(select);
                    
                    $("#dist option[value="+response["dist"]+"]").attr('selected', 'selected');
                    $("#pin_code").val(response["pin_code"]);
                    $("#school").val(response["school"]);
                    $("#board").val(response["board"]);
                    $("#batch_id option[value="+response["batch_id"]+"]").attr('selected', 'selected');
                    $("#payble_amount").val(response["fee_amount"]);
                    $("#discount").val(response["discount"]);
                    $("#comment").val(response["comment"]);
                }
        });
    }

    //Add data
    $(document).ready(function(){
        $("body").on("submit", "#addForm", function(e){
            e.preventDefault();
            $.ajax({
                url: '<?= base_url("batchsetup/addBatch/manage-add")?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){
                    if(response["status"] == 0){
                        //set error message 
                        $("#e_add_batch_name").html(response["batch_name"]);
                        $("#e_add_batch_medium").html(response["batch_medium"]);
                        $("#e_add_batch_seat").html(response["batch_seat"]);
                        $("#e_add_batch_fee").html(response["batch_fee"]);
                        $("#e_add_batch_start_date").html(response["batch_start_date"]);
                        $("#e_add_batch_start_time").html(response["batch_start_time"]);
                        $("#e_add_batch_end_time").html(response["batch_end_time"]);
                        $("#e_add_class_id").html(response["class_id"]);
                        $("#e_add_subject_id").html(response["subject_id"]);
                        $("#e_add_comment").html(response["comment"]);
                    }else if(response["status"] == 1){
                        //set blank value for error message
                        $("#e_add_batch_name").html("");
                        $("#e_add_batch_medium").html("");
                        $("#e_add_batch_seat").html("");
                        $("#e_add_batch_fee").html("");
                        $("#e_add_batch_start_date").html("");
                        $("#e_add_batch_start_time").html("");
                        $("#e_add_batch_end_time").html("");
                        $("#e_add_class_id").html("");
                        $("#e_add_subject_id").html("");
                        $("#e_add_comment").html("");

                        //set blank value after inserting the value
                        $("#add_batch_name").val("");
                        $("#add_batch_medium").val("");
                        $("#add_batch_seat").val("");
                        $("#add_batch_fee").val("");
                        $("#add_batch_start_date").val("");
                        $("#add_batch_start_time").val("");
                        $("#add_batch_end_time").val("");
                        $("#add_class_id").val("");
                        $("#add_subject_id").val("");
                        $("#add_comment").val("");
                        
                        //hide modal
                        $("#addModal").modal("hide");
                        //set message for alert box
                        Swal.fire(
                          response["alert"],
                          response["message"],
                          'success'
                        )
                        //add new row
                        $("#dataTable").append(response["lastRow"]);

                    }else{
                        $("#addModal").modal("hide");
                        //set blank value when some error occured
                        $("#add_batch_name").val("");
                        $("#add_batch_medium").val("");
                        $("#add_batch_seat").val("");
                        $("#add_batch_fee").val("");
                        $("#add_batch_start_date").val("");
                        $("#add_batch_start_time").val("");
                        $("#add_batch_end_time").val("");
                        $("#add_class_id").val("");
                        $("#add_subject_id").val("");
                        $("#add_comment").val("");
                        Swal.fire(
                          response["alert"],
                          response["message"],
                          'error'
                        )
                    }
                }
            });
        });

        
        //update data
        $("body").on("submit", "#updateForm", function(e){
            e.preventDefault();
            $.ajax({
                url: '<?= base_url("regsetup/updateRegData")?>',
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
                        $("#e_school").html(response["school"]);
                        $("#e_board").html(response["board"]);
                        $("#e_batch_id").html(response["batch_id"]);
                        $("#e_payble_amount").html(response["payble_amount"]);
                        $("#e_discount").html(response["discount"]);
                        $("#e_comment").html(response["comment"]);
                        
                        
                    }else if(response["status"] == 1){
                        //set blank value for error message
                        $("#e_student_name").html("");
                        $("#gender option").removeAttr("selected")
                        $("#category option").removeAttr("selected")
                        $("#dob").html("");
                        $("#father_name").html("");
                        $("#mother_name").html("");
                        $("#student_mobile").html("");
                        $("#student_email").html("");
                        $("#parent_mobile").html("");
                        $("#parent_email").html("");
                        $("#address").html("");
                        
                        
                        $("#state option").removeAttr("selected")
                        $("#dist option").removeAttr("selected");
                        $("#pincode").html("");
                        $("#school").html("");
                        $("#board").html("");
                        $("#batch_id option").removeAttr("selected");
                        $("#payble_amount").html("");
                        //set message for alert box
                        $("#updateModal").modal("hide");
                        
                        //set message for alert box
                        Swal.fire(
                          response["alert"],
                          response["message"],
                          'success'
                        )
                        
                        $("#"+response["rowId"]).html(response["updatedRow"]);

                    }else{
                        $("#updateModal").modal("hide");
                        $("#update_batch_name").val("");
                        $("#update_batch_status option").removeAttr("selected")
                        $("#update_batch_medium option").removeAttr("selected");
                        $("#update_batch_seat").val("");
                        $("#update_batch_fee").val("");
                        $("#update_batch_start_date").val("");
                        $("#update_batch_start_time").val("");
                        $("#update_batch_end_time").val("");
                        $("#update_subject_id option").removeAttr("selected");
                        $("#update_class_id option").removeAttr("selected");
                        $("#update_comment").val("");
                        //set message for alert box
                        Swal.fire(
                          response["alert"],
                          response["message"],
                          'error'
                        )
                    }
                }
            });
        });
        
        $("#addBtn").click(function(){
            $("#alert").html("");
        });
        $(".updateBtn").click(function(){
            $("#alert").html("");
        });

    });
</script>