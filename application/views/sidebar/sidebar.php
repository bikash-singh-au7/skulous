    <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <img class="img img-fluid" src="http://vijay.vijayphysics.com/admin/favicon/logo.png">
            </div>

            <ul class="list-unstyled components">
                <!--<p>Welcome WebXpert</p>-->
                <!--Dahboad Setup-->
                <li class="active">
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fa fa-home" id="fa"></i> Dashboard</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li>
                            <a href="">Dashboard</a>
                        </li>
                        
                    </ul>
                </li>
                <!--Session Setup-->
                <li>
                    <a href="#sessionSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fa fa-calendar" id="fa"></i> Session</a>
                    <ul class="collapse list-unstyled" id="sessionSubmenu">
                        <li> <a href="<?= base_url('sessionsetup/session/add')?>"><i class="fa fa-plus" id="fa"></i>Add Session</a></li>
                        <li> <a href="<?= base_url('sessionsetup/session/select')?>"><i class="fa fa-edit" id="fa"></i>Change Session</a> </li>    
                        <li> <a href="<?= base_url('sessionsetup/session/manage')?>"><i class="fa fa-cog" id="fa"></i>Manage Session</a> </li>    
                    </ul>
                </li>
                <!--Class Setup-->
                <li>
                    <a href="#classSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fa fa-user" id="fa"></i> Class</a>
                    <ul class="collapse list-unstyled" id="classSubmenu">
                        <li> <a href="<?= base_url('classsetup/classes/add')?>"><i class="fa fa-plus" id="fa"></i>Add Class</a></li>
                        <li> <a href="<?= base_url('classsetup/classes/manage')?>"><i class="fa fa-cog" id="fa"></i>Manage Class</a> </li>    
                    </ul>
                </li>
                <!--Subject Setup-->
                <li>
                    <a href="#subjectSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fa fa-book" id="fa"></i>&nbsp;Subjects</a>
                    <ul class="collapse list-unstyled" id="subjectSubmenu">
                        <li> <a href="<?= base_url('subjectsetup/subject/add')?>"><i class="fa fa-plus" id="fa"></i>Add Subjects</a></li>
                        <li> <a href="<?= base_url('subjectsetup/subject/manage')?>"><i class="fa fa-calendar" id="fa"></i>Manage Subjects</a> </li>    
                    </ul>
                </li>
                <!--Batch Setup-->
                <li>
                    <a href="#batchSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fa fa-users" id="fa"></i>Batches</a>
                     <ul class="collapse list-unstyled" id="batchSubmenu">
                        <li> <a href="<?= base_url('batchsetup/batch/add')?>"><i class="fa fa-plus" id="fa"></i>Add Batches</a></li>
                        <li> <a href="<?= base_url('batchsetup/batch/manage')?>"><i class="fa fa-cog" id="fa"></i>Manage Batches</a> </li>    
                    </ul>
                </li>
                
                <!--Staff Setup-->
                <li>
                        <a href="#staffSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fa fa-users" id="fa"></i>Staff/Worker</a>
                        <ul class="collapse list-unstyled" id="staffSubmenu">
                            <li> <a href="<?= base_url('staffsetup/staff/add')?>"><i class="fa fa-plus" id="fa"></i>Add Staff/Worker</a></li>
                            <li> <a href="<?= base_url('staffsetup/staff/manage')?>"><i class="fa fa-calendar" id="fa"></i>Manage Staff/Worker</a> </li>    
                        </ul>
                    </li>
                       
                <!--Registration Setup-->
                <li>
                    <a href="#regSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fa fa-graduation-cap" id="fa"></i> Registration</a>
                    <ul class="collapse list-unstyled" id="regSubmenu">
                        <li> <a href="<?= base_url('regsetup/registration/add')?>"><i class="fa fa-plus" id="fa"></i>Add Registration</a></li>
                        <li> <a href="<?= base_url('regsetup/registration/manage')?>"><i class="fa fa-calendar" id="fa"></i>Manage Registration</a> </li>    
                    </ul>
                </li>
                
                
                <li>
                    <a href="#inquirySubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fa fa-cog" id="fa"></i> Inquiry</a>
                    <ul class="collapse list-unstyled" id="inquirySubmenu">
                        <li> <a href=""><i class="fa fa-plus" id="fa"></i>Add Inquiry</a></li>
                        <li> <a href=""><i class="fa fa-calendar" id="fa"></i>Manage Inquiry</a> </li>    
                    </ul>
                </li>
                                <li>
                    <a href="#paymentSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                     <i class="fa fa-cog" id="fa"></i> Payments</a>
                    <ul class="collapse list-unstyled" id="paymentSubmenu">
                        <li> <a href=""><i class="fa fa-plus" id="fa"></i>Add Payments</a></li>
                        <li> <a href=""><i class="fa fa-calendar" id="fa"></i>Manage Payments</a> </li>    
                    </ul>
                </li>
                                
                <li>
                    <a href="#smsSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fa fa-envelope" id="fa"></i> Message/Sms</a>
                    <ul class="collapse list-unstyled" id="smsSubmenu">
                        <li> <a href="">Send SMS To Inquiry</a> </li>
                        <li> <a href="">Send SMS To Student</a> </li>    
                        <li> <a href="">Send SMS To Staff</a> </li>
                        <li> <a href="">Send Student Id/Password</a> </li>
                        <li> <a href="">Send Student Birthday SMS</a> </li>
                        <li> <a href="">Check Delevery Report</a> </li>
                    </ul>
                </li>
                
                <li>
                    <a href="#helpSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fa fa-question-circle" id="fa"></i> Help & Support</a>
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