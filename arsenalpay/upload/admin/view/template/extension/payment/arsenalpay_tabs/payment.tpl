<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_payment_edit; ?></h3>
	</div>
	<div class="panel-body">

		<div class="form-group required">
			<label class="col-sm-2 control-label"
				   for="input-widget_id"><?php echo $entry_widget_id; ?></label>
			<div class="col-sm-10">
				<input type="text" name="arsenalpay_widget_id" value="<?php echo $arsenalpay_widget_id; ?>"
					   placeholder="<?php echo $entry_widget_id; ?>" id="input-widget_id"
					   class="form-control"/>
				<?php if ($error_widget_id) { ?>
				<div class="text-danger"><?php echo $error_widget_id; ?></div>
				<?php } ?>
			</div>
		</div>
		<div class="form-group required">
			<label class="col-sm-2 control-label"
				   for="input-widget_key"><?php echo $entry_widget_key; ?></label>
			<div class="col-sm-10">
				<input type="text" name="arsenalpay_widget_key"
					   value="<?php echo $arsenalpay_widget_key; ?>"
					   placeholder="<?php echo $entry_widget_key; ?>" id="input-widget_key"
					   class="form-control"/>
				<?php if ($error_widget_key) { ?>
				<div class="text-danger"><?php echo $error_widget_key; ?></div>
				<?php } ?>
			</div>
		</div>
		<div class="form-group required">
			<label class="col-sm-2 control-label"
				   for="input-callback_key"><?php echo $entry_callback_key; ?></label>
			<div class="col-sm-10">
				<input type="text" name="arsenalpay_callback_key"
					   value="<?php echo $arsenalpay_callback_key; ?>"
					   placeholder="<?php echo $entry_callback_key; ?>" id="input-callback_key"
					   class="form-control"/>
				<?php if ($error_callback_key) { ?>
				<div class="text-danger"><?php echo $error_callback_key; ?></div>
				<?php } ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="input-callback">
                            <span data-toggle="tooltip"
								  title="<?php echo $help_callback_url; ?>"><?php echo $entry_callback_url; ?></span></label>
			<div class="col-sm-10">
				<div class="input-group"><span class="input-group-addon"><i class="fa fa-link"></i></span>
					<input type="text" readonly value="<?php echo $callback_url; ?>" id="input-callback"
						   class="form-control"/>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="input-ip"><span data-toggle="tooltip" data-html="true"
																	   data-trigger="click"
																	   title="<?php echo htmlspecialchars($help_ip); ?>"><?php echo $entry_ip; ?></span></label>
			<div class="col-sm-10">
				<input type="text" name="arsenalpay_ip" value="<?php echo $arsenalpay_ip; ?>"
					   placeholder="<?php echo $entry_ip; ?>" id="input-ip" class="form-control"/>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="input-check-status">
                            <span data-toggle="tooltip"
								  title="<?php echo $help_checked_status; ?>"><?php echo $entry_checked_status; ?></span>
			</label>
			<div class="col-sm-10">
				<select name="arsenalpay_checked_status_id" id="input-check-status" class="form-control">
					<?php foreach ($order_statuses as $order_status) { ?>
					<?php if ($order_status['order_status_id'] == $arsenalpay_checked_status_id) { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>"
							selected="selected"><?php echo $order_status['name']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
					<?php } ?>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"
				   for="input-completed-status"><?php echo $entry_completed_status; ?></label>
			<div class="col-sm-10">
				<select name="arsenalpay_completed_status_id" id="input-order-completed-status"
						class="form-control">
					<?php foreach ($order_statuses as $order_status) { ?>
					<?php if ($order_status['order_status_id'] == $arsenalpay_completed_status_id) { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>"
							selected="selected"><?php echo $order_status['name']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
					<?php } ?>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"
				   for="input-failed-status"><?php echo $entry_failed_status; ?></label>
			<div class="col-sm-10">
				<select name="arsenalpay_failed_status_id" id="input-failed-status" class="form-control">
					<?php foreach ($order_statuses as $order_status) { ?>
					<?php if ($order_status['order_status_id'] == $arsenalpay_failed_status_id) { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>"
							selected="selected"><?php echo $order_status['name']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
					<?php } ?>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"
				   for="input-canceled-status"><?php echo $entry_canceled_status; ?></label>
			<div class="col-sm-10">
				<select name="arsenalpay_canceled_status_id" id="input-canceled-status"
						class="form-control">
					<?php foreach ($order_statuses as $order_status) { ?>
					<?php if ($order_status['order_status_id'] == $arsenalpay_canceled_status_id) { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>"
							selected="selected"><?php echo $order_status['name']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
					<?php } ?>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"
				   for="input-hold-status"><?php echo $entry_holden_status; ?></label>
			<div class="col-sm-10">
				<select name="arsenalpay_holden_status_id" id="input-hold-status" class="form-control">
					<?php foreach ($order_statuses as $order_status) { ?>
					<?php if ($order_status['order_status_id'] == $arsenalpay_holden_status_id) { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>"
							selected="selected"><?php echo $order_status['name']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
					<?php } ?>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"
				   for="input-refund-status"><?php echo $entry_refunded_status; ?></label>
			<div class="col-sm-10">
				<select name="arsenalpay_refunded_status_id" id="input-refund-status" class="form-control">
					<?php foreach ($order_statuses as $order_status) { ?>
					<?php if ($order_status['order_status_id'] == $arsenalpay_refunded_status_id) { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>"
							selected="selected"><?php echo $order_status['name']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
					<?php } ?>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"
				   for="input-reverse-status"><?php echo $entry_reversed_status; ?></label>
			<div class="col-sm-10">
				<select name="arsenalpay_reversed_status_id" id="input-reverse-status" class="form-control">
					<?php foreach ($order_statuses as $order_status) { ?>
					<?php if ($order_status['order_status_id'] == $arsenalpay_reversed_status_id) { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>"
							selected="selected"><?php echo $order_status['name']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
					<?php } ?>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="input-total"><span data-toggle="tooltip"
																		  title="<?php echo $help_total; ?>"><?php echo $entry_total; ?></span></label>
			<div class="col-sm-10">
				<input type="text" name="arsenalpay_total" value="<?php echo $arsenalpay_total; ?>"
					   placeholder="<?php echo $entry_total; ?>" id="input-total" class="form-control"/>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"
				   for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
			<div class="col-sm-10">
				<select name="arsenalpay_geo_zone_id" id="input-geo-zone" class="form-control">
					<option value="0"><?php echo $text_all_zones; ?></option>
					<?php foreach ($geo_zones as $geo_zone) { ?>
					<?php if ($geo_zone['geo_zone_id'] == $arsenalpay_geo_zone_id) { ?>
					<option value="<?php echo $geo_zone['geo_zone_id']; ?>"
							selected="selected"><?php echo $geo_zone['name']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
					<?php } ?>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="input-debug"><?php echo $entry_debug; ?></label>
			<div class="col-sm-10">
				<select name="arsenalpay_debug" id="input-debug" class="form-control">
					<?php if ($arsenalpay_debug) { ?>
					<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
					<option value="0"><?php echo $text_disabled; ?></option>
					<?php } else { ?>
					<option value="1"><?php echo $text_enabled; ?></option>
					<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
					<?php } ?>
				</select>
				<span class="help-block"><?php echo $help_debug; ?></span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
			<div class="col-sm-10">
				<select name="arsenalpay_status" id="input-status" class="form-control">
					<?php if ($arsenalpay_status) { ?>
					<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
					<option value="0"><?php echo $text_disabled; ?></option>
					<?php } else { ?>
					<option value="1"><?php echo $text_enabled; ?></option>
					<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"
				   for="input-sort-order"><?php echo $entry_sort_order; ?></label>
			<div class="col-sm-10">
				<input type="text" name="arsenalpay_sort_order"
					   value="<?php echo $arsenalpay_sort_order; ?>"
					   placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order"
					   class="form-control"/>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="input-currency" "">
			<span data-toggle="tooltip"
				  title="<?php echo $help_currency_code; ?>"><?php echo $entry_currency_code; ?></span>
			</label>
			<div class="col-sm-10">
				<select name="arsenalpay_currency_code" id="input-currency" class="form-control">
					<?php foreach ($currencies as $currency) { ?>
					<?php if ($currency['code'] == $arsenalpay_currency_code) { ?>
					<option value="<?php echo $currency['code']; ?>"
							selected="selected"><?php echo $currency['code']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $currency['code']; ?>"><?php echo $currency['code']; ?></option>
					<?php } ?>
					<?php } ?>
				</select>
			</div>
		</div>
	</div>
</div>
