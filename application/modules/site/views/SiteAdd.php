<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="#">Home</a>
				</li>

				<li>
					<a href="#">Site</a>
				</li>
				<li class="active">Add Site</li>
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
					Add Site
				</h1>
			</div><!-- /.page-header -->

			<div class="row">
				<div class="col-xs-12">
					<div class="alert-box"></div>
					<!-- PAGE CONTENT BEGINS -->
					<form class="form-horizontal" role="form" id="<?php if(isset($site)): echo "site_update"; else: echo "siteadd"; endif; ?>">												
						<div class="form-group">
 							<label class="col-sm-2 no-padding-right" for="form-field-2"> Enter Site Name *</label>

							<div class="col-sm-4">
								<input type="text" id="site_name" name="site_name" placeholder="Enter Site Name"  class="col-xs-10 col-sm-12"  mandatory-field" value="<?php if(isset($site)): echo $site[0]->site_name; endif; ?>" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="site_name_errorlabel"></span>
								</span>
							</div>
                            <label class="col-sm-2 no-padding-right" for="form-field-2">Enter Site Address*</label>
							<div class="col-sm-4">
									<textarea id="address" name="address" placeholder="Enter Site Address" class="col-xs-10 col-sm-10 mandatory-field" ><?php if(isset($site)): echo $site[0]->address; endif; ?></textarea>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="address_errorlabel"></span>
								</span>
							</div>
                        </div>
						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="form-field-2"> Select Start Date<b class="red">*</b></label>
							<div class="col-sm-4">
								<input type="text" id="start_date" data-date-format="dd-mm-yyyy" name="start_date" placeholder="Enter Start Date" class="date-picker col-xs-10 col-sm-10 mandatory-field" 
								value="<?php if(isset($site)): echo $site[0]->start_date; endif; ?>" />
								<span style="width:10px;height:35px;" class="input-group-addon">
									<i class="fa fa-calendar bigger-110"></i>
								</span>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="start_date_errorlabel"></span>
								</span>
							</div>
							<label class="col-sm-2 no-padding-right" for="form-field-2"> Select Site End Date</label>
							<div class="col-sm-4">
								<input type="text" id="end_date" name="end_date" placeholder="Enter End Date" class="date-picker col-xs-10 col-sm-9" 
								value="<?php if(isset($site)): echo $site[0]->end_date; endif; ?>"/>
								<span style="width:10px;height:35px;" class="input-group-addon">
									<i class="fa fa-calendar bigger-110"></i>
								</span>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="end_date_errorlabel"></span>
								</span>
							</div>
						</div>
						<input type="hidden" value="<?php if(isset($site)): echo $site[0]->site_id; endif; ?>" name="site_id">

						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="form-field-2"> Enter Total Amount*</label>

							<div class="col-sm-4">
								<input type="text" id="total_amount" name="total_amount" placeholder="Enter Total Amount" class="col-xs-10 col-sm-12 mandatory-field" value="<?php if(isset($site)): echo $site[0]->total_amount; endif; ?>" onKeyUp="javascript:return check_isnumeric(event,this,0);"/>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="total_amount_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2 no-padding-right" for="form-field-2">Enter Spend Amount</label>

							<div class="col-sm-4">
								<input type="text" id="spend_amount" name="spend_amount" placeholder="Enter Spend Amount" class="col-xs-10 col-sm-10" value="<?php if(isset($site)): echo $site[0]->spend_amount; endif; ?>" onKeyUp="javascript:return check_isnumeric(event,this,0);"/>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="spend_amount_errorlabel"></span>
								</span>
							</div>
						</div>
						 

						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="form-field-2"> Enter Comment(if any) </label>

							<div class="col-sm-4">
								<input type="text" id="comment" name="comment" placeholder="Enter Comment If Any" class="col-xs-10 col-sm-12" value="<?php if(isset($site)): echo $site[0]->comment; endif; ?>" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="comment_errorlabel"></span>
								</span>
							</div>
						</div>				 
						
					 

						
						<div class="clearfix form-actions">
							<div class="col-md-offset-3 col-md-9">
								<button class="btn btn-info test" type="submit">
									<i class="iconcategory"></i>
									Submit
								</button>

								&nbsp; &nbsp; &nbsp;
								<button class="btn" type="reset">
									<i class="ace-icon fa fa-undo bigger-110"></i>
									Reset
								</button>
							</div>
						</div>
					</form>
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

<script src="<?php echo base_url(); ?>js/custom.js"></script>
<script src="<?php echo base_url(); ?>js/form-validation.js"></script>

<!-- inline scripts related to this page -->
<script type="text/javascript">
	jQuery(function($) {
		 
			$('.chosen-select').chosen({allow_single_deselect:true}); 
			//resize the chosen on window resize
	 
		//link
		$('.date-picker').datepicker({
			autoclose: true,
			todayHighlight: true
		})
		 
	
	});
</script>