<div class="container-fluid">
    <div class="row p-0">
        <div class="col-md-6 m-auto">
            <div class="page-header">
               <div class="inner-content">
                   <!-- Batch Details --> 
                   <div class="row">
                        <div class="col-md-12 p-0 m-0" id="alert">
                            
                        </div>
                        <div class="col-md-12 p-0 m-0 border bg-white">
                            <div class="float-left px-2 py-2">
                                <span class="text-muted font-weight-bold"> <i class="fa fa-plus"></i> Add Batch </span>
                            </div>
                            <div class="float-right px-2">
                                <a href="<?= base_url('batchsetup/batch/manage')?>">
                                    <button class="btn btn-info px-2 my-1" type="button"> <i class="fa fa-cog"></i> Manage Batch </button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <form method="post" action="" class="" id="addForm">
                       <div class="row border pt-2">
                         <div class="col-md-12 m-auto">
                            <div class="form-group">
                                <label for="">Batch name <span class="text-danger">*</span></label>
                                <input type="text" name="batch_name" class="form-control" value="" placeholder="Enter Batch Name">
                                <span class="text-danger" id="e_batch_name"></span>
                            </div>

                            <div class="form-group">
                                <label for="">Batch Medium <span class="text-danger">*</span></label>
                                <select name="batch_medium" id="" class="form-control">
                                    <option name="" id="" value="">--Select--</option>
                                    <option value="HINDI">HINDI</option>
                                    <option value="ENGLISH">ENGLISH</option>
                                </select>
                                <span class="text-danger" id="e_batch_medium"></span>
                            </div>
                            <div class="form-group">
                                <label for="">Batch Seat <span class="text-danger">*</span></label>
                                <input type="number" name="batch_seat" value="" class="form-control" placeholder="Enter no of seat">
                                <span class="text-danger" id="e_batch_seat"></span>
                            </div>
                            
                            <div class="form-group">
                                <label for="">Batch Fee <span class="text-danger">*</span></label>
                                <input type="number" name="batch_fee" value="" class="form-control" placeholder="Enter fee for this batch">
                                <span class="text-danger" id="e_batch_fee"></span>
                            </div>
                            
                            <div class="form-group">
                                <label for="">Discount Amount </label>
                                <input type="number" name="discount" value="" class="form-control" placeholder="Enter Discount amount">
                                <span class="text-danger" id="e_discount"></span>
                            </div>
                            
                            <div class="form-group">
                                <label for="">Batch Starting Date <span class="text-danger">*</span></label>
                                <input type="date" name="batch_start_date" class="form-control" value="">
                                <span class="text-danger" id="e_batch_start_date"></span>
                            </div>

                            <div class="form-group">
                                <label for="">Batch Time From <span class="text-danger">*</span></label>
                                <input type="time" name="batch_start_time" class="form-control" value="" min="04:00" max="22:00">
                                <span class="text-danger" id="e_batch_start_time"></span>
                            </div>

                            <div class="form-group">
                                <label for="">Batch Time End <span class="text-danger">*</span></label>
                                <input type="time" name="batch_end_time" class="form-control" value="" min="04:00" max="22:00">
                                <span class="text-danger" id="e_batch_end_time"></span>
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
                                <span class="text-danger" id="e_class_id"></span>
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
                                <span class="text-danger" id="e_subject_id"></span>
                            </div>

                            <div class="form-group">
                                <label for="">Comment</label>
                                <input type="text" name="comment" class="form-control" value="" placeholder="Comments Here">
                                <span class="text-danger" id="e_comment"></span>
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



<!---Ajax here-->
<script>
    $(document).ready(function(){
        $("body").on("submit", "#addForm", function(e){
            e.preventDefault();
            $.ajax({
                url: '<?= base_url("batchsetup/addBatch/add")?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){
                    if(response["status"] == 0){
                        //set error message 
                        $("#e_batch_name").html(response["batch_name"]);
                        $("#e_batch_medium").html(response["batch_medium"]);
                        $("#e_batch_seat").html(response["batch_seat"]);
                        $("#e_batch_fee").html(response["batch_fee"]);
                        $("#e_discount").html(response["discount"]);
                        $("#e_batch_start_date").html(response["batch_start_date"]);
                        $("#e_batch_start_time").html(response["batch_start_time"]);
                        $("#e_batch_end_time").html(response["batch_end_time"]);
                        $("#e_class_id").html(response["class_id"]);
                        $("#e_subject_id").html(response["subject_id"]);
                        $("#e_comment").html(response["comment"]);
                    }else{
                        //set blank value for error message
                        $("#e_batch_name").html("");
                        $("#e_batch_medium").html("");
                        $("#e_batch_seat").html("");
                        $("#e_batch_fee").html("");
                        $("#e_discount").html("");
                        $("#e_batch_start_date").html("");
                        $("#e_batch_start_time").html("");
                        $("#e_batch_end_time").html("");
                        $("#e_class_id").html("");
                        $("#e_subject_id").html("");
                        $("#e_comment").html("");

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