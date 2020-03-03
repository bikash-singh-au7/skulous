<div class="container-fluid">
    <div class="row p-0">
        <div class="col-md-6 m-auto">
            <div class="page-header">
               <div class="inner-content">
                   <!-- Subject Details --> 
                   <div class="row">
                        <div class="col-md-12 p-0 m-0" id="alert">
                            
                        </div>
                        <div class="col-md-12 p-0 m-0 border">
                            <div class="float-left px-2 py-2">
                                <span class="text-muted font-weight-bold"> <i class="fa fa-plus"></i> Add Subject </span>
                            </div>
                            <div class="float-right px-2">
                                <a href="<?= base_url('subjectsetup/subject/manage')?>">
                                    <button class="btn btn-info px-2 my-1" type="button"> <i class="fa fa-cog"></i> Manage Subject </button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <form method="post" action="" class="" id="addForm">
                       <div class="row border pt-2">
                         <div class="col-md-12 m-auto">
                            <div class="form-group">
                                <label for="">Subject name <span class="text-danger">*</span></label>
                                <input type="text" name="subject_name" class="form-control" value="" placeholder="Enter Subject like Physics/Chemistry">
                                <span class="text-danger" id="e_subject_name"></span>
                            </div>
                            <div class="form-group">
                                <label for="">Subject Code<span class="text-danger">*</span></label>
                                <input type="text" name="subject_code" class="form-control" value="" placeholder="Enter Subject Code Phy/Che">
                                <span class="text-danger" id="e_subject_code"></span>
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
                url: '<?= base_url("subjectsetup/addSubject/add")?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){
                    if(response["status"] == 0){
                        //set error message 
                        $("#e_subject_name").html(response["subject_name"]);
                        $("#e_subject_code").html(response["subject_code"]);
                        $("#e_comment").html(response["comment"]);
                    }else{
                        //set blank value for error message
                        $("#e_subject_name").html("");
                        $("#e_subject_code").html("");
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





