<div id="serverform" class="serverform">
<form id="server" name="server" action="/webMGA/cgi-bin/NGS-web.cgi" method="post" enctype="multipart/form-data">
<input type="hidden" name="PROGRAM" value="<?php print($program) ?>" />
<div>Sequence file to upload (required): <input type="file" name="SEQ_FILE" /></div> 
<?php
if ($program == "cd-hit-dup-PE") {
    print "<div>Sequence file for R2 reads (required): <input type=\"file\" name=\"SEQ_FILE2\" /></div>\n";
}
elseif ($program == "filter_eukaryote") {
    print "<div>User-defined eukaryotic sequences (required): <input type=\"file\" name=\"SEQ_FILE2\" /></div>\n";
}
?>
<div>Email (optional): <input type="text" name="EMAIL" /></div> 
<?php
if (isset($opt)) {
    print "<fieldset><legend>Parameters</legend>\n";
    if (isset($opt2)) {
        print "parameter set 1: ";
    }
    print "<input name=\"OPT\" class=\"opt\" size=\"55\" value=\"" . $opt . "\" />\n";
    if (isset($opt2)) {
        print "<br />parameter set 2: <input name=\"OPT2\" class=\"opt\" size=\"55\" value=\"" . $opt2 . "\" />\n";
    }
    if (isset($opt3)) {
        print "<br />parameter set 3: <input name=\"OPT3\" class=\"opt\" size=\"55\" value=\"" . $opt3 . "\" />\n";
    }
    print "<br /><span id=\"optdescswitch\">show description</span>\n";
    if (isset($opt_desc)) {
        print "<pre class=\"optdesc\">" . $opt_desc . "</pre>";
    }
    print "</fieldset>\n";
}
?>
<!-- <button type="reset" id="submitbutton" name="submitbutton" value="NO Submit">Please do not submit, server under Maintenance</button> -->

<button type="submit" id="submitbutton" name="submitbutton" value="Submit">Submit</button>
</form>
</div> <!--End Severform"-->
<div id="serverformexample" class="serverform">
<span style="color:white;background-color:#FF3300;display:inline;padding:4px;font-weight:bold;font-size:1.0em;position:relative;left:-10px;top:-6px">EXAMPLE</span>
<form id="serverexample" name="server" action="/webMGA/cgi-bin/submit_web_example.cgi" method="post" enctype="multipart/form-data">
<input type="hidden" name="PROGRAM" value="<?php print($program) ?>" />
<?php
if ($program=='qc_filter_fastq' or $program=='trimm' or $program=='fastq2fasta') {$inputfile = 'input.fastq';}
else {$inputfile = 'input.fasta';}
?>
<div>Sequence file to upload (required): <span class="exampleinput opt"><a href="<?php echo $inputfile ?>"><?php echo $inputfile ?></a></span></div> 
<?php
if ($program == "qc_filter_fasta_qual") {
    print "<div>Quality file to upload (required): <span class=\"exampleinput opt\"><a href=\"qualityfile.txt\">qualityfile.txt</a></span></div>\n";
}
elseif ($program == "filter_eukaryote") {
    print "<div>User-defined eukaryotic sequences (required): <span class=\"exampleinput opt\"><a href=\"filter.txt\">filter.txt</a></span></div>\n";
}
?>
<div>Email (optional): <span class="exampleinput opt">you@example.com</span></div> 
<?php
if (isset($opt)) {
    print "<fieldset><legend>Parameters</legend>\n";
    if (isset($opt2)) {
        print "parameter set 1: ";
    }
    print "<span class=\"exampleinput opt\">" . $opt . "</span>\n";
    if (isset($opt2)) {
        print "<br /><br />parameter set 2: <span class=\"exampleinput opt\">" . $opt2 . "</span>\n";
    }
    if (isset($opt3)) {
        print "<br /><br />parameter set 3: <span class=\"exampleinput opt\">" . $opt3 . "</span>\n";
    }
    if (isset($opt_desc)) {
        print "<br /><span id=\"optdescswitch\">show description</span>\n";
        print "<pre class=\"optdesc\">" . $opt_desc . "</pre>";
    }
    print "</fieldset>\n";
}
?>
<button type="submit" id="examplesubmitbutton" name="submitbutton" value="Submit">Submit Example</button>
</form>
</div> <!--End Severform Example"-->
<span id="serverexampleswitch">Show an example</span>
<div id="loader"><span style="vertical-align:middle">Submitting......</span><img src="../../image/loader.gif" style="vertical-align:middle" /></div>
