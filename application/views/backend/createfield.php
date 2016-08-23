<div class="row" style="padding:1% 0">
	<div class="col-md-12">
		<div class="pull-right">
			<a href="<?php echo site_url('site/viewfield'); ?>" class="btn btn-primary pull-right"><i class="icon-long-arrow-left"></i>&nbsp;Back</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
	    <section class="panel">
		    <header class="panel-heading">
				 field Details
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/createfieldsubmit');?>" enctype= "multipart/form-data">
			  
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select table</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('table',$table,set_value('table'),'id="tableid" class="chzn-select form-control" 	data-placeholder="Choose a table..."');
					?>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">sqlName</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="sqlname" value="<?php echo set_value('sqlname');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select sqltype</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('sqltype',$sqltype,set_value('sqltype'),'id="sqltypeid" class="chzn-select form-control" 	data-placeholder="Choose a sqltype..."');
					?>
				  </div>
				</div>
				
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select isprimary</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('isprimary',$isprimary,set_value('isprimary'),'id="isprimaryid" class="chzn-select form-control" 	data-placeholder="Choose a isprimary..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select isdefault</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('isdefault',$isdefault,set_value('isdefault'),'id="isdefaultid" class="chzn-select form-control" 	data-placeholder="Choose a isdefault..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select isnull</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('isnull',$isnull,set_value('isnull'),'id="isnullid" class="chzn-select form-control" 	data-placeholder="Choose a isnull..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select autoincrement</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('autoincrement',$autoincrement,set_value('autoincrement'),'id="autoincrementid" class="chzn-select form-control" 	data-placeholder="Choose a autoincrement..."');
					?>
				  </div>
				</div>
				
<!--
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">sqltype</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="sqltype" value="<?php echo set_value('sqltype');?>">
				  </div>
				</div>
-->
				
<!--
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">isprimary</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="isprimary" value="<?php echo set_value('isprimary');?>">
				  </div>
				</div>
-->
				
<!--
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">defaultvalue</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="defaultvalue" value="<?php echo set_value('defaultvalue');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">isnull</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="isnull" value="<?php echo set_value('isnull');?>">
				  </div>
				</div>
-->
				
<!--
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">autoincrement</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="autoincrement" value="<?php echo set_value('autoincrement');?>">
				  </div>
				</div>
-->
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">title</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="title" value="<?php echo set_value('title');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select type</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('type',$type,set_value('type'),'id="typeid" class="chzn-select form-control" 	data-placeholder="Choose a type..."');
					?>
				  </div>
				</div>
				
<!--
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">type</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="type" value="<?php echo set_value('type');?>">
				  </div>
				</div>
				
-->
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">placeholder</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="placeholder" value="<?php echo set_value('placeholder');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">showinview</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="showinview" value="<?php echo set_value('showinview');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">&nbsp;</label>
				  <div class="col-sm-4">
				  <button type="submit" class="btn btn-primary">Save</button>
				  <a href="<?php echo site_url('site/viewfield'); ?>" class="btn btn-secondary">Cancel</a>
				</div>
				</div>
			  </form>
			</div>
		</section>
	</div>
</div>