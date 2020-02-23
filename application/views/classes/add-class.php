<div class="container-fluid">
    <div class="row p-0">
        <div class="col-md-6 m-auto">
            <div class="page-header">
               <div class="inner-content">
                   <!-- Class Details --> 
                   <div class="row">
                        <div class="col-md-12 p-0 m-0" id="alert">
                            
                        </div>
                        <div class="col-md-12 p-0 m-0 border">
                            <div class="float-left px-2 py-2">
                                <span class="text-muted font-weight-bold">Add Class </span>
                            </div>
                            <div class="float-right px-2">
                                <a href="<?= base_url('classsetup/classes/manage')?>">
                                    <button class="btn btn-info px-2 my-1" type="button"> <i class="fa fa-cog"></i> Manage Class </button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <form method="post" action="" class="" id="addForm">
                       <div class="row border pt-2">
                         <div class="col-md-12 m-auto">
                            <div class="form-group">
                                <label for="">Class name <span class="text-danger">*</span></label>
                                <input type="text" name="class_name" class="form-control" value="" placeholder="Enter class like 11th/12th">
                                <span class="text-danger" id="e_class_name"></span>
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
                url: '<?= base_url("classsetup/addClass/add")?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){
                    if(response["status"] == 0){
                        //set error message 
                        $("#e_class_name").html(response["class_name"]);
                        $("#e_comment").html(response["comment"]);
                    }else if(response["status"] == 1){
                        //set blank value for error message
                        $("#e_class_name").html("");
                        $("#e_comment").html("");

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
        });

        $(".form-control").focus(function(){
            $("#alert").html("");
        });
        
    });
</script>