<div class="row" style="padding:1% 0">
	<div class="col-md-12">
		<div class="pull-right">
			<a href="<?php echo site_url('site/viewproject'); ?>" class="btn btn-primary pull-right"><i class="icon-long-arrow-left"></i>&nbsp;Back</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
	    <section class="panel">
		    <header class="panel-heading">
				 project Details
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/createprojectsubmit');?>" enctype= "multipart/form-data">
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Name</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="name" value="<?php echo set_value('name');?>">
				  </div>
				</div>
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Email</label>
				  <div class="col-sm-4">
					<input type="email" id="normal-field" class="form-control" name="email" value="<?php echo set_value('email');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">databasename</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="databasename" value="<?php echo set_value('databasename');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">databasepassword</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="databasepassword" value="<?php echo set_value('databasepassword');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">hostname</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="hostname" value="<?php echo set_value('hostname');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">userpassword</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="userpassword" value="<?php echo set_value('userpassword');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">mandrillid</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="mandrillid" value="<?php echo set_value('mandrillid');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">mandrillpassword</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="mandrillpassword" value="<?php echo set_value('mandrillpassword');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">&nbsp;</label>
				  <div class="col-sm-4">
				  <button type="submit" class="btn btn-primary">Save</button>
				  <a href="<?php echo site_url('site/viewproject'); ?>" class="btn btn-secondary">Cancel</a>
				</div>
				</div>
			  </form>
			</div>
		</section>
	</div>
</div>