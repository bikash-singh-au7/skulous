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
                                <span class="text-muted font-weight-bold"> <span class="fa fa-plus"></span> Add Session </span>
                            </div>
                            <div class="float-right px-2">
                                <a href="<?= base_url('sessionsetup/session/select')?>">
                                    <button class="btn btn-info px-2 my-1" type="button"> <i class="fa fa-check"></i> Select Session </button>
                                </a>
                            </div>
                         </div>
                    </div>
                    <form method="post" action="" class="" id="addForm">
                       <div class="row border pt-2">
                         <div class="col-md-12 m-auto">
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

                        //set blank value after inserting the value
                        $(".form-control").val("");
                        //set message for alert box
                        $("#alert").html(response["alert"]);
                    }else{
                        $(".form-control").val("");
                        $("#alert").html(response["alert"]);
                    }
                }
            });
        })
    });
</script>