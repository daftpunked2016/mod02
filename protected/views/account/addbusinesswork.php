<section class="content-header">
  <h1>
    Add Business or Work History
  </h1>
</section>

    <!-- Main content -->
<section class="content">
  <div class="row">
    
    <?php foreach(Yii::app()->user->getFlashes() as $key=>$message) {
              echo "<div class='alert alert-danger alert-dismissible fade-in' role='alert' id='myAlert'>
              <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
              $message.'</div>';
              }
    ?>
  </div>

  <div class="row">
    <div class="col-md-3"> </div>
    <div class="well col-md-6" style="margin-bottom: 30px;">
      <select id="chooseType" name="chooseType" class="form-control">
        <option> Select Type.. </option>
        <option value='1'> Business </option>
        <option value='2'> Work </option>
      </select>
    </div>
    <div class="col-md-3"> </div>
  </div>


    <form id="addBusiness" name="addBusiness" role="form" enctype= 'multipart/form-data' method="post" >
      
      <div class="row" id="businessFormFields">   
        <!-- Business Form Fields -->
          <div class="col-md-3"> </div>
          <div class="well col-md-6">
            <h4 style="margin-top:0px;margin-bottom:20px;"><i class="fa fa-building" style="margin-right:15px;"></i>Add New Business</h4>
            <div class="form-group">
                <label>Category* </label>
                <select class="form-control" id="business-category" name="business-category" required>
                  <option value=""> Select Business Category... </option>
                  <?php $categories = BusinessCategory::model()->findAll(); 
                    foreach($categories as $category)
                      echo "<option value='".$category->id."'>".$category->category."</option>";
                  ?>
                </select>
            </div>

            <div class="form-group">    
                <label>SubType* </label>
                <select class="form-control" id="business-subtype" name="business-subtype" required>
                  <option value=""> -- </option>
                </select>
            </div>
            
            <div class="form-group">    
                <label>Business Name* </label>
                <input type="text" class="form-control" id="business-name" name="business-name" required /> 
            </div>


            <div class="form-group">    
                <label>Description </label>
                <textarea class="form-control" id="business-description" name="business-description" style="resize:none;" rows="3" required> </textarea>
            </div>

            <div class="form-group">    
                <label>Business Address(Full)* </label>
                <input type="text" class="form-control" id="business-address" name="business-address" required /> 
            </div>

            <div class="form-group">
                <label>Province* </label>
                <select class="form-control" id="business-province" name="business-province" required>
                  <option value=""> Select Province... </option>
                  <?php $provinces = Provinces::model()->findAll(); 
                    foreach($provinces as $province)
                      echo "<option value='".$province->id."'>".$province->name."</option>";
                  ?>
                </select>
            </div>

            <div class="form-group">    
                <label>City* </label>
                <select class="form-control" id="business-city" name="business-city" required>
                  <option value=""> -- </option>
                </select>
            </div>

            <div class="form-group">    
                <label>Street </label>
                <input type="text" class="form-control" id="business-street" name="business-street" /> 
            </div>

            <div class="form-group">    
                <label>Contact No(s). </label>
                <textarea type="text" class="form-control" id="business-contact" name="business-contact" style="resize:none;" rows="2"></textarea> 
            </div>

            <div class="form-group">    
                <label>Operating Hours* </label>
                <input type="text" class="form-control" id="business-hours" name="business-hours" required /> 
            </div>

            <div class="form-group">    
                <label>Logo </label>
                <input type="file" id="business-logo" name="business-logo" /> 
            </div>

            <div class="form-group">
              <input type="submit" value="Add Business" name="business-submit" class="btn btn-primary pull-right" style="margin-top:20px;" />
            </div>

          </div>
          <div class="col-md-3"> </div>
      </div>    
    </form>
    

    <form id="addWork" name="addWork" role="form" enctype= 'multipart/form-data' method="post" >
      <div class="row" id="workFormFields">
        <!-- Work History Form Fields -->
          <div class="col-md-3"> </div>
          <div class="well col-md-6">
            <h4 style="margin-top:0px;margin-bottom:20px;"><i class="fa fa-suitcase" style="margin-right:15px;"></i>Add New Work</h4>
            <div class="form-group">
                <label>Category* </label>
                <select class="form-control" id="work-category" name="work-category" required>
                  <option value=""> Select Work Category... </option>
                  <?php $categories = BusinessCategory::model()->findAll(); 
                    foreach($categories as $category)
                      echo "<option value='".$category->id."'>".$category->category."</option>";
                  ?>
                </select>
            </div>

            <div class="form-group">    
                <label>SubType* </label>
                <select class="form-control" id="work-subtype" name="work-subtype" required>
                  <option value=""> -- </option>
                </select>
            </div>

            <div class="form-group">    
                <label>Company Name* </label>
                <input type="text" class="form-control" id="work-company" name="work-company" required /> 
            </div>

            <div class="form-group">    
                <label>Job Position/Title* </label>
                <input type="text" class="form-control" id="work-position" name="work-position" required /> 
            </div>

            <div class="form-group">    
                <label>Company Address(Full)* </label>
                <input type="text" class="form-control" id="work-address" name="work-address" required /> 
            </div>

            <div class="form-group">
                <label>Province* </label>
                <select class="form-control" id="work-province" name="work-province" required>
                  <option value=""> Select Province... </option>
                  <?php $provinces = Provinces::model()->findAll(); 
                    foreach($provinces as $province)
                      echo "<option value='".$province->id."'>".$province->name."</option>";
                  ?>
                </select>
            </div>

            <div class="form-group">    
                <label>City* </label>
                <select class="form-control" id="work-city" name="work-city" required>
                  <option value=""> -- </option>
                </select>
            </div>

            <div class="form-group">    
                <label>Street </label>
                <input type="text" class="form-control" id="work-street" name="work-street" /> 
            </div>
            
            <div class="form-group">
              <input type="submit" value="Add Work" name="work-submit" class="btn btn-primary pull-right" style="margin-top:20px;" />
            </div>

          </div>
          <div class="col-md-3"> </div>
      </div>

    </form>


</section><!-- /.content -->