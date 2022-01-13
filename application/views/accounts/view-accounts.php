<?php defined('BASEPATH') OR exit('') ?>

<div class="row">
                    <div class="col-sm-4">
                        <label for="d1" class="">From</label>
                        <input type="date" id="d1" name="d1" class="form-control" >
                    </div>
                    <div class="col-sm-4">
                        <label for="d2" class="">To</label>
                        <input type="date" id="d2" name="d2" class="form-control" >
                    </div>
                    <div class="col-sm-4">
                        <br>
                        <button class="btn btn-primary btn-sm" id="print1" onclick="printDivAccountLedger('accountListTable1')">Print Ledger</button>
                    </div>
</div> 
<hr>
<div class="panel panel-primary" id="Statement">
    <!-- Default panel contents -->
  

    <h3>Account Statement of: <?= $accName ?> &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;Current Balance: <?= number_format($balance) ?></h3>
    
    <?php if($accountTransactions): ?>
        <?php $sn = 1; ?>
    <div class="col-sm-12" id="accountListTable1">
    <div class="table table-responsive">
        <table class="table table-bordered table-striped" id="ledger">
            <thead>
                <tr>
                    <th>SN</th>
                    <th></th>
                    <th>Date</th>
                    <?php   if($accName === 'Cash In Hand'):?>
                    <th>Cash To / From</th>
                  <?php endif;?>
                    <th>Amount Plus</th>
                    <th>Amount Minus</th>
                    <th>Accumulated</th>
                    <th>Description</th>
                    <th>Link</th>
                    
                    
                </tr>
            </thead>
            <?php $sum = 0;?>
            <tbody>
                <?php foreach($accountTransactions as $get): ?>
                <tr>
                    <input type="hidden" value="<?=$get->transId?>" class="curTransId">
                    <th class="transSN"><?= $sn ?>.</th>
                    <td><a class="pointer vICr"><?= $get->transId ?></a></td>
                    <td><?= $get->transactionDate ?></td>
                    <?php   if($accName === 'Cash In Hand'):?>
                    <td><?= $get->referenceNo ?></td>
                  <?php endif;?>
                    
                    
                    <?php   if($accName === 'Cash In Hand' || $accName === 'factory' || $accName === 'pvcDoor' || $accName === 'HP Hattar' || $type === 'payable'):?>
                      <td><?= number_format($get->creditAmount) ?></td>
                      <td><?= number_format($get->debitAmount) ?></td>
                    <?php else: ?>
                      <td><?= number_format($get->debitAmount) ?></td>
                    <td><?= number_format($get->creditAmount) ?></td>
                    <?php endif; ?>
                    
                  <?php   if($accName === 'factory' || $accName === 'Cash In Hand' || $accName === 'pvcDoor' || $accName === 'HP Hattar' || $type === 'payable' ){
                          if($get->debitAmount){ $sum = $sum - $get->debitAmount;}
                          if($get->creditAmount){ $sum = $sum + $get->creditAmount;}
                  }else{
                          if($get->debitAmount){ $sum = $sum + $get->debitAmount;}
                          if($get->creditAmount){ $sum = $sum - $get->creditAmount;}} ?>
                    <td><?= number_format($sum)?></td>
                    <td><?= $get->description ?></td>
                    <td><a href="<?= $get->hlink ?>"  target="blank"><span class ="hidden-print"><?= $get->hlink ?></span></a></td>
                    <td class="text-center text-primary hidden-print">
                        <a href="<?php echo site_url(); echo isset($get->creditAmount)? 'Cashbook/incomingCashEdit/' : 'Cashbook/outgoingCashEdit/' ; echo $get->transId;?>" >Edit</a>
                            <i class="fa fa-pencil pointer"></i>
                    </td>


                    
                    
                </tr>

                <?php $sn++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    </div>
<!-- table div end-->
    <?php else: ?>
        <ul><li>No Transactions</li></ul>
    <?php endif; ?>
    
</div>



<div class="row">
                    <div class="col-sm-2">
                    <button class="btn btn-primary btn-sm" id="print" onclick="printDiv('Statement')">Print</button></div>
</div>  

<!-- panel end-->