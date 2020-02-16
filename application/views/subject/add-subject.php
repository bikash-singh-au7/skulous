<div class="container-fluid">
    <div class="row p-0">
        <div class="col-md-6 m-auto">
            <div class="page-header">
               <div class="inner-content">
                   <!-- Subject Details --> 
                   <div class="row">
                        <div class="col-md-12 p-0 m-0">
                            <?= $this->session->flashdata("success")?>
                        </div>
                        <div class="col-md-12 p-0 m-0 border">
                            <div class="float-left px-2 py-2">
                                <span class="text-muted font-weight-bold">Add Subject </span>
                            </div>
                            <div class="float-right px-2">
                                <a href="<?= base_url('welcome/subject/manage')?>">
                                    <button class="btn btn-info px-2 my-1" type="button"> <i class="fa fa-cog"></i> Subject </button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <form method="post" action="<?= base_url('welcome/subject/add')?>" class="">
                       <div class="row border pt-2">
                         <div class="col-md-12 m-auto">
                            <div class="form-group">
                                <label for="">Subject name <span class="text-danger">*</span></label>
                                <input type="text" name="subject_name" class="form-control" value="<?= set_value('subject_name')?>" placeholder="Enter Subject like Phy/Che">
                                <?= form_error("subject_name")?>
                            </div>
                            
                            <div class="form-group">
                                <label for="">Comment</label>
                                <input type="text" name="comment" class="form-control" value="<?= set_value('comment')?>" placeholder="Comments Here">
                                <?= form_error("comment")?>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="sbmt" class="btn btn-info">
                                <input type="reset" name="reset" class="btn btn-danger">
                            </div>
                          </div> 
                        </div>   
                    </form>  
               </div>     
        </div>

    </div>
</div>