 
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Codeigniter Crud By PHP Code Builder</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
</head>
<body>

    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="http://crudegenerator.in">Codeigniter Crud By PHP Code Builder</a>
          </div>
          <ul class="nav navbar-nav">
            <li><a href="<?php echo site_url(); ?>manage-batch">Manage Batch</a></li>
            <li class="active" ><a href="<?php echo site_url(); ?>add-batch">Add Batch</a></li>
          </ul>
      </div>
    </nav>

<div class="container">

  <h2>Add Batch</h2>  
    <form role="form" method="post" action="<?php echo site_url()?>/add-batch-post" >
              <div class="form-group">
        <label for="cust_id">Cust_id:</label>
        <input type="text" class="form-control" id="cust_id" name="cust_id">
      </div>
            <div class="form-group">
        <label for="batch_no">Batch_no:</label>
        <input type="text" class="form-control" id="batch_no" name="batch_no">
      </div>
            <div class="form-group">
        <label for="date">Date:</label>
        <input type="text" class="form-control" id="date" name="date">
      </div>
            <div class="form-group">
        <label for="purchase_order_no">Purchase_order_no:</label>
        <input type="text" class="form-control" id="purchase_order_no" name="purchase_order_no">
      </div>
            <div class="form-group">
        <label for="brand_top">Brand_top:</label>
        <input type="text" class="form-control" id="brand_top" name="brand_top">
      </div>
            <div class="form-group">
        <label for="color">Color:</label>
        <input type="text" class="form-control" id="color" name="color">
      </div>
          <div class="form-group">
    <label for="crown_type">Crown_type:</label>
    <select class="form-control" id="crown_type" name="crown_type">
        <option value=""></option>
        </select>
    </div>
          <div class="form-group">
    <label for="liner_material">Liner_material:</label>
    <select class="form-control" id="liner_material" name="liner_material">
        <option value=""></option>
        </select>
    </div>
          <div class="form-group">
    <label for="sheet_type">Sheet_type:</label>
    <select class="form-control" id="sheet_type" name="sheet_type">
        <option value=""></option>
        </select>
    </div>
            <div class="form-group">
        <label for="quantity">Quantity:</label>
        <input type="text" class="form-control" id="quantity" name="quantity">
      </div>
            <div class="form-group">
        <label for="due_date">Due_date:</label>
        <input type="text" class="form-control" id="due_date" name="due_date">
      </div>
            <div class="form-group">
        <label for="no_cases">No_cases:</label>
        <input type="text" class="form-control" id="no_cases" name="no_cases">
      </div>
            <div class="form-group">
        <label for="ups">Ups:</label>
        <input type="text" class="form-control" id="ups" name="ups">
      </div>
            <div class="form-group">
        <label for="total_sheets">Total_sheets:</label>
        <input type="text" class="form-control" id="total_sheets" name="total_sheets">
      </div>
            <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

</body>
</html>