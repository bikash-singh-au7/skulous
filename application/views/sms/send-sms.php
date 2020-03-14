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
                        <div class="col-md-12 p-0 m-0 border">
                            <div class="float-left px-2 py-2">
                                <span class="text-muted font-weight-bold"> <i class="fa fa-cog"></i> SMS Setup</span>
                            </div>
                            <div class="float-right px-2">
                                
                            </div>
                        </div>
                    </div>
                    <div class="">
                       <div class="row border">
                        <div class="col-md-8 p-2 table-responsive shadow-sm bg-white">
                            <table id="dataTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#Sn</th>
                                        <th>Operation</th>
                                        <th>No Of Student</th>
                                        
                                        <th class="text-center" style="width: 120px">Action</th>
                                    </tr> 
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>3</td>
                                        <td>Student</td>
                                        <td>
                                            <?php
                                                $noOfStudent = $this->work->count_data("registration", ["session_id"=>$this->session->userdata("session_id")], "id");
                                                echo $noOfStudent;
                                            ?>
                                        </td>
                                        <td><button class="btn btn-info" onclick="sendSms('student')"> <i class="fa fa-paper-plane"></i> Send SMS</button></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Inquiry</td>
                                        <td>
                                            <?php
                                                $noOfInquiry = $this->work->count_data("inquiry", ["session_id"=>$this->session->userdata("session_id")], "id");
                                                echo $noOfInquiry;
                                            ?>
                                        </td>
                                        <td><button class="btn btn-info" onclick="sendSms('inquiry')">  <i class="fa fa-paper-plane"></i> Send SMS</button></td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>Batch</td>
                                        <td>
                                            <?php
                                                $noOfStudent = $this->work->count_data("registration", ["session_id"=>$this->session->userdata("session_id")], "id");
                                                echo $noOfStudent;
                                            ?>
                                        </td>
                                        <td><button class="btn btn-info" onclick="sendSms('batch')"> <i class="fa fa-paper-plane"></i> Send SMS</button></td>
                                    </tr>
                                    
                                </tbody>
                            </table> 
                                
                        </div> 
                        <div class="col-md-4 shadow-sm bg-white">
                            <div class="">
                                <h6 class="h5 text-info py-2"> <i class="fa fa-envelope"></i> SMS Balence</h6>
                                <div class="text-center" id="loader" style="display:none">
                                    <img src="<?= base_url('assets/images/loader/ajax-loader.gif')?>" alt="">
                                </div>
                                <div id="smsBalance">
                                    
                                </div>
                            </div>
                        </div>
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
                            <div class="form-group" id="batch" style="display:none">
                                <label for="" class="text-muted">Select Batch </label>
                                <select name="batch_id" id="batch_id" class="form-control">
                                    <?php
                                        $batch_info = $this->work->select_data("batch", ["session_id"=>$this->session->userdata("session_id")]);
                                        foreach($batch_info as $batch){
                                            ?>
                                            <option value="<?= $batch->id?>"> <?= date("h:m A", strtotime($batch->batch_start_time))."-".date("h:m A", strtotime($batch->batch_end_time))?> </option>
                                            <?
                                        }     
                                          
                                    ?>
                                    
                                </select>
                                <span class="text-danger" id="e_batch_id"></span>
                            </div>
                            <div class="form-group">
                                <input type="hidden" class="form-control" name="action" id="action">
                               
                                <label for="" class="text-muted">Sender Id </label>
                                <input type="text" class="form-control" maxlength="6" minlength="6" name="sender" id="sender">
                                <span class="text-danger" id="e_sender"></span>
                            </div>
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="sms_reg_id" name='reg_id'>
                                <label for="" class="text-muted">Write Message <span class="text-danger">*</span> </label>
                                <textarea name="message" id="message" cols="30" rows="5" class="form-control"></textarea>
                                <span class="text-danger" id="e_message"></span>
                            </div>
                        </form>
                        
                        <div class="" id="smsFeatures">
                            
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info" form="smsForm">Send 
                            <span class="text-center" id="smsLoader" style="display:none">
                                <img src="<?= base_url('assets/images/loader/ajax-loader.gif')?>" alt="">
                            </span>
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        
                    </div>
                </div>
            </div>
        </div>
        
  

<!---Ajax here-->

<script>
 
    
    //For send sms
    function sendSms(action){
        $("#sender").val("");
        $("#message").val("");
        $("#e_message").html("");
        $("#batch").hide();
        
        $("#smsModal").modal("show");
        $("#action").val(action);
        if(action == "student"){
            msg = "<span class='text-info'>@name: for Name</span> | <span class='text-info'>@fee: for Dues Amount</span>"
            $("#smsFeatures").html(msg);
        }else if(action == "batch"){
            $("#batch").show();
            msg = "<span class='text-info'>@name: for Name</span> | <span class='text-info'>@fee: for Dues Amount</span>"
            $("#smsFeatures").html(msg);
        }else{
            msg = "<span class='text-info'>@name: for Name</span>"
            $("#smsFeatures").html(msg);
        }
        
        
    }
    
    $("body").on("submit", "#smsForm", function(e){
        e.preventDefault();
        if($("#action").val() == "student"){
            data = {action:"student"}
        }else if($("#action").val() == "inquiry"){
            data = {action:"inquiry"}
        }else if($("#action").val() == "batch"){
            batch_id = $("#batch_id").val();
            data = {action:"batch", batch_id:batch_id}
        }
        
        $.ajax({
            url:"<?= base_url('smssetup/noOfStudent')?>",
            type:"POST",
            data:data,
            dataType:"json",
            success:function(response){

                trans = $("#trans").html();
                if(response["student"] <= trans){
                    //Fire ajax
                    fire_ajax(data);
                }else{
                    $("#e_message").html("Not Enough SMS Balance, Please Recharge First");
                    fire_ajax = 0
                }
            }
        }); 
    });
    
    
    function fire_ajax(){
        $.ajax({
            url: "<?= base_url('smssetup/sendsms')?>",
            data: $("#smsForm").serialize(),
            type: "POST",
            dataType: "json",
            beforeSend:function(){
                $("#smsLoader").show()
            },
            complete:function(){
                $("#smsLoader").hide()
            },
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
                    //Update sms balance
                    smsBalance();
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
    }
    
    function smsBalance(){
        $("#loader").show();
        $("#smsBalance").html("");
        $.ajax({
            url:"<?= base_url('smssetup/smsBal')?>",
            type:"POST",
            data:{},
            dataType:"json",
            beforeSend: function(){
                $("#loader").show();
            },
            complete: function(){
                $("#loader").hide();
            },
            success:function(response){
                $("#smsBalance").html(response["html"]);
            }
        });
    }
    
    
    $(document).ready(function(){
        $.ajax({
            url:"<?= base_url('smssetup/smsBal')?>",
            type:"POST",
            data:{},
            dataType:"json",
            beforeSend: function(){
                $("#loader").show();
            },
            complete: function(){
                $("#loader").hide();
            },
            success:function(response){
                $("#smsBalance").html(response["html"]);
            }
        });
    });

</script>