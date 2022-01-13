<?php defined('BASEPATH') OR exit('') ?>


<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading"><?= $heading ?></div>
    <?php if($Cash): ?>
    <div class="table table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>SN</th>
                    <th class="hidden-print">Trans Id</th>
                    <th class="hidden-print">Category</th>
                    <th class="hidden-print"><?= $flag ?></th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Link</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php $cumTotal = 0;
                 ?>

                <?php foreach($Cash as $get): ?>
                <tr>
                    <input type="hidden" value="<?=$get->transId?>" class="curTransId">
                    <th class="transSN"><?= $sn ?>.</th>
                    
                        <td><a class="pointer vICr" title="Click to view receipt"><?= $get->transId ?></a></td>
                    
                       
                    <td class="hidden-print"><?= $get->type ?></td>
                    <td class="hidden-print"><?= $get->referenceNo ?></td>
                    <td><?= isset($get->creditAmount)? number_format($get->creditAmount) : number_format($get->debitAmount) ?></td>
                    <td><?= $get->description ?></td>
                    <td><a href="<?= $get->hlink ?>" target="blank"><?= $get->hlink ?></a></td>

                    <td class="text-center text-primary hidden-print">
                        <a href="<?php echo site_url(); echo isset($get->creditAmount)? 'Cashbook/incomingCashEdit/' : 'Cashbook/outgoingCashEdit/' ; echo $get->transId;?>" >Edit</a>
                            <i class="fa fa-pencil pointer"></i>
                    </td>
                    <td class="text-center hidden-print" id="<?=$get->transId?>">
                        <a href="<?php echo site_url(); echo isset($get->creditAmount)? 'Cashbook/deleteIncomingPost/' : 'Cashbook/deleteOutgoingPost/' ; echo $get->transId;?>" ><i class="fa fa-trash text-danger delItem pointer"></i></a>
                        </td>
        
                                
                </tr>
                <?php $sn++; isset($get->creditAmount)? $cumTotal+=$get->creditAmount : $cumTotal+=$get->debitAmount; 
                 ?>
                <?php endforeach; ?>
                <tr>
                    <th class="hidden-print"></th>
                    <td class="hidden-print"></td>
                    <td>Total</td>
                    <td><b>Rs<?= number_format($cumTotal) ?></b></td>
                    <td class="hidden-print"></td>
                    <td class="hidden-print"></td>

                </tr>
            </tbody>
        </table>
    </div>
<!-- table div end-->
    <?php else: ?>
        <ul><li>No Transactions</li></ul>
    <?php endif; ?>
    
    
</div>
<!-- panel end-->