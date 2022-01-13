<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route["access/css"]["GET"] = "misc/check_session_status";
$route['access/login']['POST'] = "home/login";
$route['dbmanagement'] = "misc/dbmanagement";

// routes for customers.
$route['manage-customers']="CustomersController/ManageCustomers";
$route['change-status-customers/(:num)']="CustomersController/changeStatusCustomers/$1";
$route['edit-customers/(:num)']="CustomersController/editCustomers/$1";
$route['edit-customers-post']="CustomersController/editCustomersPost";
$route['delete-customers/(:num)']="CustomersController/deleteCustomers/$1";
$route['add-customers']="CustomersController/addCustomers";
$route['add-customers-post']="CustomersController/addCustomersPost";
$route['view-customers/(:num)']="CustomersController/viewCustomers/$1";

// routes for accounts.
$route['manage-accounts']="AccountsController/ManageAccounts";
$route['change-status-accounts/(:num)']="AccountsController/changeStatusAccounts/$1";
$route['edit-accounts/(:num)']="AccountsController/editAccounts/$1";
$route['edit-accounts-post']="AccountsController/editAccountsPost";
$route['delete-accounts/(:num)']="AccountsController/deleteAccounts/$1";
$route['add-accounts']="AccountsController/addAccounts";
$route['add-accounts-post']="AccountsController/addAccountsPost";
$route['view-accounts/(:num)']="AccountsController/viewAccounts/$1";
// end of accounts routes

// routes for expense.
$route['manage-expense']="ExpenseController/ManageExpense";
$route['change-status-expense/(:num)']="ExpenseController/changeStatusExpense/$1";
$route['edit-expense/(:num)']="ExpenseController/editExpense/$1";
$route['edit-expense-post']="ExpenseController/editExpensePost";
$route['delete-expense/(:num)']="ExpenseController/deleteExpense/$1";
$route['add-expense']="ExpenseController/addExpense";
$route['add-expense-post']="ExpenseController/addExpensePost";
$route['view-expense/(:num)']="ExpenseController/viewExpense/$1";

$route['manage-home-expense']="HomeExpenseController/ManageExpense";
$route['change-status-home-expense/(:num)']="HomeExpenseController/changeStatusExpense/$1";
$route['edit-home-expense/(:num)']="HomeExpenseController/editExpense/$1";
$route['edit-home-expense-post']="HomeExpenseController/editExpensePost";
$route['delete-home-expense/(:num)']="HomeExpenseController/deleteExpense/$1";
$route['add-home-expense']="HomeExpenseController/addExpense";
$route['add-home-expense-post']="HomeExpenseController/addExpensePost";
$route['view-home-expense/(:num)']="HomeExpenseController/viewExpense/$1";
// end of expense routes

$route['add-incoming-post']="Cashbook/addIncomingPost";
$route['incoming-cash']="Cashbook/incomingCash";

$route['add-outgoing-post']="Cashbook/addOutgoingPost";
$route['outgoing-cash']="Cashbook/outgoingCash";

// routes for products.
$route['manage-products']="ProductsController/ManageProducts";
$route['change-status-products/(:num)']="ProductsController/changeStatusProducts/$1";
$route['edit-products/(:num)']="ProductsController/editProducts/$1";
$route['edit-products-post']="Items/editProductsPost";
$route['delete-products/(:num)']="ProductsController/deleteProducts/$1";
$route['add-products']="ProductsController/addProducts";
$route['add-products-post']="ProductsController/addProductsPost";
$route['view-products/(:num)']="ProductsController/viewProducts/$1";
// end of products routes

// routes for vendors.
$route['manage-vendors']="VendorsController/ManageVendors";
$route['change-status-vendors/(:num)']="VendorsController/changeStatusVendors/$1";
$route['edit-vendors/(:num)']="VendorsController/editVendors/$1";
$route['edit-vendors-post']="VendorsController/editVendorsPost";
$route['delete-vendors/(:num)']="VendorsController/deleteVendors/$1";
$route['add-vendors']="VendorsController/addVendors";
$route['add-vendors-post']="VendorsController/addVendorsPost";
$route['view-vendors/(:num)']="VendorsController/viewVendors/$1";
// end of vendors routes

$route['view-item/(:num)']="Items/viewItem/$1";
$route['edit-transaction/(:num)']="Transactions/editTransaction/$1";
$route['edit-purchase/(:num)']="Items/editPurchase/$1";





//al burhan metal

$route['manage-batch']="BatchController/ManageBatch";
$route['change-status-batch/(:num)']="BatchController/changeStatusBatch/$1";
$route['edit-batch/(:num)']="BatchController/editBatch/$1";
$route['edit-batch-post']="BatchController/editBatchPost";
$route['delete-batch/(:num)']="BatchController/deleteBatch/$1";
$route['add-batch']="BatchController/addBatch";
$route['add-batch-post']="BatchController/addBatchPost";
$route['view-batch/(:num)']="BatchController/viewBatch/$1";
