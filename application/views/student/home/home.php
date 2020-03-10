<div class="container-fluid">
   
    <!---Color card--->
    <div class="row">
        <div class="col-lg-4">     <!--Total Paid Amount-->
           <a href="#">
               <div class="card color-card bg-info">
                 <i id="fa" class="fa fa-rupee-sign"></i> 
                 <span>
                   <?php
                    
                    $reg_data = $this->work->select_data("registration", ["id"=>$this->session->userdata("id")]);
                     if($reg_data[0]->full_paid == 1){
                         $msg = "Full Paid";
                     }else{
                         $msg = "";
                     }
                    $data = $this->work->select_sum("payment", ["reg_id"=>$this->session->userdata("id")], "amount");  
                    if($data[0]->amount == ""){
                        echo 0;
                    }else{
                        echo $data[0]->amount;
                    }
                   ?>
                 </span> 
                 <p class="pr-3">
                    Paid Amount
                    <b class="badge badge-success float-right mr-4"><?= $msg?></b> 
                 </p>
                    
               </div>
           </a>
         </div> 
         
        <div class="col-lg-4">     <!--Total Dues Amount-->
           <a href="#">
               <div class="card color-card bg-danger">
                <i id="fa" class="fa fa-users"></i> 
                 <span>
                   <?php
                    
                    $reg_data = $this->work->select_data("registration", ["id"=>$this->session->userdata("id")]);
                    $batch_id = $reg_data[0]->batch_id;
                    $reg_discount = $reg_data[0]->discount;
                     if($reg_data[0]->full_paid == 1){
                         echo 0; 
                     }else{
                         $payment = $this->work->select_sum("payment", ["reg_id"=>$this->session->userdata("id")], "amount"); 
                         $paid_amount = $payment[0]->amount;
                         
                         //Batch Info
                         $batch = $this->work->select_data("batch", ["id"=>$batch_id]);
                         $batch_fee = $batch[0]->batch_fee;
                         $batch_discount = $batch[0]->discount;
                         
                         $dues_amount = $batch_fee -($paid_amount+$reg_discount+$batch_discount);
                         echo $dues_amount;
                     }
                    
                   ?>
                 </span> 
                 <p class="pr-3">
                    Dues Amount
                     
                 </p>
                        
               </div>
           </a>
         </div>
         
        <div class="col-lg-4">     <!--Notification-->
           <a href="#">
               <div class="color-card bg-success">
                <i id="fa" class="fa fa-bell"></i> 
                 <span>
                   <?php
                       echo 0;  
                   ?>  
                 </span>  
                 <p>Notifications</p>    
               </div>
           </a>
         </div>
         
    </div>
    
  
    <!----->
    <div class="main-content">
        <div class="row p-0">
          <!---------Left Section------>    
            <div class="col-md-8">
                <div class="to-do">  
                   <div class="to-do-heading">
                     <h2>
                         <span>Ask Question/Doubts</span>
                         <button id="askQuestionBtn"><i class="fa fa-angle-down"></i></button>
                     </h2>
                   </div>
                   <div class="px-3 py-2" id="askQuestion">
                       <form action="">
                           <div class="form-group">
                               <label for="">Question Title</label>
                               <input type="text" class="form-control">
                           </div>
                           <div class="form-group">
                               <label for="">Discriptions</label>
                               <textarea name="" id="" cols="30" rows="4" class="form-control"></textarea>
                           </div>
                           <div class="form-group">
                               <button class="btn btn-info rounded-0">Ask</button>
                           </div>
                       </form>
                   </div>
               </div>
            </div>
          <!---------End Left Section------>



           <!---------Right Section------>    
            <div class="col-md-4">   
              <!--------News Section----->    
               <div class="news-feed">  
                   <div class="news-heading">
                     <h2>News Feeds</h2>
                   </div>
                   <div class="news-content">
                     <p>
                         <i class="fa fa-user"></i>
                         No News
                     </p>
                   </div>
               </div>
               <!-------End News Section----->

               <!-------- To Do List Section ----->
               <div class="to-do">   
                   <div class="to-do-heading">
                     <h2>
                         <span>To Do</span>
                         <button id="toDo"><i class="fa fa-angle-down"></i></button>
                     </h2>
                   </div>
                   <div class="to-do-content" id="openToDo">
                     <form action="" method="post" class="to-do-form">   <!--------To Do Form----->
                         <input type="text" placeholder="Subject">
                         <textarea type="text" placeholder="Whats your mind ?"></textarea>
                         <?php 
                            date_default_timezone_set("Asia/Kolkata"); 
                            $dt = date("Y-m-d");
                         ?>
                         <input value="<?php echo $dt;?>" type="date" placeholder="Subject">
                         <button type="submit">Add <i class="fa fa-angle-right"></i></button>
                     </form>
                     <div class="to-do-list">

                     </div>   
                   </div>
               </div> 
              <!--------End To Do List Section----->   


            </div>
           <!---------End Right Section------>    
        </div>
    </div>
    
    
</div>
<script type="text/javascript">
        $(document).ready(function(){
          $("#taggleBtn").click(function(){
            $("#mainButtonContainer").toggle();
          });
        });
        
        $(document).ready(function(){
          $("#optionBtn").click(function(){
            $("#optionContainer").toggle();
          });
        });
        $(document).ready(function(){
          var f = false;    
          $("#toDo").click(function(){
            $("#openToDo").toggle();
            if( f == false){
               $(this).html('<i class="fa fa-angle-up"></i>');
                f = true;
                }
             else{
                $(this).html('<i class="fa fa-angle-down"></i>');
                f = false;
                }   
          });
        });
        
        $(document).ready(function(){
          var f = false;    
          $("#askQuestionBtn").click(function(){
            $("#askQuestion").toggle();
            if( f == false){
               $(this).html('<i class="fa fa-angle-up"></i>');
                f = true;
                }
             else{
                $(this).html('<i class="fa fa-angle-down"></i>');
                f = false;
                }   
          });
        });
        
        $(document).ready(function(){
          var f = false;    
          $("#calendarBtn").click(function(){
            $("#openCalendar").toggle();
            if( f == false){
               $(this).html('<i class="fa fa-angle-up"></i>');
                f = true;
                }
             else{
                $(this).html('<i class="fa fa-angle-down"></i>');
                f = false;
                }   
          });
        });
        
        $(document).ready(function(){
          var f = false;    
          $("#feeReportBtn").click(function(){
            $("#openFeeReport").toggle();
            if( f == false){
               $(this).html('<i class="fa fa-angle-up"></i>');
                f = true;
                }
             else{
                $(this).html('<i class="fa fa-angle-down"></i>');
                f = false;
                }   
          });
        });
    </script>
    
    
<!--Chatt Section-->
    
<!--- Script for chart --->
<?php
    $dataPoints = [];
    $dataPoints[] = ["label" => "1", "y" => 100];
    $dataPoints[] = ["label" => "2", "y" => 300];
    $dataPoints[] = ["label" => "3", "y" => 400];
?>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>
    // Student Chart
    window.onload = function () {
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2", // "light1", "light2", "dark1", "dark2"
            title: {
                //text: "Top 10 Google Play Categories - till 2017"
            },
            axisY: {
                title: "Number of Students",
                includeZero: false
            },
            data: [{
                type: "column",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
    }
        
</script>