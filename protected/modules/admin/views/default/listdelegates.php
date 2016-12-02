<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <?php $this->widget('ChapterHeads'); ?>
  <!--
  BODY TAG OPTIONS:
  =================
  Apply one or more of the following classes to get the
  desired effect
  |---------------------------------------------------------|
  | SKINS         | skin-blue                               |
  |               | skin-black                              |
  |               | skin-purple                             |
  |               | skin-yellow                             |
  |               | skin-red                                |
  |               | skin-green                              |
  |---------------------------------------------------------|
  |LAYOUT OPTIONS | fixed                                   |
  |               | layout-boxed                            |
  |               | layout-top-nav                          |
  |               | sidebar-collapse                        |
  |               | sidebar-mini                            |
  |---------------------------------------------------------|
  -->
  <body class="skin-black sidebar-mini">
    <div class="wrapper">

      <?php $this->widget('AdminHeader'); ?>

      <?php $this->widget('AdminLeftside'); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            ADMINISTRATOR
            <small>Authorized Personnel Only!</small>
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">
			<div class="row">
				<div class="col-md-12 col-lg-12">
					<div class="box">
		            	<div class="box-header">
		          			<h3 class="box-title">List Delegates (ACTIVE ACCOUNTS)</h3>
		                </div><!-- /.box-header -->
	                	<div class="box-body no-padding">
			                  <?php  $this->widget('zii.widgets.CListView', array(
								'dataProvider'=>$listdelegatesDP,
								'itemView'=>'_view_accounts',
								'template' => "{sorter}<table id=\"example1\"class=\"table table-bordered table-hover\" >
										<thead>
											<th>Avatar</th>
											<th>Email Address / Username</th>
											<th>First Name</th>
											<th>Last Name</th>
											<th>Chapter</th>
											<th>Position</th>
											<th>Action</th>
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
			</div>

			<div class="row">
				<div class="col-md-12 col-lg-12">
					<div class="box">
		            	<div class="box-header">
		          			<h3 class="box-title">List Delegates (INACTIVE ACCOUNTS)</h3>
		                </div><!-- /.box-header -->
	                	<div class="box-body no-padding">
			                  <?php  $this->widget('zii.widgets.CListView', array(
								'dataProvider'=>$InactivelistdelegatesDP,
								'itemView'=>'_view_accounts_inactive',
								'template' => "{sorter}<table id=\"example2\"class=\"table table-bordered table-hover\" >
										<thead>
											<th>Avatar</th>
											<th>Email Address / Username</th>
											<th>First Name</th>
											<th>Last Name</th>
											<th>Chapter</th>
											<th>Position</th>
											<th>Action</th>
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
			</div>

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <?php $this->widget('UserFooter'); ?>
	  
    </div><!-- ./wrapper -->

    <?php $this->widget('ChapterScripts'); ?>

  </body>
</html>