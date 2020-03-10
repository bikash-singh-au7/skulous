<?php date_default_timezone_set("Asia/Kolkata") ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Skulous: Advance School Management System</title>

    <!--Data Table-->
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    
    
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js"></script>

 

    <!--Jquery with Ajax-->
    <script src="<?= base_url('assets/js/jquery-3.4.1.min.js')?>"></script>

    <!-- Bootstrap Online CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">


   
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/sidebar-style.css')?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/other-style.css')?>">

    <!--Data Table Jqery-->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        } );
    </script>
    <!--Sweet Alert-->
    <script src="<?= base_url('assets/sweetalert/dist/sweetalert2.js')?>"></script>
    <link rel="stylesheet" href="<?= base_url('assets/sweetalert/dist/sweetalert2.css')?>">

</head>

<body class="bg-light">
    <div class="wrapper">       
 