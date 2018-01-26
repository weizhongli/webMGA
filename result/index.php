<?php
$title = 'Results';
require("../includes/common.php");
?>
<div id="maininner">
<div style="width:60%;border:1px solid #777;padding:8px;margin-bottom:20px;color:#555;" class="centered"><?php include("desc.php"); print $page_overview; ?></div>
<?php
function checkjobid($jobid) {
    if (is_numeric($jobid)) 
        return true;
    else
        return false;
}


$statuses = array('C'=>'COMPLETE','W'=>'WAITING','R'=>'RUNNING','A'=>'WAITING');

$jobform = '<form id="jobform" name="jobform" action="." method="GET">Job ID: <input type="text" id="jobid" name="jobid" size="30"><button type="submit">Submit</button></form>'."\n";
if (array_key_exists('jobid',$_REQUEST)) {
    $jobid = $_REQUEST['jobid'];
    if (checkjobid($jobid)) {
        if (file_exists("output/$jobid.zip")) {
          print "<br />Job finished! <br />Download the result file: <a href=\"output/$jobid.zip\">$jobid.zip</a>";
        }
        else {
          print "<br />Job not finished yet: <a href=\"./?jobid=$jobid\"><button>Refresh</button></a>";
        }
        print("<hr />\nCheck another job:\n");
    }
    else {
        print "Invalid job ID. Try again please.<hr />\n";
    }
}
print $jobform;
?>
<span style="color:blue;text-decoration:underline;cursor:pointer" onclick="$('#jobid').val('06606620101127225044003432')">Load an example job id</span>
</div>
<?php
require("../includes/footer.php");
?>
