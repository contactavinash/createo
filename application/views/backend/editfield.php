	    <section class="panel">
		    <header class="panel-heading">
				 Field Details
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/editfieldsubmit');?>" enctype= "multipart/form-data">
				<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select table</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('table',$table,set_value('table',$before->table),'id="tableid" class="chzn-select form-control" 	data-placeholder="Choose a table..."');
					?>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">sqlName</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="sqlname" value="<?php echo set_value('sqlname',$before->sqlname);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select sqltype</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('sqltype',$sqltype,set_value('sqltype',$before->sqltype),'id="sqltypeid" class="chzn-select form-control" 	data-placeholder="Choose a sqltype..."');
					?>
				  </div>
				</div>
				
<!--
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">sqltype</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="sqltype" value="<?php echo set_value('sqltype',$before->sqltype);?>">
				  </div>
				</div>
-->
				
<!--
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">isprimary</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="isprimary" value="<?php echo set_value('isprimary',$before->isprimary);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">defaultvalue</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="defaultvalue" value="<?php echo set_value('defaultvalue',$before->defaultvalue);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">isnull</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="isnull" value="<?php echo set_value('isnull',$before->isnull);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">autoincrement</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="autoincrement" value="<?php echo set_value('autoincrement',$before->autoincrement);?>">
				  </div>
				</div>
-->
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select isprimary</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('isprimary',$isprimary,set_value('isprimary',$before->isprimary),'id="isprimaryid" class="chzn-select form-control" 	data-placeholder="Choose a isprimary..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select isdefault</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('isdefault',$isdefault,set_value('isdefault',$before->defaultvalue),'id="isdefaultid" class="chzn-select form-control" 	data-placeholder="Choose a isdefault..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select isnull</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('isnull',$isnull,set_value('isnull',$before->isnull),'id="isnullid" class="chzn-select form-control" 	data-placeholder="Choose a isnull..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select autoincrement</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('autoincrement',$autoincrement,set_value('autoincrement',$before->autoincrement),'id="autoincrementid" class="chzn-select form-control" 	data-placeholder="Choose a autoincrement..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">title</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="title" value="<?php echo set_value('title',$before->title);?>">
				  </div>
				</div>
				
<!--
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">type</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="type" value="<?php echo set_value('type',$before->type);?>">
				  </div>
				</div>
-->
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select type</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('type',$type,set_value('type',$before->type),'id="typeid" class="chzn-select form-control" 	data-placeholder="Choose a type..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">placeholder</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="placeholder" value="<?php echo set_value('placeholder',$before->placeholder);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">showinview</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="showinview" value="<?php echo set_value('showinview',$before->showinview);?>">
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