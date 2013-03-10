
		<div id="mainContent2" class="jqueryslidemenu">
		<ul id="menuModel2">
			<li id="60006"><a href="#">File</a>
				<ul width="170">
					<li id="600061"><a href="#">Export</a>
					<ul width="170">
						<li id="6000611"><a href="#">To XLS</a>
						<ul width="170">
							<li id="6000612"><a href="javascript:xlsexport()">Current View</a></li>
							<li id="6000613"><a href="javascript:xlsexportall('done')">Done Servers</a></li>
							<li id="6000614"><a href="javascript:xlsexportall('notdone')">To Deployment</a></li>
						</ul>
						</li>
						<li id="6000615"><a href="#">To XML</a>
						<ul width="170">
							<li id="6000616"><a href="javascript:xmlexport()">Current View</a></li>
							<li id="6000617"><a href="javascript:xmlexport('done')">Done Servers</a></li>
							<li id="6000618"><a href="javascript:xmlexport('notdone')">To Deployment</a></li>
						</ul>
						</li>
					</ul>
				</ul>			
			</li>
			<li id="60005" itemType="separator"></li>
			<li id="60002"><a href="#">View</a>				
				<ul width="150">
					<li id="600022"><a href="javascript:pokaz('deployment')">Deployment</a></li>
					<li id="600024"><a href="javascript:pokaz('done')">Done</a></li></li>
					<li id="600026"><a href="javascript:picked_save()">Picked Save</a></li>
					<li id="600023"><a href="javascript:pokaz('result')">Last Query Result</a></li>
					<li id="600025"><a href="javascript:pokaz('statistics')">Statistics</a></li>
				</ul>
			<li id="60003" itemType="separator"></li>		
		</ul>		
			
		<div id="menuDiv2"></div>
	
	</div>
	
	
	<script type="text/javascript">
	var menuModel = new DHTMLSuite.menuModel();
	menuModel.addItemsFromMarkup('menuModel2');
	menuModel.setMainMenuGroupWidth(00);	
	menuModel.init();
	
	var menuBar = new DHTMLSuite.menuBar();
	menuBar.addMenuItems(menuModel);
	menuBar.setMenuItemCssPrefix('Custom_');
	menuBar.setCssPrefix('Custom_');
	menuBar.setTarget('menuDiv2');
	
	menuBar.init();
		

	</script>
