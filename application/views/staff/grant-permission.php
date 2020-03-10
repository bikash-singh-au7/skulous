<div class="container-fluid">
    <div class="row p-0">
        <div class="col-md-8 m-auto">
            <div class="page-header">
               <div class="inner-content">
                   <!-- Staff Details --> 
                   <div class="row">
                        <div class="col-md-12 p-0 m-0" id="alert">
                            
                        </div>
                        <div class="col-md-12 p-0 m-0 border bg-white">
                            <div class="float-left px-2 py-2">
                                <span class="text-info font-weight-bold "> <i class="fa fa-cog"></i> Grant Permission </span>
                            </div>
                            
                        </div>
                    </div>
                    <div class="row bg-white">
                        <div class="col-md-12">
                            <form method="post" action="" class="p-0" enctype="multipart/form-data" id="permissionForm">
                               
                                    

                            </form>
                        </div>
                    </div>  
               </div>     
        </div>

    </div>
</div>


<!---Ajax here-->
<script>
    $(document).ready(function(){
        $("body").on("submit", "#permissionForm", function(e){
            e.preventDefault();
            $.ajax({
                url: '<?= base_url("staffsetup/grantPermission")?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){
                    if(response["status"] == 0){
                        //set error message 
                        $("#e_staff_name").html(response["staff_name"]);
                        $("#e_gender").html(response["gender"]);
                        $("#e_mobile_number").html(response["mobile_number"]);
                        $("#e_email").html(response["email"]);
                        $("#e_address").html(response["address"]);
                        
                    }else{
                        //set blank value for error message
                        $("#e_staff_name").html("");
                        $("#e_gender").html("");
                        $("#e_mobile_number").html("");
                        $("#e_email").html("");
                        $("#e_address").html("");
                        

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
