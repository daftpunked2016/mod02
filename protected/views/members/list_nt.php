<section class="content-header">
	<h1>
		Membership List
		<small>dashboard</small>
	</h1>
	<ol class="breadcrumb">
		<li>
			<?php echo CHtml::link('Membership List', array('members/list')); ?>
		</li>
		<li class="active">Dashboard</li>
	</ol>
</section>

<section class="content-header">

</section>

<section class="content">
	<div class="box box-solid">
		<div class="box-header with-border">
			List of Areas
			<div class="pull-right">
				<span class="fa fa-cogs"></span>
			</div>
		</div>
		<div class="box-body">
			<?php  $this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$areasDP,
				'itemView'=>'_list_nt',
				'template' => "{sorter}<table id=\"example2\"class=\"table table-bordered table-hover\" >
						<thead>
							<th>Area</th>
							<th>Regular Members</th>
							<th>Associate Members</th>
							<th>Total</th>
						</thead>
						<tbody>
							{items}
						</tbody>
					</table>
					{pager}",
				'emptyText' => "<tr><td colspan=\"4\">No available entries</td></tr>",
			));  ?>
		</div>
		<div class="box-footer"></div>
	</div>
</section>