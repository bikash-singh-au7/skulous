    <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header text-center mb-0">
                <img class="img img-student-profile" src="https://image.shutterstock.com/image-vector/profile-placeholder-image-gray-silhouette-260nw-1190386324.jpg" style="height:120px; width:100px">
                <p class="text-center">
                    <?= $this->session->userdata('student_name')?>
                </p>
            </div>

            <ul class="list-unstyled components mt-0">
                <!--<p>Welcome WebXpert</p>-->
                <!--Dahboad Setup-->
                <li class="active"><a href="<?= base_url('student/')?>"><i class="fa fa-user" id="fa"></i> Dashboard</a><li>
                <!--Profile-->
                <li><a href="<?= base_url('student/profile')?>"><i class="fa fa-user" id="fa"></i> Profile</a><li>
                
                <!--Setting-->
                <li><a href="<?= base_url('student/setting')?>"><i class="fa fa-cog" id="fa"></i>Setting</a><li>
                
                <!--Payment-->
                <li><a href="<?= base_url('student/payment')?>"><i class="fa fa-rupee-sign" id="fa"></i> Payment</a><li>
                
                <!--Help and Support-->
                <li>
                    <a href="#helpSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fa fa-question-circle" id="fa"></i>Help & Support</a>
                    <ul class="collapse list-unstyled" id="helpSubmenu">
                        <li> <a href="#">Support Request</a> </li>
                        <li> <a href="#">Support History</a> </li>    
                        <li> <a href="#">Feedback</a> </li>
                        <li> <a href="#">Contact Us</a> </li>
                        <li> <a href="#">Demo Video</a> </li>
                    </ul>
                </li>
                
            </ul>
        </nav>