<?php 
    $startSession = date("Y-m-d");
    $date = getdate(strtotime($startSession));
    $endSession = (int)$date["year"] + 1 ."-". sprintf("%02d", $date["mon"]). "-" . sprintf("%02d", (int)$date["mday"]-1);
?>
<div class="container-fluid">
    <div class="row p-0">
        <div class="col-md-11 m-auto">
            <div class="page-header">
               <div class="inner-content">
                   <!-- Session Details --> 
                   <div class="row">
                        <div class="col-md-12 p-0 m-0">
                            <?= $this->session->flashdata("success")?>
                        </div>
                        <div class="col-md-12 p-0 m-0 border">
                            <div class="float-left px-2 py-2">
                                <span class="text-muted font-weight-bold">Manage Session</span>
                            </div>
                            <div class="float-right px-2">
                                <button class="btn btn-info px-2 my-1" type="button" data-toggle="modal" data-target="#addSession"> <i class="fa fa-plus"></i> Session </button>
                            </div>
                        </div>
                    </div>
                    <div class="">
                       <div class="row border">
                        <div class="col-md-12 m-auto p-0 table-responsive">
                            <?php
                            if(empty($session)){
                                ?>
                                    <div class="alert alert-danger rounded-0..">There is no data. Please add first!</div>
                                <?
                            }else {
                                ?>
                                <table class="table table-striped table-hover m-0">
                                    <tr>
                                        <th>#Id</th>
                                        <th>Session Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th class="text-center">DOC</th>
                                        <th>Status</th>
                                        <th colspan=2 class="text-center">Action</th>
                                    </tr>    
                                    <?
                                        foreach($session as $value){
                                            ?>
                                                <tr>
                                                    <td><?=$value->id?></td>
                                                    <td><?=$value->session_name?></td>
                                                    <td><?=date("d-M-Y", strtotime($value->start_session))?></td>
                                                    <td><?=date("d-M-Y", strtotime($value->end_session))?></td>
                                                    <td class="text-center"><?=date("d-M-Y h:m:s A")?></td>
                                                    <td class="text-center">
                                                        <?php
                                                            if($value->session_status == 1){
                                                                $status = 1;
                                                                echo"<span class='badge badge-info'>Active</span>";
                                                            }else{
                                                                $status = 0;
                                                                echo"<span class='badge badge-danger'>Disable</span>";
                                                            }
                                                        ?>
                                                    </td>
                                                    <td><button class="btn btn-info px-2 py-1" type="button" data-toggle="modal" data-target="#updateSession<?=$value->id?>"> <i class="fa fa-edit"></i> </button></td>
                                                    <td><button class="btn btn-danger px-2 py-1" type="button" data-toggle="modal" data-target="#deleteSession<?=$value->id?>"> <i class="fa fa-trash"></i> </button></td>
                                                </tr>

                                                <!--Delete session Modal---->
                                                <div class="modal fade" id="deleteSession<?=$value->id?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h6 class="modal-title" id="deleteSessionlabel">Delete Session</h6>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <img class="img img-responsive" height=100 src="<?= base_url('assets/images/danger.png')?>" alt="">
                                                            <h5 class="text-muted">Do you want to delete?</h5>
                                                        </div>
                                                        <div class="m-auto pb-2">
                                                            <form action="<?= base_url('sessionsetup/session/manage/delete/')?>" method="post">
                                                                <input type="hidden" value="<?= $value->id?>" name="session_id">
                                                                <button type="submit" class="btn btn-danger" name="delSbmt">Delete</button>
                                                                <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                                                            </form>
                                                            
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!--Update session form---->
                                                <div class="modal fade" id="updateSession<?=$value->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h6 class="modal-title" id="updateSessionlabel">Update Session</h6>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= base_url('sessionsetup/session/manage/update')?>" method="post" id="updateSessionForm">
                                                                <div class="form-group">
                                                                    <label for="">Session Name <span class="text-danger">*</span></label>
                                                                    <input type="text" name="session_name" value="<?= $value->session_name?>" class="form-control" placeholder="Enter session name">
                                                                    <input type="hidden" name="session_id" value="<?= $value->id?>" class="form-control">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">Start Session <span class="text-danger">*</span></label>
                                                                    <input type="date" name="start_session" class="form-control" value="<?= date('Y-m-d', strtotime($value->start_session)); ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">End Session <span class="text-danger">*</span></label>
                                                                    <input type="date" name="end_session" class="form-control" value="<?= date('Y-m-d', strtotime($value->end_session)); ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">Status <span class="text-danger">*</span></label>
                                                                    <select name="session_status" id="" class="form-control">
                                                                        <option value="1" <?php if($status==1){echo'selected';} ?> >Active</option>
                                                                        <option value="0" <?php if($status==0){echo'selected';} ?> >Disable</option>
                                                                    </select>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-info" name="updtSbmt" form="updateSessionForm">Update</button>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?
                                        }                                    
                                    
                                    ?>                            
                                </table>
                                <?   
                            }                           
                            
                            ?>
                        </div> 
                        </div>   
                    </div>  
               </div>     
        </div>

        <!--Add session form---->
        <div class="modal fade" id="addSession" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="addSessionlabel">Add Session</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('sessionsetup/session/add')?>" method="post" id="sessionForm">
                        <div class="form-group">
                            <label for="">Session Name <span class="text-danger">*</span></label>
                            <input type="text" name="session_name" class="form-control" placeholder="Enter session name">
                            
                        </div>
                        <div class="form-group">
                            <label for="">Start Session <span class="text-danger">*</span></label>
                            <input type="date" name="start_session" class="form-control" value="<?= $startSession; ?>">
                        </div>
                        <div class="form-group">
                            <label for="">End Session <span class="text-danger">*</span></label>
                            <input type="date" name="end_session" class="form-control" value="<?= $endSession; ?>">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info" form="sessionForm">Add</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>