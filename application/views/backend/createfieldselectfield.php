<div class="row" style="padding:1% 0">
	<div class="col-md-12">
		<div class="pull-right">
			<a href="<?php echo site_url('site/viewfieldselectfield?id=').$this->input->get('id'); ?>" class="btn btn-primary pull-right"><i class="icon-long-arrow-left"></i>&nbsp;Back</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
	    <section class="panel">
		    <header class="panel-heading">
				 fieldselectfield Details
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/createfieldselectfieldsubmit');?>" enctype= "multipart/form-data">
				<div class="form-group" style="display:none;">
				  <label class="col-sm-2 control-label" for="normal-field">id</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$this->input->get('id'));?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">name</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="name" value="<?php echo set_value('name');?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Value</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="value" value="<?php echo set_value('value');?>">
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
	</div>
</div>