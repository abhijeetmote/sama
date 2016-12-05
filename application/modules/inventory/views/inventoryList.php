<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="#">Home</a>
				</li>

				<li>
					<a href="#">Inventory</a>
				</li>
				<li class="active">Inventory Lists</li>
			</ul><!-- /.breadcrumb -->

			<div class="nav-search" id="nav-search">
				<form class="form-search">
					<span class="input-icon">
						<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
						<i class="ace-icon fa fa-search nav-search-icon"></i>
					</span>
				</form>
			</div><!-- /.nav-search -->
		</div>

		<div class="page-content">
			
			<div class="page-header">
				<h1>
					Inventory List
				</h1>
			</div><!-- /.page-header -->

			<div class="row">
				<div class="col-xs-12">
					<div class="alert-box"></div>
					<!-- PAGE CONTENT BEGINS -->
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<label class="col-sm-1 no-padding-right" for="form-field-2"><b class="red"> * </b>Cust Type</label>
	                            <div class="col-sm-3">
									<select style="width:240px;" data-placeholder="" id="inventory_type" class="chosen-select form-control">
											<option <?php if(isset($i_type) && $i_type == 1) { echo "selected"; }?> value="1">Inward</option>
											<option <?php if(isset($i_type) && $i_type == 2) { echo "selected"; }?> value="2">Outward</option>
	                                </select>
	                                 
									 
								</div>
	                            
                            	<label class="col-sm-1 no-padding-right" for="form-field-2"><b class="red"> * </b>Form Date</label>
	                            <div class="col-sm-3">
									<div class="input-group">
									<input type="text" data-date-format="dd-mm-yyyy" class="date-picker col-xs-10 col-sm-12" id="from_date" name="from_date" placeholder="Enter from Date" value="<?php if(isset($from_date)): echo  $from_date; endif; ?>">
									<span class="input-group-addon">
										<i class="fa fa-calendar bigger-110"></i>
									</span>

									</div>
									 
								</div>

								<label class="col-sm-1 no-padding-right" for="form-field-2"><b class="red"> * </b>To Date</label>
	                             <div class="col-sm-3">
									<div class="input-group">
									<input type="text" data-date-format="dd-mm-yyyy" class="date-picker col-xs-10 col-sm-12" id="to_date" name="to_date" placeholder="Enter User Booking Date" value="<?php if(isset($to_date)): echo $to_date; endif; ?>">
									<span class="input-group-addon">
										<i class="fa fa-calendar bigger-110"></i>
									</span>
									</div>									 
								</div>
                   		 	</div>            		 	 
						</div>
					</div>	
		
					<div class="clearfix form-actions">
						<div class="col-md-offset-3 col-md-9">
							<button class="btn btn-info inventory_filter" type="button">
								<i class="iconcategory"></i>
								Submit
							</button>

							&nbsp; &nbsp; &nbsp;
							<button class="btn b_reset" type="reset">
								<i class="ace-icon fa fa-undo bigger-110 "></i>
								Reset
							</button>
						</div>
					</div>
				</div>	
			</div>

			<div class="row">
				<div class="col-xs-12">
					<a id="gritter-without-image" class="btn btn-success" href="#inward-modal" data-toggle="modal" >Inward</a>
					<a id="gritter-without-image" class="btn btn-success" href="#outward-modal" data-toggle="modal">Outward</a>
					<div class="row">
						<div class="col-xs-12">
							<div class="clearfix">
								<div class="pull-right tableTools-container"></div>
							</div>
							<div class="table-header">
								List
							</div>

							<!-- div.table-responsive -->

							<!-- div.dataTables_borderWrap -->
							<div>
								<table id="dynamic-table" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>Sr. No</th>
											<th>Product Name</th>
											<th>Site Name</th>
											<th>Vendor Name</th>
											<th>Price</th>
											<th>Qty</th>
											<th>Total Amt</th>
											<th>Status</th>
											
										</tr>
									</thead>

									<tbody>
										<?php foreach ($inventory as $key => $val) { ?>
											<tr>
												<td><?php echo ++$key ?></td>
												<td><?php echo $val->p_name ?></td>
												<td><?php echo $val->site_name ?></td>
												<td><?php echo $val->vendor_name ?></td>
												<td><?php echo $val->price ?></td>
												<td><?php echo $val->qty ?></td>
												<td><?php echo $val->total_amt ?></td>
												<td><?php if($val->inventory_status == 1): echo "Inward"; else: echo "Outward"; endif; ?></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>

					<div id="inward-modal" class="modal fade" tabindex="-1">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h3 class="smaller lighter blue no-margin">Inward</h3>
								</div>

								<div class="modal-body">
									<div class="row">
										<div class="col-xs-12">
											<div class="alert-box"></div>
											<!-- PAGE CONTENT BEGINS -->
											<form class="form-horizontal" role="form" id="vehiclecategory">						
												<div class="form-group">
													<label class="col-sm-3 control-label no-padding-right" for="">Select Product<b class="red">*</b></label>

													<div class="col-sm-7">
														<select class="chosen-select form-control" id="product">
															<option value="">Please select</option>
														<?php
															foreach ($product_list as $val) {
																echo '<option value="'.$val->p_id.'">'.$val->p_name.'</option>';
															}
														?>
															
														</select>
													</div>												
												</div>
												<div class="form-group">
													<label class="col-sm-3 control-label no-padding-right" for="">Select site<b class="red">*</b></label>

													<div class="col-sm-7">
														<select class="chosen-select form-control" id="site">
															<option value="">Please select</option>
														<?php
															foreach ($site_list as $val) {
																echo '<option value="'.$val->site_id.'">'.$val->site_name.'</option>';
															}
														?>
															
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 control-label no-padding-right" for="">Select vendor<b class="red">*</b></label>

													<div class="col-sm-7">
														<select class="chosen-select form-control" id="vendor">
															<option value="">Please select</option>
														<?php
															foreach ($vendor_list as $val) {
																echo '<option value="'.$val->vendor_id.'">'.$val->vendor_name.'</option>';
															}
														?>
															
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 control-label no-padding-right" for="">Unit price<b class="red">*</b></label>

													<div class="col-sm-9">
														<input type="text" id="price" class="col-xs-10 col-sm-5 mandatory-field" value="0" disabled>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 control-label no-padding-right" for="">Enter Qty<b class="red">*</b></label>

													<div class="col-sm-9">
														<input type="text" id="qty" class="col-xs-10 col-sm-5 mandatory-field" value="0">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 control-label no-padding-right" for="">Total amt<b class="red">*</b></label>

													<div class="col-sm-9">
														<input type="text" id="total_amt" class="col-xs-10 col-sm-5 mandatory-field" value="0" disabled>
													</div>
												</div>
												
												<div class="clearfix form-actions">
													<div class="col-md-offset-3 col-md-9">
														<button class="btn btn-info" id="inward" type="button">
															<i class="iconcategory"></i>
															Submit								</button>

														&nbsp; &nbsp; &nbsp;
														<button class="btn" type="reset">
															<i class="ace-icon fa fa-undo bigger-110"></i>
															Reset
														</button>
													</div>
												</div>
											</form>
										</div><!-- /.col -->
									</div>
								</div>
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div>

					<div id="outward-modal" class="modal fade" tabindex="-1">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h3 class="smaller lighter blue no-margin">Outward</h3>
								</div>

								<div class="modal-body">
									<div class="row">
										<div class="col-xs-12">
											<div class="alert-box"></div>
											<!-- PAGE CONTENT BEGINS -->
											<form class="form-horizontal" role="form" id="vehiclecategory">	
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="">Select Product<b class="red">*</b></label>

												<div class="col-sm-7">
													<select class="chosen-select form-control" id="out_product">
														<option value="">Please select</option>
													<?php
														foreach ($product_list as $val) {
															echo '<option value="'.$val->p_id.'">'.$val->p_name.'</option>';
														}
													?>
														
													</select>
												</div>												
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="">Select site<b class="red">*</b></label>

												<div class="col-sm-7">
													<select class="chosen-select form-control" id="out_site">
														<option value="">Please select</option>
													<?php
														foreach ($site_list as $val) {
															echo '<option value="'.$val->site_id.'">'.$val->site_name.'</option>';
														}
													?>
														
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="">Unit price<b class="red">*</b></label>

												<div class="col-sm-9">
													<input type="text" id="out_price" class="col-xs-10 col-sm-5 mandatory-field" value="0" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="">Enter Qty<b class="red">*</b></label>

												<div class="col-sm-9">
													<input type="text" id="out_qty" class="col-xs-10 col-sm-5 mandatory-field" value="0">
												</div>
											</div>
											
											<div class="clearfix form-actions">
												<div class="col-md-offset-3 col-md-9">
													<button class="btn btn-info" id="outward" type="button"><i class="iconcategory"></i>Submit</button>&nbsp; &nbsp; &nbsp;
													<button class="btn" type="reset">
														<i class="ace-icon fa fa-undo bigger-110"></i>
														Reset
													</button>
												</div>
											</div>
											</form>		
										</div><!-- /.col -->
									</div>
								</div>
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.page-content -->
	</div>
</div><!-- /.main-content -->

<!-- basic scripts -->

<!--[if !IE]> -->
<script src="<?php echo base_url(); ?>js/jquery.min.js"></script>

<!-- <![endif]-->

<!--[if IE]>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<![endif]-->
<script type="text/javascript">
	if('ontouchstart' in document.documentElement) document.write("<script src='components/_mod/jquery.mobile.custom/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>

<!-- page specific plugin scripts -->

<!--[if lte IE 8]>
  <script src="./components/ExplorerCanvas/excanvas.min.js"></script>
<![endif]-->
<script src="<?php echo base_url(); ?>components/_mod/jquery-ui.custom/jquery-ui.custom.min.js"></script>
<script src="<?php echo base_url(); ?>components/jqueryui-touch-punch/jquery.ui.touch-punch.min.js"></script>
<script src="<?php echo base_url(); ?>components/chosen/chosen.jquery.min.js"></script>
<script src="<?php echo base_url(); ?>components/fuelux/js/spinbox.min.js"></script>
<script src="<?php echo base_url(); ?>components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url(); ?>components/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script src="<?php echo base_url(); ?>components/moment/moment.min.js"></script>
<script src="<?php echo base_url(); ?>components/bootstrap-daterangepicker/daterangepicker.min.js"></script>
<script src="<?php echo base_url(); ?>components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo base_url(); ?>components/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo base_url(); ?>components/jquery-knob/dist/jquery.knob.min.js"></script>
<script src="<?php echo base_url(); ?>components/autosize/dist/autosize.min.js"></script>
<script src="<?php echo base_url(); ?>components/jquery-inputlimiter/jquery.inputlimiter.min.js"></script>
<script src="<?php echo base_url(); ?>components/jquery.maskedinput/dist/jquery.maskedinput.min.js"></script>
<script src="<?php echo base_url(); ?>components/_mod/bootstrap-tag/bootstrap-tag.min.js"></script>

<!-- ace scripts -->
<script src="<?php echo base_url(); ?>js/ace-elements.min.js"></script>
<script src="<?php echo base_url(); ?>js/ace.min.js"></script>

<script src="<?php echo base_url(); ?>components/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>components/_mod/datatables/jquery.dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>components/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="<?php echo base_url(); ?>components/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>components/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>components/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<script src="<?php echo base_url(); ?>components/datatables.net-select/js/dataTables.select.min.js"></script>

<script src="<?php echo base_url(); ?>js/custom.js"></script>
<script src="<?php echo base_url(); ?>js/form-validation.js"></script>

<!-- inline scripts related to this page -->
<script type="text/javascript">
	jQuery(function($) {
		//initiate dataTables plugin
		$('.date-picker').datepicker({
			autoclose: true,
			todayHighlight: true
		})
		var myTable = 
		$('#dynamic-table')
		//.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
		.DataTable( { 
	    } );
	
		
		
		$.fn.dataTable.Buttons.swfPath = "<?php echo base_url(); ?>components/datatables.net-buttons-swf/index.html"; //in Ace demo ./components will be replaced by correct assets path
		$.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';
		
		new $.fn.dataTable.Buttons( myTable, {
			buttons: [
			  
			  {
				"extend": "csv",
				"text": "<i class='fa fa-database bigger-110 orange'></i> <span class='hidden'>Export to CSV</span>",
				"className": "btn btn-white btn-primary btn-bold"
			  },
			  
			  {
				"extend": "print",
				"text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span>",
				"className": "btn btn-white btn-primary btn-bold",
				autoPrint: false,
				message: 'This print was produced using the Print button for DataTables'
			  }		  
			]
		} );
		myTable.buttons().container().appendTo( $('.tableTools-container') );
		
		 
	
	})
</script>

<script type="text/javascript">
	$(document).on('change','#product', function(e){
		var id = $(this).val();
        
        var obj = array.filter(function(obj){
            return obj.name === "product_details"
        })[0];

        var uri = obj['value'];

        jobject = {
            'id' : id
        }
        
        $.ajax({
            url: uri,
            method: 'POST',
            crossDomain: true,
            data: jobject,
            dataType: 'json',
            beforeSend: function (xhr) {
                //$('.icon'+id).addClass('ace-icon fa fa-spinner fa-spin orange bigger-125');
            },
            success: function (data) {
                $('#price').val(data.successMsg);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError);
            }
        });
    });

    $(document).on('blur','#qty', function(e){
		var qty = $(this).val();
		var price = $('#price').val();
    	$('#total_amt').val(qty*price);
    });

    $(document).on('click','#inward', function(e){
		var product = $("#product").val();
		var site = $("#site").val();
		var vendor = $("#vendor").val();
		var qty = $("#qty").val();
		if(product == ""){
			alert("Select product");
			return false;
		}
		if(site == ""){
			alert("Select site");
			return false;
		}
		if(vendor == ""){
			alert("Select vendor");
			return false;
		}
		if(qty == ""){
			alert("Select qty");
			return false;
		}

		var obj = array.filter(function(obj){
            return obj.name === "inward_submit"
        })[0];

        var uri = obj['value'];

        jobject = {
            'product' : product,
            'site' : site,
            'vendor' : vendor,
            'qty' : qty
        }
        
        $.ajax({
            url: uri,
            method: 'POST',
            crossDomain: true,
            data: jobject,
            dataType: 'json',
            beforeSend: function (xhr) {
                //$('.icon'+id).addClass('ace-icon fa fa-spinner fa-spin orange bigger-125');
            },
            success: function (data) {
                if(data.success == true){
                	alert(data.successMsg);
                	window.location.reload();
                }else{
                	alert(data.errorMsg);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError);
            }
        });
    });

	$(document).on('change','#out_product', function(e){
		var id = $(this).val();
        
        var obj = array.filter(function(obj){
            return obj.name === "product_details"
        })[0];

        var uri = obj['value'];

        jobject = {
            'id' : id
        }
        
        $.ajax({
            url: uri,
            method: 'POST',
            crossDomain: true,
            data: jobject,
            dataType: 'json',
            beforeSend: function (xhr) {
                //$('.icon'+id).addClass('ace-icon fa fa-spinner fa-spin orange bigger-125');
            },
            success: function (data) {
                $('#out_price').val(data.successMsg);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError);
            }
        });
    });

     $(document).on('click','#outward', function(e){
		var product = $("#out_product").val();
		var site = $("#out_site").val();
		var qty = $("#out_qty").val();
		if(product == ""){
			alert("Select product");
			return false;
		}
		if(site == ""){
			alert("Select site");
			return false;
		}
		if(qty == ""){
			alert("Select qty");
			return false;
		}

		var obj = array.filter(function(obj){
            return obj.name === "outward_submit"
        })[0];

        var uri = obj['value'];

        jobject = {
            'product' : product,
            'site' : site,
            'qty' : qty
        }
        
        $.ajax({
            url: uri,
            method: 'POST',
            crossDomain: true,
            data: jobject,
            dataType: 'json',
            beforeSend: function (xhr) {
                //$('.icon'+id).addClass('ace-icon fa fa-spinner fa-spin orange bigger-125');
            },
            success: function (data) {
                if(data.success == true){
                	alert(data.successMsg);
                	window.location.reload();
                }else{
                	alert(data.errorMsg);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError);
            }
        });
    });

	$(document).on('click','.inventory_filter', function() {
		var from_date = $("#from_date").val();
		var to_date = $("#to_date").val();
		var inventory_type = $("#inventory_type").val();

		
			if(from_date == ""){
				from_date=0;
			}
			if(to_date == ""){
				to_date = 0;
			}
			if(from_date !="" && to_date == "") {
				alert("select To date");
				return false;
			}
			if(to_date !="" && from_date == "") {
				alert("select from date");
				return false;
			}
		window.location.href = baseUrl+"inventory/inventoryList/"+inventory_type+"/"+from_date+"/"+to_date;
	});
</script>