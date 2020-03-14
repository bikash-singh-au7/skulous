<?php
    date_default_timezone_set("Asia/Kolkata");
    $today = date("Y-m-d");
?>   

<div class="container-fluid">
    <div class="row p-1 bg-white">
        <div class="col-md-8 shadow-sm">
            <div class="page-header">
               <div class="inner-content">
                   <!-- Registration Details --> 
                   <div class="row">
                        <div class="col-md-12 p-0 m-0">
                            <div class="float-left px-2 py-2">
                                <p class="text-muted font-weight-bold m-0"> <i class="fa fa-globe"></i> Registration No Format </p>
                            </div>
                            <div class="float-right px-2 py-1" id="addBtn">
                                <button class="btn btn-info" type="button" data-toggle="modal" data-target="#addModal"> <span class="fa fa-plus"></span> Add Format  </button>
                            </div>
                            
                        </div>
                    </div>
                    <div class="row px-2 py-2">
                        
                        <div class="col-md-12 bg-white py-2">
                            <table id="dataTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr class="text-muted">
                                        <th>Id</th>
                                        <th>Format String</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($data as $value){
                                        ?>
                                        <tr id="<?= 'row-'.$value->id?>">
                                            <td><?= $value->id?></td>
                                            <td><?= $value->format_string?></td>
                                            <td>
                                                <?php
                                                if($value->status == 1){
                                                    ?>
                                                    <span class="badge badge-info">Active</span>
                                                    <?
                                                }else{
                                                    ?>
                                                    <span class="badge badge-danger">Disabled</span>
                                                    <?
                                                }
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-info px-2 py-1" onclick="getId('<?= $value->id?>')"> <i class="fa fa-edit"></i> </button>
                                                <button class="btn btn-danger px-2 py-1" onclick="deleteData('<?= $value->id?>')"> <i class="fa fa-trash"></i> </button>
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
        <div class="col-md-4 px-4">
            <div class="row shadow-sm">
                <div class=" px-2 py-2">
                    <p class="text-muted font-weight-bold m-0"> <i class="fa fa-globe"></i> Format String</p>
                </div>
                <div class="col-md-12">
                    <table class="table table-bordered text-muted">
                        <tr>
                            <td>Full Year (<?= date("Y")?>)</td>
                            <td>Y</td>
                        </tr>
                        <tr>
                            <td>Half Year (<?= date("y")?>)</td>
                            <td>y</td>
                        </tr>
                        <tr>
                            <td>Subject (Phy/Che)</td>
                            <td>S</td>
                        </tr>
                        
                        <tr>
                            <td>Institute Code</td>
                            <td>I</td>
                        </tr>
                        <tr>
                            <td>Number (001)</td>
                            <td>3</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!--Add Format--->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="updateModallabel"> <i class="fa fa-edit"></i> Add Format</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="addForm">
                       
                        <div class="form-group">
                            <label for="" class="text-muted font-weight-bold">Format String </label>
                            <input type="text" class="form-control" name="format_string" id="format_string" placeholder="Y-S-I-3">
                            <span class="text-danger" id="e_format_string"></span>
                        </div>
                        
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info" form="addForm">Send</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>    
    
    <!--Update Format--->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="updateModallabel"> <i class="fa fa-edit"></i> Update Format</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="updateForm">
                       
                        <div class="form-group">
                            <label for="" class="text-muted font-weight-bold">Format String </label>
                            <input type="text" class="form-control" name="format_string" id="update_format_string" placeholder="Y-S-I-3">
                            
                            <input type="hidden" class="form-control" name="id" id="update_id" placeholder="Y-S-I-3">
                            <span class="text-danger" id="e_update_format_string"></span>
                        </div>
                        
                        <div class="form-group">
                            <label for="" class="text-muted font-weight-bold">Status </label>
                            <select name="status" id="update_status" class="form-control">
                                <option value="">--Select--</option>
                                <option value="1">Active</option>
                                <option value="0">Disable</option>
                            </select>
                            <span class="text-danger" id="e_update_format_string"></span>
                        </div>
                        
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info" form="updateForm">Update</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>    
    <!--Delete Data Modal---->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="deleteModallabel">Delete Format</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img class="img img-responsive" height=100 src="<?= base_url('assets/images/danger.png')?>" alt="">
                <h5 class="text-muted">Do you want to delete?</h5>
                <span class="badge badge-danger" id="deleteAlert"></span>
            </div>
            <div class="m-auto pb-2">
                <form action="" method="post" id="deleteForm">
                    <input type="hidden" value="" name="id" id="delete_id">
                    <button type="submit" class="btn btn-danger" name="delSbmt">Delete</button>
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                </form>

            </div>
            </div>
        </div>
    </div>
</div>



<!---Ajax here-->
<script>
     //All delete
    function deleteData(id){
        $("#deleteModal").modal("show");
        $("#delete_id").val(id);
    }
    $(document).ready(function(){
        $("body").on("submit", "#deleteForm", function(e){
            e.preventDefault();
            $.ajax({
                url: "<?= base_url('adminSetup/deleteFormatString')?>",
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){
                    $("#deleteModal").modal("hide");
                    $(response["rowId"]).remove();
                    Swal.fire(
                      response["alert"],
                      response["message"],
                      response["modal"]
                    )
                }
            });
        })
    });

    
    
    //Get Format
    function getId(id){
        $("#updateModal").modal("show");
        $("#e_update_formate_string").html("");
        $("#e_update_status").html("");
        $("#update_id").val(id);
        $("#update_status option").removeAttr("selected");
        $.ajax({
            url: '<?= base_url("adminSetup/getFormatString")?>',
            type: 'POST',
            data: {format_id:id},
            dataType: 'json',
            success: function(response){
                $("#update_format_string").val(response["format_string"]);
                $("#update_status option[value="+response['format_status']+"]").attr("selected", "selected");
            }
        });
    }
    
    $("#updateForm").on("submit", function(e){
        e.preventDefault();
        $.ajax({
            url: "<?= base_url('adminsetup/updateFormat')?>",
            type: "POST",
            data : $(this).serialize(),
            dataType: "json",
            success: function(response){
                if(response["status"]==0){
                    $("#e_update_format_string").html(response["format_string"]);
                    $("#e_update_status").html(response["format_status"]);
                }else{
                    $(response["rowId"]).html(response["html"]);
                    $("#updateModal").modal("hide");
                    Swal.fire(
                      response["alert"],
                      response["message"],
                      response["modal"]
                    )
                }
            }
        });
    })
    
    
    //Add Format
    $(function(){
        $("#addForm").on("submit", function(e){
            e.preventDefault();
            $.ajax({
                url: "<?= base_url('adminsetup/addData')?>",
                type: "POST",
                data : $(this).serialize(),
                dataType: "json",
                success: function(response){
                    if(response["status"]==0){
                        $("#e_format_string").html(response["format_string"]);
                    }else{
                        //Erase Error
                        $("#e_format_string").html("");
                        //Erase Input Box Value
                        $("#format_string").val("");
                        $("#addModal").modal("hide");
                        $("#dataTable").append(response["html"]);
                        
                        //hide add format button
                        //$("#addBtn").hide();
                        
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
    
    
    
</script>



