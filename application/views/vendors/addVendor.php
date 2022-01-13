<?php
defined('BASEPATH') OR exit('');
?>

<div class="pwell hidden-print">   

    
    
    <!-- row of adding new item form and items list table-->
    <div class="row">
        <div class="col-sm-12">
            <!--Form to add/update an item-->
            <div class="col-sm-8" id='createNewVendorDiv'>
                <div class="well">
                    
                    <form name="addNewVendorForm" id="addNewVendorForm" role="form">
                        <div class="text-center errMsg" id='addVendorErrMsg'></div>
                        
                        <br>
                        
                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="companyName">Company Name</label>
                                <input type="text" id="companyName" name="companyName" placeholder="Company Name" maxlength="80"
                                    class="form-control" onchange="validateEmail(this.value, 'companyNameErr')" autofocus>
                                <!--<span class="help-block"><input type="checkbox" id="gen4me"> auto-generate</span>-->
                                <span class="help-block errMsg" id="companyNameErr"></span>
                            </div>
                        </div>

                        
                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="salesRepresentative">Sales Representative</label>
                                <input type="text" id="salesRepresentative" name="salesRepresentative" placeholder="Sales Representative" maxlength="80"
                                    class="form-control" onchange="checkField(this.value, 'salesRepresentativeErr')">
                                <span class="help-block errMsg" id="salesRepresentativeErr"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" placeholder="Email" class="form-control" onchange="checkField(this.value, 'emailErr')">
                                <span class="help-block errMsg" id="emailErr"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="phone">Phone</label>
                                <input type="text" id="phone" name="phone" placeholder="Phone"
                                    class="form-control" min="0" onchange="checkField(this.value, 'phoneErr')">
                                <span class="help-block errMsg" id="phoneErr"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="address">Address</label>
                                <input type="text" id="address" name="address" placeholder="Address"
                                    class="form-control" min="0" onchange="checkField(this.value, 'addressErr')">
                                <span class="help-block errMsg" id="addressErr"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="outstandingBalance">Outstanding Balance</label>
                                <input type="number" id="outstandingBalance" name="outstandingBalance" placeholder="0 default (Optional)" class="form-control"
                                    >
                                <span class="help-block errMsg" id="outstandingBalanceErr"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
        <label for="accName">Page Number:</label>
        <input type="text" class="form-control" id="pageNo" name="pageNo" >
      </div>
                        </div>
                        
                        <br>
                        <div class="row text-center">
                            <div class="col-sm-6 form-group-sm">
                                <button class="btn btn-primary btn-sm" id="addNewVendor" >Add Vendor</button>
                            </div>

                            <div class="col-sm-6 form-group-sm">
                                <button type="reset" id="cancelAddVendor" class="btn btn-danger btn-sm cancelAddVendor" form='addNewVendorForm'>Cancel</button>
                            </div>
                        </div>
                    </form><!-- end of form-->
                </div>
            </div>
            
            
        </div>
    </div>
    <!-- End of row of adding new item form and items list table-->
</div>


<!--end of modal-->
<script src="<?=base_url()?>public/js/vendors.js"></script>