<?php
        $fileupload = Fileupload::model()->findByPk($data->business_avatar);
        $business_avatar = $fileupload->filename;
        $businesstype = BusinessSubtype::model()->findByPk($data->business_type_id);
        $businesscat = BusinessCategory::model()->findByPk($businesstype->type);
        $city = Cities::model()->findByPk($data->city_id);
        $province = Provinces::model()->findByPk($data->province_id);
      ?>
  <div class="col-xs-12">
    <div class="panel panel-default">
      <div class="panel-heading"><h4><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/admin/account/viewbusiness/id/<?php echo $data->id; ?>"><?php echo $data->business_name; ?></a><small style="margin-left:10px"><?php echo $businesscat->category; ?></small></h4></div>
      <div class="panel-body">
        <div class="col-md-3">
          <?php if($business_avatar == null || $business_avatar === ""): ?>
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/notavail.jpg" class="img-circle" alt="Business Image" style="height:120px; width:120px; display:block;margin-left:auto;margin-right:auto;" />
          <?php else: ?>
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/business_avatars/<?php echo $business_avatar; ?>" class="img-circle" alt="Business Image" style="height:120px; width:120px; display:block;margin-left:auto;margin-right:auto;" />
          <?php endif; ?>
        </div>
        <div class="col-md-9">
          <table class="table table-hover">
            <tr>
              <th>Subtype</th>
              <td><?php echo $businesstype->subtype; ?></td>
            </tr>
            <tr>
              <th>Province</th>
              <td><?php echo $province->name; ?></td>
            </tr>
            <tr>
              <th>City</th>
              <td><?php echo $city->name; ?></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
