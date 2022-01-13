<?php


class ProductsController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['products', 'vendor', 'item']);
        $this->load->library('session');
    }
    /*
    function for manage Products.
    return all Productss.
    created by your name
    created at 22-07-20.
    */
    public function manageProducts() { 
        $data["productss"] = $this->products->getAll();
        $this->load->view('items/manage-products', $data);
    }
    /*
    function for  add Products get
    created by your name
    created at 22-07-20.
    */
    public function addProducts() {
        $this->load->view('items/add-products');
    }
    /*
    function for add Products post
    created by your name
    created at 22-07-20.
    */
    public function addProductsPost() {
        $data['name'] = $this->input->post('name');
        $data['subCategory'] = $this->input->post('subCategory');
        $data['description'] = $this->input->post('description');
        $data['thickness'] = $this->input->post('thickness');
        $data['quantity'] = $this->input->post('quantity');
        $data['location'] = $this->input->post('location');
        $data['costPrice'] = $this->input->post('costPrice');
        $data['sellingPrice'] = $this->input->post('sellingPrice');
        $data['vendor'] = $this->input->post('vendor');
    $this->products->insert($data);
        $this->session->set_flashdata('success', 'Products added Successfully');
        redirect('manage-products');
    }
    /*
    function for edit Products get
    returns  Products by id.
    created by your name
    created at 22-07-20.
    */
    public function editProducts($products_id) {
        $data1['products_id'] = $products_id;
        $data1['products'] = $this->products->getDataById($products_id);
        $data1['vendors'] = $this->vendor->getActiveVendors('companyName', 'ASC');//
        $data1['categories'] = $this->item->getAllCategories();
        $data['pageContent'] = $this->load->view('items/edit-products', $data1, TRUE);
        $data['pageTitle'] = "Items";
        $this->load->view('main', $data);
    }
    /*
    function for edit Products post
    created by your name
    created at 22-07-20.
    */
    public function editProductsPost() {
        $products_id = $this->input->post('products_id');
        $products = $this->products->getDataById($products_id);
        $data['name'] = $this->input->post('name');
        $data['subCategory'] = $this->input->post('subCategory');
        $data['description'] = $this->input->post('description');
        $data['thickness'] = $this->input->post('thickness');
        $data['quantity'] = $this->input->post('quantity');
        $data['location'] = $this->input->post('location');
        $data['costPrice'] = $this->input->post('costPrice');
        $data['sellingPrice'] = $this->input->post('sellingPrice');
        $data['vendorName'] = $this->input->post('vendorName');
        $data['hlink'] = $this->input->post('hlink');
        $edit = $this->products->update($products_id,$data);
        if ($edit) {
            $this->session->set_flashdata('success', 'Products Updated');
            redirect('items/index1');
        }
    }
    /*
    function for view Products get
    created by your name
    created at 22-07-20.
    */
    public function viewProducts($products_id) {
        $data['products_id'] = $products_id;
        $data['products'] = $this->products->getDataById($products_id);
        $this->load->view('items/view-products', $data);
    }
    /*
    function for delete Products    created by your name
    created at 22-07-20.
    */
    public function deleteProducts($products_id) {
        $delete = $this->products->delete($products_id);
        $this->session->set_flashdata('success', 'products deleted');
        redirect('manage-products');
    }
    /*
    function for activation and deactivation of Products.
    created by your name
    created at 22-07-20.
    */
    public function changeStatusProducts($products_id) {
        $edit = $this->products->changeStatus($products_id);
        $this->session->set_flashdata('success', 'products '.$edit.' Successfully');
        redirect('manage-products');
    }
    
}