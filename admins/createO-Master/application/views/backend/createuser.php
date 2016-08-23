<div id="page-title">
    <a href="<?php echo site_url('site/viewusers'); ?>" class="btn btn-primary btn-labeled fa fa-arrow-left margined pull-right">Back</a>

    <h1 class="page-header text-overflow">User Details</h1>
</div>

<div id="page-content">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
               <div class="panel-heading">
							<h3 class="panel-title">Create User</h3>
						</div>
                <div class="panel-body">
                    <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/createusersubmit');?>" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="normal-field">Name</label>
                            <div class="col-sm-4">
                                <input type="text" id="normal-field" class="form-control" name="name" value="<?php echo set_value('name');?>">
                            </div>
                        </div>
                        <!--
                    <div class=" form-group">
                      <label class="col-sm-2 control-label" for="normal-field">Username</label>
                      <div class="col-sm-4">
                        <input type="text" id="normal-field" class="form-control" name="username" value="<?php echo set_value('username');?>">
                      </div>
                    </div>
    -->

                        <div class=" form-group">
                            <label class="col-sm-2 control-label" for="normal-field">Email</label>
                            <div class="col-sm-4">
                                <input type="email" id="normal-field" class="form-control" name="email" value="<?php echo set_value('email');?>">
                            </div>
                        </div>
                        <div class=" form-group">
                            <label class="col-sm-2 control-label" for="description-field">Password</label>
                            <div class="col-sm-4">
                                <input type="password" id="description-field" class="form-control" name="password" value="">
                            </div>
                        </div>
                        <div class=" form-group">
                            <label class="col-sm-2 control-label" for="description-field">Confirm Password</label>
                            <div class="col-sm-4">
                                <input type="password" id="description-field" class="form-control" name="confirmpassword" value="">
                            </div>
                        </div>
                        <div class=" form-group">
                            <label class="col-sm-2 control-label" for="normal-field">SocialId</label>
                            <div class="col-sm-4">
                                <input type="text" id="normal-field" class="form-control" name="socialid" value="<?php echo set_value('socialid');?>">
                            </div>
                        </div>

                        <div class=" form-group">
                            <label class="col-sm-2 control-label">logintype</label>
                            <div class="col-sm-4">
                                <?php echo form_dropdown( 'logintype',$logintype,set_value( 'logintype'), 'class="chzn-select form-control" 	data-placeholder="Choose a Logintype..."'); ?>
                            </div>
                        </div>

                        <div class=" form-group">
                            <label class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-4">
                                <?php echo form_dropdown( 'status',$status,set_value( 'status'), 'class="chzn-select form-control" 	data-placeholder="Choose a Accesslevel..."'); ?>
                            </div>
                        </div>

                        <div class=" form-group">
                            <label class="col-sm-2 control-label" for="normal-field">Image</label>
                            <div class="col-sm-4">
                                
                                <span class="pull-left btn btn-default btn-file">
											Browse... <input type="file" id="normal-field" class="form-control" name="image" value="<?php echo set_value('image');?>">
											</span>
                            </div>
                        </div>

                        <div class=" form-group">
                            <label class="col-sm-2 control-label">Select Accesslevel</label>
                            <div class="col-sm-4">
                                <?php echo form_dropdown( 'accesslevel',$accesslevel,set_value( 'accesslevel'), 'id="accesslevelid" onchange="operatorcategories()" class="chzn-select form-control" 	data-placeholder="Choose a Accesslevel..."'); ?>
                            </div>
                        </div>

                        <!--
                    <div class=" form-group categoryclass" style="display:none;">
                      <label class="col-sm-2 control-label">Category</label>
                      <div class="col-sm-4">
                        <?php
                            
                            echo form_dropdown('category[]',$category,set_value('category'),'id="select10" class="chzn-select form-control" 	data-placeholder="Choose a category..." multiple');
                        ?>
                      </div>
                    </div>
    -->

                        <div class=" form-group">
                            <label class="col-sm-2 control-label" for="normal-field">json</label>
                            <div class="col-sm-4">
                                <input type="text" id="normal-field" class="form-control" name="json" value="<?php echo set_value('json');?>">
                            </div>
                        </div>
                        <div class=" form-group">
                            <label class="col-sm-2 control-label">&nbsp;</label>
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="<?php echo site_url('site/viewusers'); ?>" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>
<script type="text/javascript">
    function operatorcategories() {
        console.log($('#accesslevelid').val());
        if ($('#accesslevelid').val() == 2) {
            $(".categoryclass").show();
        } else {
            $(".categoryclass").hide();
        }

    }
</script>