<?php 
    $startSession = date("Y-m-d");
    $date = getdate(strtotime($startSession));
    $endSession = (int)$date["year"] + 1 ."-". sprintf("%02d", $date["mon"]). "-" . sprintf("%02d", (int)$date["mday"]-1);
?>
<div class="container-fluid">
    <div class="row p-0">
        <div class="col-md-11 m-auto">
            <div class="page-header">
               <div class="inner-content">
                   <!-- Session Details --> 
                   <div class="row">
                        <div class="col-md-12 p-0 m-0" id="alert">
                            
                        </div>
                        <div class="col-md-12 p-0 m-0 border">
                            <div class="float-left px-2 py-2">
                                <span class="text-muted font-weight-bold"> <i class="fa fa-cog"></i> Manage Session</span>
                            </div>
                            <div class="float-right px-2">
                                <a href="<?= base_url('sessionsetup/session/select')?>" class="btn btn-info">
                                    <i class="fa fa-eye"></i> Select Session
                                </a>
                                <button class="btn btn-info px-2 my-1" type="button" data-toggle="modal" data-target="#addSession" id="addBtn"> <i class="fa fa-plus"></i>Add Session </button>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="row border p-2">
                            <div class="col-md-12 m-auto p-0 table-responsive">
                                <table id="dataTable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#Id</th>
                                            <th>Session Name</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th class="text-center">DOC</th>
                                            <th>Status</th>
                                            <th class="text-center">Edit</th>
                                            <th class="text-center">Delete</th>
                                        </tr> 
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach($session as $value){
                                                ?>
                                                <tr id="row-<?=$value->id?>">
                                                    <td><?=$value->id?></td>
                                                    <td><?=$value->session_name?></td>
                                                    <td><?=date("d-M-Y", strtotime($value->start_session))?></td>
                                                    <td><?=date("d-M-Y", strtotime($value->end_session))?></td>
                                                    <td class="text-center"><?=date("d-M-Y h:m:s A", strtotime($value->created_date))?></td>
                                                    <td class="text-center">
                                                        <?php
                                                            if($value->session_status == 1){
                                                                $status = 1;
                                                                echo"<span class='badge badge-info'>Active</span>";
                                                            }else{
                                                                $status = 0;
                                                                echo"<span class='badge badge-danger'>Disable</span>";
                                                            }
                                                        ?>
                                                    </td>
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
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="deleteSessionlabel">Delete Session</h6>
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
                        <input type="hidden" value="" name="session_id" id="delete_session_id">
                        <button type="submit" class="btn btn-danger" name="delSbmt">Delete</button>
                        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    </form>
                                                            
                </div>
                </div>
            </div>
        </div>
    
        <!--Update session form---->
        <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="updateSessionlabel">Update Session</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="updateForm">
                        <div class="form-group">
                            <label for="">Session Name <span class="text-danger">*</span></label>
                            <input type="text" name="session_name" value="" class="form-control" placeholder="Enter session name" id="update_session_name">
                            <span class="text-danger" id="e_update_session_name"></span>
                            <input type="hidden" name="session_id" value="" class="form-control" id="update_session_id">
                        </div>
                        <div class="form-group">
                            <label for="">Start Session <span class="text-danger">*</span></label>
                            <input type="date" name="start_session" class="form-control" value="" id="update_start_session">
                            <span class="text-danger" id="e_update_start_session"></span>
                        </div>
                        <div class="form-group">
                            <label for="">End Session <span class="text-danger">*</span></label>
                            <input type="date" name="end_session" class="form-control" value="" id="update_end_session">
                            <span class="text-danger" id="e_update_end_session"></span>
                        </div>
                        <div class="form-group">
                            <label for="">Status <span class="text-danger">*</span></label>
                            <select name="session_status" class="form-control" id="update_session_status">
                                <option value="1"> Active</option>
                                <option value="0"> Disable</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info updateBtn" name="updtSbmt" form="updateForm">Update</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>

        <!--Add session form---->
        <div class="modal fade" id="addSession" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="addSessionlabel">Add Session</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="addForm">
                        <div class="form-group">
                            <label for="">Session name <span class="text-danger">*</span></label>
                            <input type="text" name="session_name" class="form-control" value="" placeholder="Enter session name" id="add_session_name">
                            <span class="text-danger" id="e_add_session_name"></span>
                        </div>
                        <div class="form-group">
                            <label for="">Session Start Date <span class="text-danger">*</span></label>
                            <input type="date" name="start_session" class="form-control" value="<?= $startSession; ?>" id="add_start_session">
                            <span class="text-danger" id="e_add_start_session"></span>
                        </div>
                        <div class="form-group">
                            <label for="">Session End Date <span class="text-danger">*</span></label>
                            <input type="date" name="end_session" class="form-control" value="<?= $endSession; ?>" id="add_end_session">
                            <span class="text-danger" id="e_add_end_session"></span>                            
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
        $("#delete_session_id").val(id);
    }
    
    $(document).ready(function(){
        $("body").on("submit", "#deleteForm", function(e){
            e.preventDefault();
            $.ajax({
                url: '<?= base_url("sessionsetup/deleteData")?>',
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
                    if(response["redirect"] != ""){
                        window.location = response["redirect"];
                    }
                }
            });
        })
    });

    //Get id for updating the data
    function getId(id){
        $("#updateModal").modal("show");
        $("#alert").html("");
        $("#e_update_session_name").html("");
        $("#e_update_start_session").html("");
        $("#e_update_end_session").html("");
        $.ajax({
                url: '<?= base_url("sessionsetup/getData")?>',
                type: 'POST',
                data: {session_id:id},
                dataType: 'json',
                success: function(response){
                    $("#update_session_id").val(response["session_id"]);
                    $("#update_session_name").val(response["session_name"]);
                    $("#update_start_session").val(response["start_session"]);
                    $("#update_session_status option[value="+response["session_status"]+"]").attr('selected', 'selected');
                    $("#update_end_session").val(response["end_session"]);
                }
        });
    }
    $(document).ready(function(){
        $("body").on("submit", "#addForm", function(e){
            e.preventDefault();
            $.ajax({
                url: '<?= base_url("sessionsetup/addSession/manage-add")?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){
                    if(response["status"] == 0){
                        //set error message 
                        $("#e_add_session_name").html(response["session_name"]);
                        $("#e_add_start_session").html(response["start_session"]);
                        $("#e_add_end_session").html(response["end_session"]);
                    }else{
                        //set blank value for error message
                        $("#e_add_session_name").html("");
                        $("#e_add_start_session").html("");
                        $("#e_add_end_session").html("");

                        //set blank value after inserting the value
                        $("#add_session_name").val("");
                        $("#add_start_session").val("<?= $startSession?>");
                        $("#add_end_session").val("<?= $endSession?>");
                        //hide modal
                        $("#addSession").modal("hide");
                        //set message for alert box
                        Swal.fire(
                          response["alert"],
                          response["message"],
                          response["modal"]
                        )
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
                url: '<?= base_url("sessionsetup/updateSession")?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){
                    if(response["status"] == 0){
                        //set error message 
                        $("#e_update_session_name").html(response["session_name"]);
                        $("#e_update_start_session").html(response["start_session"]);
                        $("#e_update_end_session").html(response["end_session"]);
                    }else{
                        //set blank value for error message
                        $("#e_update_session_name").html("");
                        $("#e_update_start_session").html("");
                        $("#e_update_end_session").html("");

                        
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