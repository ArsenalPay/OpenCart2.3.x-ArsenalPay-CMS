<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-arsenalpay" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-arsenalpay" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-merchant"><?php echo $entry_merchant; ?></label>
            <div class="col-sm-10">
              <input type="text" name="arsenalpay_merchant" value="<?php echo $arsenalpay_merchant; ?>" placeholder="<?php echo $entry_merchant; ?>" id="input-merchant" class="form-control" />
              <?php if ($error_merchant) { ?>
              <div class="text-danger"><?php echo $error_merchant; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-key"><?php echo $entry_key; ?></label>
            <div class="col-sm-10">
              <input type="password" name="arsenalpay_key" value="<?php echo $arsenalpay_key; ?>" placeholder="<?php echo $entry_key; ?>" id="input-key" class="form-control" />
              <?php if ($error_key) { ?>
              <div class="text-danger"><?php echo $error_key; ?></div>
              <?php } ?>
            </div>
          </div>
		      <div class="form-group">
            <label class="col-sm-2 control-label" for="input-src"><?php echo $entry_src; ?></label>
            <div class="col-sm-10">
              <select name="arsenalpay_src" id="input-src" class="form-control">
                <?php if ($arsenalpay_src == 'mk') { ?>
                <option value="card"><?php echo $text_card; ?></option>
                <option value="mk" selected="selected"><?php echo $text_mk; ?></option>
                <?php } else { ?>
                <option value="card" selected="selected"><?php echo $text_card; ?></option>
                <option value="mk"><?php echo $text_mk; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
			      <label class="col-sm-2 control-label" for="input-callback"><span data-toggle="tooltip" title="<?php echo $help_callback; ?>"><?php echo $entry_callback; ?></span></label>
			      <div class="col-sm-10">
				      <div class="input-group"><span class="input-group-addon"><i class="fa fa-link"></i></span>
				        <input type="text" readonly value="<?php echo $callback_url; ?>" id="input-callback" class="form-control" />
				      </div>
			      </div>
			    </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-ip"><span data-toggle="tooltip" data-html="true" data-trigger="click" title="<?php echo htmlspecialchars($help_ip); ?>"><?php echo $entry_ip; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="arsenalpay_ip" value="<?php echo $arsenalpay_ip; ?>" placeholder="<?php echo $entry_ip; ?>" id="input-ip" class="form-control" />
            </div>
          </div>
		      <div class="form-group required">
			      <label class="col-sm-2 control-label" for="input-frame-url"><?php echo $entry_frame_url; ?></label>
			      <div class="col-sm-10">
			        <input type="text" name="arsenalpay_frame_url" value="<?php echo $arsenalpay_frame_url; ?>" placeholder="<?php echo $entry_frame_url; ?>" id="input-frame-url" class="form-control"/>
			        <?php if ($error_frame_url) { ?>
			        <div class="text-danger"><?php echo $error_frame_url; ?></div>
			        <?php } ?>
			      </div>
		      </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_frame_mode; ?></label>
            <div class="col-sm-10">
              <label class="radio-inline">
                <?php if ($arsenalpay_frame_mode == "1") { ?>
                <input type="radio" name="arsenalpay_frame_mode" value="1" checked="checked" />
                <?php echo $text_in_frame; ?>
                <?php } else { ?>
                <input type="radio" name="arsenalpay_frame_mode" value="1" />
                <?php echo $text_in_frame; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                <?php if ($arsenalpay_frame_mode == "0") { ?>
                <input type="radio" name="arsenalpay_frame_mode" value="0" checked="checked" />
                <?php echo $text_out_of_frame; ?>
                <?php } else { ?>
                <input type="radio" name="arsenalpay_frame_mode" value="0" />
                <?php echo $text_out_of_frame; ?>
                <?php } ?>
              </label>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-frame-params"><span data-toggle="tooltip" data-html="true" data-trigger="click" title="<?php echo htmlspecialchars($help_frame_params); ?>"><?php echo $entry_frame_params; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="arsenalpay_frame_params" value="<?php echo $arsenalpay_frame_params; ?>" placeholder="<?php echo $entry_frame_params; ?>" id="input-frame-params" class="form-control" />
			        <?php if ($error_frame_params) { ?>
			       <div class="text-danger"><?php echo $error_frame_params; ?></div>
			       <?php } ?>	
			      </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-css"><span data-toggle="tooltip" title="<?php echo $help_css; ?>"><?php echo $entry_css; ?></span></label>
            <div class="col-sm-10">
              <div class="input-group"><span class="input-group-addon"><i class="fa fa-link"></i></span>
                <input type="text" readonly value="<?php echo $arsenalpay_css; ?>" id="input-css" class="form-control" />
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-waiting-status"><?php echo $entry_waiting_status; ?></label>
            <div class="col-sm-10">
              <select name="arsenalpay_waiting_status_id" id="input-waiting-status" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $arsenalpay_waiting_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-completed-status"><?php echo $entry_completed_status; ?></label>
            <div class="col-sm-10">
              <select name="arsenalpay_completed_status_id" id="input-order-completed-status" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $arsenalpay_completed_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-failed-status"><?php echo $entry_failed_status; ?></label>
            <div class="col-sm-10">
              <select name="arsenalpay_failed_status_id" id="input-failed-status" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $arsenalpay_failed_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-canceled-status"><?php echo $entry_canceled_status; ?></label>
            <div class="col-sm-10">
              <select name="arsenalpay_canceled_status_id" id="input-canceled-status" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $arsenalpay_failed_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-total"><span data-toggle="tooltip" title="<?php echo $help_total; ?>"><?php echo $entry_total; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="arsenalpay_total" value="<?php echo $arsenalpay_total; ?>" placeholder="<?php echo $entry_total; ?>" id="input-total" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
            <div class="col-sm-10">
              <select name="arsenalpay_geo_zone_id" id="input-geo-zone" class="form-control">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $arsenalpay_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
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
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="arsenalpay_sort_order" value="<?php echo $arsenalpay_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>