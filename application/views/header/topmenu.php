       <!-- Page Content  -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light p-2 mb-3">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-info px-2 py-1">
                        <i class="fas fa-align-left"></i>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto px-2 py-1" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>
                    
                    
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <div class="nav navbar-nav m-auto">
                            <span class="badge badge-info px-3 py-2"> 
                                <?php 
                                    $data["session"] = $this->work->select_data("session", ["id"=>$this->session->userdata('session_id')]);
                                    foreach($data["session"] as $value){
                                        $start_session_date = date("M/Y",strtotime($value->start_session));
                                        $end_session_date = date("M/Y",strtotime($value->end_session));
                                        $final_session = $start_session_date."-".$end_session_date;
                                        echo $final_session;    
                                    }
                                ?>
                                
                            </span>
                        </div>
                        
                    </div>
                    <!-- Admin Sections-->     
                        <div class="btn-group">
                           
                           <?php
                                if($this->session->userdata("type") == "staff"){
                                    $profile_url = base_url("StaffSetup/profile");
                                    $setting_url = base_url("StaffSetup/setting");
                                    $logout_url = base_url("welcome/stafflogout");
                                    $type = "Staff";
                                }else{
                                    $profile_url = base_url("AdminSetup/profile");
                                    $setting_url = base_url("AdminSetup/setting");
                                    $logout_url = base_url("welcome/logoutogout");
                                    $type = "Admin";
                                }
                                
                                
                           ?>
                           
                           
                            <button type="button" class="btn btn-info rounded-0" data-toggle="dropdown"> <i class="fa fa-user"></i> <?= $type?></button>
                            <div class="dropdown-menu dropdown-menu-right p-0 border-0 shadow-sm rounded-0">
                                <a href="<?= $profile_url;?>" class="dropdown-item px-3"> <i class="fa fa-user"></i> Profile</a>
                                <a href="<?= $setting_url;?>" class="dropdown-item px-3"> <i class="fa fa-cog"></i> Setting</a>
                                <a href="<?= $logout_url;?>" class="dropdown-item px-3"> <span class="fa fa-power-off"></span> Logout</a>
                            </div>
                        </div>
                </div>
            </nav>
            
            
            