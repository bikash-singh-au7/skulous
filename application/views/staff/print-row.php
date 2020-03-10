<?php
date_default_timezone_set("Asia/Kolkata");
//Update
if($action == "update"){
    foreach($result as $value){
        ?>         
            <td><?=$value->id?></td>
            <td><?=$value->staff_name?></td>
            <td><?=$value->mobile_number?></td>
            <td><?=$value->email?></td>
            <td class="text-center">
                <?php
                    if($value->staff_status == 1){
                        $status = 1;
                        echo"<span class='badge badge-info'>Active</span>";
                    }else{
                        $status = 0;
                        echo"<span class='badge badge-danger'>Disable</span>";
                    }
                ?>
            </td>
            <td class="text-center"><?=date("d-M-Y h:m:s A", strtotime($value->created_date))?></td>
                                                    
            <td class="text-center">
                <button class="btn btn-info px-2 py-1" onclick="getId('<?= $value->id?>')"> <i class="fa fa-edit"></i> </button>

                <button class="btn btn-success px-2 py-1" onclick="getPermission('<?= $value->id?>')"> <i class="fa fa-cog"></i> </button>

                <button class="btn btn-danger px-2 py-1" onclick="deleteData('<?= $value->id?>')"> <i class="fa fa-trash"></i> </button>
            </td>
            
        <?
    }
}
?>