<div id="header">	
		<div id="alstomlogomini">&nbsp;</div>
		<div id="header_monitoring_logo">&nbsp;</div>
		<!--<div id="header_dispatching_logo">&nbsp;</div>-->
	</div><!-- header -->


		<div id="mainContent" class="jqueryslidemenu">
		<!-- This <ul><li> list is the source of a menuModel object -->
		<ul id="menuModel">
		
			<li id="50000"><a href="../index.php" onclick="$('#form_OpenOrDeleted').val('0');$('#form').submit();">Reports</a></li>
			<li id="50001" itemType="separator"></li>
			<li id="50002"><a href="index.php?OpenOrDeleted=0">Tickets</a>				
				<ul width="150">
					<li id="500021"><a href="index.php?OpenOrDeleted=0" onclick="$('#form_OpenOrDeleted').val('0');$('#form').submit();">Open</a></li>
					<li id="500022"><a href="index.php?OpenOrDeleted=1" onclick="$('#form_OpenOrDeleted').val('1');$('#form').submit();">Marked as deleted</a></li>
					<li id="500023"><a href="index.php?OpenOrDeleted=2" onclick="$('#form_OpenOrDeleted').val('2');$('#form').submit();">Last week (All)</a></li>
					<li id="500024"><a href="per_date.php">Per date</a></li>
					<li id="500025"><a href="index.php?OpenOrDeleted=3" onclick="$('#form_OpenOrDeleted').val('3');$('#form').submit();">Not assigned</a></li>
					<li id="500026"><a href="recurring_incidents.php">Recurring incidents</a></li>
				</ul>
			</li>
			<li id="50003" itemType="separator"></li>
			<li id="50004"><a href="exception.php">Exceptions</a>
				<ul width="150">
					<li id="500041"><a href="exception.php" >Open</a></li>
					<li id="500042"><a href="exception.php?DataClose=true" >Close</a></li>
				</ul>
			</li>
			<li id="50005" itemType="separator"></li>			
			<li id="50006"><a href="#">Operational Reports</a>
				<ul width="170">
					<li id="500061"><a href="#">SM&amp;C</a>
					<ul width="170">
						<li id="5000611"><a href="grayed_out_machines.php" >Grayed out</a></li>
						<li id="5000612"><a href="compare_custom_properties.php" >Custom properties</a></li>
						<li id="5000613"><a href="NetIQservers_to_remove.php" >Servers to remove</a></li>
						<li id="5000622"><a href="daily_tasks.php">Daily Tasks (BETA)</a></li>
						<li id="5000614"><a href="NetIQservers_to_add.php">Servers to integrate</a></li>
						<li id="5000615"><a href="MS_Null.php">Servers without MS</a></li>
						<li id="5000616"><a href="servers_with_AP_0.php">Servers with AP 0</a></li>
						
						<li id="5000620"><a href="deployment_admin.php?Page=1&System=WinNT">Deployment</a>
						<li id="5000618"><a href="managed_other_than_DCSL.php">Incorrect ManagedBy</a></li>
						<li id="5000619"><a href="maintenance_mode_current.php">Maintenance mode</a>
								<ul width="150">
									<li id="50006191"><a href="maintenance_mode_current.php">Current</a></li>
									<li id="50006192"><a href="maintenance_mode_history.php">History</a></li>
								</ul>
						</li>
						<li id="5000621"><a href="Duplicated_Servers.php">Duplicated Servers</a></li>
					</ul>
					<li id="500062"><a href="serman.php">Serman offline</a></li>															
				</ul>			
			</li>
			<li id="50007" itemType="separator"></li>	
		
		</ul>		
			
		<div id="menuDiv"></div>
	
	</div>
	
	
	<script type="text/javascript">
	var menuModel = new DHTMLSuite.menuModel();
	menuModel.addItemsFromMarkup('menuModel');
	menuModel.setMainMenuGroupWidth(00);	
	menuModel.init();
	
	var menuBar = new DHTMLSuite.menuBar();
	menuBar.addMenuItems(menuModel);
	menuBar.setMenuItemCssPrefix('Custom_');
	menuBar.setCssPrefix('Custom_');
	menuBar.setTarget('menuDiv');
	
	menuBar.init();
		

	</script>
