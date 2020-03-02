<?php
    date_default_timezone_set("Asia/Kolkata");
    $today = date("d-m-Y");
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
                                <span class="text-muted font-weight-bold"> <i class="fa fa-cog"></i> Manage Inquiry</span>
                            </div>
                            <div class="float-right px-2">
                                <button class="btn btn-info px-2 my-1" type="button" data-toggle="modal" data-target="#addModal" id="addBtn"> <i class="fa fa-plus"></i> New Inquiry</button>
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
                                        <th>Mobile</th>
                                        <th>Subject</th>
                                        <th>Class</th>
                                        <th>Purpose</th>
                                        <th>Status</th>
                                        <th>Inquiry Date</th>
                                        
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
                                                <td class="text-center"><?= $value->student_mobile; ?></td>
                                                
                                                <td class="text-center">
                                                    <?php
                                                        $data = $this->work->select_data("subject", ["id"=>$value->subject_id]);
                                                        echo $data[0]->subject_name;
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                        $data = $this->work->select_data("classes", ["id"=>$value->class_id]);
                                                        echo $data[0]->class_name;
                                                    ?>
                                                </td>
                                                <td class="text-center"> <?= $value->inquiry_purpose?> </td>
                                                <td class="text-center">
                                                    <?php
                                                        
                                                        if($value->inquiry_status == 1){
                                                            $status = 1;
                                                            echo"<button onclick=statusChange('".$value->id."','0') class='badge badge-info rounded-0 border-0'>Resolved</button>";
                                                        }else{
                                                            $status = 0;
                                                            echo"<button onclick=statusChange('".$value->id."','1') class='badge badge-danger rounded-0 border-0'>Pending</button>";
                                                        }
                                                        
                                                    ?>
                                                </td>

                                                <td class="text-center">
                                                    <?php  
                                                        if(date("d-m-Y", strtotime($value->created_date)) == $today):
                                                            echo"Today";
                                                        else:
                                                            echo date("d-m-Y", strtotime($value->created_date));
                                                        endif;
                                                    ?>
                                                </td>
                                                
                                                
                                                
                                                <td class="text-center">
                                                    <button class="btn btn-info px-2 py-1" onclick="getId('<?= $value->id?>')"> <i class="fa fa-edit"></i> </button>
                                                    
                                                    <button class="btn btn-success px-2 py-1" onclick="viewId('<?= $value->id?>')"> <i class="fa fa-eye"></i> </button>
                                                    
                                                    <button class="btn btn-danger px-2 py-1" onclick="deleteData('<?= $value->id?>')"> <i class="fa fa-trash"></i> </button>
                                                    
                                                    <button class="btn btn-warning px-2 py-1" onclick="sendSms('<?= $value->id?>')"> <i class="fa fa-envelope"></i> </button>
                                                    
                                                
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
        
        <!--Status Modal---->
        <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="deleteModallabel">Update Status</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img class="img img-responsive" height=100 src="<?= base_url('assets/images/smily.png')?>" alt="">
                    <h5 class="text-muted">Do you want to update?</h5>
                </div>
                <div class="m-auto pb-2">
                    <form action="" method="post" id="statusForm">
                        <input type="hidden" value="" name="inquiry_id" id="update_inquiry_id">
                        <input type="hidden" value="" name="inquiry_status" id="inquiry_status">
                        <button type="submit" class="btn btn-info" name="">Update</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </form>
                                                            
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
                        <input type="hidden" value="" name="inquiry_id" id="delete_inquiry_id">
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
                    <form method="post" action="" class="" id="updateForm" class="bg-white">
                       <div class="bg-white mt-2">
                           <div class="row p-0 bg-white">
                                <div class="col-md-12 border p-0">
                                    <p class="p-1 text-info bg-light" style=""> <strong> <i class="fa fa-user"></i> Personal Details</strong></p>
                                    <div class="row px-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Student Name <span class="text-danger">*</span></label>
                                                <input type="text" name="student_name" class="form-control pl-2" value="" placeholder="Student Name" id="update_student_name">
                                                <input type="hidden" name="inquiry_id" class="form-control pl-2" id="update_inquiry_id">
                                                <span class="text-danger" id="e_update_student_name"></span>
                                            </div> 
                                        </div> 
                                      
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Student Mobile <span class="text-danger">*</span></label>     
                                                <input type="tel" name="student_mobile" value="" class="form-control" placeholder="8757885800" id="update_student_mobile">
                                                <span class="text-danger" id="e_update_student_mobile"></span>
                                            </div>
                                        </div> 
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Student Email </label>     
                                                <input type="email" name="student_email" value="" class="form-control" placeholder="rahul@abc.com" id="update_student_email">
                                                <span class="text-danger" id="e_update_student_email"></span>
                                            </div>
                                        </div> 
                            
                            
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Address </label>     
                                                <input type="text" name="address" value="" id="update_address" class="form-control" placeholder="Enter Address">
                                                <span class="text-danger" id="e_update_address"></span>
                                            </div>
                                        </div>  
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">State <span class="text-danger">*</span></label>  
                                                <select name="state" class="form-control" id="update_state">
                                                    <option value="">--Select--</option>
                                                    <option value="Bihar">Bihar</option>
                                                    <option value="Jharkhand">Jharkhand</option>
                                                    <option value="UP">UP</option>
                                                </select>
                                                <span class="text-danger" id="e_update_state"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Dist <span class="text-danger">*</span></label>
                                                <select name="dist" class="form-control" id="update_dist">
                                                    <option value="">-Select-</option>
                                                </select>
                                                <span class="text-danger" id="e_update_dist"></span>
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
                                        
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="font-weight-bold">Select Class<span class="text-danger">*</span></label>
                                            <select id="update_class_id" class="form-control" name="class_id">
                                                <option value="">--Select--</option>
                                                <?php
                                                    foreach($class as $value){
                                                        ?>
                                                        <option value="<?= $value->id?>"> <?= $value->class_name?> </option>
                                                        <?
                                                    }

                                                ?>
                                            </select>
                                            <span class="text-danger" id="e_update_class_id"></span>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="font-weight-bold">Select Subject<span class="text-danger">*</span></label>
                                            <select id="update_subject_id" class="form-control" name="subject_id">
                                                <option value="">--Select--</option>
                                                <?php
                                                    foreach($subject as $value){
                                                        ?>
                                                        <option value="<?= $value->id?>"> <?= $value->subject_name?> </option>
                                                        <?
                                                    }

                                                ?>
                                            </select>
                                            <span class="text-danger" id="e_update_subject_id"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="font-weight-bold">Select Medium<span class="text-danger">*</span></label>
                                            <select id="update_medium" class="form-control" name="medium">
                                                <option value="">--Select--</option>
                                                <option value="HINDI">HINDI</option>
                                                <option value="ENGLISH">ENGLISH</option>
                                                
                                            </select>
                                            <span class="text-danger" id="e_update_medium"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="font-weight-bold">Inquiry Purpose</label>
                                            <input type="text" id="update_inquiry_purpose" name="inquiry_purpose" placeholder="Purpose" class="form-control pl-2"> 
                                            <span class="text-danger" id="e_update_inquiry_purpose"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Remarks </label>
                                            <input type="text" name="comment" placeholder="Remarks" class="form-control pl-2" id="update_comment"> 
                                            <span class="text-danger" id="e_update_comment"></span>
                                        </div> 
                                    </div> 
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Refreances </label>
                                            <input type="text" id="update_refrence" name="refrence" placeholder="Refrence" class="form-control pl-2"> 
                                            <span class="text-danger" id="e_update_refrence"></span>
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
                                <input type="hidden" class="form-control" id="sms_inquiry_id" name='inquiry_id'>
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
    </div>
</div>


<!---Ajax here-->

<script>
    //Change Status
    function statusChange(id, status){
        $("#statusModal").modal("show");
        $("#update_inquiry_id").val(id)
        $("#inquiry_status").val(status)
    }
    $("body").on("submit", "#statusForm", function(e){
        e.preventDefault();
        $.ajax({
            url: "<?= base_url('inquirysetup/updateStatus')?>",
            data: $(this).serialize(),
            type: "POST",
            dataType: "json",
            success: function(response){
                if(response["status"] == 0){
                    $("#statusModal").modal("hide");
                    Swal.fire(
                      response["alert"],
                      response["message"],
                      'error'
                    )
                    
                }else if(response["status"] == 1){
                    //hide modal box
                    $("#statusModal").modal("hide");

                    //set message for alert box
                    Swal.fire(
                      response["alert"],
                      response["message"],
                      'success'
                    )

                    $("#"+response["rowId"]).html(response["updatedRow"]);
                }else{
                    //hide modal
                    $("#statusModal").modal("hide");
                    Swal.fire(
                      response["alert"],
                      response["message"],
                      'error'
                    )
                }
            }
        });
    });
    //For send sms
    function sendSms(id){
        $("#sms_inquiry_id").val(id);
        $("#sender").val("");
        $("#message").val("");
        $("#e_message").html("");
        
        $("#smsModal").modal("show");
    }
    $("body").on("submit", "#smsForm", function(e){
        e.preventDefault();
        $.ajax({
            url: "<?= base_url('inquirysetup/sendsms')?>",
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
        
        $("#update_state").change(function(){
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
            $("#update_dist").html(select);
        })
    
     //view modal
    function viewId(id){
        $("#viewModal").modal("show");  
        $.ajax({
            url: "<?= base_url('inquirysetup/viewInfo')?>", //https://jsonplaceholder.typicode.com/users
            type: "POST",
            data: {inquiry_id:id},
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
        $("#delete_inquiry_id").val(id);
        
    }
    $(document).ready(function(){
        $("body").on("submit", "#deleteForm", function(e){
            e.preventDefault();
            $.ajax({
                url: '<?= base_url("inquirysetup/deleteData")?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){
                    $("#"+response["rowId"]).remove();
                    $("#deleteModal").modal("hide");
                    Swal.fire(
                      response["alert"],
                      response["message"],
                      'success'
                    )
                }
            });
        })
    });

    //Get id for updating the data
    function getId(id){
        $("#updateModal").modal("show");
        $("#e_update_student_name").html("");
        $("#e_update_student-mobile").html("");
        $("#e_update_student_email").html("");
        
        $("#e_update_address").html("");
        $("#e_update_state").html("");
        $("#e_update_dist").html("");
        
        $("#e_update_class_id").html("");
        $("#e_update_subject_id").html("");
        $("#e_update_medium").html("");
        $("#e_update_enquiry_purpose").html("");
        $("#e_update_comment").html("");
        $("#e_update_refrence").html("");
        $.ajax({
                url: '<?= base_url("inquirysetup/getData")?>',
                type: 'POST',
                data: {inquiry_id:id},
                dataType: 'json',
                success: function(response){
                    //remove selected attribute from select box
                    $("#update_state option").removeAttr("selected")
                    $("#update_dist option").removeAttr("selected")
                    $("#update_class_id option").removeAttr("selected")
                    $("#update_subject_id option").removeAttr("selected")
                    $("#update_medium option").removeAttr("selected")
                    
                    
                    $("#update_inquiry_id").val(response["inquiry_id"]);
                    $("#update_student_name").val(response["student_name"]);
                    $("#update_student_mobile").val(response["student_mobile"]);
                    $("#update_student_email").val(response["student_email"]);
                    $("#update_address").val(response["address"]);
                    
                    $("#update_state option[value="+response["state"]+"]").attr('selected', 'selected');
                    //For district
                    
                    for(i=0; i<arr[response["state"]].length; i++){
                        select+="<option value="+arr[response["state"]][i]+">"+arr[response["state"]][i]+"</option>";
                    }
                    $("#update_dist").html(select);
                    
                    $("#update_dist option[value="+response["dist"]+"]").attr('selected', 'selected');
                   
                    $("#update_class_id option[value="+response["class_id"]+"]").attr('selected', 'selected');
                    $("#update_subject_id option[value="+response["subject_id"]+"]").attr('selected', 'selected');
                    $("#update_medium option[value="+response["medium"]+"]").attr('selected', 'selected');
                    $("#update_inquiry_purpose").val(response["inquiry_purpose"]);
                    $("#update_comment").val(response["comment"]);
                    $("#update_refrence").val(response["refrence"]);
                    
                }
        });
    }

    //Add data
    $(document).ready(function(){
        //Add Data
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
                url: '<?= base_url("inquirysetup/updateData")?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){
                    if(response["status"] == 0){
                        //set error message 
                        $("#e_update_student_name").html(response["student_name"]);
                        $("#e_update_student_mobile").html(response["student_mobile"]);
                        $("#e_update_student_email").html(response["student_email"]);
                        $("#e_update_address").html(response["address"]);
                        $("#e_update_state").html(response["state"]);
                        $("#e_update_dist").html(response["dist"]);
                        $("#e_update_class_id").html(response["class_id"]);
                        $("#e_update_subject_id").html(response["subject_id"]);
                        $("#e_update_medium").html(response["medium"]);
                        $("#e_update_inquiry_purpose").html(response["inquiry_purpose"]);
                        $("#e_update_comment").html(response["comment"]);
                        $("#e_update_refrence").html(response["refrence"]);
                        
                        
                        
                    }else if(response["status"] == 1){
                        //set blank value for error message
                        $("#e_update_student_name").html("");
                        $("#e_update_student_email").html("");
                        $("#e_update_student_mobile").html("");
                        $("#update_state option").removeAttr("selected")
                        $("#update_dist option").removeAttr("selected")
                        $("#update_class_id option").removeAttr("selected")
                        $("#update_subject_id option").removeAttr("selected")
                        $("#update_medium option").removeAttr("selected")
                        
                        $("#update_address").html("");
                        $("#update_inquiry_purpose").html("");
                        $("#update_comment").html("");
                        $("#update_refrence").html("");
                        
                        
                        
                        //hide modal box
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
                        $("#e_update_student_name").html("");
                        $("#e_update_student_email").html("");
                        $("#e_update_student_mobile").html("");
                        $("#update_state option").removeAttr("selected")
                        $("#update_dist option").removeAttr("selected")
                        $("#update_class_id option").removeAttr("selected")
                        $("#update_subject_id option").removeAttr("selected")
                        $("#update_medium option").removeAttr("selected")
                        
                        $("#update_address").html("");
                        $("#update_inquiry_purpose").html("");
                        $("#update_comment").html("");
                        $("#update_refrence").html("");
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