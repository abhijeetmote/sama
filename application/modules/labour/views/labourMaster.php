<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="#">Home</a>
				</li>

				<li>
					<a href="#">Labour</a>
				</li>
				<li class="active">Add Labour</li>
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
					Add Labour
				</h1>
			</div><!-- /.page-header -->

			<div class="row">
				<div class="col-xs-12">
					<div class="alert-box"></div>
					<!-- PAGE CONTENT BEGINS -->
					<form class="form-horizontal" role="form" id="<?php if(isset($labour)): echo "labour_update"; else: echo "labourmaster"; endif; ?>">						
						<div class="form-group">
							<label class="col-sm-2  no-padding-right" for="">Labour First Name<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="text" id="labour_fname" name="labour_fname" value="<?php if(isset($labour)): echo $labour[0]->labour_fname; endif; ?>" placeholder="Enter Labour First Name" class="col-xs-10 col-sm-12 mandatory-field" onKeyUp="javascript:return check_isalphanumeric(event,this);"/>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="labour_fname_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2 no-padding-right" for="">Labour Middle Name</label>

							<div class="col-sm-4">
								<input type="text" id="labour_mname" name="labour_mname" value="<?php if(isset($labour)): echo $labour[0]->labour_mname; endif; ?>" placeholder="Enter Labour Middle Name" class="col-xs-10 col-sm-12" onKeyUp="javascript:return check_isalphanumeric(event,this);"/>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="labour_mname_errorlabel"></span>
								</span>
							</div>
						</div>

						 

						<div class="form-group">
							<label class="col-sm-2  no-padding-right" for="">Labour Last Name<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="text" id="labour_lname" name="labour_lname" placeholder="Enter Labour Last Name" value="<?php if(isset($labour)): echo $labour[0]->labour_lname; endif; ?>" class="col-xs-10 col-sm-12 mandatory-field" onKeyUp="javascript:return check_isalphanumeric(event,this);"/>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="labour_lname_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2  no-padding-right" for="">Labour DOB</label>

							<div class="col-sm-4">
								<input type="text" data-date-format="dd-mm-yyyy" id="labour_dob" name="labour_dob" value="<?php if(isset($labour)): echo $newDateTime = date('d/m/Y', strtotime($labour[0]->labour_bdate)); endif; ?>" class="date-picker col-xs-10 col-sm-12"/>
								<span style="width:10px;height:35px;" class="input-group-addon">
									<i class="fa fa-calendar bigger-110"></i>
								</span>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="labour_dob_errorlabel"></span>
								</span>
							</div>
						</div>


 
						
						<input type="hidden" value="<?php if(isset($labour)): echo $labour[0]->labour_id; endif; ?>" name="id">
						<input type="hidden" value="<?php if(isset($labour)): echo $labour[0]->ledger_id; endif; ?>" name="ledger_id">	

						<div class="form-group">
							<label class="col-sm-2  no-padding-right" for="">Labour Address<b class="red">*</b></label>

							<div class="col-sm-4">
								<textarea id="labour_address" name="labour_address" value="<?php if(isset($labour)): echo $labour[0]->labour_add; endif; ?>" placeholder="Enter Labour Address" class="col-xs-10 col-sm-12 mandatory-field" ><?php if(isset($labour)): echo trim($labour[0]->labour_add); endif; ?></textarea>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="labour_address_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2  no-padding-right" for="">Labour Mobile1<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="text" id="labour_mobile" name="labour_mobile" onblur="javascript:return check_ismobile(event,this,0);" value="<?php if(isset($labour)): echo $labour[0]->labour_mobno; endif; ?>" placeholder="Enter Labour Mobile No" class="col-xs-10 col-sm-12 mandatory-field"  onKeyUp="javascript:return check_isnumeric(event,this,0);" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="labour_mobile_errorlabel"></span>
								</span>
							</div>
						</div>


					 


						<div class="form-group">
							<label class="col-sm-2  no-padding-right" for="">Labour Mobile2</label>

							<div class="col-sm-4">
								<input type="text" id="labour_mobile1" name="labour_mobile1" onblur="javascript:return check_ismobile(event,this,0);" value="<?php if(isset($labour)): echo $labour[0]->labour_mobno1; endif; ?>" placeholder="Enter Labour Mobile No" class="col-xs-10 col-sm-12" onKeyUp="javascript:return check_isnumeric(event,this,0);"/>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="labour_mobile1_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2 no-padding-right" for="form-field-2">Site Name</label>
						
                            <div class="col-sm-4">
                              <select  name="site_id" id="site_id" class="chosen-select form-control">
                                    
									<?php
										foreach ($sitelist as $val) {
											if(isset($labour) && $val->site_id == $labour[0]->site_id){
												echo '<option selected value="'.$val->site_id.'">'.$val->site_name.'</option>';
											}else{
												echo '<option value="'.$val->site_id.'">'.$val->site_name.'</option>';
											}
										}
									?>
                                    
                                </select>
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle input-text-error" id="site_id_errorlabel"></span>
                                </span>
                            </div>
						</div>

						<div class="form-group">

							<label class="col-sm-2 no-padding-right" for="form-field-2">Salary status</label>
						
                            <div class="col-sm-4">
                              	<select name="salary_status" class="chosen-select form-control">
                                	<option value="0" <?php if(isset($labour) && $labour[0]->salary_status == 0){ echo "selected"; } ?> >Daily</option>	
                                	<option value="1" <?php if(isset($labour) && $labour[0]->salary_status == 1){ echo "selected"; } ?> >Monthly</option>	
                                </select>
                            </div>

                            <label class="col-sm-2 no-padding-right" for="">Wages</label>

							<div class="col-sm-4">
								<input type="text" id="labour_wages" name="labour_wages" value="<?php if(isset($labour)): echo $labour[0]->labour_wages; endif; ?>" placeholder="Enter Labour Wages" class="col-xs-10 col-sm-12 mandatory-field" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="labour_wages_errorlabel"></span>
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
		$('#id-disable-check').on('click', function() {
			var inp = $('#form-input-readonly').get(0);
			if(inp.hasAttribute('disabled')) {
				inp.setAttribute('readonly' , 'true');
				inp.removeAttribute('disabled');
				inp.value="This text field is readonly!";
			}
			else {
				inp.setAttribute('disabled' , 'disabled');
				inp.removeAttribute('readonly');
				inp.value="This text field is disabled!";
			}
		});
	
	
		 
			$('.chosen-select').chosen({allow_single_deselect:true}); 
			//resize the chosen on window resize
	 
		$('.date-picker').datepicker({
			autoclose: true,
			todayHighlight: true
		})
		//show datepicker when clicking on the icon
		.next().on(ace.click_event, function(){
			$(this).prev().focus();
		});
	
		 
	
	});
</script>