<?php 
    $startSession = date("Y-m-d");
    $date = getdate(strtotime($startSession));
    $endSession = (int)$date["year"] + 1 ."-". sprintf("%02d", $date["mon"]). "-" . sprintf("%02d", (int)$date["mday"]-1);
?>
<div class="container-fluid">
    <div class="row p-0">
        <div class="col-md-6 m-auto">
            <div class="page-header">
               <div class="inner-content">
                   <!-- Session Details --> 
                   <div class="row">
                        <div class="col-md-12 p-0 m-0" id="alert">
                            
                        </div>
                        <div class="col-md-12 p-0 m-0 border">
                            <div class="float-left px-2 py-2">
                                <span class="text-muted font-weight-bold">Select Session</span>
                            </div>
                            <div class="float-right px-2">
                                <button class="btn btn-info px-2 my-1" type="button" data-toggle="modal" data-target="#addSession"> <i class="fa fa-plus"></i> Add Session </button>
                            </div>
                         </div>
                    </div>
                    <form method="post" action="<?= base_url('sessionsetup/session/select')?>" class="">
                       <div class="row border">
                         <div class="col-md-12 m-auto">
                            <div class="form-group">
                              <label class="py-1 text-muted">Select Session <span class="text-danger">*</span></label>
                              <select name="session" id="selectSession" class="form-control">
                                <option value="">--Select--</option>
                                <?php
                                    foreach($session as $value){
                                        $start_session_date = date("M/Y",strtotime($value->start_session));
                                        $end_session_date = date("M/Y",strtotime($value->end_session));
                                        $final_session = $start_session_date."-".$end_session_date;

                                        if($value->id == $this->session->userdata("session_id")){
                                            $selected = "selected";
                                        }else{
                                            $selected = "";
                                        }
                                        ?>
                                            <option value="<?= $value->id?>" <?= $selected?>  > <?= $final_session?> </option>            
                                        <?
                                    }
                                
                                ?>
                                

                              </select> 
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
                            <input type="text" name="session_name" class="form-control" value="" placeholder="Enter session name">
                            <span class="text-danger" id="session_name"></span>
                        </div>
                        <div class="form-group">
                            <label for="">Session Start Date <span class="text-danger">*</span></label>
                            <input type="date" name="start_session" class="form-control" value="<?= $startSession; ?>">
                            <span class="text-danger" id="start_session"></span>
                        </div>
                        <div class="form-group">
                            <label for="">Session End Date <span class="text-danger">*</span></label>
                            <input type="date" name="end_session" class="form-control" value="<?= $endSession; ?>">
                            <span class="text-danger" id="end_session"></span>                            
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
    $(document).ready(function(){
        $("body").on("submit", "#addForm", function(e){
            e.preventDefault();
            $.ajax({
                url: '<?= base_url("sessionsetup/addSession/add")?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){
                    if(response["status"] == 0){
                        //set error message 
                        $("#session_name").html(response["session_name"]);
                        $("#start_session").html(response["start_session"]);
                        $("#end_session").html(response["end_session"]);
                    }else if(response["status"] == 1){
                        //set blank value for error message
                        $("#session_name").html("");
                        $("#start_session").html("");
                        $("#end_session").html("");
                        //hide modal
                        $("#addSession").modal('hide');
                        //set blank value after inserting the value
                        $(".form-control").val("");
                        //set message for alert box
                        $("#alert").html(response["alert"]);
                        $("#selectSession").append(response["lastRow"]);
                    }else{
                        //hide modal
                        $("#addSession").modal('hide');
                        $(".form-control").val("");
                        $("#alert").html(response["alert"]);
                    }
                }
            });
        })
    });
</script>