<html lang="pl">
<head>
	<title>jQuery UI Tabs - Default functionality</title>
			<script type="text/javascript">AC_FL_RunContent = 0;</script>
			<script type="text/javascript"> DetectFlashVer = 0; </script>
			<script src="AC_RunActiveContent.js" type="text/javascript"></script>
			<script type="text/javascript">
			<!--
			var requiredMajorVersion = 9;
			var requiredMinorVersion = 0;
			var requiredRevision = 45;
			-->
			</script>
	<link type="text/css" href="js/theme/ui.all.css" rel="stylesheet">
	<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
	<script type="text/javascript" src="js/ui/ui.core.js"></script>
	<script type="text/javascript" src="js/ui/ui.tabs.js"></script>
	<script type="text/javascript" src="js/jquery.blockui.js"></script>

	<script type="text/javascript">
	$(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
	$(function() {
		$("#tabs").tabs();
	});
	
	</script>
</head>
<body>

<div class="demo">

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Deployment</a></li>
		<li><a href="#tabs-2">Done</a></li>
		<li><a href="test2.php">Statistics</a></li>
	</ul>
	<div id="tabs-1">
		<p>Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.</p>
	</div>
	<div id="tabs-2">
		<p>Morbi tincidunt, dui sit amet facilisis feugiat, odio metus gravida ante, ut pharetra massa metus id nunc. Duis scelerisque molestie turpis. Sed fringilla, massa eget luctus malesuada, metus eros molestie lectus, ut tempus eros massa ut dolor. Aenean aliquet fringilla sem. Suspendisse sed ligula in ligula suscipit aliquam. Praesent in eros vestibulum mi adipiscing adipiscing. Morbi facilisis. Curabitur ornare consequat nunc. Aenean vel metus. Ut posuere viverra nulla. Aliquam erat volutpat. Pellentesque convallis. Maecenas feugiat, tellus pellentesque pretium posuere, felis lorem euismod felis, eu ornare leo nisi vel felis. Mauris consectetur tortor et purus.</p>
	</div>
</div>

</div><!-- End demo -->

<div class="demo-description">

<p>Click tabs to swap between content that is broken into logical sections.</p>

</div><!-- End demo-description -->

</body>
</html>
