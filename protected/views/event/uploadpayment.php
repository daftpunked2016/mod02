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
    Upload Payment 
  </h1>
</section>

  <div class="row">
    <div class="form">

      <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'position-form',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>true,
      )); ?>

    <div class="col-md-3"></div>
    <div class="col-md-6">

        <div class="well">

            <div class="row" style="margin-bottom:15px;">
              <div class="form-group">
                <div class="col-sm-4">
                  <label for="eventname">Event Name</label>
                </div>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="eventname" value="<?php echo ucwords(strtolower($event->name)); ?>" disabled/>
                </div>
              </div>
            </div>

            <div class="row" style="margin-bottom:15px;">
              <div class="form-group">
                <div class="col-sm-4">
                  <label for="expectamount">Expected Amount</label>
                </div>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="expectamount" value="<?php echo "Php. ".$currentprice; ?>" disabled/>
                  <input type="hidden" id="origamount" value="<?php echo $currentprice; ?>" />
                </div>
              </div>
            </div>

            <div class="row" style="margin-bottom:15px;">
             <center><small><i>*Please enter the exact details printed from the receipt.</i></small></center>
            </div>
            
            <div class="row" style="margin-bottom:15px;">
              <div class="form-group">
                <div class="col-sm-4">
                  <label for="bank_branch">Bank Branch</label>
                </div>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="bank_branch" name="bank_branch" required />
                </div>
              </div>
            </div>

            <div class="row" style="margin-bottom:15px;">
              <div class="form-group">
                <div class="col-sm-4">
                  <label for="position_id">Date</label>
                </div>
                <div class="col-sm-8">
                  <div class="form-group">
                    <?php
                      $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'options'=>array(
                          'showAnim'=>'slideDown',
                          'yearRange'=>'-2:-0',
                          'changeMonth' => true,
                          'changeYear' => true,
                          'dateFormat' => 'yy-mm-dd'
                          ),
                        'htmlOptions' => array(
                          'size' => 20,         // textField size
                          'class' => 'form-control',
                          'required'=>'true',
                          'name'=>'date',
                        ),  
                      ));
                    ?>
                  </div>
                </div>
              </div>
            </div>


            <div class="row" style="margin-bottom:15px;">
              <div class="form-group">
                <div class="col-sm-4">
                  <label for="time">Time</label>
                </div>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="time" name="time" required />
                </div>
              </div>
            </div>

            <div class="row" style="margin-bottom:15px;">
              <div class="form-group">
                <div class="col-sm-4">
                  <label for="amount">Amount Paid</label>
                </div>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="amount" name="amount" placeholder="eg. 999.75" data-toggle="tooltip" data-placement="top" title="Input numerical values only." required />
                </div>
              </div>
            </div>

            <div class="row" style="margin-bottom:15px;">
              <div class="form-group">
                <div class="col-sm-4">
                  <label for="receipt">Receipt Photo</label>
                </div>
                <div class="col-sm-8">
                  <input type="file" class="form-control" id="receipt" name="receipt" required />
                </div>
              </div>
            </div>


        </div>
          

        <div class="row buttons">    
          <?php echo CHtml::submitButton('Submit', array('class'=>'btn btn-lg btn-primary pull-right', 'style'=>'margin-right:20px;')); ?>
          <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/event/transactions" class="btn btn-warning pull-right" style="margin-right:10px;"><span class="glyphicon glyphicon-chevron-left" style="margin-right:10px;"></span>Back</a>
        </div>

      </div>
    </div>
  </div>
  <div class="col-md-3"></div>


  <?php $this->endWidget(); ?>

    
</section><!-- /.content -->


<script>
  $(document).ready(function(){
   
    function validateInput(value)    
    {
      var RE = /^[0-9]+\.?\d{0,2}$/; 
      if(RE.test(value)){
         return true;
      }else{
         return false;
      }
    }



    var $amountinput = $('#amount');
    var $amountneeded = $('#origamount');

    $amountinput.focusout(function(){
      if(validateInput($amountinput.val()))
       {
         if(parseInt($amountinput.val()) < parseInt($amountneeded.val()))
          {
            alert("Amount Paid must be equal or higher than the expected amount!");
            $amountinput.focus();
          }
       }
      else
        {
          alert("Amount Paid must only consist of numerical values and 2 decimal values. Eg. 999.75");
          $amountinput.focus();
        }
    });


  });
</script>