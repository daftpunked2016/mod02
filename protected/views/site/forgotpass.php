<div class="login-box">
  <div class="login-logo">
    <img src = "../../dist/img/navbar_jci.png" width="300px" height="150px" ></img>
  </div><!-- /.login-logo -->
  <div class="login-box-body">

      <?php foreach(Yii::app()->user->getFlashes() as $key=>$message) {
          if($key  === 'success')
                {
                echo "<div class='alert alert-success alert-dismissible fade-in' role='alert'>
                <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
                $message.'</div>';
                }
              else
                {
                echo "<div class='alert alert-danger alert-dismissible fade-in' role='alert' id='myAlert'>
                <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
                $message.'</div>';
                }
        }
      ?>


    <h4 class="login-box-msg">Reset Password</h4>

    <div class="form">
      <form method="post">
        <div class="form-group">
            <input type="email" class="form-control" name="email" id="email" placeholder="Email">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary form-control" name="reset" value="Reset Password" />
        </div>
      </form>
    </div>

  </div><!-- /.login-box-body -->
</div><!-- /.login-box -->

<script>
  function showAlert(){
    $("#myAlert").addClass("in")
  }
</script>