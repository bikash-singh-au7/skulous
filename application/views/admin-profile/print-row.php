<?php
if($action == "update"){
    foreach($data as $value){
        ?>
        <td><?= $value->id?></td>
        <td><?= $value->format_string?></td>
        <td>
            <?php
            if($value->status == 1){
                ?>
                <span class="badge badge-info">Active</span>
                <?
            }else{
                ?>
                <span class="badge badge-danger">Disabled</span>
                <?
            }
            ?>
        </td>
        <td class="text-center">
            <button class="btn btn-info px-2 py-1" onclick="getId('<?= $value->id?>')"> <i class="fa fa-edit"></i> </button>
            <button class="btn btn-danger px-2 py-1" onclick="deleteData('<?= $value->id?>')"> <i class="fa fa-trash"></i> </button>
        </td>
        <?
    }
}

if($action == "add"){
    foreach($data as $value){
        ?>
        <tr id="row-<?= $value->id?>">
            <td><?= $value->id?></td>
            <td><?= $value->format_string?></td>
            <td>
                <?php
                if($value->status == 1){
                    ?>
                    <span class="badge badge-info">Active</span>
                    <?
                }else{
                    ?>
                    <span class="badge badge-danger">Disabled</span>
                    <?
                }
                ?>
            </td>
            <td class="text-center">
                <button class="btn btn-info px-2 py-1" onclick="getId('<?= $value->id?>')"> <i class="fa fa-edit"></i> </button>
                <button class="btn btn-danger px-2 py-1" onclick="deleteData('<?= $value->id?>')"> <i class="fa fa-trash"></i> </button>
            </td>
        </tr>
        <?
    }
}
?>