<?php
    $data["data"] = $this->work->select_data("registration", ["id"=>$this->session->userdata("id")]);
    $data = $data["data"];
    ?>
    <div class="container">
        <div class="row">
           <div class="col-md-10  m-auto">
            <?
            foreach($data as $value){
                ?>  <div class="row px-2 my-1">
                        <div class="col-md-12 m-0 shadow-sm bg-white">
                            <h5 class="text-info py-2"> <i class="fa fa-edit" bg-white></i> Payment Details</h5>
                        </div>
                    </div>
                    <div class="row px-2">
                        <!--Intero-->
                        <div class="col-md-12 shadow-sm py-2 mb-1 bg-white">
                            <div class="row">
                                
                                <div class="col-md-10">
                                    <div class="float-left">
                                        <img src="https://www.freeiconspng.com/uploads/male-icon-4.jpg" alt="" class="img profile-pic">
                                    </div>
                                    <div class="float-right">
                                        <h5 class="text-info">  <i class="fa fa-user"></i> <?= $value->student_name?></h5>
                                        <p class="p-0 m-0"> <i class="fa fa-phone"></i> <?= $value->student_mobile?></p>
                                        <p class="p-0 m-0">  <i class="fa fa-envelope"></i> <?= $value->student_email?></p>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                </div>
                            </div>
                        </div>
                     

                        <!--Payment Details--->
                        <div class="col-md-12 shadow-sm py-2 mb-1 bg-white">
                            <h5 class="text-info"> <i class="fa fa-rupee-sign" bg-white></i> Payment Details</h5>
                            <?php
                                $payment_info = $this->work->select_data("payment", ["reg_id"=>$value->id]);
                                $total_payment = 0;
                                foreach($payment_info as $info){
                                    $total_payment += $info->amount;
                                }

                                // From Batch
                                $batch_info = $this->work->select_data("batch", ["id"=>$value->batch_id]);
                                $batch_fee = $batch_info[0]->batch_fee;
                                $batch_discount = $batch_info[0]->discount;

                                //From Regitration
                                $reg_discount = $value->discount;

                                //check full paid or not
                                if($value->full_paid == 1){
                                    $dues_amount = 0;
                                    $pay_status = "<span class='badge badge-info'>Full Paid</span>";
                                    $note = "<span class='badge badge-warning'>The student may got some additional discount</span>";
                                }else{
                                    $dues_amount = $batch_fee - ($batch_discount+$reg_discount+$total_payment);
                                    $pay_status = "<span class='badge badge-danger'>Unpaid</span>";
                                    $note= "";
                                }

                                if(empty($payment_info)){
                                    ?>

                                    <div class="row">
                                        <div class="col-md-6"><h6 class='font-weight-bold text-muted'>Dues Amount</h6></div>
                                        <div class="col-md-6"><h6 class='font-weight-bold text-danger'><?= "<i class='fa fa-rupee-sign'></i>". $dues_amount?></h6></div>

                                    </div>

                                    <?
                                }else{
                                    ?>
                                        <div class="row">
                                            <div class="col-md-3"><h6 class='font-weight-bold text-muted'>#Payment Id</h6></div>
                                            <div class="col-md-3"><h6 class='font-weight-bold text-muted'>Mode</h6></div>
                                            <div class="col-md-3"><h6 class='font-weight-bold text-muted'>Payment Date</h6></div>
                                            <div class="col-md-3"><h6 class='font-weight-bold text-muted'>Amount</h6></div>
                                        </div>
                                        <?
                                        $total_payment = 0;
                                        foreach($payment_info as $info){
                                            $total_payment += $info->amount;
                                            ?>
                                            <div class="row">
                                                <div class="col-md-3"><h6 class='text-muted'>
                                                    <?= $info->id?>
                                                </h6></div>
                                                <div class="col-md-3"><h6 class='text-muted'>
                                                    Manual
                                                </h6></div>
                                                <div class="col-md-3"><h6 class='text-muted'>
                                                    <?= $info->payment_date?>
                                                </h6></div>
                                                <div class="col-md-3"><h6 class='text-muted'>
                                                    <?= $info->amount?>
                                                </h6></div>

                                            </div>
                                            <?
                                        }
                                        ?>
                                            <div class="row mt-2">

                                                <div class="col-md-6"></div>
                                                <div class="col-md-6 text-muted">
                                                    <div class="row">                                           
                                                        <div class="col-md-6 border-top">Total</div>
                                                        <div class="col-md-6 border-top"><?= $total_payment?></div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 border-top">Batch Fee</div>
                                                        <div class="col-md-6 border-top"><?= $batch_fee?></div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 border-top">Batch Discount</div>
                                                        <div class="col-md-6 border-top"><?= $batch_discount?></div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">Student Discount</div>
                                                        <div class="col-md-6"><?= $reg_discount?></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 border-top text-info">Dues Amount</div>
                                                        <div class="col-md-6 border-top text-info">
                                                        <?php 
                                                            echo "<i class='fa fa-rupee-sign'></i>". $dues_amount;
                                                        ?>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 border-top">Payment Status</div>
                                                        <div class="col-md-6 border-top">
                                                            <?= $pay_status?>

                                                        </div>
                                                        <col-md-12><?=$note?></col-md-12>
                                                    </div>
                                                </div>
                                            </div>
                                        <?

                                }
                            ?>

                        </div>

                    </div>
                <?
            }
        ?>
        </div>
    </div>
</div>