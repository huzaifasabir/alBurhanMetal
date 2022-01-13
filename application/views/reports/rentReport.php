<?php
defined('BASEPATH') OR exit('');


?>




           

<h2>Rent Report</h2>



<div class="" id='reportModal' data-backdrop='static' role='dialog'>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="close" data-dismiss='modal'>&times;</div>
                <h4 class="text-center">Generate Report</h4>
            </div>
            
            <div class="modal-body">
                <div class="row" id="datePair">
                    <div class="col-sm-4 form-group-sm">
                        <label class="control-label">From Date</label>                                    
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span><i class="fa fa-calendar"></i></span>
                            </div>
                            <input type="date" id='transFrom' class="form-control" placeholder="YYYY-MM-DD">
                        </div>
                        <span class="help-block errMsg" id='transFromErr'></span>
                    </div>

                    <div class="col-sm-4 form-group-sm">
                        <label class="control-label">To Date</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span><i class="fa fa-calendar"></i></span>
                            </div>
                            <input type="date" id='transTo' class="form-control" placeholder="YYYY-MM-DD">
                        </div>
                        <span class="help-block errMsg" id='transToErr'></span>
                    </div>
                    <div class=" col-sm-4 form-inline form-group-sm">
                        <label for="rentS">Rent</label>
                        <select id="rentS" class="form-control">
                            <option value="shop1">shop1</option>
                            <option value="shop2">shop2</option>
                            <option value="shop3">shop3</option>
                            
                        </select>
                         <span class="help-block errMsg" id='rentSErr'></span>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button class="btn btn-success" id='clickToGenRent'>Generate</button>
            </div>
        </div>
    </div>
</div>

<div id="incomeTable1"></div>


<!---End of copy of div to clone when adding more items to sales transaction---->
<script src="<?=base_url()?>public/js/reports.js"></script>
<script src="<?=base_url('public/ext/datetimepicker/bootstrap-datepicker.min.js')?>"></script>
<script src="<?=base_url('public/ext/datetimepicker/jquery.timepicker.min.js')?>"></script>
<script src="<?=base_url()?>public/ext/datetimepicker/datepair.min.js"></script>
<script src="<?=base_url()?>public/ext/datetimepicker/jquery.datepair.min.js"></script>