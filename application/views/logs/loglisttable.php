<?php defined('BASEPATH') OR exit('') ?>

<div class='col-sm-6'>
    <?= isset($range) && !empty($range) ? $range : ""; ?>
</div>



<div class='col-xs-12'>
    <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading">Event Log</div>
        <?php if($allLog): ?>
        <div class="table table-responsive">
            <table class="table table-bordered table-striped" style="background-color: #f5f5f5">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Event</th>
                        <th>Item Code / Transaction Ref</th>
                        <th>Item Name</th>
                        <th>Description</th>
                        <th>Table</th>
                        <th>Staff</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($allLog as $get): ?>
                    <tr>
                        <input type="hidden" value="<?=$get->id?>" class="curItemId">
                        <th class="itemSN"><?=$sn?>.</th>
                        <td><span id="itemName-<?=$get->id?>"><?=$get->event?></span></td>
                        <td><span id="itemUrduName-<?=$get->id?>"><?=$get->eventItemCodeOrRef?></span></td>
                        <td><span id="itemCode-<?=$get->id?>"><?=$get->itemName?></td>
                        <td>
                            <span id="itemDesc-<?=$get->id?>" data-toggle="tooltip" title="<?=$get->eventDesc?>" data-placement="auto">
                                <?=word_limiter($get->eventDesc, 100)?>
                            </span>
                        </td>
                        <td><span id="itemLocation-<?=$get->id?>"><?=$get->eventTable?></span></td>
                        <td><span><?=$this->genmod->gettablecol('admin', 'name', 'id', $get->staffInCharge)?></span></td>
                        
                        <td><span id="itemPrice-<?=$get->id?>"><?=$get->eventTime?></span></td>
                        
                    </tr>
                    <?php $sn++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- table div end-->
        <?php else: ?>
        <ul><li>No items</li></ul>
        <?php endif; ?>
    </div>
    <!--- panel end-->
</div>

<!---Pagination div-->
<div class="col-sm-12 text-center">
    <ul class="pagination">
        <?= isset($links) ? $links : "" ?>
    </ul>
</div>
