<?php
$title = 'Server';
$program = "cd-hit";
require("../../includes/common.php");
?>
<div id="maininner">
<?php
require("../../includes/progmenu.php");
include("desc.php");
?>
<div id="srvmain">
<div class="programtitle"></div>
<div class="programdesc"><?php print($prog_overview) ?></div>
<?php include("../form.php"); ?>
<div id="output" class="output_succ"><div id="outputinner"></div></div>
<?php
if (isset($ref)) {
print("<div id=\"ref\"><h5>Program/Database References</h5>" . $ref . "</div>");
}
?>
<div id="ver"><h5>Program/Database Version</h5>
<?php
foreach ($programs as $p) {
    if ($p[0] == $program) {
        $versionstring = $p[3];
    }
}
if (isset($versionstring)) {
    $versions = explode(';',$versionstring);
    echo 'Program: '.$versions[0];
    echo '<br/>';
    echo 'Database: '.$versions[1];
}
?>
</div>
</div> <!--End srvmain-->
<div class="clear"></div>
</div><!--maininner-->
<?php
require("../../includes/footer.php");
?>
