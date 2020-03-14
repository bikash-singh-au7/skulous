
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Skulous: Student Login</title>

    <!--Data Table-->
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    
    
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js"></script>

 

    <!--Jquery with Ajax-->
    <script src="http://localhost/skulous/assets/js/jquery-3.4.1.min.js"></script>

    <!-- Bootstrap Online CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">


   
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="http://localhost/skulous/assets/css/sidebar-style.css">
    <link rel="stylesheet" href="http://localhost/skulous/assets/css/other-style.css">

    <!--Data Table Jqery-->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        } );
    </script>
    <!--Sweet Alert-->
    <script src="http://localhost/skulous/assets/sweetalert/dist/sweetalert2.js"></script>
    <link rel="stylesheet" href="http://localhost/skulous/assets/sweetalert/dist/sweetalert2.css">

</head>

<body class="bg-light">
    <div class="wrapper">       
     <div class="container login-container mt-5">
        <div class="row my-5 p-4">
            
            <div class="col-md-4 m-auto p-4 shadow rounded">
                <?php
                    if($this->session->flashdata("success")){
                        echo $this->session->flashdata("success");
                    }
                ?>
                
                <form action="<?= base_url('studentauth')?>" method="post">
                    <div class="">
                        <img src="http://localhost/skulous/assets/images/logo.png" class="img img-responsive img-fluid" alt="">
                        <div class="">
                            
                        </div>
                        <div class="form-group mt-">
                            <label for="user_name" class="font-weight-bold"> User Name </label>
                            <input type="text" name="user_name" class="form-control" value="" autocomplete="off">
                            <?= form_error("user_name")?>
                        </div>
                        <div class="form-group" >
                            <label for="user_password" class="font-weight-bold"> Password </label>
                            <input type="password" name="user_password" class="form-control" value="">
                            <?= form_error("user_password")?>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-info"> Log In</button>
                        </div>
                    </div>
                </form>
                <div class="text-right">
                    <a href="<?= base_url("forgetPassword/student")?>" class="text-primary">Forget Password?</a>
                </div>
            </div>
            
        </div>
    </div>