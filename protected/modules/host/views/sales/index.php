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
  <h1>
  	<?php echo $event->name; ?> Sales
    <small>sales preview of current event</small>
  </h1>
</section>

<section class="content">
	<div class="row">
		<div class="col-xs-12">

      <div class="well">
        <div class="row" id="searchFilters" style="margin-bottom:20px;">
          <p>
            <h4 style="margin-left:10px;">Search Options</h4>

            <form method="post" name="search">

              <div class="row" style="margin-bottom:10px;">
                <div class="col-xs-6 col-md-4">
                  <div class="form-group">
                    <div class="col-md-4">
                      <label for="area_no">Area No.</label>
                    </div>
                    <div class="col-md-8">
                      <select name="area_no" class="form-control" id="area_no2">
                        <option value="">Please Select...</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                      </select>
                    </div>
                  </div>
                </div>

                <!-- <div class="col-xs-6 col-lg-3">
                  First or Last Name: <input type="text" name="name" class="form-control" />
                </div> -->

                <div class="col-xs-6 col-md-4">
                  <div class="form-group">
                    <div class="col-md-4">
                      <label for="chapter">Region</label>
                    </div>
                    <div class="col-md-8">
                      <select name="region" class="form-control" id="region2">
                        <option value="*">Please Select...</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-md-4">
                  <div class="form-group">
                    <div class="col-md-4">
                      <label for="chapter">Chapter</label>
                    </div>
                    <div class="col-md-8">
                      <select name="chapter" class="form-control" id="chapter2">
                        <option value="*">Please Select...</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row" style="margin-bottom:10px;">
                <div class="col-xs-6 col-md-4">
                  <div class="form-group">
                    <div class="col-md-4">
                      <label for="from">From</label>
                    </div>
                    <div class="col-md-8">
                      <?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                          'options'=>array(
                            'showAnim'=>'slideDown',
                            'yearRange'=>'-10:-0',
                            'changeMonth' => true,
                            'changeYear' => true,
                            'dateFormat' => 'yy-mm-dd'
                            ),
                          'htmlOptions' => array(
                            'size' => 20,         // textField size
                            'class' => 'form-control',
                            'name'=>'from',
                          ),  
                        ));
                      ?>
                    </div>
                  </div>
                </div>

                <!-- <div class="col-xs-6 col-lg-3">
                  First or Last Name: <input type="text" name="name" class="form-control" />
                </div> -->

                <div class="col-xs-6 col-md-4">
                  <div class="form-group">
                    <div class="col-md-4">
                      <label for="to">To</label>
                    </div>
                    <div class="col-md-8">
                      <?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                          'options'=>array(
                            'showAnim'=>'slideDown',
                            'yearRange'=>'-10:-0',
                            'changeMonth' => true,
                            'changeYear' => true,
                            'dateFormat' => 'yy-mm-dd'
                            ),
                          'htmlOptions' => array(
                            'size' => 20,         // textField size
                            'class' => 'form-control',
                            'name'=>'to',
                          ),  
                        ));
                      ?>
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-md-4">
                  <div class="form-group">
                    <div class="col-md-4">
                      <label for="amount">Amount</label>
                    </div>
                    <div class="col-md-8">
                      <input type="text" placeholder="9999.99" class="form-control" name="amount" />
                    </div>
                  </div>
                </div>

              </div>

              <div class="row" style="margin-bottom:10px;">
                <div class="col-md-10 visible-md visible-lg"></div>
                <div class="col-md-2">
                  <div class="form-group">
                    <div class="pull-right" style="margin-top:10px; margin-right:15px;">
                      <input type="submit" class="btn btn-success" value="Search" />
                    </div>
                  </div>
                </div>
              </div>

              
            </form> 
          </p>
        </div>
      </div>

      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Event Sales</h3>
          <div class="box-body table-responsive no-padding">
           <div class="row wrappers transaction_wrapper">
            <div class="col-md-12">
              <?php  $this->widget('zii.widgets.CListView', array(
                'dataProvider'=>$salesDP,
                'itemView'=>'_list_sales',
                'template' => "{sorter}<table id=\"example2\" class=\"table table-bordered table-hover\">
                <thead class='panel-heading'>
                <th>Username / Email Address</th>
                <th>Name</th>
                <th>Chapter</th>                
                <th>Date Registered</th>
                <th>Date Approved</th>
                <th>Amount</th>
                <th>Deposit Slip</th>
                </thead>
                <tbody>
                {items}
                </tbody>
                </table>
                {pager}",
                'emptyText' => "<tr><td colspan=\"6\">No available entries</td></tr>",
                ));  ?>
              </div>
            </div>
          </div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>
  </div>
</section>

<div class="content col-lg-3 pull-right"><div class="well"><?php echo "<B>GRAND TOTAL:</B> PHP ".money_format('%i', $grandTotal); ?></div></div>