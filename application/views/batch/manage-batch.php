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
                                <span class="text-muted font-weight-bold"> <i class="fa fa-cog"></i> Manage Batch</span>
                            </div>
                            <div class="float-right px-2">
                                <button class="btn btn-info px-2 my-1" type="button" data-toggle="modal" data-target="#addModal" id="addBtn"> <i class="fa fa-plus"></i> Add Batch </button>
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
                                        <th>Batch</th>
                                        <th>Status</th>
                                        <th>Class</th>
                                        <th>Subject</th>
                                        <th>Medium</th>
                                        <th>Timing</th>
                                        <th class="text-center">Edit</th>
                                        <th class="text-center">Show</th>
                                        <th class="text-center">Delete</th>
                                    </tr> 
                                </thead>
                                <tbody>
                                    <?php
                                        foreach($data as $value){
                                        ?>
                                            <tr id="row-<?=$value->id?>">
                                                <td><?=$value->id?></td>
                                                <td><?=$value->batch_name?></td>
                                                <td class="text-center">
                                                    <?php
                                                        if($value->batch_status == 1){
                                                            $status = 1;
                                                            echo"<span class='badge badge-info'>Active</span>";
                                                        }else{
                                                            $status = 0;
                                                            echo"<span class='badge badge-danger'>Disable</span>";
                                                        }
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                        $data = $this->work->select_data("classes", ["id"=>$value->class_id]);
                                                        echo $data[0]->class_name;
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                        $data = $this->work->select_data("subject", ["id"=>$value->subject_id]);
                                                        echo $data[0]->subject_name;
                                                    ?>
                                                </td>
                                                <td class="text-center"><?=$value->batch_medium?></td>

                                                <td class="text-center"><?= date("h:m A", strtotime($value->batch_start_time))."-".date("h:m A", strtotime($value->batch_end_time)) ?></td>
                                                
                                                <td class="text-center"><button class="btn btn-info px-2 py-1" onclick="getId('<?= $value->id?>')"> <i class="fa fa-edit"></i> </button></td>
                                                
                                                <td class="text-center"><button class="btn btn-success px-2 py-1" onclick="viewId('<?= $value->id?>')"> <i class="fa fa-eye"></i> </button></td>
                                                
                                                <td class="text-center"><button class="btn btn-danger px-2 py-1" onclick="deleteData('<?= $value->id?>')"> <i class="fa fa-trash"></i> </button></td>
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
        
        <!--Delete Batch Modal---->
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
                        <input type="hidden" value="" name="batch_id" id="delete_batch_id">
                        <button type="submit" class="btn btn-danger" name="delSbmt">Delete</button>
                        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    </form>
                                                            
                </div>
                </div>
            </div>
        </div>

        <!--Update Form-->
        <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="updateModallabel">Update Batch Information</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="updateForm">
                        <div class="row">
                            <div class="col-md-6 form-group">
                               <label for="">Batch name <span class="text-danger">*</span></label>
                               <input type="text" name="batch_name" class="form-control" value="" placeholder="Enter Batch Name" id="update_batch_name">
                               <input type="hidden" name="batch_id" class="form-control" value="" id="update_batch_id">
                               <span class="text-danger" id="e_update_batch_name"></span>
                            </div>
                            <div class="col-md-6 form-group">
                               <label for="">Status <span class="text-danger">*</span></label>
                               <select name="batch_status" id="update_batch_status" class="form-control">
                                   <option value="1">Active</option>
                                   <option value="0">Disable</option>
                               </select>
                               <span class="text-danger" id="e_update_batch_status"></span>
                            </div>
                            
                            <div class="col-md-6 form-group">
                                <label for="">Batch Medium <span class="text-danger">*</span></label>
                                <select name="batch_medium" id="update_batch_medium" class="form-control">
                                    <option name="" id="">--Select--</option>
                                    <option value="HINDI">HINDI</option>
                                    <option value="ENGLISH">ENGLISH</option>
                                </select>
                                <span class="text-danger" id="e_update_batch_medium"></span>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="">Batch Seat <span class="text-danger">*</span></label>
                                <input type="number" name="batch_seat" id="update_batch_seat" value="" class="form-control" placeholder="Enter no of seat">
                                <span class="text-danger" id="e_update_batch_seat"></span>
                            </div>
                            
                            
                            <div class="col-md-6 form-group">
                                <label for="">Batch Fee <span class="text-danger">*</span></label>
                                <input type="number" name="batch_fee" value="" class="form-control" placeholder="Enter fee for this batch" id="update_batch_fee">
                                <span class="text-danger" id="e_update_batch_fee"></span>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="">Batch Starting Date <span class="text-danger">*</span></label>
                                <input type="date" name="batch_start_date" class="form-control" value="" id="update_batch_start_date">
                                <span class="text-danger" id="e_update_batch_start_date"></span>
                            </div>
                                
                            <div class="col-md-6 form-group">
                                <label for="">Batch Time From <span class="text-danger">*</span></label>
                                <input type="time" name="batch_start_time" class="form-control" value="" id="update_batch_start_time">
                                <span class="text-danger" id="e_update_batch_start_time"></span>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="">Batch Time End <span class="text-danger">*</span></label>
                                <input type="time" name="batch_end_time" class="form-control" value="" id="update_batch_end_time">
                                <span class="text-danger" id="e_update_batch_end_time"></span>
                            </div>
                            
                            <div class="col-md-6 form-group">
                                <label for="">Select Class <span class="text-danger">*</span></label>
                                <select id="update_class_id" class="form-control" name="class_id">
                                    <option value="">--Select--</option>
                                    <?php
                                        foreach($classes as $c){
                                            ?>
                                            <option value="<?= $c->id?>"> <?= $c->class_name?> </option>
                                            <?
                                        }

                                    ?>
                                </select>
                                <span class="text-danger" id="e_update_class_id"></span>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="">Select Subject<span class="text-danger">*</span></label>
                                <select id="update_subject_id" class="form-control" name="subject_id">
                                    <option value="">--Select--</option>
                                    <?php
                                        foreach($subject as $s){
                                            ?>
                                            <option value="<?= $s->id?>"> <?= $s->subject_name?> </option>
                                            <?
                                        }

                                    ?>
                                </select>
                                <span class="text-danger" id="e_update_subject_id"></span>
                            </div>
                            
                            <div class="col-md-6 form-group">
                                <label for="">Comment</label>
                                <input type="text" name="comment" class="form-control" value="" placeholder="Comments Here" id="update_comment">
                                <span class="text-danger" id="e_update_comment"></span>
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

        <!--Add form---->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="addModallabel">Add Batch</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="addForm">
                        <div class="form-group">
                            <label for="">Batch name <span class="text-danger">*</span></label>
                            <input type="text" name="batch_name" class="form-control" value="" placeholder="Enter Batch Name" id="add_batch_name">
                            <span class="text-danger" id="e_add_batch_name"></span>
                        </div>

                        <div class="form-group">
                            <label for="">Batch Medium <span class="text-danger">*</span></label>
                            <select name="batch_medium" id="add_batch_medium" class="form-control">
                                <option name="" id="" value="">--Select--</option>
                                <option value="HINDI">HINDI</option>
                                <option value="ENGLISH">ENGLISH</option>
                            </select>
                            <span class="text-danger" id="e_add_batch_medium"></span>
                        </div>
                            
                        <div class="form-group">
                            <label for="">Batch Seat <span class="text-danger">*</span></label>
                            <input type="number" name="batch_seat" value="" class="form-control" placeholder="Enter no of seat" id="add_batch_seat">
                            <span class="text-danger" id="e_add_batch_seat"></span>
                        </div>
                            
                        <div class="form-group">
                            <label for="">Batch Fee <span class="text-danger">*</span></label>
                            <input type="number" name="batch_fee" value="" class="form-control" placeholder="Enter fee for this batch" id="add_batch_fee">
                            <span class="text-danger" id="e_add_batch_fee"></span>
                        </div>

                        <div class="form-group">
                            <label for="">Batch Starting Date <span class="text-danger">*</span></label>
                            <input type="date" name="batch_start_date" class="form-control" value="" id="add_batch_start_date">
                            <span class="text-danger" id="e_add_batch_start_date"></span>
                        </div>

                        <div class="form-group">
                            <label for="">Batch Time From <span class="text-danger">*</span></label>
                            <input type="time" name="batch_start_time" class="form-control" value="" id="add_batch_start_time">
                            <span class="text-danger" id="e_add_batch_start_time"></span>
                        </div>

                        <div class="form-group">
                            <label for="">Batch Time End <span class="text-danger">*</span></label>
                            <input type="time" name="batch_end_time" class="form-control" value="" id="add_batch_end_time">
                            <span class="text-danger" id="e_add_batch_end_time"></span>
                        </div>

                        <div class="form-group">
                            <label for="">Select Class <span class="text-danger">*</span></label>
                            <select id="add_class_id" class="form-control" name="class_id">
                                <option value="">--Select--</option>
                                <?php
                                    foreach($classes as $value){
                                        ?>
                                        <option value="<?= $value->id?>"> <?= $value->class_name?> </option>
                                        <?
                                    }

                                ?>
                            </select>
                            <span class="text-danger" id="e_add_class_id"></span>
                        </div>

                        <div class="form-group">
                            <label for="">Select Subject<span class="text-danger">*</span></label>
                            <select id="add_subject_id" class="form-control" name="subject_id">
                                <option value="">--Select--</option>
                                <?php
                                    foreach($subject as $value){
                                        ?>
                                        <option value="<?= $value->id?>"> <?= $value->subject_name?> </option>
                                        <?
                                    }

                                ?>
                            </select>
                            <span class="text-danger" id="e_add_subject_id"></span>
                        </div>

                        <div class="form-group">
                            <label for="">Comment</label>
                            <input type="text" name="comment" class="form-control" value="" placeholder="Comments Here" id="add_comment">
                           <span class="text-danger" id="e_add_comment"></span>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info" form="addForm">Add</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>
        
        <!--View Modal--->
        <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="updateModallabel"> <i class="fa fa-eye"></i> Batch Information</h6>
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
    </div>
</div>


<!---Ajax here-->

<script>
    
     //view modal
    function viewId(id){
        $("#viewModal").modal("show");  
        $.ajax({
            url: "<?= base_url('batchsetup/viewInfo')?>", //https://jsonplaceholder.typicode.com/users
            type: "POST",
            data: {batch_id:id},
            dataType: "json",
            beforeSend: function(){
                $("#loader").show();
            },
            complete: function(){
                $("#loader").hide();
            },
            success: function(response){
                /*var result = "";
                for(var i in response){
                    result+=" <p>postId: "+ i.id +" <p>name: "+ i.name +"</p> <p>email: ${data[i].username} </p>  ";
                }
                $("#viewModal .modal-body").html(result);*/
                $("#viewModal .modal-body").html(response["html"]);
            }
            
        });
    }
    
    //delete
    function deleteData(id){
        $("#deleteModal").modal("show");
        $("#delete_batch_id").val(id);
        
        $("#alert").html("");
        
    }
    
    $(document).ready(function(){
        $("body").on("submit", "#deleteForm", function(e){
            e.preventDefault();
            $.ajax({
                url: '<?= base_url("batchsetup/deleteData")?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){
                    $("#"+response["rowId"]).remove();
                    $("#deleteModal").modal("hide");
                    $("#alert").html(response["alert"]);
                }
            });
        })
    });

    //Get id for updating the data
    function getId(id){
        $("#updateModal").modal("show");
        $("#alert").html("");
        $("#e_update_batch_name").html("");
        $("#e_update_batch_status").html("");
        $("#e_update_batch_medium").html("");
        $("#e_update_batch_fee").html("");
        $("#e_update_batch_seat").html("");
        $("#e_update_batch_start_date").html("");
        $("#e_update_batch_start_time").html("");
        $("#e_update_batch_end_time").html("");
        $("#e_update_class_id").html("");
        $("#e_update_subject_id").html("");
        $("#e_update_comment").html("");
        $.ajax({
                url: '<?= base_url("batchsetup/getData")?>',
                type: 'POST',
                data: {batch_id:id},
                dataType: 'json',
                success: function(response){
                    //remove selected attribute from select box
                    $("#update_batch_status option").removeAttr("selected")
                    $("#update_batch_medium option").removeAttr("selected");
                    $("#update_subject_id option").removeAttr("selected");
                    $("#update_class_id option").removeAttr("selected");
                    
                    
                    $("#update_batch_id").val(response["batch_id"]);
                    $("#update_batch_name").val(response["batch_name"]);
                    $("#update_batch_status option[value="+response["batch_status"]+"]").attr('selected', 'selected');
                    $("#update_batch_medium option[value="+response["batch_medium"]+"]").attr('selected', 'selected');
                    $("#update_batch_seat").val(response["batch_seat"]);
                    $("#update_batch_fee").val(response["batch_fee"]);
                    $("#update_batch_start_date").val(response["batch_start_date"]);
                    $("#update_batch_start_time").val(response["batch_start_time"]);
                    $("#update_batch_end_time").val(response["batch_end_time"]);
                    $("#update_subject_id option[value="+response["subject_id"]+"]").attr('selected', 'selected');
                    $("#update_class_id option[value="+response["class_id"]+"]").attr('selected', 'selected');
                    $("#update_comment").val(response["comment"]);
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
                        $("#alert").html(response["alert"]);
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
                        $("#alert").html(response["alert"]);
                    }
                }
            });
        });

        
        //update
        $("body").on("submit", "#updateForm", function(e){
            e.preventDefault();
            $.ajax({
                url: '<?= base_url("batchsetup/updateBatch")?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){
                    if(response["status"] == 0){
                        //set error message 
                        $("#e_update_batch_name").html(response["batch_name"]);
                        $("#e_update_batch_status").html(response["batch_status"]);
                        $("#e_update_batch_medium").html(response["batch_medium"]);
                        $("#e_update_batch_seat").html(response["batch_seat"]);
                        $("#e_update_batch_fee").html(response["batch_fee"]);
                        $("#e_update_batch_start_date").html(response["batch_start_date"]);
                        $("#e_update_batch_start_time").html(response["batch_start_time"]);
                        $("#e_update_batch_end_time").html(response["batch_end_time"]);
                        $("#e_update_subject_id").html(response["subject_id"]);
                        $("#e_update_class_id").html(response["class_id"]);
                        
                    }else if(response["status"] == 1){
                        //set blank value for error message
                        $("#e_update_batch_name").html("");
                        $("#e_update_batch_status").html("");
                        $("#e_update_batch_medium").html("");
                        $("#e_update_batch_seat").html("");
                        $("#e_update_batch_fee").html("");
                        $("#e_update_batch_start_date").html("");
                        $("#e_update_batch_start_time").html("");
                        $("#e_update_batch_end_time").html("");
                        $("#e_update_subject_id").html("");
                        $("#e_update_class_id").html("");
                        $("#e_update_comment").html("");
                        
                        //remove selected attributes
                        $("#update_batch_status option").removeAttr("selected")
                        $("#update_batch_medium option").removeAttr("selected");
                        $("#update_subject_id option").removeAttr("selected");
                        $("#update_class_id option").removeAttr("selected");
                        //set message for alert box
                        $("#updateModal").modal("hide");
                        $("#alert").html(response["alert"]);
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
                        $("#alert").html(response["alert"]);
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