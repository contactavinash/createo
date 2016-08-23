
			<!--MAIN NAVIGATION-->
			<!--===================================================-->
			<nav id="mainnav-container">
				<div id="mainnav">

					<div id="mainnav-menu-wrap">
						<div class="nano">
							<div class="nano-content">
								<ul id="mainnav-menu" class="list-group">
						
									<!--Category name-->
									<!--<li class="list-header">Navigation</li>
						
									<!--Menu list item-->
									<li class="active-link">
										<a href="<?php echo site_url("site/index");?>">
											<img src="<?php echo base_url('assets/img/icons/dash_icon.png'); ?>"/>
											<span class="menu-title">
												<strong>Dashboard</strong>
												<!--<span class="label label-success pull-right">Top</span>-->
											</span>
										</a>
									</li>
						
									<!--Menu list item-->
									<li>
										<a href="<?php echo site_url("site/viewusers");?>">
<!--										<a href="tables-footable.html">-->
											<img src="<?php echo base_url('assets/img/icons/calaendar_icon.png'); ?>"/>
											<span class="menu-title">
												<strong>My Campaigns</strong>
											</span>
											<!--<i class="arrow"></i>-->
										</a>
                                        <li>
										<a href="#">
											<img src="<?php echo base_url('assets/img/icons/list_icon.png'); ?>"/>
											<span class="menu-title">
												<strong>My Lists</strong>
											</span>
											<!--<i class="arrow"></i>-->
										</a>
                                        <li>
										<a href="<?php echo site_url("site/viewcalender");?>">
											<img src="<?php echo base_url('assets/img/icons/star_icon.png'); ?>"/>
											<span class="menu-title">
												<strong>Campaign Calendar</strong>
											</span>
											<!--<i class="arrow"></i>-->
										</a>
                                        <li>
										<a href="#">
											<img src="<?php echo base_url('assets/img/icons/reports_icn.png'); ?>"/>
											<span class="menu-title">
												<strong>Reports & Analytic</strong>
											</span>
											<!--<i class="arrow"></i>-->
										</a>
						<a href="#">
											<img src="<?php echo base_url('assets/img/icons/integr_icon.png'); ?>"/>
											<span class="menu-title">
												<strong>Intergrations</strong>
											</span>
											<!--<i class="arrow"></i>-->
										</a>

											<li class="pad-ver" style="background-color: rgb(236, 236, 236);"><!--<a href="#" class="btn btn-success btn-bock" id="add_button" style="color: white;">Start New Campaign</a>-->
											<a href="<?php echo site_url("site/createcampaign");?>"><img src="<?php echo base_url('assets/img/submit_button.png'); ?>" id="add_button"/></a>
										
                                            </li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</nav>
			<aside id="aside-container">
		</div>


</section>
 <!-- js placed at the end of the document so the pages load faster -->
    
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.scrollTo.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.nicescroll.js'); ?>" type="text/javascript"></script>
   
    <script src="<?php echo base_url('assets/js/owl.carousel.js'); ?>" ></script>
    <script src="<?php echo base_url('assets/js/jquery.customSelect.min.js'); ?>" ></script>
	<script type="text/javascript" src="<?php echo base_url('assets/assets/data-tables/jquery.dataTables.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/assets/data-tables/DT_bootstrap.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/dynamic-table.js'); ?>"></script>
    <!--common script for all pages-->
    <script src="<?php echo base_url('assets/js/common-scripts.js'); ?>"></script>

    <!--script for this page-->
   
	<script src="<?php echo base_url('assets/js/TableTools.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/assets/bootstrap-datepicker/js/bootstrap-datepicker.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/assets/bootstrap-daterangepicker/date.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/assets/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js'); ?>"></script>
	 <!--custom switch-->
    <script src="<?php echo base_url('assets/js/bootstrap-switch.js'); ?>"></script>
    <!--custom tagsinput-->
    <script src="<?php echo base_url('assets/js/jquery.tagsinput.js'); ?>"></script>
	
	<!--script for this page-->
	<script src="<?php echo base_url('assets/js/form-component.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/select2.js'); ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/select2.min.js'); ?>" type="text/javascript"></script>
  <script>

      //owl carousel

      $(document).ready(function() {
          $("#checkbox").click(function () {
            // alert("checkbox");
            if ($("#checkbox").is(':checked')) {
                //alert("checkbox");
                $(".check").prop('checked', true);
            } else {
                $(".check").prop('checked', false);

            }
        });
          $("#owl-demo").owlCarousel({
              navigation : true,
              slideSpeed : 300,
              paginationSpeed : 400,
              singleItem : true

          });
		  $('.fpTable').dataTable();
		  
		  var datatable=$('.csvdataTable').dataTable({
			"sDom": "T<'clear'>lfrtip",
			"oTableTools": {
				"sSwfPath": "<?php echo base_url('assets/media/swf/copy_csv_xls_pdf.swf'); ?>"
			},
			"sPaginationType": "bootstrap",
			"oLanguage": {
				"sLengthMenu": "_MENU_ records per page"
			}

			
		});
		$(".myselect2").select2({
			allowClear: true
		});
      });

      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

  </script>
  

</body>
</html>