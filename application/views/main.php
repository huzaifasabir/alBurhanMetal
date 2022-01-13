<?php
defined('BASEPATH') OR exit('');
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title><?= $pageTitle ?></title>
		
        <!-- Favicon -->
        <link rel="shortcut icon" href="<?=base_url()?>public/images/alburhan.png">
        <!-- favicon ends -->
        
        <!-- LOAD FILES -->
        <?php if((stristr($_SERVER['HTTP_HOST'], "localhost") !== FALSE) || (stristr($_SERVER['HTTP_HOST'], "192.168.") !== FALSE)|| (stristr($_SERVER['HTTP_HOST'], "127.0.0.") !== FALSE)): ?>
        <link rel="stylesheet" href="<?=base_url()?>public/bootstrap/css/bootstrap.min.css">
        
        <link rel="stylesheet" href="<?=base_url()?>public/bootstrap/css/bootstrap-theme.min.css" media="screen">
        <link rel="stylesheet" href="<?=base_url()?>public/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?=base_url()?>public/font-awesome/css/font-awesome-animation.min.css">
        <link rel="stylesheet" href="<?=base_url()?>public/ext/select2/select2.min.css">
        <link rel="stylesheet" href="<?=base_url()?>public/css/custom.css">

        <script src="<?=base_url()?>public/js/jquery.min.js"></script>
        <script src="<?=base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
       
        <script src="<?=base_url()?>public/ext/select2/select2.min.js"></script>

        <?php else: ?>
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.8/font-awesome-animation.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

        <?php endif; ?>
        
        <!-- custom CSS -->
        <link rel="stylesheet" href="<?= base_url() ?>public/css/main.css">

        <!-- custom JS -->
        <script src="<?= base_url() ?>public/js/main.js"></script>
    </head>
<style>
    .sidenav a, .dropdown-btn {
    padding: 10px 10px 10px 16px;
    display: block;
    width: 100%;
    text-align: left;
    border: none;
    background: inherit;
    font: inherit;
    font-family: inherit;
    color: inherit;
    cursor: pointer;
}
.dropdown-container {
    display: none;
    padding-left: 8px;
}
.staticlabel {
    background-color: #61A29C;
}

</style>

    <body>
        <nav class="main-nav navbar navbar-default hidden-print">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarCollapse" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="" href="<?=base_url()?>" style="">
                        <img src="<?=base_url()?>public/images/alburhan.png" alt="logo" class="img-responsive" width="73px">
                    </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="main-nav collapse navbar-collapse " id="navbarCollapse">
                    
                    <ul class="nav navbar-nav navbar-left visible-xs">
                        <li class="<?= $pageTitle == 'Dashboard' ? 'active' : '' ?>">
                            <a href="<?= site_url('dashboard') ?>">
                                <i class="fa fa-home"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="<?= $pageTitle == 'fs' ? 'active' : '' ?>">
                        <button class="dropdown-btn <?= $pageTitle == 'Cashbook' ? 'active' : '' ?>">
                            <i class="fa fa-shopping-cart"></i>
                            Cash Book
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-container">
                            <a href="<?= site_url('cashbook/dailyCashBook') ?>" class="<?= $pageTitle == 'Cashbook' ? 'active' : '' ?>">
                                <i class="fa fa-money"></i>
                                Daily Cash Book
                            </a>
                            <br>
                            <a href="<?= site_url('cashbook/incomingCash') ?>"><i class="fa fa-money"></i> Add Incoming Cash</a>
                            <br>
                            <a href="<?= site_url('cashbook/outgoingCash') ?>"><i class="fa fa-money"></i> Add Out going Cash</a>
                        </div>
                        </li>
                        
                        <li class="<?= $pageTitle == 'Vendors' ? 'active' : '' ?>">
                        <button class="dropdown-btn <?= $pageTitle == 'Vendors' ? 'active' : '' ?>">
                            <i class="fa fa-user"></i>
                            Vendors
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-container">
                            <a href="<?= site_url('vendors/addVendor') ?>">
                                <i class="fa fa-shopping-cart"></i> Add new vendor</a>
                            <!--<a href="<?= site_url('vendors/addTransaction') ?>"><i class="fa fa-shopping-cart"></i> Add Vendor Payment</a>-->
                            <br>
                            <a href="<?= site_url('manage-vendors') ?>"><i class="fa fa-shopping-cart"></i> All Vendors</a>
                        </div>
                        </li>
                        <!--<?php if($this->session->admin_role === "Super"):?>-->
                        <li class="<?= $pageTitle == 'Items' ? 'active' : '' ?>">
                        <button class="dropdown-btn <?= $pageTitle == 'Items' ? 'active' : '' ?>">
                            <i class="fa fa-shopping-cart"></i>
                            Inventory
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-container">
                            <a href="<?= site_url('items/newProduct') ?>">
                                <i class="fa fa-shopping-cart"></i> Add new product</a>
                                <br>
                            <a href="<?= site_url('items/purchaseOrder') ?>"><i class="fa fa-shopping-cart"></i> New Purchse Order</a>
                            <br>
                            <a href="<?= site_url('items/allPurchaseOrders') ?>"><i class="fa fa-shopping-cart"></i> All Purchase Orders</a>
                            <br>
                            <a href="<?= site_url('items/index1') ?>"><i class="fa fa-shopping-cart"></i> All Inventory</a>
                            <br>
                            <a href="<?= site_url('items/lasani') ?>"><i class="fa fa-shopping-cart"></i> Lasani Lamination</a>
                            <br>
                            <a href="<?= site_url('items/chipboard') ?>"><i class="fa fa-shopping-cart"></i> Chipboard Lamination</a>
                            <br>
                            <a href="<?= site_url('items/foamboard') ?>"><i class="fa fa-shopping-cart"></i> Foamboard (PVC) Lamination</a>
                        </div>
                        </li>
                        <li class="<?= $pageTitle == 'Customers' ? 'active' : '' ?>">
                            <button class="dropdown-btn <?= $pageTitle == 'Customers' ? 'active' : '' ?>">
                            <i class="fa fa-shopping-cart"></i>
                            Customers
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-container">
                            <a href="<?= site_url('add-customers') ?>">
                                <i class="fa fa-shopping-cart"></i> Add new Customer</a>
                                <br>
                            <a href="<?= site_url('manage-customers') ?>"><i class="fa fa-shopping-cart"></i> All Cutomers</a>
                            
                        </div>
                            
                        </li>
                        <li class="<?= $pageTitle == 'Transactions' ? 'active' : '' ?>">
                        <button class="dropdown-btn <?= $pageTitle == 'Transactions' ? 'active' : '' ?>">
                            <i class="fa fa-exchange"></i>
                            Sales
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-container">
                            <a href="<?= site_url('transactions/newSale') ?>">
                                <i class="fa fa-shopping-cart"></i> New Sale Transaction </a>
                                <br>
                            <a href="<?= site_url('transactions/newQuotation') ?>">
                                <i class="fa fa-shopping-cart"></i> Quotation </a>
                                <br>
                            <a href="<?= site_url('transactions/returnProduct') ?>"><i class="fa fa-shopping-cart"></i>Return Product</a>
                            <br>
                            <a href="<?= site_url('transactions/allTransactions') ?>"><i class="fa fa-shopping-cart"></i> All Transactions</a>
                            <br>
                            <a href="<?= site_url('transactions/allReturnTransactions') ?>"><i class="fa fa-shopping-cart"></i>All Return Transactions</a>
                        </div>
                        </li>
                        
                        <li class="<?= $pageTitle == 'Accounts' ? 'active' : '' ?>">
                            <button class="dropdown-btn <?= $pageTitle == 'Accounts' ? 'active' : '' ?>">
                            <i class="fa fa-money"></i>
                            Accounts
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-container">
                            <a href="<?= site_url('add-accounts') ?>">
                                <i class="fa fa-shopping-cart"></i> Add New Account </a>
                                <br>
                            <a href="<?= site_url('manage-accounts') ?>"><i class="fa fa-shopping-cart"></i>All Accounts</a>
                            
                        </div>
                            
                        </li>
                        
                        <li class="<?= $pageTitle == 'Expenses' ? 'active' : '' ?>">
                            
                            <button class="dropdown-btn <?= $pageTitle == 'Expenses' ? 'active' : '' ?>">
                            <i class="fa fa-exchange"></i>
                            Expenses
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-container">
                            <a href="<?= site_url('expenses/shopExpense') ?>">
                                <i class="fa fa-shopping-cart"></i> Shop Expenses </a>
                                <br>
                            <a href="<?= site_url('expenses/homeExpense') ?>"><i class="fa fa-shopping-cart"></i>Home Expenses</a>
                            <a href="<?= site_url('manage-expense') ?>"><i class="fa fa-shopping-cart"></i>All Expense Categories</a>
                            <a href="<?= site_url('add-expense') ?>"><i class="fa fa-shopping-cart"></i>Add New Expense Category</a>
                            
                        </div>
                        </li>
                        <?php if ($this->session->admin_access === "all") { ?>
                            
                        
                        
                        <li class="<?= $pageTitle == 'Reports' ? 'active' : '' ?>">
                            
                            <button class="dropdown-btn <?= $pageTitle == 'Reports' ? 'active' : '' ?>">
                            <i class="fa fa-exchange"></i>
                            Reports
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-container">
                            <a href="<?= site_url('reports/incomeStatementForm') ?>">
                                <i class="fa fa-shopping-cart"></i> Income Statement </a>
                                <br>
                            <a href="<?= site_url('reports/financialStatementForm') ?>"><i class="fa fa-shopping-cart"></i>Financial Statement</a>
                            <a href="<?= site_url('reports/dailyReport') ?>"><i class="fa fa-shopping-cart"></i>Daily Report</a>
                            <a href="<?= site_url('reports/stockReportForm') ?>"><i class="fa fa-shopping-cart"></i>Stock Report</a>
                            <a href="<?= site_url('reports/categoryReport') ?>"><i class="fa fa-shopping-cart"></i>Stock Category Report</a>
                            <a href="<?= site_url('reports/rentReportForm') ?>"><i class="fa fa-shopping-cart"></i>Rent Report</a>
                            
                        </div>
                        </li>
                    <?php } ?>
                        
                        
                        <li class="<?= $pageTitle == 'Eventlog' ? 'active' : '' ?>">
                            <a href="<?= site_url('logs') ?>">
                                <i class="fa fa-tasks"></i>
                                Event Log
                            </a>
                        </li>
                        
                        
                        <li class="<?= $pageTitle == 'Administrators' ? 'active' : '' ?>">
                            <a href="<?= site_url('administrators') ?>">
                                <i class="fa fa-user"></i>
                                Admin Management
                            </a>
                        </li>
                        <!--<?php endif; ?>-->
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown hidden">
                            <a>
                                Total Earned Today: <b>Rs <span id="totalEarnedToday"></span></b>
                            </a>
                        </li>
                        <li class="dropdown hidden">
                            <a>
                                Total Profit Today: <b>Rs <span id="totalProfitToday"></span></b>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user navbarIcons"></i>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-menu-header text-center">
                                    <strong>Account</strong>
                                </li>
                                <li class="divider"></li>
                                <!---<li>
                                    <a href="#">
                                        <i class="fa fa-gear fa-fw"></i> 
                                        Settings
                                    </a>
                                </li>
                                <li class="divider"></li>--->
                                <li><a href="<?= site_url('logout') ?>"><i class="fa fa-sign-out"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>

        <div class="container-fluid hidden-print">
            <div class="row content">
                <!-- Left sidebar -->
                <div class="col-sm-2 sidenav hidden-xs mySideNav">
                    <br>
                    <ul class="nav nav-pills nav-stacked pointer main-nav">
                        <li class="<?= $pageTitle == 'Dashboard' ? 'active' : '' ?>">
                            <a href="<?= site_url('dashboard') ?>">
                                <i class="fa fa-home"></i>
                                Dashboard
                            </a>
                        </li>
                        
                        <li class="<?= $pageTitle == 'Items' ? 'active' : '' ?>">
                        <button class="dropdown-btn <?= $pageTitle == 'Items' ? 'active' : '' ?>">
                            <i class="fa fa-shopping-cart"></i>
                            Inventory
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-container">
                            <?php if($this->session->admin_role === "Super"):?>
                            <a href="<?= site_url('items/newProduct') ?>">
                                <i class="fa fa-shopping-cart"></i> Add new product</a>
                            <a href="<?= site_url('items/index1') ?>"><i class="fa fa-shopping-cart"></i> All Inventory</a>
                            <a href="<?= site_url('items/purchaseOrder') ?>"><i class="fa fa-shopping-cart"></i> Stock In Form</a>
                            <a href="<?= site_url('items/allPurchaseOrders') ?>"><i class="fa fa-shopping-cart"></i> All Stock In Transactions</a>
                            
                            <?php endif; ?>
                            
                           
                            
                        </div>
                        </li>
                        <?php if($this->session->admin_role === "Super"):?>
                        <li class="<?= $pageTitle == 'fs' ? 'active' : '' ?>">
                        <button class="dropdown-btn <?= $pageTitle == 'Cashbook' ? 'active' : '' ?>">
                            <i class="fa fa-shopping-cart"></i>
                            Production
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-container">
                            <a href="<?= site_url('transactions/newSale') ?>" class="<?= $pageTitle == 'Cashbook' ? 'active' : '' ?>">
                                <i class="fa fa-money"></i>
                                New Batch
                            </a>
                            <a href="<?= site_url('cashbook/incomingCash') ?>"><i class="fa fa-money"></i> Stock Issue Form</a>
                            <a href="<?= site_url('cashbook/outgoingCash') ?>"><i class="fa fa-money"></i> Printing Production Form</a>
                            <a href="<?= site_url('cashbook/allTransactions') ?>"><i class="fa fa-money"></i> Press Production Form </a>
                            <a href="<?= site_url('cashbook/allTransactions') ?>"><i class="fa fa-money"></i> PMC Production Form </a>
                            <a href="<?= site_url('cashbook/allTransactions') ?>"><i class="fa fa-money"></i> Dispatch Form </a>
                        </div>
                        </li>
                        
                        <li class="<?= $pageTitle == 'Vendors' ? 'active' : '' ?>">
                        <button class="dropdown-btn <?= $pageTitle == 'Vendors' ? 'active' : '' ?>">
                            <i class="fa fa-user"></i>
                            Production Reports
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-container">
                            <a href="<?= site_url('vendors/addVendor') ?>">
                                <i class="fa fa-shopping-cart"></i> All Batch Reports</a>
                            <a href="<?= site_url('vendors/addVendor') ?>">
                                <i class="fa fa-shopping-cart"></i> All Stock Consumption Transactions</a>
                            <a href="<?= site_url('vendors/addVendor') ?>">
                                <i class="fa fa-shopping-cart"></i>All Printing Transactions</a>
                            <a href="<?= site_url('manage-vendors') ?>"><i class="fa fa-shopping-cart"></i> All Press Transactions</a>
                            <a href="<?= site_url('manage-vendors') ?>"><i class="fa fa-shopping-cart"></i> All PMC Transactions</a>
                            <a href="<?= site_url('manage-vendors') ?>"><i class="fa fa-shopping-cart"></i> All Dispatch Transactions</a>
                            <a href="<?= site_url('manage-vendors') ?>"><i class="fa fa-shopping-cart"></i> Complete batch Wastage Reports</a>
                        </div>
                        </li>
                        <!--<?php if($this->session->admin_role === "Super"):?>-->
                        
                        
                        
                        <?php if ($this->session->admin_access === "all") { ?>
                        <li class="<?= $pageTitle == 'Reports' ? 'active' : '' ?>">
                            
                            <button class="dropdown-btn <?= $pageTitle == 'Reports' ? 'active' : '' ?>">
                            <i class="fa fa-exchange"></i>
                            Reports
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-container">
                            <a href="<?= site_url('reports/wastageDateWiseForm') ?>">
                                <i class="fa fa-shopping-cart"></i> Wastage Reports </a>
                            <a href="<?= site_url('reports/machineProductionReportForm') ?>"><i class="fa fa-shopping-cart"></i>Machine Production Reports</a>
                            
                        </div>
                        </li>
                        
                        <?php }?>

                        <li class="<?= $pageTitle == 'Customers' ? 'active' : '' ?>">
                            <button class="dropdown-btn <?= $pageTitle == 'Customers' ? 'active' : '' ?>">
                            <i class="fa fa-shopping-cart"></i>
                            Customers
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-container">
                            <a href="<?= site_url('add-customers') ?>">
                                <i class="fa fa-shopping-cart"></i> Add new Customer</a>
                            <a href="<?= site_url('manage-customers') ?>"><i class="fa fa-shopping-cart"></i> All Cutomers</a>
                            
                        </div>
                            
                        </li>
                        
                        
                        
                        <li class="<?= $pageTitle == 'Administrators' ? 'active' : '' ?>">
                            <a href="<?= site_url('administrators') ?>">
                                <i class="fa fa-user"></i>
                                Admin Management
                            </a>
                        </li>
                        <?php endif; ?>
                        <!--<?php endif; ?>-->
                    </ul>
                    <br>
                </div>
                <!-- Left sidebar ends -->
                <br>

                <!-- Main content -->
                <div class="col-sm-10">
                    <?= isset($pageContent) ? $pageContent : "" ?>
                </div>
                <!-- Main content ends -->
            </div>
        </div>

        <footer class="container-fluid text-center hidden-print">
            <p>
                <i class="fa fa-copyright"></i>
                Copyright <a href="">Huzaifa Sabir</a> (2019)
            </p>
        </footer>

        <!--Modal to show flash message-->
        <div id="flashMsgModal" class="modal fade" role="dialog" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" id="flashMsgHeader">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <center><i id="flashMsgIcon"></i> <font id="flashMsg"></font></center>
                    </div>
                </div>
            </div>
        </div>
        <!--Modal end-->

        <!--modal to display transaction receipt when a transaction's ref is clicked on the transaction list table -->
        <div class="modal fade" role='dialog' data-backdrop='static' id="transReceiptModal">
            <div class="modal-dialog ">
                <div class="modal-content" id="cotent1">
                    <div class="modal-header">
                        <button class="close hidden-print" data-dismiss='modal'>&times;</button>
                        
                        <div class="row">
                            <div class="col-xs-3 text-center text-uppercase">
                                <!--
                                <center style='margin-top: 2px'><img src="<?=base_url()?>public/images/favicon.jpeg" alt="logo" class="img-responsive" style="width:100px; height: 100px;"></center> -->
                            </div>
                            <div class="col-xs-7 text-center">
                                <h6 class="text-center"><!--<b class="red1" style=" font-size: 15px;">Haidery Plywood Agency</b>
                                    <br>
                                    <span class="green1" style="">61A, Jinnah Road</span>
                                    <br>
                                    <span class="green1" style="">Rawalpindi</span>
                                    <br>
                                    <br><a>www.haideryplywood.com </a>
                                -->
                                
                                    <span class="red1" >051-5559265 <i class="fa fa-whatsapp" style="color: green;"></i></span>
                                    
                                </h6>
                                
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body" id='transReceipt'></div>
                </div>
            </div>
        </div>
        <!-- End of modal-->
		
		
        <!--Login Modal-->
        <div class="modal fade" role='dialog' data-backdrop='static' id='logInModal'>
            <div class="modal-dialog">
                <!-- Log in div below-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close closeLogInModal">&times;</button>
                        <h4 class="text-center">Log In</h4>
                        <div id="logInModalFMsg" class="text-center errMsg"></div>
                    </div>
                    <div class="modal-body">
                        <form name="logInModalForm">
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <label for='logInModalUsername' class="control-label">Username</label>
                                    <input type="text" id='logInModalUsername' class="form-control checkField" placeholder="E-mail" autofocus>
                                    <span class="help-block errMsg" id="logInModalUsernameErr"></span>
                                </div>
                                <div class="col-sm-12 form-group">
                                    <label for='logInPassword' class="control-label">Password</label>
                                    <input type="password" id='logInModalPassword'class="form-control checkField" placeholder="Password">
                                    <span class="help-block errMsg" id="logInModalPasswordErr"></span>
                                </div>
                            </div>
                            
                            <div class="row">
                                <!--<div class="col-sm-6 pull-left">
                                    <input type="checkbox" class="control-label" id='remMe'> Remember me
                                </div>-->
                                <div class="col-sm-4"></div>
                                <div class="col-sm-2 pull-right">
                                    <button id='loginModalSubmit' class="btn btn-primary">Log in</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- End of log in div-->
            </div>
        </div>
        <!---end of Login Modal-->
    </body>
</html>