<?php
    if($this->session->userdata("type") == "staff"){
        $staff_per = $this->work->select_data("staff_permission", ["staff_id"=>$this->session->userdata("id")]);
        $session_permission = $staff_per[0]->session;
        $classes_permission = $staff_per[0]->classes;
        $subject_permission = $staff_per[0]->subject;
        $batch_permission = 1;
        $inquiry_permission = 1;
        $staff_permission = $staff_per[0]->staff;
        $registration_permission = $staff_per[0]->registration;
        $payment_permission = $staff_per[0]->payment;
        $sms_permission = $staff_per[0]->sms;
    }else{
        $session_permission = 1;
        $classes_permission = 1;
        $subject_permission = 1;
        $batch_permission = 1;
        $inquiry_permission = 1;
        $staff_permission = 1;
        $registration_permission = 1;
        $payment_permission = 1;
        $sms_permission = 1;
    }
    
?>  
    <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <img class="img img-fluid" src="http://vijay.vijayphysics.com/admin/favicon/logo.png">
            </div>

            <ul class="list-unstyled components">
                <!--Dashboad Setup-->
                <li class="active">
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fa fa-home" id="fa"></i> Dashboard</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li>
                            <a href="<?= base_url()?>">Dashboard</a>
                        </li>
                        
                    </ul>
                </li>
                <!--Session Setup-->
                <?php 
                if($session_permission){
                    ?>
                    <li>
                        <a href="#sessionSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fa fa-calendar" id="fa"></i> Session</a>
                        <ul class="collapse list-unstyled" id="sessionSubmenu">
                            <li> <a href="<?= base_url('sessionsetup/session/add')?>"><i class="fa fa-plus" id="fa"></i>Add Session</a></li>
                            <li> <a href="<?= base_url('sessionsetup/session/select')?>"><i class="fa fa-edit" id="fa"></i>Change Session</a> </li>    
                            <li> <a href="<?= base_url('sessionsetup/session/manage')?>"><i class="fa fa-cog" id="fa"></i>Manage Session</a> </li>    
                        </ul>
                    </li>
                    <?
                }
                ?>
                
                
                <!--Class Setup-->
                <?php 
                if($classes_permission){
                    ?>
                    <li>
                        <a href="#classSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fa fa-user" id="fa"></i> Class</a>
                        <ul class="collapse list-unstyled" id="classSubmenu">
                            <li> <a href="<?= base_url('classsetup/classes/add')?>"><i class="fa fa-plus" id="fa"></i>Add Class</a></li>
                            <li> <a href="<?= base_url('classsetup/classes/manage')?>"><i class="fa fa-cog" id="fa"></i>Manage Class</a> </li>    
                        </ul>
                    </li>
                    <?
                }
                ?>
                
                
                <!--Subject Setup-->
                <?php 
                if($subject_permission){
                    ?>
                    <li>
                        <a href="#subjectSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fa fa-book" id="fa"></i>&nbsp;Subjects</a>
                        <ul class="collapse list-unstyled" id="subjectSubmenu">
                            <li> <a href="<?= base_url('subjectsetup/subject/add')?>"><i class="fa fa-plus" id="fa"></i>Add Subjects</a></li>
                            <li> <a href="<?= base_url('subjectsetup/subject/manage')?>"><i class="fa fa-calendar" id="fa"></i>Manage Subjects</a> </li>    
                        </ul>
                    </li>
                    <?
                }
                ?>
                
                <!--Batch Setup-->
                <?php 
                if($batch_permission){
                    ?>
                    <li>
                        <a href="#batchSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fa fa-users" id="fa"></i>Batches</a>
                         <ul class="collapse list-unstyled" id="batchSubmenu">
                            <li> <a href="<?= base_url('batchsetup/batch/add')?>"><i class="fa fa-plus" id="fa"></i>Add Batches</a></li>
                            <li> <a href="<?= base_url('batchsetup/batch/manage')?>"><i class="fa fa-cog" id="fa"></i>Manage Batches</a> </li>    
                        </ul>
                    </li>
                    <?
                }
                ?>
                
                <!--Staff Setup-->
                <?php 
                if($staff_permission){
                    ?>
                    <li>
                        <a href="#staffSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fa fa-users" id="fa"></i>Staff/Worker</a>
                        <ul class="collapse list-unstyled" id="staffSubmenu">
                            <li> <a href="<?= base_url('staffsetup/staff/add')?>"><i class="fa fa-plus" id="fa"></i>Add Staff/Worker</a></li>
                            <li> <a href="<?= base_url('staffsetup/staff/manage')?>"><i class="fa fa-calendar" id="fa"></i>Manage Staff/Worker</a> </li>  
                            <li> <a href="<?= base_url('staffsetup/staff/grantpermission')?>"><i class="fa fa-cog" id="fa"></i>Grant Permision</a> </li>    
                        </ul>
                    </li>
                    <?
                    }
                ?>
                       
                <!--Registration Setup-->
                <?php 
                if($registration_permission){
                    ?>
                    <li>
                        <a href="#regSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fa fa-graduation-cap" id="fa"></i> Registration</a>
                        <ul class="collapse list-unstyled" id="regSubmenu">
                            <li> <a href="<?= base_url('regsetup/registration/add')?>"><i class="fa fa-plus" id="fa"></i>Add Registration</a></li>
                            <li> <a href="<?= base_url('regsetup/registration/manage')?>"><i class="fa fa-cog" id="fa"></i>Manage Registration</a> </li>  
                            <li> <a href="<?= base_url('regsetup/registration/report')?>"><i class="fa fa-calendar" id="fa"></i>Registration Report</a> </li>    
                        </ul>
                    </li>
                    <?
                }
                ?>
                
                <!--Inquiry Setup-->
                <?php 
                if($inquiry_permission){
                    ?>
                    <li>
                        <a href="#inquirySubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fa fa-cog" id="fa"></i> Inquiry</a>
                        <ul class="collapse list-unstyled" id="inquirySubmenu">
                            <li> <a href="<?= base_url('inquirysetup/inquiry/add')?>"><i class="fa fa-plus" id="fa"></i>Add Inquiry</a></li>
                            <li> <a href="<?= base_url('inquirysetup/inquiry/manage')?>"><i class="fa fa-calendar" id="fa"></i>Manage Inquiry</a> </li>    
                        </ul>
                    </li>
                    <?
                }
                ?>
                
                <!--Payment Setup-->
                <?php 
                if($payment_permission){
                    ?>
                <li>
                    <a href="#paymentSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                     <i class="fa fa-cog" id="fa"></i> Payments</a>
                    <ul class="collapse list-unstyled" id="paymentSubmenu">
                        <li> <a href="<?= base_url('paymentsetup/payment/add')?>"><i class="fa fa-plus" id="fa"></i>Add Payments</a></li>
                        <li> <a href="<?= base_url('paymentsetup/payment/manage')?>"><i class="fa fa-calendar" id="fa"></i>Manage Payments</a> </li> 
                        
                        <li> <a href="<?= base_url('paymentsetup/payment/report')?>"><i class="fa fa-calendar" id="fa"></i>Payment Report</a> </li>    
                    </ul>
                </li>
                <?
                }
                ?>
                                
                <!--SMS Setup-->
                <?php 
                if($sms_permission){
                    ?>
                <li><a href="<?= base_url('smssetup/sms')?>"><i class="fa fa-envelope" id="fa"></i> Message/Sms</a></li>
                <?
                }
                ?>
                
                <li><a href="<?= base_url('helpsupport')?>"> <i class="fa fa-question-circle" id="fa"></i> Help & Support</a></li>
                
            </ul>
        </nav>