<?php
defined('BASEPATH') OR exit('');


?>
<script>
    var flag = <?=json_encode($flag)?>;
    
    
</script>
<div class="pwell hidden-print">   
    <div class="row">
        <div class="col-sm-12">
            <!-- sort and co row-->
            <div class="row">
                <div class="col-sm-12">
                    

                    <div class="col-sm-3 form-inline form-group-sm">
                        <label for="itemsListPerPage">Show</label>
                        <select id="itemsListPerPage" class="form-control">
                            <option value="1">1</option>
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <label>per page</label>
                    </div>

                    <div class="col-sm-3 form-group-sm form-inline">
                        <label for="itemsListSortBy">Sort by</label>
                        <select id="itemsListSortBy" class="form-control">
                            <option value="transactionDate-DESC">date(Latest First)</option>
                            <option value="transactionDate-ASC">date(Oldest First)</option>
                        </select>
                    </div>

                    <div class="col-sm-3 form-inline form-group-sm">
                        <label for='itemSearch'><i class="fa fa-search"></i></label>
                        <input type="search" id="itemSearch" class="form-control" placeholder="Search Items">
                    </div>
                    
                </div>
            </div>
            <div class="row">
            <div class="col-sm-3">
                        <label for="d1" class="">From</label>
                        <input type="date" id="d1" name="d1" class="form-control" >
                    </div>
                    <div class="col-sm-3">
                        <label for="d2" class="">To</label>
                        <input type="date" id="d2" name="d2" class="form-control" >
                    </div>
                    <div class="col-sm-3">
                        <br>
                        <button class="btn btn-primary btn-sm" id="search12">Search</button>
                    </div>
            </div>
            <!-- end of sort and co div-->
        </div>
    </div>
    
    <hr>
    
    <!-- row of adding new item form and items list table-->
    <div class="row">
        <div class="col-sm-12">
            
            <!--- Item list div-->
            <div class="col-sm-12" id="itemsListDiv">
                <!-- Item list Table-->
                <div class="row">
                    <div class="col-sm-12" id="itemsListTable"></div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                    <button class="btn btn-primary btn-sm" id="print" onclick="printDiv('itemsListTable')">Print</button></div>
                </div> 
                <!--end of table-->
            </div>
            <!--- End of item list div-->

        </div>
    </div>
    <!-- End of row of adding new item form and items list table-->
</div>

<!--end of modal-->
<script src="<?=base_url()?>public/js/expense.js"></script>