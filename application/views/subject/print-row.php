<?php
date_default_timezone_set("Asia/Kolkata");
//It print the data for "manage session" page when add the new session
if($action == "manage-add"){
    foreach($result as $value){
        ?>
            <tr id="row-<?=$value->id?>">
            <td><?=$value->id?></td>
            <td><?=$value->subject_name?></td>
            <td><?=$value->subject_code?></td>
            <td class="text-center">
                <?php
                    if($value->subject_status == 1){
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
                                                    
            <td><button class="btn btn-info px-2 py-1" onclick="getId('<?= $value->id?>')"> <i class="fa fa-edit"></i> </button></td>
            <td><button class="btn btn-danger px-2 py-1" onclick="deleteData('<?= $value->id?>')"> <i class="fa fa-trash"></i> </button></td>
    
            </tr>
        <?
    }
}


//Update
if($action == "update"){
    foreach($result as $value){
        ?>         
            <td><?=$value->id?></td>
            <td><?=$value->subject_name?></td>
            <td><?=$value->subject_code?></td>
            <td class="text-center">
                <?php
                    if($value->subject_status == 1){
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
                                                    
            <td><button class="btn btn-info px-2 py-1" onclick="getId('<?= $value->id?>')"> <i class="fa fa-edit"></i> </button></td>
            <td><button class="btn btn-danger px-2 py-1" onclick="deleteData('<?= $value->id?>')"> <i class="fa fa-trash"></i> </button></td>
            
        <?
    }
}
?>