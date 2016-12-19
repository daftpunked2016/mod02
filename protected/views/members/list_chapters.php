<section class="content-header">
	<h1>
		<?php echo $region->region; ?>
		<small>chapters</small>
	</h1>
	<ol class="breadcrumb">
		<li>
			<?php echo CHtml::link('Membership List', array('members/list')); ?>
		</li>
		<li class="active"><?php echo $region->region; ?></li>
	</ol>
</section>

<section class="content-header">

</section>

<section class="content">
	<div class="box box-solid">
		<div class="box-header with-border">
			List of Chapters
			<div class="pull-right">
				<span class="fa fa-cogs"></span>
			</div>
		</div>
		<div class="box-body">
			<?php  $this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$chaptersDP,
				'itemView'=>'_list_rvp',
				'template' => "{sorter}<table id=\"example2\"class=\"table table-bordered table-hover\" >
						<thead>
							<th>Chapter</th>
							<th>Regular Members(Active)</th>
							<th>Associate Members(Active)</th>
							<th>Total(Active)</th>
							<th>Regular Members(HQ)</th>
							<th>Associate Members(HQ)</th>
							<th>Total(HQ)</th>
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