<div class="container-fluid">
    <div class="row p-0">
        <div class="col-md-11 m-auto">
            <div class="page-header">
               <div class="inner-content">
                   <!-- Class Details --> 
                   <div class="row">
                        <div class="col-md-12 p-0 m-0">
                            <?= $this->session->flashdata("success")?>
                        </div>
                        <div class="col-md-12 p-0 m-0 border">
                            <div class="float-left px-2 py-2">
                                <span class="text-muted font-weight-bold">Manage Class</span>
                            </div>
                            <div class="float-right px-2">
                                <button class="btn btn-info px-2 my-1" type="button" data-toggle="modal" data-target="#addClass"> <i class="fa fa-plus"></i> Class </button>
                            </div>
                        </div>
                    </div>
                    <div class="">
                       <div class="row border">
                        <div class="col-md-12 m-auto p-0 table-responsive">
                            <?php
                            if(empty($data)){
                                ?>
                                    <div class="alert alert-danger rounded-0">There is no data. Please add first!</div>
                                <?
                            }else {
                                ?>
                                <table class="table table-striped table-hover m-0">
                                    <tr>
                                        <th>#Id</th>
                                        <th>Class Name</th>
                                        <th>Status</th>
                                        <th>Comments</th>
                                        <th class="text-center">DOC</th>
                                        <th colspan=2 class="text-center">Action</th>
                                    </tr>    
                                    <?
                                        foreach($data as $value){
                                            ?>
                                                <tr>
                                                    <td><?=$value->id?></td>
                                                    <td><?=$value->class_name?></td>
                                                    <td class="text-center">
                                                        <?php
                                                            if($value->class_status == 1){
                                                                $status = 1;
                                                                echo"<span class='badge badge-info'>Active</span>";
                                                            }else{
                                                                $status = 0;
                                                                echo"<span class='badge badge-danger'>Disable</span>";
                                                            }
                                                        ?>
                                                    </td>
                                                    <td><?=$value->comment?></td>
                                                    <td class="text-center"><?=date("d-M-Y h:m:s A", strtotime($value->created_date))?></td>
                                                    
                                                    <td><button class="btn btn-info px-2 py-1" type="button" data-toggle="modal" data-target="#updateClass<?=$value->id?>"> <i class="fa fa-edit"></i> </button></td>
                                                    <td><button class="btn btn-danger px-2 py-1" type="button" data-toggle="modal" data-target="#deleteClass<?=$value->id?>"> <i class="fa fa-trash"></i> </button></td>
                                                </tr>

                                                <!--Delete session Modal---->
                                                <div class="modal fade" id="deleteClass<?=$value->id?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h6 class="modal-title" id="deleteSessionlabel">Delete Class</h6>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <img class="img img-responsive" height=100 src="<?= base_url('assets/images/danger.png')?>" alt="">
                                                            <h5 class="text-muted">Do you want to delete?</h5>
                                                        </div>
                                                        <div class="m-auto pb-2">
                                                            <form action="<?= base_url('welcome/classes/manage/delete/')?>" method="post">
                                                                <input type="hidden" value="<?= $value->id?>" name="class_id">
                                                                <button type="submit" class="btn btn-danger" name="delSbmt">Delete</button>
                                                                <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                                                            </form>
                                                            
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!--Update Class form--->
                                                <div class="modal fade" id="updateClass<?=$value->id?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h6 class="modal-title" id="updateClasslabel">Update Class</h6>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= base_url('welcome/classes/manage/update')?>" method="post" id="updateClassForm<?=$value->id?>">
                                                                <div class="form-group">
                                                                    <label for="">Class name <span class="text-danger">*</span></label>
                                                                    <input type="text" name="class_name" class="form-control" value="<?= $value->class_name?>" placeholder="Enter class like 11th/12th">
                                                                    <input type="hidden" name="class_id" class="form-control" value="<?= $value->id?>">
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label for="">Status <span class="text-danger">*</span></label>
                                                                    <select name="class_status" id="" class="form-control">
                                                                        <option value="1" <?php if($status==1){echo'selected';} ?> >Active</option>
                                                                        <option value="0" <?php if($status==0){echo'selected';} ?> >Disable</option>
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">Comment</label>
                                                                    <input type="text" name="comment" class="form-control" value="<?= $value->comment ?>" placeholder="Comments Here">
                                                                </div>  

                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-info" name="updtSbmt" form="updateClassForm<?=$value->id?>">Update</button>
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
        <div class="modal fade" id="addClass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="addClasslabel">Add Class</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('welcome/classes/add')?>" method="post" id="AddClassForm">
                        <div class="form-group">
                            <label for="">Class name <span class="text-danger">*</span></label>
                            <input type="text" name="class_name" class="form-control" value="<?= set_value('class_name')?>" placeholder="Enter class like 11th/12th">
                            <?= form_error("class_name")?>
                        </div>
                            
                        <div class="form-group">
                            <label for="">Comment</label>
                            <input type="text" name="comment" class="form-control" value="<?= set_value('comment')?>" placeholder="Enter class like 11th/12th">
                            <?= form_error("comment")?>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info" form="AddClassForm">Add</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>