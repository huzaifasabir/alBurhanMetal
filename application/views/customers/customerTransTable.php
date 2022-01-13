<?php defined('BASEPATH') OR exit('') ?>

<?= isset($range) && !empty($range) ? $range : ""; ?>
<div class="panel panel-primary" id="customer">
    <!-- Default panel contents -->
    <h3>Outstanding Balance: Rs <?= number_format($outstandingBalance) ?></h3>
    <div class="col-sm-12" id="transListTable">
    <h3>TRANSACTIONS</h3>
    <?php if($customerPurchase): ?>
        
    <div class="table table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Receipt No</th>
                    <th>Total Items</th>
                    <th>Total Amount</th>
                    <th>Amount Tendered</th>
                    <th>Remaining Balance</th>
                    <th>Total Profit</th>
                    <th>Staff</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($customerPurchase as $get): ?>
                <tr>
                    <input type="hidden" value="<?=$get->ref?>" class="curTransId">
                    <th class="transSN"><?= $sn ?>.</th>
                    <td><a class="pointer vtr" title="Click to view receipt"><?= $get->ref ?></a></td>
                    <td><?= $get->quantity ?></td>
                    <td>Rs <?= number_format($get->cumulativeAmount - $get->previousBalance) ?></td>
                    <td>Rs <?= number_format($get->amountTendered) ?></td>
                    <td>Rs <?= number_format($get->remainingBalance) ?></td>
                    <td>Rs <?=  number_format($get->totalProfit)?></td>
                    <td><?=$get->staffName?></td>
                    <td><?=$get->cust_name?></td>
                    <td><?= $get->transDate ?></td>
                    <td class="text-center"><i class="fa fa-trash text-danger delItem pointer"></i></td>
                </tr>
                <?php $sn++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
<!-- table div end-->
    <?php else: ?>
        <ul><li>No Transactions</li></ul>
    <?php endif; ?>


<h3>Customer Returns</h3>
    <?php if($customerReturns): ?>

        <?php $sn = 1; ?>
    <div class="table table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Receipt No</th>
                    <th>Total Items</th>
                    <th>Total Amount</th>
                    <th>Previous Balance</th>
                    <th>Amount Payable</th>
                    <th>Remaining Balance</th>
                    <th>Profit Reduction</th>
                    <th>Staff</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($customerReturns as $get): ?>
                <tr>
                    <input type="hidden" value="<?=$get->returnRef?>" class="curTransId">
                    <th class="transSN"><?= $sn ?>.</th>
                    <td><a class="pointer vtrR" title="Click to view receipt"><?= $get->returnRef ?></a></td>
                    <td><?= $get->quantity ?></td>
                    <td>Rs <?= number_format($get->invoiceTotal) ?></td>
                    <td>Rs <?= number_format($get->previousBalance) ?></td>
                    <td>Rs <?= number_format($get->amountPayable) ?></td>
                    <td>Rs <?= number_format($get->remainingBalance) ?></td>
                    <td>Rs <?=  number_format($get->profitReduction)?></td>
                    <td><?=$get->staffName?></td>
                    <td><?=$get->cust_name?></td>
                    <td><?= $get->transDate ?></td>
                    <td class="text-center"><i class="fa fa-trash text-danger delItem pointer"></i></td>
                </tr>
                <?php $sn++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
<!-- table div end-->
    <?php else: ?>
        <ul><li>No Transactions</li></ul>
    <?php endif; ?>


    <h3>Customer Payments</h3>
    
    <?php if($customerTransactions): ?>
        <?php $sn = 1; ?>
    <div class="col-sm-12" id="">
    <div class="table table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Description</th>
                    
                    
                </tr>
            </thead>
            <tbody>
                <?php foreach($customerTransactions as $get): ?>
                <tr>
                    <input type="hidden" value="<?=$get->transId?>" class="curTransId">
                    <th class="transSN"><?= $sn ?>.</th>
                    
                    <td><?= $get->transactionDate ?></td>
                    <td>Rs <?= isset($get->creditAmount) ? number_format($get->creditAmount): number_format($get->debitAmount) ?></td>
                    <td><?= $get->description ?></td>
                    
                    
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

    <h3>Customer Ledger</h3>

    <?php  if($customerLedger): ?>
    <div class="col-sm-12" id="purchaseListTable2">
        <div class="row">
                            <div class="col-xs-3 text-center text-uppercase">
                                <center style='margin-top: 2px'><img src="<?=base_url()?>public/images/favicon.jpeg" alt="logo" class="img-responsive" style="width:100px; height: 100px;"></center>
                            </div>
                            <div class="col-xs-7 text-center">
                                <h6 class="text-center"><b class="red1" style=" font-size: 15px;">Haidery Plywood Agency</b>
                                    <br>
                                    <span class="green1" style="">61A, Jinnah Road</span>
                                    <br>
                                    <span class="green1" style="">Rawalpindi</span>
                                    <br>
                                    <span class="red1" >051-5559265 <i class="fa fa-whatsapp" style="color: green;"></i></span>
                                    <br><a>www.haideryplywood.com </a>
                                </h6>
                                
                                <div></div>
                            </div>
                        </div>
                        <div class="row">
                            
            <div class="col-xs-4" style="border: 1px solid black; ">
            
            <b>Customer:</b><br>
            <b><?=isset($customerName) ? $customerName : ""?></b>
        </div>
        <div class="col-xs-4"></div>
        
        <div class="col-xs-4" style="border: 1px solid black; ">
            
            <b>From:</b><br>
            <b id="fromDate"></b>
        </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-4" style="border: 1px solid black; ">
            
            <b>Printed On:</b><br>
            <b><?=date("Y-m-d")?></b>
        </div>
                            
            
        <div class="col-xs-4"></div>
        <div class="col-xs-4" style="border: 1px solid black; ">
            
            <b>To:</b><br>
            <b id="toDate"></b>
        </div>

                        </div>
    <div class="table table-responsive" >
        <table class="table table-bordered table-striped" id="ledger">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Receipt #</th>
                    <th>Date</th>
                    <th>Particulars</th>
                    <th>QTY</th>
                    <th>Rate</th>
                    <th>Total Amount</th>
                    <th>Plus</th>
                    <th>Minus</th>
                    <th>Accumulated</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php $sn = 1; $previousRef = 0; $previousName=NULL; $previousCash = 0; $previousTotal=0; $refTotal=0; $Accumulated = 0; foreach($customerLedger as $get):  ?>
                <?php if($get->ref === 'customer'){?>
                
                <?php }?>
                <?php  ?>
                <?php if ($previousRef === $get->ref) {
                    
                        $refTotal += $get->amount;
                    }else{ if ($get->ref === 'customer') { if(is_numeric($previousName)){$Accumulated += ($previousTotal - $previousCash);}else{$Accumulated -= ($previousTotal - $previousCash);} 
                      ?>
                <tr>
                    <th class="transSN"><?= $sn ?>.</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?php if(is_numeric($previousName)){echo number_format($previousTotal);}else{echo $previousCash;}?></td>
                    <td><?php if(is_numeric($previousName)){echo number_format($previousCash);}else{echo $previousTotal;}?></td> 
                    <td><?=number_format($Accumulated)?></td>
                </tr>
                <td><?php if(is_numeric($previousName)){echo "bill";}else{if($sn>1){echo "return";}} ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                       <?php 
                    $sn++;}else{ if($previousRef === 'customer'){}else{ if(is_numeric($previousName)){$Accumulated += ($previousTotal - $previousCash);}else{$Accumulated -= ($previousTotal - $previousCash);} ?>
                <tr>
                    <th class="transSN"><?= $sn ?>.</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?php if(is_numeric($previousName)){echo number_format($previousTotal);}else{echo $previousCash;}?></td>
                    <td><?php if(is_numeric($previousName)){echo number_format($previousCash);}else{echo $previousTotal;}?></td> 
                    <td><?=number_format($Accumulated)?></td>
                </tr>
            <?php }?>
                <td><?php if($previousRef === 'customer'){}else{if(is_numeric($previousName)){echo "bill";}else{if($sn>1){echo "return";}}} ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                        <?php $refTotal = 0; $refTotal+= $get->amount; $sn++;}} ?>
                <tr>
                    <th class="transSN"><?= $sn ?>.</th>
                    <td><?php if($get->ref === 'customer'){ ?>
                        <a class="pointer vICr" title="Click to view receipt"><?= $get->transId ?></a>
                    <?php  }
                    else{ if($get->tableName === 'sale'){?>
                        <a class="pointer vtr" title="Click to view receipt"><?= $get->ref ?></a>
                    <?php }else{ ?>
                        <a class="pointer vtrR" title="Click to view receipt"><?= $get->ref ?></a>
                    <?php }} ?></td>
                    <td><?= date('Y-m-d', strtotime($get->transDate)) ?></td>
                    <td><?= is_numeric($get->name) ? $this->genmod->getTableCol('products', 'description', 'code', $get->name) : $get->name ?></td>
                    <?php  if($get->cust_name === 'customer'): ?>
                        <td></td>
                        <td></td>
                    <?php else: ?>  
                    <td><?= $get->qty ?></td>
                    <td><?= number_format($get->price) ?></td>
                    
                    <?php endif; ?>

                    <td><?=  isset($get->amount) ? number_format($get->amount) : number_format($get->qty)?></td>
                    <?php  if($get->cust_name === 'customer'): if(isset($get->amount)){$Accumulated += $get->amount;}else{$Accumulated -= $get->qty;}  ?>
                    <td><?=isset($get->amount) ? number_format($get->amount) : ""?></td>
                    <td><?=isset($get->amount) ? "" : number_format($get->qty)?></td>
                    <?php else: ?>
                    <td></td>
                    <td></td>
                    <?php endif; ?> 
                    <td><?php if($get->ref === 'customer'){echo number_format($Accumulated);}?></td>
                    <td class="hidden-print"><?php if($get->ref === 'customer'){ if(isset($get->amount)){?>
                        <a href="<?php echo site_url(); echo 'Cashbook/outgoingCashEdit/' ; echo $get->transId;?>" target="_blank" >Edit</a>
                            <i class="fa fa-pencil pointer"></i>
                    <?php }else{ ?>
                        <a href="<?php echo site_url(); echo 'Cashbook/incomingCashEdit/' ; echo $get->transId;?>" target="_blank" >Edit</a>
                            <i class="fa fa-pencil pointer"></i>
                    <?php  }  }
                    else{ if($get->tableName === 'sale'){?>
                        <a href="<?php echo site_url()?>edit-transaction/<?php echo $get->ref?>" target="_blank" >Edit</a>
                    <?php }else{ ?>
                    <?php }} ?></td>
                    <?php if($get->ref === 'customer'){ ?><td><a href="<?= $get->link ?>" target="blank"><?= $get->link ?></a> </td><?php }?>

                    
                </tr>
                <?php $sn++; $previousRef = $get->ref; $previousName = $get->name; $previousCash = $get->cash; $previousTotal = $get->invoiceTotal; ?>
                <?php endforeach; if($previousRef === 'customer'){}else{ if(is_numeric($previousName)){$Accumulated += ($previousTotal - $previousCash);}else{$Accumulated -= ($previousTotal - $previousCash);}?>
                    <th><?= $sn ?>.</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?php echo number_format($previousTotal);?></td>
                    <td><?php echo number_format($previousCash);?></td>
                    <td><?= number_format($Accumulated) ?></td>
                <?php } ?>

            </tbody>
        </table>
    </div>

    </div>
<!-- table div end-->
    <?php else: ?>
        <ul><li>No Transactions</li></ul>
    <?php endif; ?>

    
    <!--Pagination div-->

</div>
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
                        <button class="btn btn-primary btn-sm" id="print1" onclick="printDivLedger('purchaseListTable2')">Print Ledger</button>
                    </div>
</div>
<hr>
<div class="row">
                    <div class="col-sm-2">
                    <button class="btn btn-primary btn-sm" id="print" onclick="printDiv('customer')">Print</button></div>
</div> 
<!-- panel end-->

<script src="<?=base_url()?>public/js/login.js"></script>