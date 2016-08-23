	    <section class="panel">
		    <header class="panel-heading">
				 Project Details
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/editprojectsubmit');?>" enctype= "multipart/form-data">
				<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Name</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="name" value="<?php echo set_value('name',$before->name);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Email</label>
				  <div class="col-sm-4">
					<input type="email" id="normal-field" class="form-control" name="email" value="<?php echo set_value('email',$before->email);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">databasename</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="databasename" value="<?php echo set_value('databasename',$before->databasename);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">databasepassword</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="databasepassword" value="<?php echo set_value('databasepassword',$before->databasepassword);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">hostname</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="hostname" value="<?php echo set_value('hostname',$before->hostname);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">userpassword</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="userpassword" value="<?php echo set_value('userpassword',$before->userpassword);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">mandrillid</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="mandrillid" value="<?php echo set_value('mandrillid',$before->mandrillid);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">mandrillpassword</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="mandrillpassword" value="<?php echo set_value('mandrillpassword',$before->mandrillpassword);?>">
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