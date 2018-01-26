<?php
$title = 'Server';
$program = "overview";
require("../includes/common.php");
?>
<div id="maininner">
<?php
require("../includes/progmenu.php");
?>
<div id="srvmain">
<?php include("desc.php"); print $page_overview; ?>
</div> <!--End srvmain-->
<div class="clear"></div>
</div><!--maininner-->
<?php
require("../includes/footer.php");
?>
