<div class="row">
	<div class="col-lg-12">
	    <section class="panel">
		    <header class="panel-heading">
				 Menu Details
			</header>
			<div class="panel-body">
			    <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('menu/editmenusubmit');?>">
				    <input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before['menu']->id);?>" style="display:none;">
					<div class="form-group">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-4">
						  <input type="text" id="normal-field" class="form-control" name="name" value="<?php echo set_value('name',$before['menu']->name);?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Icon</label>
						<div class="col-sm-4">
						  <input type="text" id="normal-field" class="form-control" name="icon" value="<?php echo set_value('icon',$before['menu']->icon);?>" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-4">
						  <input type="text" id="normal-field" class="form-control" name="description" value="<?php echo set_value('description',$before['menu']->description);?>" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Keyword</label>
						<div class="col-sm-4">
						  <input type="text" id="" name="keyword" class="form-control" value="<?php echo set_value('keyword',$before['menu']->keyword); ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Url</label>
						<div class="col-sm-4">
						  <input type="text" id="normal-field" class="form-control" name="url" value="<?php echo set_value('url',$before['menu']->url); ?>">
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-2 control-label">Link Type</label>
						<div class="col-sm-4">
						  <?php
							$linktype= array(
							"1" => "Site Url",
							"2" => "Base URL",
							"3" => "External URL"
							);
							echo form_dropdown('linktype',$linktype,set_value('linktype',$before['menu']->linktype),'class="chzn-select form-control"'); 
						  ?>
						</div>
					</div>
					<div class=" form-group">
					  <label class="col-sm-2 control-label">Parent Menu</label>
					  <div class="col-sm-4">
						<?php 	 echo form_dropdown('parentmenu',$parentmenu,set_value('parentmenu',$before['menu']->parent),'class="chzn-select form-control" 	');
						?>
					  </div>
					</div>
					<div class=" form-group">
					  <label class="col-sm-2 control-label">Menu Access</label>
					  <div class="col-sm-4">
						<?php   echo form_multiselect('menuaccess[]',$accesslevel,set_value('menuaccess',$before['menuaccess']),'id="select2" class="chzn-select myselect2 form-control populate placeholder select2-offscreen" ');	 ?>
					  </div>
					</div>
					<div class=" form-group">
					  <label class="col-sm-2 control-label">Is active</label>
					  <div class="col-sm-4">
						<?php 	
						$isactive = array(
						"1" => "Yes",
						"2" => "No",
						);
						echo form_dropdown('isactive',$isactive,set_value('isactive',$before['menu']->isactive),'class="chzn-select form-control" 	');
						?>
					  </div>
					</div>
					<div class=" form-group">
					  <label class="col-sm-2 control-label">Order</label>
					  <div class="col-sm-4">
						<input type="number" name="order" class="form-control" value="<?php echo set_value('order',$before['menu']->order); ?>">
					  </div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">&nbsp;</label>
						<div class="col-sm-4">	
							<button type="submit" class="btn btn-info">Submit</button>
						</div>
					</div>
				</form>
			</div>
		</section>
    </div>
</div>