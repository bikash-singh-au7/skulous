<?php
    date_default_timezone_set("Asia/Kolkata");
    $today = date("Y-m-d");
?>   

<div class="container-fluid">
    <div class="row p-0">
        <div class="col-md-7 m-auto">
            <div class="page-header">
               <div class="inner-content">
                   <!-- Registration Details --> 
                   <div class="row">
                        <div class="col-md-12 p-0 m-0 border">
                            <div class="float-left px-2 py-2">
                                <span class="text-muted font-weight-bold"> <i class="fa fa-users"></i> Make Payment </span>
                            </div>
                            <div class="float-right px-2">
                                <a href="<?= base_url('paymentsetup/payment/manage')?>">
                                    <button class="btn btn-info px-2 my-1" type="button"> <i class="fa fa-cog"></i> Manage Payment </button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <form method="post" action="" class="" id="searchForm" class="bg-white">
                       <div class="bg-white mt-2">
                           <div class="row p-0 bg-white">
                                <div class="col-md-12 border p-0">
                                    <div class="row px-2">
                                        <div class="col-md-12">
                                            <div class="input-group my-3">
                                                <input type="search" name="search" class="form-control pl-2 rounded-0" value="" placeholder="Search Here!! (Name, Father, Mother, DOB...)" id="search" autofocus autocomplete="off">
                                                <input type="submit" class="btn btn-info rounded-0" value="Search">
                                                <span class="text-danger" id="e_student_name"></span>
                                            </div>
                                            <div id="searchedData">
                                                
                                                <div id="searchedTable">
                                                    <table id="dataTable" class="table table-striped table-bordered">
                                                        <!--Data loading using Ajax  -->
                                                    </table>
                                                </div>
                                                <div class="text-center" id="loader" style="display:none">
                                                    <img src="<?= base_url('assets/images/loader/ajax-loader.gif')?>" alt="">
                                                </div>
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
                            <input type="hidden" class="form-control" id="reg_id" name='reg_id'>
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



<!---Ajax here-->
<script>
    //Make Payment
    function makePayment(x){
        $("#reg_id").val(x);
        $("#amount").val("");
        $("#e_amount").html("");
        $("#e_payment_date").html("");
        $("#makePaymentModal").modal("show");
    }
    
    $(function(){
        $("#paymentForm").on("submit", function(e){
            e.preventDefault();
            $.ajax({
                url: "<?= base_url('paymentSetup/makePayment')?>",
                type: "POST",
                data : $(this).serialize(),
                dataType: "json",
                success: function(response){
                    if(response["status"]==0){
                        $("#e_amount").html(response["amount"]);
                        $("#e_payment_date").html(response["payment_date"]);
                    }else{
                        $("#e_amount").html(response["amount"]);
                        $("#e_payment_date").html(response["payment_date"]);
                        $("#makePaymentModal").modal("hide");
                        Swal.fire(
                          response["alert"],
                          response["message"],
                          response["modal"]
                        )
                    }
                }
            });
        })
    });
    
    
    
    
    
    $(document).ready(function(){
        //Search Data
        $("#search").on("keyup", function(){
            $.ajax({
                url:"<?= base_url('paymentsetup/searchData')?>",
                type:"POST",
                data:$("#searchForm").serialize(),
                dataType:"json",
                beforeSend: function(){
                    $("#loader").show();
                },
                complete: function(){
                    $("#loader").hide();
                },
                success: function(response){
                    tHead = "<thead><tr><th>Name</th><th>Father</th><th>Batch</th><th>Amount</th><th>Pay</th></tr></thead>";
                    tHead+="<tbody>"+response["html"]+"</tbody>";
                    if(response["html"] == ''){
                        $("#searchedData #dataTable").html("<tr> <td colstan=5 class='text-danger'>Data not found</td> </td>");
                    }else{
                        if($("#search").val() == ""){
                            $("#searchedData #dataTable").html("");
                        }else{
                            $("#searchedData #dataTable").html(tHead);
                        }
                    }
                    
                }
                
            });
        })
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



