
<div class="pwell">  
<div class="container">
  <h2>Manage Expense Category</h2>
  <?php if($this->session->flashdata('success')){ ?>
  <div class="alert alert-success">
                    <strong><span class="glyphicon glyphicon-ok"></span>   <?php echo $this->session->flashdata('success'); ?></strong>
                </div>
  <?php } ?>

<?php if(!empty($expenses)) {?>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>SL No</th>
        <th>Category</th>
       <th>Actions</th>
      </tr>
    </thead>
    <tbody>
    <?php $i=1; foreach($expenses as $expense) { ?>
      <tr>
        <td> <?php echo $i; ?> </td>
        <td>  <?php echo $expense->category ?>  </td>

        <td>
        
        <a href="<?php echo site_url()?>edit-home-expense/<?php echo $expense->id?>" >Edit</a>
        <a href="<?php echo site_url()?>delete-home-expense/<?php echo $expense->id?>" onclick="return confirm('are you sure to delete')">Delete</a>
        </td>

      </tr>
    <?php $i++; } ?>
    </tbody>
  </table>
  <?php } else {?>
  <div class="alert alert-info" role="alert">
                    <strong>No Expenses Found!</strong>
                </div>
  <?php } ?>
</div>
</div>
<script src="<?=base_url()?>public/js/login.js"></script>
