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
        <li><a href="<?php echo site_url(); ?>add-batch">Add Batch</a></li>
      </ul>
  </div>
</nav>

<div class="container">

 <div class="row">
  <div class="col-xs-12 col-md-10 well">
   cust_id  :  <?php echo $batch[0]->cust_id ?>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-md-10 well">
   batch_no  :  <?php echo $batch[0]->batch_no ?>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-md-10 well">
   date  :  <?php echo $batch[0]->date ?>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-md-10 well">
   purchase_order_no  :  <?php echo $batch[0]->purchase_order_no ?>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-md-10 well">
   brand_top  :  <?php echo $batch[0]->brand_top ?>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-md-10 well">
   color  :  <?php echo $batch[0]->color ?>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-md-10 well">
   crown_type  :  <?php echo $batch[0]->crown_type ?>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-md-10 well">
   liner_material  :  <?php echo $batch[0]->liner_material ?>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-md-10 well">
   sheet_type  :  <?php echo $batch[0]->sheet_type ?>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-md-10 well">
   quantity  :  <?php echo $batch[0]->quantity ?>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-md-10 well">
   due_date  :  <?php echo $batch[0]->due_date ?>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-md-10 well">
   no_cases  :  <?php echo $batch[0]->no_cases ?>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-md-10 well">
   ups  :  <?php echo $batch[0]->ups ?>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-md-10 well">
   total_sheets  :  <?php echo $batch[0]->total_sheets ?>
  </div>
</div>

</div>

</body>
</html>