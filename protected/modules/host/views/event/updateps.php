<section id="flashAlert">
  <?php foreach(Yii::app()->user->getFlashes() as $key=>$message) {
    if($key  === 'success')
    {
      echo "<div class='alert alert-success alert-dismissible' role='alert' style='margin-bottom:5px'>
      <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
      $message.'</div>';
    }
    else
    {
      echo "<div class='alert alert-danger alert-dismissible' role='alert' style='margin-bottom:5px'>
      <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
      $message.'</div>';
    }

  }
  ?>
</section>


<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="row visible-sm visible-xs" style="margin-left: 5px; margin-right: 5px; margin-top:0px;">
    <h3>Edit Payment Schemes 
      <button data-toggle="modal" data-target="#addPS"  class="btn btn-primary btn-md pull-right"> <span class="glyphicon glyphicon-plus" style="margin-right:10px"></span> Add New </button>
    </h3>
  </div>

  <div class="row hidden-sm hidden-xs">
    <div class="col-md-6">
      <h2 style="margin-top:0px;">Edit Payment Schemes</h2>
    </div>
    <div class="col-md-6">
     <button data-toggle="modal" data-target="#addPS"  class="btn btn-primary btn-md pull-right" style="margin-right:20px"> <span class="glyphicon glyphicon-plus" style="margin-right:10px"></span> Add New </button>
   </div>
 </div>
</section>

<!-- Main content -->

<section class="content">

  <div class="row">
    <div class="content">
      <div class="box">
        <div class="box-body table-responsive no-padding">
          <?php  $this->widget('zii.widgets.CListView', array(
            'dataProvider'=>$listEventsPSDP,
            'itemView'=>'_list_events_ps',
            'template' => "{sorter}<table id=\"example2\"class=\"table table-bordered table-hover\" >
            <thead>
            <th>Bank Details</th>
            <th>Bank Account No.</th>
            <th>Actions</th>
            </thead>
            <tbody>
            {items}
            </tbody>
            </table>
            {pager}",
            'emptyText' => "<tr><td colspan=\"6\">No available entries</td></tr>",
            )); ?>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div>
    </div>

  </section><!-- /.content -->

  <div class="modal fade" id="addPS" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="myModalLabel">Add New Payment Scheme</h4>
        </div>
        <div class="modal-body">
          <div class ="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
              <form role="form" method="POST" action="<?php echo Yii::app()->baseUrl; ?>/index.php/host/event/addnewps?event_id=<?php echo $event->id; ?>">
                <div class="form-group">
                  <select class="form-control" name="event_ps" required>
                    <option value=''>Select New Payment Scheme..</option>
                    <?php 
                    $ps = PaymentScheme::model()->findAll('status_id = 1'); 

                    foreach($ps as $ps1) 
                    {
                      $check = 0;

                      foreach($event_ps as $event_ps1) 
                      {
                        if($event_ps1->payment_scheme_id == $ps1->id)
                          $check++;
                      }

                      if($check==0)
                        echo "<option value='".$ps1->id."'>".$ps1->bank_details." -- ".$ps1->bank_account_no."</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-md-2"></div>
            </div>
          </div>  
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="submit" value="Payment Scheme" id="submit">Add</button> 
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php foreach($event_ps as $event_ps2): ?>
  <div class="modal fade" id="updatePS<?php echo $event_ps2->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="myModalLabel">Update Payment Scheme</h4>
        </div>
        <div class="modal-body">
          <div class ="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
              <form role="form" method="POST" action="<?php echo Yii::app()->baseUrl; ?>/index.php/host/event/updateps?event_id=<?php echo $event->id; ?>&id=<?php echo $event_ps2->id; ?>">
                <div class="form-group">
                  <select class="form-control" name="event_ps" required>
                    <option value=''>Select Payment Scheme..</option>
                    <?php 
                    $ps = PaymentScheme::model()->findAll('status_id = 1'); 

                    foreach($ps as $ps1) 
                    {
                      $check = 0;

                      foreach($event_ps as $event_ps1) 
                      {
                        if($event_ps1->payment_scheme_id == $ps1->id)
                          $check++;
                      }

                      if($check==0)
                        echo "<option value='".$ps1->id."'>".$ps1->bank_details." -- ".$ps1->bank_account_no."</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-md-2"></div>
            </div>
          </div>  
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="submit" value="Payment Scheme" id="submit">Update</button> 
          </form>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?> 