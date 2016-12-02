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
        Upload Payment
      </h3>
    </div>
  </div>
</section>

<div class="container">
  <section class="content" style="margin-top:20px;">
  	<div class="row">
      <div class="col-md-4"></div>

      <div class="col-md-4">
        <div class="well">
          <form method="post">
            <div class="form-group">
              <label for="event">Select an Event:</label>

              <select name="event" class="form-control" required <?php if($event_list == null) echo "disabled"; ?>>
                <?php if($event_list == null): ?>
                  <option value='' disabled> YOU HAVE NO UNPAID REGISTRATIONS </option>
                <?php endif; ?>

                <?php if($event_list != null): ?>
                  <option value=''>Select a Registered Event.. </option>
                <?php endif; ?>
                
                <?php foreach($event_list as $a): 
                      $event = Event::model()->findByPk($a->event_id);
                ?>
                  <option value="<?php echo $event->id; ?>"><?php echo $event->name; ?></option>
                <?php endforeach; ?>

              </select>
            </div>

            <input type="submit" class="btn btn-primary btn-block" value="Select" />
          </form>
        </div>
      </div>

      <div class="col-md-4"></div>
    </div>
  </section>
</div>