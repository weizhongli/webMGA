<?php
$title = 'Contact Us';
require("../includes/common.php");
?>
<div id="maininner">
<form action="request.php" id="contactform" method="post">
<table style="width:600px; font-size:90%;border:2px solid #AAA;padding:10px;margin:6px;margin-left:auto;margin-right:auto">
<tr>
<td style="text-align: right; width: 160px;">Your email address*:</td><td><input type="text" id="uemail" name="uemail" style="width: 100%"></input></td>
</tr>
<tr>
<td style="text-align: right; width: 160px;">Confirm email address*:</td><td><input type="text" id="uemail2" name="uemail2" style="width: 100%"></input></td>
</tr>
<tr>
<td style="text-align: right">Subject:</td><td><input type="text" id="subject" name="subject" style="width: 100%"></input></td>
</tr>
<tr>
<td style="text-align: right">Message*:</td>
<td>
<div><textarea id="mailbody" name="mailbody" style="width:100%; height:200px"></textarea></div>
</td>
</tr>
<tr>
<td><span style="color:#999">* required</span></td>
<td style="text-align: right"><button type="submit" id="submitbutton">Send</button></td>
</tr>
</table>
</form>
<div id="output" class="output_succ centered" style="width:600px"><div id="outputinner"></div></div>
</div><!--END maininner-->
<?php
require("../includes/footer.php");
?>
