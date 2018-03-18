<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_tax_edit; ?></h3>
	</div>
	<div class="panel-body">
		<div class="form-group">
			<h4 class="container-fluid">
				<?php echo $text_arsenalpay_tax; ?>
			</h4>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="tax-class-default">
				<?php echo $entry_default_tax_rate; ?>
			</label>
			<div class="col-sm-10">
				<select id="tax-class-default" name="arsenalpay_default_tax_rate" class="form-control">
					<?php foreach ($ap_tax_rates as $ap_tax_id => $ap_tax_entry) : ?>
					<option value="<?php echo $ap_tax_id; ?>"<?php echo $arsenalpay_default_tax_rate == $ap_tax_id ? ' selected' : ''; ?>><?php echo $ap_tax_entry; ?></option>
					<?php endforeach; ?>
				</select>
				<p class="help-block"><?php echo $help_default_tax_rate; ?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">
				<?php echo $entry_tax_table; ?>
			</label>
			<div class="col-sm-10">
				<table class="table">
					<thead>
					<tr>
						<th><?php echo $help_header_shop_tax_classes; ?></th>
						<th><?php echo $help_header_ap_tax_rates; ?></th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($shop_tax_classes as $shop_tax_id => $shop_tax_name) : ?>
					<tr>
						<td>
							<label class="control-label" for="tax-class-<?php echo $shop_tax_id; ?>"><?php echo $shop_tax_name; ?></td>
						<td>
							<select id="tax-class-<?php echo $shop_tax_id; ?>" name="arsenalpay_tax_rates_map[<?php echo $shop_tax_id; ?>]" class="form-control">
								<?php foreach ($ap_tax_rates as $ap_tax_id => $ap_tax_entry) : ?>
								<option value="<?php echo $ap_tax_id; ?>"<?php echo (isset($arsenalpay_tax_rates_map[$shop_tax_id]) && $arsenalpay_tax_rates_map[$shop_tax_id] == $ap_tax_id)? ' selected' : ''; ?>><?php echo $ap_tax_entry; ?></option>
								<?php endforeach; ?>
							</select>
						</td>
					</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>

	</div>
</div>
