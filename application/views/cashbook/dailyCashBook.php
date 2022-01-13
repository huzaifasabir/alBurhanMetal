<?php
defined('BASEPATH') OR exit('');

$current_items = [];

if(isset($items) && !empty($items)){    
    foreach($items as $get){
        $current_items[$get->code] = $get->name;
    }
}
$customers_array = [];

if(isset($customers) && !empty($customers)){    
    foreach($customers as $get){
        $customers_array[$get->id] = $get->customerName;
    }
}
?>

<style href="<?=base_url('public/ext/datetimepicker/bootstrap-datepicker.min.css')?>" rel="stylesheet"></style>

<script>
    var currentItems = <?=json_encode($current_items)?>;
    var customersArray = <?=json_encode($customers_array)?>;
</script>



<div class="pwell">   
    <div class="row">
        <div class="col-sm-12">
            <!--- Row to create new transaction-->
            <?php if($this->session->flashdata('success')){ ?>
        <div class="alert alert-success">
            <strong><span class="glyphicon glyphicon-ok"></span>   <?php echo $this->session->flashdata('success'); ?></strong>
            </div>
    <?php } ?>
            <br>
            <!--- End of row to create new transaction-->
            <!---form to create new transactions--->
            
            <!--end of form-->

    
            <br><br>
            <!-- sort and co row-->
            <div class="row">
                <div class="col-sm-12">
                    

                    

                    <div class="col-sm-4 form-inline form-group-sm" id="dateDiv">
                        <label for='date1'>Select Date</label>
                        <input type="date" id="date1" class="form-control selectedDateDefault" placeholder="Select Date">
                    </div>
                    <div class="col-sm-4 form-inline form-group-sm" >
                        
                    </div>
                    <div class="col-sm-4 form-inline form-group-sm" >
                        <table>
                        <tr> 
                        <td>   
                        <h3>CASH IN HAND:</h3></td><td><h3> <?= number_format($this->genmod->gettablecol('accounts', 'balance', 'id', 5 ) )?></h3>
                        </td>
                        </tr>
                        <tr>
                        <td><h4>Hardware: </h4></td><td><h4><span id="cashHardware"><?= isset($hardwareCash) ? number_format($hardwareCash) : "" ?></span></h4></td>
                        </tr>
                        <tr>
                        <td><h4>Gola: </h4></td><td><h4> <span id="cashGola"><?= isset($golaCash) ? number_format($golaCash) : "" ?></span></h4></td>
                    </tr>
                    <tr>

                        <td><h4>Total: </h4></td><td><h4> <span id="cashTotal"><?= isset($totalCash) ? number_format($totalCash) : "" ?></span></h4></td>
                        
                        </tr>
                        </table>
                        
                    </div>
                </div>
            </div>
            <!-- end of sort and co div-->
        </div>
    </div>
    
    <hr>
    <div id="cashbook">
    <div class="row">
        <div class="col-sm-4" id="date2">
            <h3><?= isset($date1) ? $date1 : "" ?></h3>
        </div>
    </div>
    <!-- transaction list table-->
    <div class="row" >
        
        <!-- Transaction list div-->
        <div class="col-sm-4" id="outgoingCash">
            <?= isset($outgoing) ? $outgoing : "" ?>        
        </div>
        <!-- End of transactions div-->
    
    
        <!-- Transaction list div-->
        <div class="col-sm-4" id="incomingCash">
            <?= isset($incoming) ? $incoming : "" ?>
        </div>
        <!-- End of transactions div-->
    
        <!-- Transaction list div-->
        <div class="col-sm-4" id="transListTable">
            <?= isset($transTable) ? $transTable : "" ?>
        </div>

        <!-- End of transactions div-->
    </div>
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-6">
       <b>Revenue: <span id="revenue"><?= isset($Revenue) ? number_format($Revenue) : "" ?></span></b>
       <br>
        
        <b>Gross Profit: <span id="gross"><?= isset($Profit) ? number_format($Profit) : "" ?></span></b>
        <br>
    
        <b>Expense Total: <span id="expense"><?= isset($ExpenseTotal) ? number_format($ExpenseTotal) : "" ?></span></b>
        <br>
        <?php if ($this->session->admin_access === "all") { ?>
        <b>Net Profit: <span id="net"><?= isset($NetProfit) ? number_format($NetProfit) : "" ?></span></b>
        <?php } ?>
        </div>
    </div>
    </div>
    <div class="row">
                    <div class="col-sm-2">
                    <button class="btn btn-primary btn-sm" id="print" onclick="printDiv('cashbook')">Print</button></div>
    </div> 
    <!-- End of transactions list table-->
</div>

           





<div class="modal fade" id='reportModal' data-backdrop='static' role='dialog'>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="close" data-dismiss='modal'>&times;</div>
                <h4 class="text-center">Generate Report</h4>
            </div>
            
            <div class="modal-body">
                <div class="row" id="datePair">
                    <div class="col-sm-6 form-group-sm">
                        <label class="control-label">From Date</label>                                    
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span><i class="fa fa-calendar"></i></span>
                            </div>
                            <input type="text" id='transFrom' class="form-control date start" placeholder="YYYY-MM-DD">
                        </div>
                        <span class="help-block errMsg" id='transFromErr'></span>
                    </div>

                    <div class="col-sm-6 form-group-sm">
                        <label class="control-label">To Date</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span><i class="fa fa-calendar"></i></span>
                            </div>
                            <input type="text" id='transTo' class="form-control date end" placeholder="YYYY-MM-DD">
                        </div>
                        <span class="help-block errMsg" id='transToErr'></span>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button class="btn btn-success" id='clickToGen'>Generate</button>
                <button class="btn btn-danger" data-dismiss='modal'>Close</button>
            </div>
        </div>
    </div>
</div>

<!---End of copy of div to clone when adding more items to sales transaction---->
<script src="<?=base_url()?>public/js/cashbook.js"></script>
<script src="<?=base_url('public/ext/datetimepicker/bootstrap-datepicker.min.js')?>"></script>
<script src="<?=base_url('public/ext/datetimepicker/jquery.timepicker.min.js')?>"></script>
<script src="<?=base_url()?>public/ext/datetimepicker/datepair.min.js"></script>
<script src="<?=base_url()?>public/ext/datetimepicker/jquery.datepair.min.js"></script>