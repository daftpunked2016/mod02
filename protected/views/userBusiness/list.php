<section class="content-header">
	<h1>
		Business Referrals
		<small>view</small>
	</h1>
</section>

<section class="content">
	<div class="box">
		<div class="box-header with-border">
			List of Business Referrals
		</div>
		<div class="box-body">
			<?php
			$this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$referralsDP,
				'itemView'=>'_view_list_referrals',
				'template' => "{sorter}<table id=\"example1\" class=\"table table-bordered table-hover\">
				<thead class='panel-heading'>
					<th>Account Name</th>
					<th>Business</th>
					<th>Status</th>
					<th class='text-center'>Action</th>
				</thead>
				<tbody>
					{items}
				</tbody>
				</table>
				{pager}",
				'emptyText' => "<tr><td class='text-center' colspan=\"4\">No available entries</td></tr>",
			));  ?>
		</div>
		<div class="box-footer">
			List of Business Referrals
		</div>
	</div>
</section>