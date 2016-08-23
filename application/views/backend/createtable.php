<div class="row" style="padding:1% 0">
	<div class="col-md-12">
		<div class="pull-right">
			<a href="<?php echo site_url('site/viewtable'); ?>" class="btn btn-primary pull-right"><i class="icon-long-arrow-left"></i>&nbsp;Back</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
	    <section class="panel">
		    <header class="panel-heading">
				 Table Details
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/createtablesubmit');?>" enctype= "multipart/form-data">
			  
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select Project</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('project',$project,set_value('project'),'id="projectid" class="chzn-select form-control" 	data-placeholder="Choose a project..."');
					?>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Table Name</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="tablename" value="<?php echo set_value('tablename');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">&nbsp;</label>
				  <div class="col-sm-4">
				  <button type="submit" class="btn btn-primary">Save</button>
				  <a href="<?php echo site_url('site/viewtable'); ?>" class="btn btn-secondary">Cancel</a>
				</div>
				</div>
			  </form>
			</div>
		</section>
	</div>
</div>