<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="#">Home</a>
				</li>

				<li>
					<a href="#">Contractor</a>
				</li>
				<li class="active">Add Contractor</li>
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
					Add Contractor
				</h1>
			</div><!-- /.page-header -->

			<div class="row">
				<div class="col-xs-12">
					<div class="alert-box"></div>
					<!-- PAGE CONTENT BEGINS -->
					<form class="form-horizontal" role="form" id="<?php if(isset($contractor)): echo "contractor_update"; else: echo "contractormaster"; endif; ?>">						
						
						<input type="hidden" value="<?php if(isset($contractor)): echo $contractor[0]->contractor_id; endif; ?>" name="id">
						<input type="hidden" value="<?php if(isset($contractor)): echo $contractor[0]->contractor_ledger_id; endif; ?>" name="contractor_ledger_id">
						
						<div class="form-group">
                            <label class="col-sm-2 no-padding-right" for="form-field-2"> Contractor Name<b class="red">*</b></label>

                            <div class="col-sm-4">
                                <input type="text" id="contractor_name" name="contractor_name" value="<?php if(isset($contractor)): echo $contractor[0]->contractor_name; endif; ?>" placeholder="Enter contractor Name" onKeyUp="javascript:return check_isalphanumeric(event,this);" class="col-xs-10 col-sm-12 mandatory-field" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="contractor_name_errorlabel"></span>
								</span>
                            </div>
                            <label class="col-sm-2 no-padding-right" for=""> Mobile Number<b class="red">*</b></label>
                            <div class="col-sm-4">
                               <input type="text" id="contractor_contact_number" onKeyUp="javascript:return check_isnumeric(event,this,0);" onblur="javascript:return check_ismobile(event,this,0);" name="contractor_contact_number" placeholder=" Mobile Number" value="<?php if(isset($contractor)): echo $contractor[0]->contractor_contact_number; endif; ?>" class="col-xs-10 col-sm-12 mandatory-field" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="contractor_contact_number_errorlabel"></span>
								</span>
                            </div>
                        </div>


						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="form-field-2"> Phone Number</label>

							<div class="col-sm-4">
								<input type="text" id="contractor_phone_number" onKeyUp="javascript:return check_isnumeric(event,this,0);" name="contractor_phone_number" value="<?php if(isset($contractor)): echo $contractor[0]->contractor_contact_number; endif; ?>" placeholder=" Phone Nubmer" class="col-xs-10 col-sm-12" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="contractor_phone_numbererrorlabel"></span>
								</span>
							</div>
							<label class="col-sm-2 no-padding-right" for="form-field-2"> Contractor Email<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="text" id="contractor_email" name="contractor_email" value="<?php if(isset($contractor)): echo $contractor[0]->contractor_email; endif; ?>" placeholder="Enter contractor Email" class="col-xs-10 col-sm-12 mandatory-field" onblur="check_isemail(this,event);"/>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="contractor_email_errorlabel"></span>
								</span>
							</div>
						</div>
						 

						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="form-field-2"> Contractor Notes</label>

							<div class="col-sm-4">
								<input type="text" id="contractor_notes" name="contractor_notes" value="<?php if(isset($contractor)): echo $contractor[0]->contractor_notes; endif; ?>" placeholder="Enter contractor Notes" class="col-xs-10 col-sm-12" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="contractor_notes_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2 no-padding-right" for="form-field-2">Contractor Service Region</label>

							<div class="col-sm-4">
								<input type="text" id="contractor_service_regn" name="contractor_service_regn" value="<?php if(isset($contractor)): echo $contractor[0]->contractor_service_regn; endif; ?>" placeholder="Eneter Service Region" class="col-xs-10 col-sm-12" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="contractor_service_regn_errorlabel"></span>
								</span>
							</div>
						</div>
						 

						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="form-field-2"> Contractor PAN Number<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="text" id="contractor_pan_num" name="contractor_pan_num" onblur="check_ispan(this,event);" value="<?php if(isset($contractor)): echo $contractor[0]->contractor_pan_num; endif; ?>" placeholder="Enter contractor PAN Number" onchange="check_isalphanumeric(event,this);" class="col-xs-10 col-sm-12 mandatory-field" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="contractor_pan_num_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2 no-padding-right" for="form-field-2"> Contractor Section Code</label>

							<div class="col-sm-4">
								<input type="text" id="contractor_section_code" name="contractor_section_code" value="<?php if(isset($contractor)): echo $contractor[0]->contractor_section_code; endif; ?>" placeholder="Enter Section Code" class="col-xs-10 col-sm-12" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="contractor_section_code_errorlabel"></span>
								</span>
							</div>
						</div>


						 
						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="form-field-2"> Contractor Payee Name<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="text" id="contractor_payee_name" name="contractor_payee_name" onKeyUp="javascript:return check_isalphanumeric(event,this);"  value="<?php if(isset($contractor)): echo $contractor[0]->contractor_payee_name; endif; ?>" placeholder="Enter contractor Payee Name" class="col-xs-10 col-sm-12 mandatory-field" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="contractor_payee_name_errorlabel"></span>
								</span>
							</div>
							<label class="col-sm-2 no-padding-right" for="form-field-2"> Contractor Address<b class="red">*</b></label>
							<div class="col-sm-4">
								<textarea id="contractor_address" name="contractor_address" placeholder="Enter contractor Address" class="col-xs-10 col-sm-12 mandatory-field" ><?php if(isset($contractor)): echo $contractor[0]->contractor_address; endif; ?></textarea>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="contractor_address_errorlabel"></span>
								</span>
							</div>
						</div>


						 


						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="form-field-2"> VAT</label>

							<div class="col-sm-4">
								<input type="text" id="contractor_vat" name="contractor_vat" value="<?php if(isset($contractor)): echo $contractor[0]->contractor_vat; endif; ?>" placeholder="Enter contractor VAT Number" class="col-xs-10 col-sm-12  " />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="contractor_vat_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2 no-padding-right" for="form-field-2"> CST</label>

							<div class="col-sm-4">
								<input type="text" id="contractor_cst" name="contractor_cst" value="<?php if(isset($contractor)): echo $contractor[0]->contractor_cst; endif; ?>" placeholder="Enter  CST " class="col-xs-10 col-sm-12   " />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="contractor_cst_errorlabel"></span>
								</span>
							</div>
						</div>
						
						 
						
						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="form-field-2"> GST</label>

							<div class="col-sm-4">
								<input type="text" id="contractor_gst" name="contractor_gst" value="<?php if(isset($contractor)): echo $contractor[0]->contractor_gst; endif; ?>" placeholder="Enter GST" class="col-xs-10 col-sm-12  " />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="contractor_gst_errorlabel"></span>
								</span>
							</div>
<!-- 							<label class="col-sm-2 no-padding-right" for="form-field-2">Site Name</label>
						
                            <div class="col-sm-4">
                              <select  name="site_id" id="site_id" class="chosen-select form-control">
                                    
									<?php
										foreach ($sitelist as $val) {
											if(isset($contractor) && $val->site_id == $contractor[0]->site_id){
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
                            </div> -->
							 
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