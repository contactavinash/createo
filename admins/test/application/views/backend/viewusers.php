<div id="page-title">
       <a class="btn btn-primary btn-labeled fa fa-plus margined pull-right" href="<?php echo site_url('site/createuser'); ?>">Create</a>

    <h1 class="page-header text-overflow">User Details</h1>
</div>

<div id="page-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel drawchintantable">

                <?php $this->chintantable->createsearch("User List");?>


                <div class="fixed-table-container">
                    <div class="fixed-table-body">
                        <table class="table table-hover" id="" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr>
                                    <th data-field="id">Id</th>
                                    <th data-field="name">Name</th>
                                    <!--                        <th data-field="username">Username</th>-->
                                    <th data-field="email">Email</th>
                                    <th data-field="socialid">Socialid</th>
                                    <th data-field="logintype">logintype</th>
                                    <th data-field="json">json</th>
                                    <th data-field="accesslevelname">accesslevel</th>
                                    <th data-field="status">status</th>
                                    <th data-field="action">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <div class="fixed-table-pagination" style="display: block;">
                        <div class="pull-left pagination-detail">
                                    <?php $this->chintantable->createpagination();?>
                        </div>

                    </div>
                </div>
            </div>



        </div>
    </div>

    <script>
        function drawtable(resultrow) {
            if (!resultrow.username) {
                resultrow.username = "";
            }
            if (!resultrow.logintype) {
                resultrow.logintype = "";
            }
            if (!resultrow.json) {
                resultrow.json = "";
            }
            return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.name + "</td><td>" + resultrow.email + "</td><td>" + resultrow.socialid + "</td><td>" + resultrow.logintype + "</td><td>" + resultrow.json + "</td><td>" + resultrow.accesslevelname + "</td><td>" + resultrow.status + "</td><td><a class='btn btn-primary btn-xs' href='<?php echo site_url('site/edituser?id=');?>" + resultrow.id + "'><i class='icon-pencil'></i></a><a class='btn btn-danger btn-xs' href='<?php echo site_url('site/deleteuser?id='); ?>" + resultrow.id + "'><i class='icon-trash '></i></a></td><tr>";
        }
        generatejquery('<?php echo $base_url;?>');
    </script>
</div>
<!--Extra Div closed dont delete-->
</div>