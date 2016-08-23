<div class="row" style="padding:1% 0">
	<div class="col-md-12">
		<div class="pull-right">
			<a href="<?php echo site_url('site/viewpage'); ?>" class="btn btn-primary pull-right"><i class="icon-long-arrow-left"></i>&nbsp;Back</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
	    <section class="panel">
		    <header class="panel-heading">
				 page Details
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/createpagesubmit');?>" enctype= "multipart/form-data">
			  
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select table</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('table',$table,set_value('table'),'id="tableid" class="chzn-select form-control" 	data-placeholder="Choose a table..."');
					?>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">navigationname</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="navigationname" value="<?php echo set_value('navigationname');?>">
				  </div>
				</div>
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">navigationtype</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="navigationtype" value="<?php echo set_value('navigationtype');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">navigationparent</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="navigationparent" value="<?php echo set_value('navigationparent');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select crudtype</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('crudtype',$crudtype,set_value('crudtype'),'id="crudtypeid" class="chzn-select form-control" 	data-placeholder="Choose a crudtype..."');
					?>
				  </div>
				</div>
				
<!--
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">accesslevel</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="accesslevel" value="<?php echo set_value('accesslevel');?>">
				  </div>
				</div>
-->
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">&nbsp;</label>
				  <div class="col-sm-4">
				  <button type="submit" class="btn btn-primary">Save</button>
				  <a href="<?php echo site_url('site/viewpage'); ?>" class="btn btn-secondary">Cancel</a>
				</div>
				</div>
			  </form>
			</div>
		</section>
	</div>
</div>