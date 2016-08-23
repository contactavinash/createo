	    <section class="panel">
		    <header class="panel-heading">
				 pageaccesslevel Details
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/editpageaccesslevelsubmit');?>" enctype= "multipart/form-data">
<!--				<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">-->
				<div class="form-group" style="display:none;">
				  <label class="col-sm-2 control-label" for="normal-field">pageid</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$this->input->get('id'));?>">
				  </div>
				</div>
				
				<div class="form-group" style="display:none;">
				  <label class="col-sm-2 control-label" for="normal-field">project Accesslevel id</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="pageaccesslevelid" value="<?php echo set_value('pageaccesslevelid',$this->input->get('pageaccesslevelid'));?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">accesslevel</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="accesslevel" value="<?php echo set_value('accesslevel',$before->accesslevel);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">&nbsp;</label>
				  <div class="col-sm-4">
				  <button type="submit" class="btn btn-primary">Save</button>
				  <a href="<?php echo site_url('site/viewpageaccesslevel'); ?>" class="btn btn-secondary">Cancel</a>
				</div>
				</div>
			  </form>
			</div>
		</section>