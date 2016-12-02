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


<section class="content-header">
  <div class="row">
    <div class="col-md-7">
      <h3>
        Event Transactions History
      </h3>
    </div>
  </div>
</section>

<div class="content">
  <section class="content" style="margin-top:20px;">
  	<div class="col-md-12 col-lg-12">
  		<div class="box">
          	<div class="box-header">
        			<h3 class="box-title">Transactions History</h3>
              </div><!-- /.box-header -->
          	<div class="box-body table-responsive no-padding">
                    <?php  $this->widget('zii.widgets.CListView', array(
  					'dataProvider'=>$eventAttendeeDP,
  					'itemView'=>'_list_transactions',
  					'template' => "{sorter}<table id=\"example2\"class=\"table table-bordered table-hover\" >
  							<thead>
  								<th>Event Name</th>
                  <th>Event Type</th>
  								<th>Price</th>
  								<th>Date Registered</th>
                  <th>Payment Status</th>
  								<th>Actions</th>
  							</thead>
  							<tbody>
  								{items}
  							</tbody>
  						</table>
  						{pager}",
  					'emptyText' => "<tr><td colspan=\"6\">No available entries</td></tr>",
  					));  ?>
         		</div><!-- /.box-body -->
    		</div><!-- /.box -->
  	</div>
  </section>
</div>

<?php 
  if($payments != null): 
    foreach($payments as $payment):
?>

<div class="modal fade" id="paymentModal<?php echo $payment->event_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Payment Details</h4>
      </div> 
      <div class="modal-body"> 
        <div class = "well">
          <div class ="row">
            <div class="col-lg-12 col-md-12">
              <center><img style="border:2px solid black;  height:100%; width:100%;" src="<?php echo Yii::app()->request->baseUrl; ?>/payment_uploads/<?php $fileupload= Fileupload::model()->findByPk($payment->payment_avatar); echo $fileupload->filename; ?>" id="userAvatar" /> </center>
            </div>
          </div>
        </div>
        <div class="row">
          <div class = "col-lg-12">
            <B>Payment No:</B> <?php echo $payment->payment_avatar; ?> </br>
            <B>Bank Branch:</B> <?php echo $payment->bank_branch; ?> </br>
            <B>Amount:</B> <?php echo $payment->amount; ?> </br>
            <B>Date:</B> <?php echo date('F d, Y',  strtotime($payment->date)); ?></br>
            <B>Time:</B> <?php echo $payment->time; ?></br>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <form>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php 
    endforeach;
  endif; 
?>