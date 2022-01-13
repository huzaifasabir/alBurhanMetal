<?php
defined('BASEPATH') OR exit('');

$current_items = [];

if(isset($items) && !empty($items)){    
    foreach($items as $get){
        $current_items[$get->code] = $get->name;
    }
}


$current_vendors = [];

if(isset($vendors) && !empty($vendors)){    
    foreach($vendors as $get){
        $current_vendors[$get->id] = $get->companyName;
    }
}
$current_categories = [];

if(isset($categories) && !empty($categories)){    
    foreach($categories as $get){
        $current_categories[$get->subCategory] = $get->subCategory;
    }
}
?>
<script>
    var currentItems = <?=json_encode($current_items)?>;
    var currentVendors = <?=json_encode($current_vendors)?>;
    var currentCategories = <?=json_encode($current_categories)?>;
</script>
<div class="pwell hidden-print">  
<div class="container">

  <h2>Update Products</h2>  
<form role="form" method="post" action="<?php echo site_url()?>edit-products-post" enctype="multipart/form-data">

 <input type="hidden" value="<?php echo $products[0]->code ?>"   name="products_id">


      <div class="form-group">
    <label for="name">Name:</label>
    <input type="text" value="<?php echo $products[0]->name ?>" class="form-control" id="name" name="name" required>
  </div>
    <div class="form-group">
    <label for="subCategory">SubCategory:</label>
    <input type="text" value="<?php echo $products[0]->subCategory ?>" class="form-control" id="subCategory" name="subCategory" list="category" required/>
<datalist id="category">
  
</datalist>
  </div>
    <div class="form-group">
    <label for="description">Description:</label>
    <input type="text" value="<?php echo $products[0]->description ?>" class="form-control" id="description" name="description" required>
  </div>
    <div class="form-group">
    <label for="thickness">Thickness:</label>
    <input type="number" value="<?php echo $products[0]->thickness ?>" class="form-control" id="thickness" name="thickness" required>
  </div>
    <div class="form-group">
    <label for="quantity">Quantity:</label>
    <input type="number" value="<?php echo $products[0]->quantity ?>" class="form-control" id="quantity" name="quantity" required>
  </div>
    <div class="form-group">
    <label for="location">Location:</label>
    <input type="text" value="<?php echo $products[0]->location ?>" class="form-control" id="location" name="location" required>
  </div>
    <div class="form-group">
    <label for="costPrice">CostPrice:</label>
    <input type="text" value="<?php echo $products[0]->costPrice ?>" class="form-control" id="costPrice" name="costPrice" required >
  </div>
    <div class="form-group">
    <label for="sellingPrice">SellingPrice:</label>
    <input type="number" value="<?php echo $products[0]->sellingPrice ?>" class="form-control" id="sellingPrice" name="sellingPrice">
  </div>
  <div class="form-group">
<label for="vendor">Vendor:</label>
<select class="form-control" id="vendor" name="vendor">
<option value="<?php echo $products[0]->vendorName ?>" <?php echo $products[0]->vendorName ?> ></option>
</select>
</div>
<div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="hlink">Link</label>
                                <input type="text" id="hlink" name="hlink" 
                                    class="form-control" placeholder="Link" value="<?php echo $products[0]->hlink ?>" >
                                
                            </div>
                        </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
</div>
<script src="<?=base_url()?>public/js/login.js"></script>
<script src="<?=base_url()?>public/js/products/items.js"></script>