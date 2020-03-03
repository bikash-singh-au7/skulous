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
                                <span class="text-muted font-weight-bold"> <i class="fa fa-cog"></i> Manage Class</span>
                            </div>
                            <div class="float-right px-2">
                                <button class="btn btn-info px-2 my-1" type="button" data-toggle="modal" data-target="#addModal" id="addBtn"> <i class="fa fa-plus"></i> Add Class </button>
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
                                        <th>Class Name</th>
                                        <th>Status</th>
                                        <th>Comments</th>
                                        <th class="text-center">DOC</th>
                                        <th class="text-center">Edit</th>
                                        <th class="text-center">Delete</th>
                                    </tr> 
                                </thead>
                                <tbody>
                                    <?php
                                        foreach($data as $value){
                                        ?>
                                            <tr id="row-<?=$value->id?>">
                                                <td><?=$value->id?></td>
                                                <td><?=$value->class_name?></td>
                                                <td class="text-center">
                                                    <?php
                                                        if($value->class_status == 1){
                                                            $status = 1;
                                                            echo"<span class='badge badge-info'>Active</span>";
                                                        }else{
                                                            $status = 0;
                                                            echo"<span class='badge badge-danger'>Disable</span>";
                                                        }
                                                    ?>
                                                </td>
                                                <td><?=$value->comment?></td>
                                                <td class="text-center"><?=date("d-M-Y h:m:s A", strtotime($value->created_date))?></td>
                                                    
                                                <td><button class="btn btn-info px-2 py-1" onclick="getId('<?= $value->id?>')"> <i class="fa fa-edit"></i> </button></td>
                                                <td><button class="btn btn-danger px-2 py-1" onclick="deleteData('<?= $value->id?>')"> <i class="fa fa-trash"></i> </button></td>
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
        
        <!--Delete session Modal---->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="deleteSessionlabel">Delete Class</h6>
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
                        <input type="hidden" value="" name="class_id" id="delete_class_id">
                        <button type="submit" class="btn btn-danger" name="delSbmt">Delete</button>
                        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    </form>
                                                            
                </div>
                </div>
            </div>
        </div>

        <!--Update Form-->
        <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="updateClasslabel">Update Class</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="updateForm">
                        <div class="form-group">
                            <label for="">Class name <span class="text-danger">*</span></label>
                            <input type="text" name="class_name" class="form-control" value="" placeholder="Enter class like 11th/12th" id="update_class_name">
                            <span class="text-danger" id="e_update_class_name"></span>
                            <input type="hidden" name="class_id" class="form-control" value="" id="update_class_id">
                        </div>
                                                                    
                        <div class="form-group">
                            <label for="">Status <span class="text-danger">*</span></label>
                            <select name="class_status" class="form-control update_class_status" id="update_class_status">
                                <option value="1">Active</option>
                                <option value="0">Disable</option>
                            </select>
                            
                        </div>

                        <div class="form-group">
                            <label for="">Comment</label>
                            <input type="text" name="comment" class="form-control" value="" placeholder="Comments Here" id="update_comment">
                            <span class="text-danger" id="e_update_comment"></span>
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
                    <h6 class="modal-title" id="addClasslabel">Add Class</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="addForm">
                        <div class="form-group">
                            <label for="">Class name <span class="text-danger">*</span></label>
                            <input type="text" name="class_name" class="form-control" value="" placeholder="Enter class like 11th/12th" id="add_class_name">
                            <span class="text-danger" id="e_add_class_name"></span>
                        </div>
                            
                        <div class="form-group">
                            <label for="">Comment</label>
                            <input type="text" name="comment" class="form-control" value="" placeholder="Enter Comment" id="add_comment">
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
    </div>
</div>


<!---Ajax here-->
<script>

    //delete
    function deleteData(id){
        $("#deleteModal").modal("show");
        $("#delete_class_id").val(id);
        
        $("#alert").html("");
        
    }
    
    $(document).ready(function(){
        $("body").on("submit", "#deleteForm", function(e){
            e.preventDefault();
            $.ajax({
                url: '<?= base_url("classsetup/deleteData")?>',
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
        $("#e_update_class_name").html("");
        $("#e_update_comment").html("");
        $.ajax({
                url: '<?= base_url("classsetup/getData")?>',
                type: 'POST',
                data: {class_id:id},
                dataType: 'json',
                success: function(response){
                    $("#update_class_id").val(response["class_id"]);
                    $("#update_class_name").val(response["class_name"]);
                    $("#update_comment").val(response["comment"]);
                    $(".update_class_status option[value="+response["class_status"]+"]").attr('selected', 'selected');
                }
        });
    }

    //Add data
    $(document).ready(function(){
        $("body").on("submit", "#addForm", function(e){
            e.preventDefault();
            $.ajax({
                url: '<?= base_url("classsetup/addClass/manage-add")?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){
                    if(response["status"] == 0){
                        //set error message 
                        $("#e_add_class_name").html(response["class_name"]);
                        $("#e_add_comment").html(response["coment"]);
                    }else{
                        //set blank value for error message
                        $("#e_add_class_name").html("");
                        $("#e_add_comment").html("");

                        //set blank value after inserting the value
                        $("#add_class_name").val("");
                        $("#add_comment").val("");
                        
                        //hide modal
                        $("#addModal").modal("hide");
                        //set message for alert box
                        Swal.fire(
                          response["alert"],
                          response["message"],
                          response["modal"]
                        );
                        //add new row
                        $("#dataTable").append(response["lastRow"]);

                    }
                }
            });
        });


        
        //update
        $("body").on("submit", "#updateForm", function(e){
            e.preventDefault();
            $.ajax({
                url: '<?= base_url("classsetup/updateClass")?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){
                    if(response["status"] == 0){
                        //set error message 
                        $("#e_update_class_name").html(response["class_name"]);
                        $("#e_update_class_status").html(response["class_status"]);
                        $("#e_update_comment").html(response["comment"]);
                    }else{
                        //set blank value for error message
                        $("#e_update_class_name").html("");
                        $("#e_update_class_status").html("");
                        $("#e_update_comment").html("");
                        
                        //set message for alert box
                        $("#updateModal").modal("hide");
                        Swal.fire(
                          response["alert"],
                          response["message"],
                          response["modal"]
                        );
                        $("#"+response["rowId"]).html(response["updatedRow"]);

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