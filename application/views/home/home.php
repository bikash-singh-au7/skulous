<div class="container-fluid">
   <!--
    <div class="row">
        <div class="col-md-6">
            <div id="columnchart_values" style="width: 100%; height: 300px;"></div>
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                google.charts.load("current", {packages:['corechart']});
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ["Element", "Density", { role: "style" } ],
                    ["Bird", 8.94, "#b87333"],
                    ["Robin", 10.49, "silver"],
                    ["Rock", 19.30, "gold"],
                    ["Google", 600, "gold"],
                    ["Platinum", 21.45, "color: #e5e4e2"]
                ]);

                var view = new google.visualization.DataView(data);
                view.setColumns([0, 1,
                                { calc: "stringify",
                                    sourceColumn: 1,
                                    type: "string",
                                    role: "annotation" },
                                2]);

                var options = {
                    title: "Students in differents Batches",
                    width: 450,
                    height: 300,
                    bar: {groupWidth: "95%"},
                    legend: { position: "none" },
                };
                var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
                chart.draw(view, options);
            }
            </script>
        </div>

        <div class="col-md-6">
            <div id="piechart" style="width: auto; height: 300px;"></div>
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                var data = google.visualization.arrayToDataTable([
                ['Payments', 'Batch Wise'],
                <?php
                    $c = 40000;
                    $d = 1000;
                    echo"['Robin', ".$c."],
                         ['Angle', ".$d."]
                        "; 
                ?>
                ]);

                var options = {
                title: 'Payments Batch Wise'
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                chart.draw(data, options);
            }
            </script>
        </div>

    </div>
    -->
    
    <!---Color card--->
    <div class="row">
        <div class="col-lg-3">     <!--Total Student Section-->
           <a href="#">
               <div class="card color-card bg-info">
                 <i id="fa" class="fa fa-graduation-cap"></i> 
                 <span>
                   0
                 </span> 
                 <p>Total Students</p>   
               </div>
           </a>
         </div> 
         
        <div class="col-lg-3">     <!--Total Student Section-->
           <a href="#">
               <div class="card color-card bg-danger">
                <i id="fa" class="fa fa-users"></i> 
                 <span>
                   <?php
                       echo 0;
                   ?>  
                 </span> 
                 <p>Total Inquiry</p>    
               </div>
           </a>
         </div>
         
        <div class="col-lg-3">     <!--Total Student Section-->
           <a href="#">
               <div class="color-card bg-success">
                <i id="fa" class="fa fa-rupee-sign"></i> 
                 <span>
                   <?php
                       echo 0;  
                   ?>  
                 </span>  
                 <p>Total Fee Collection</p>    
               </div>
           </a>
         </div>
         
        <div class="col-lg-3">     <!--Total Unpaid Student Section-->
           <a href="#">
               <div class="color-card bg-primary">
                <i id="fa" class="fa fa-user" ></i> 
                 <span> <?= 0;?> </span> 
                 <p>Total Unpaid Student.</p> 
               </div>
           </a>
         </div> 
    </div>
    
    
    <!---White card--->
    <div class="row">
        <div class="col-lg-4">     <!--Total Student Section-->
           <a href="#">
               <div class="card white-card">
                 <i id="fa" class="fa fa-birthday-cake"></i> 
                 <span>
                     <?php
                        echo 0;
                     ?>
                 </span> 
                 <p>Today's Birthday</p>   
               </div>
           </a>
        </div> 
        <div class="col-lg-4">     <!--Total Student Section-->
           <a href="#">
               <div class="card white-card">
                 <i id="fa" class="fa fa-rupee-sign"></i> 
                 <span>
                     <?php
                        echo 0;
                     ?>
                 </span> 
                 <p>Today Fee Collaction</p>   
               </div>
           </a>
        </div>
        
        <div class="col-lg-4">     <!--Total Student Section-->
           <a href="#">
               <div class="card white-card">
                 <i id="fa" class="fa fa-users"></i> 
                 <span>
                     <?php
                        echo 0;
                     ?>
                 </span> 
                 <p>Total Batchs</p>   
               </div>
           </a>
        </div>
    
    </div>
    
    
    <!----->
    <div class="main-content">
        <div class="row p-0">
          <!---------Left Section------>    
            <div class="col-md-8"> 

             <!--Students Chart Section-->    
                <div class="student-chart-container">
                    <h2>
                       <span>Students Overview</span>
                       <button id="attendenceBtn"><i class="fa fa-angle-down"></i></button>
                    </h2>
                    <div class="attendence-chart" id="openAttendence">
                        <div id="chartContainer" style="height: 300px; width: 100%;"></div>
                        
                    </div>
                </div>
               <!--End Attendence Section--> 

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
          $("#attendenceBtn").click(function(){
            $("#openAttendence").toggle();
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