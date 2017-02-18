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
				<li class="active">Contractor Task</li>
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
					Add New Contract
				</h1>
			</div><!-- /.page-header -->

			<div class="row">
				<div class="col-xs-12">
					<div class="alert-box"></div>
					<!-- PAGE CONTENT BEGINS -->
					<form class="form-horizontal" role="form" id="<?php if(isset($contract)): echo "contract_update"; else: echo "contractmaster"; endif; ?>">						
						
						<input type="hidden" value="<?php if(isset($contract)): echo $contract[0]->contract_id; endif; ?>" name="id">
						
						
						<div class="form-group">
                            <label class="col-sm-2 no-padding-right" for="form-field-2"> Contractor Name<b class="red">*</b></label>

                            <div class="col-sm-4">
                              <select  name="contractor_id" id="contractor_id" class="chosen-select form-control">
                                    
									<?php
										foreach ($contractorlist as $val) { echo $val->contractor_id;
											if(isset($contract) && $val->contractor_id == $contract[0]->contractor_id){
												echo '<option selected value="'.$val->contractor_id.'">'.$val->contractor_name.'</option>';
											}else{
												echo '<option value="'.$val->contractor_id.'">'.$val->contractor_name.'</option>';
											}
										}
									?>
                                    
                                </select>
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle input-text-error" id="contractor_id_errorlabel"></span>
                                </span>
                            </div>
							<label class="col-sm-2 no-padding-right" for="form-field-2">Site Name</label>
						
                            <div class="col-sm-4">
                              <select  name="site_id" id="site_id" class="chosen-select form-control">
                                    
									<?php
										foreach ($sitelist as $val) {
											if(isset($contractor) && $val->site_id == $contract[0]->site_id){
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
							<label class="col-sm-2 no-padding-right" for="form-field-2"> Contract Amount </label>

							<div class="col-sm-4">
								<input type="text" id="contract_amount" onKeyUp="javascript:return check_isnumeric(event,this,0);" name="contract_amount" value="<?php if(isset($contract)): echo $contract[0]->contract_amt; endif; ?>" placeholder="Contract Amount" class="col-xs-10 col-sm-12 mandatory-field" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="contract_amount_errorlabel"></span>
								</span>
							</div>
							<label class="col-sm-2  no-padding-right" for="">Start Date</label>

							<div class="col-sm-4">
								<input type="text" data-date-format="dd-mm-yyyy" id="start_date" name="start_date" placeholder="Enter Start Date"value="<?php if(isset($contract)): echo $newDateTime = date('d/m/Y', strtotime($contract[0]->start_date)); endif; ?>" class="date-picker col-xs-10 col-sm-12 mandatory-field"/>
								<span style="width:10px;height:35px;" class="input-group-addon">
									<i class="fa fa-calendar bigger-110"></i>
								</span>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="start_date_errorlabel"></span>
								</span>
							</div>
						</div>
						 

						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="form-field-2"> End Date</label>

							<div class="col-sm-4">
								<input type="text" data-date-format="dd-mm-yyyy" id="end_date" name="end_date" value="<?php if(isset($contract)): echo $newDateTime = date('d/m/Y', strtotime($contract[0]->end_date)); endif; ?>" class="date-picker col-xs-10 col-sm-12"/>
								<span style="width:10px;height:35px;" class="input-group-addon">
									<i class="fa fa-calendar bigger-110"></i>
								</span>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="end_date_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2 no-padding-right" for="form-field-2">Other Remark</label>

							<div class="col-sm-4">
								<textarea id="other_remark" name="other_remark" placeholder="Enter Remark IfAny" class="col-xs-10 col-sm-12 mandatory-field" ><?php if(isset($contract)): echo $contract[0]->remark; endif; ?></textarea>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="other_remark_errorlabel"></span>
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