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
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            