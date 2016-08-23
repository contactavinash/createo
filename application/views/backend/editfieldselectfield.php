	    <section class="panel">
		    <header class="panel-heading">
				 fieldselectfield Details
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/editfieldselectfieldsubmit');?>" enctype= "multipart/form-data">
<!--				<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">-->
				<div class="form-group" style="display:none;">
				  <label class="col-sm-2 control-label" for="normal-field">Fieldid</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$this->input->get('id'));?>">
				  </div>
				</div>
				
				<div class="form-group" style="display:none;">
				  <label class="col-sm-2 control-label" for="normal-field">project Accesslevel id</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="fieldselectfieldid" value="<?php echo set_value('fieldselectfieldid',$this->input->get('fieldselectfieldid'));?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">name</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="name" value="<?php echo set_value('name',$before->name);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">value</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="value" value="<?php echo set_value('value',$before->value);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">&nbsp;</label>
				  <div class="col-sm-4">
				  <button type="submit" class="btn btn-primary">Save</button>
				  <a href="<?php echo site_url('site/viewfieldselectfield'); ?>" class="btn btn-secondary">Cancel</a>
				</div>
				</div>
			  </form>
			</div>
		</section>