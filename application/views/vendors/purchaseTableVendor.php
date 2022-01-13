<?php defined('BASEPATH') OR exit('') ?>
<div id="vendor">

<div class="panel panel-primary">
    <h3>Outstanding Balance: Rs <?= number_format($outstandingBalance) ?></h3>
    <!-- Default panel contents -->
    <div class="panel-heading">PURCHASE ORDERS</div>
    <?php if($vendorPurchase): ?>
    <div class="col-sm-12" id="purchaseListTable">
    <div class="table table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Receipt No</th>
                    <th>Total Items</th>
                    <th>Total Amount</th>
                    <th>Vendor Payable</th>
                    <th>Labor Cost</th>
                    <th>Transport Cost</th>
                    <th>Staff</th>
                    <th>Vendor</th>
                    <th>Date</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php foreach($vendorPurchase as $get): ?>
                <tr>
                    <input type="hidden" value="<?=$get->ref?>" class="curTransId">
                    <th class="transSN"><?= $sn ?>.</th>
                    <td><a class="pointer vtrP" title="Click to view receipt"><?= $get->ref ?></a></td>
                    <td><?= $get->quantity ?></td>
                    <td>Rs <?= number_format($get->cumulativeTotal) ?></td>
                    <td>Rs <?= number_format($get->vendorPayable) ?></td>
                    <td>Rs <?= number_format($get->labor) ?></td>
                    <td>Rs <?=  number_format($get->transport)?></td>
                    <td><?=$get->staffName?></td>
                    <td><?=$get->vendor?></td>
                    <td><?= $get->transDate ?></td>
                    
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

    <h3>Vendor Payments</h3>
    
    <?php if($vendorTransactions): ?>
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
                <?php foreach($vendorTransactions as $get): ?>
                <tr>
                    <input type="hidden" value="<?=$get->transId?>" class="curTransId">
                    <th class="transSN"><?= $sn ?>.</th>
                    
                    <td><?= $get->transactionDate ?></td>
                    <td>Rs <?= number_format($get->debitAmount) ?></td>
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

    
    <!-- Default panel contents -->
    <h3>Vendor Ledger</h3>

    <?php  if($vendorLedger): ?>
    <div class="col-sm-12" id="purchaseListTable1">
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
            
            <b>Vendor:</b><br>
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
    <div class="table table-responsive">
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
                <?php $sn = 1; $previousRef = 0; $previousName=NULL; $refTotal=0; $Accumulated = 0; foreach($vendorLedger as $get): ?>
                <?php if($get->ref === 'vendor'){?>
                
                <?php }?>
                <?php  ?>
                <?php if ($previousRef === $get->ref) {
                    
                        $refTotal += $get->amount;
                    }else{ if ($get->ref === 'vendor') { if(is_numeric($previousName)){?>

                <tr>
                    <th class="transSN"><?= $sn ?>.</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?php echo number_format($refTotal);?></td>
                    <td><?=number_format($Accumulated)?></td>
                </tr>
                    <?php
                    }else{?>
                <tr>
                    <th class="transSN"><?= $sn ?>.</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?= number_format($refTotal)?></td>
                    <td></td>
                    <td><?=number_format($Accumulated)?></td>
                </tr>
                <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                </tr>
                       <?php 
                    $sn++;}}else{ if($previousRef === 'vendor'){}else{if(is_numeric($previousName)){?>

                <tr>
                    <th class="transSN"><?= $sn ?>.</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?php echo number_format($refTotal);?></td>
                    <td><?=number_format($Accumulated)?></td>
                </tr>
                    <?php
                    }else{?>
                <tr>
                    <th class="transSN"><?= $sn ?>.</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?php echo number_format($refTotal);?></td>
                    <td></td>
                    <td><?=number_format($Accumulated)?></td>
                </tr>
            <?php }}?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                </tr>
                        <?php $refTotal = 0; $refTotal+= $get->amount; $sn++;}} ?>
                <tr>
                    <th class="transSN"><?= $sn ?>.</th>
                    <td><?php if($get->ref === 'vendor'){ ?>
                        <a class="pointer vICr" title="Click to view receipt"><?= $get->transId ?></a>
                    <?php  }
                    else{ if($get->tableName === 'purchase'){?>
                        <a class="pointer vtrP" title="Click to view receipt"><?= $get->ref ?></a>
                    <?php }else{ ?>
                        <a class="pointer vtrPR" title="Click to view receipt"><?= $get->ref ?></a>
                    <?php }} ?></td>
                    <td><?= date('Y-m-d', strtotime($get->transDate)) ?></td>
                    <td><?= is_numeric($get->name) ? $this->genmod->getTableCol('products', 'description', 'code', $get->name) : $get->name ?></td>
                    <?php  if($get->vendor === 'vendor'): ?>
                        <td></td>
                        <td></td>
                    <?php else: ?>  
                    <td><?= $get->qty ?></td>
                    <td><?= number_format($get->costPrice) ?></td>
                    
                    <?php endif; ?>

                    <td><?=  number_format($get->amount)?></td>
                    <?php if($get->vendor === 'vendor' || is_numeric($get->name)){ $Accumulated -= $get->amount;} if($get->vendor === 'vendor'):   ?>
                    <td></td>
                    <td><?=number_format($get->amount)?></td>
                    <?php else: if(is_numeric($get->name)){}else{$Accumulated += $get->amount;}?>
                    <td></td>
                    <td></td>
                    <?php endif; ?> 
                    <td><?php if($get->ref === 'vendor'){echo number_format($Accumulated);}?></td>
                    <td class="hidden-print"><?php if($get->ref === 'vendor'){ ?>
                        <a href="<?php echo site_url(); echo 'Cashbook/outgoingCashEdit/' ; echo $get->transId;?>" target="_blank" >Edit</a>
                            <i class="fa fa-pencil pointer"></i>
                    <?php  }
                    else{ if($get->tableName === 'purchase'){?>
                        <a href="<?php echo site_url()?>edit-purchase/<?php echo $get->ref?>" target="_blank" >Edit</a>
                    <?php }else{ ?>
                    <?php }} ?></td>
                    <?php if($get->ref === 'vendor'){ ?><td><a href="<?= $get->link ?>" target="blank"><?= $get->link ?></a> </td><?php }?>


                    
                </tr>
                <?php $sn++; $previousRef = $get->ref; $previousName = $get->name;?>
                <?php endforeach; if($previousRef === 'vendor'){}else{ ?>
                    <tr>
                    <th><?= $sn ?>.</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?= number_format($refTotal)?></td>
                    <td></td>
                    <td><?= number_format($Accumulated) ?></td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>
    </div>
<!-- table div end-->
    <?php else: ?>
        <ul><li>No Transactions</li></ul>
    <?php endif; ?>
    <p id="info">

    </p>
    

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
                        <button class="btn btn-primary btn-sm" id="print1" onclick="printDivLedger('purchaseListTable1')">Print Ledger</button>
                    </div>
</div>
<hr>
 <div class="row">
                    <div class="col-sm-2">
                    <button class="btn btn-primary btn-sm" id="print" onclick="printDiv('vendor')">Print</button></div>

</div>   

<script src="<?=base_url()?>public/js/login.js"></script>

<!-- panel end-->