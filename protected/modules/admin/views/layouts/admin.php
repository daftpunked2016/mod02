<?php /* @var $this Controller */ ?>
<?php $this->beginContent('/layouts/main'); ?>
<!-- Nav -->
<?php $this->widget('AdminHeader'); ?>
<?php $this->widget('AdminLeftside'); ?>
<div class="content-wrapper">
	<?php echo $content; ?>
</div><!-- content -->
<?php $this->endContent(); ?>