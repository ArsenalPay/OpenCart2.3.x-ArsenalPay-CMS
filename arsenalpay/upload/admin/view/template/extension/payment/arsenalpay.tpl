<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-arsenalpay" data-toggle="tooltip" title="<?php echo $button_save; ?>"
						class="btn btn-primary"><i class="fa fa-save"></i></button>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>"
				   class="btn btn-default"><i class="fa fa-reply"></i></a></div>
			<h1><?php echo $heading_title; ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="container-fluid">
		<?php if ($error_warning) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-payment" data-toggle="tab"><?php echo $text_payment_tab_header; ?></a></li>
			<li><a href="#tab-tax" data-toggle="tab"><?php echo $text_tax_tab_header; ?></a></li>
		</ul>
		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-arsenalpay"
			  class="form-horizontal">
			<div class="tab-content bootstrap">
				<div class="tab-pane active" id="tab-payment">
					<?php include dirname(__FILE__) . '/arsenalpay_tabs/payment.tpl'; ?>
				</div>
				<div class="tab-pane" id="tab-tax">
					<?php include dirname(__FILE__) . '/arsenalpay_tabs/tax.tpl'; ?>
				</div>
			</div>
		</form>
	</div>
</div>
<?php echo $footer; ?>