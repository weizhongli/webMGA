<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="keywords" content="bioinformatics,genomics" />
<script type="text/javascript" src="<?php print($ROOT) ?>/script/jquery.js"></script>
<script type="text/javascript" src="<?php print($ROOT) ?>/script/jquery.corner.js"></script>
<script type="text/javascript" src="<?php print($ROOT) ?>/script/jquery.form.js"></script>
<script type="text/javascript" src="<?php print($ROOT) ?>/script/jquery.colorbox-min.js"></script>
<script type="text/javascript" src="<?php print($ROOT) ?>/script/my.js"></script>
<title>WebMGA | <?php print($title);if ($program && $program != 'overview') print(" | $program") ?></title>
<link rel="stylesheet" href="<?php print($ROOT) ?>/css/main.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php print($ROOT) ?>/css/colorbox.css" type="text/css" media="screen" />
<link rel="shortcut icon" href="<?php print($ROOT) ?>/image/favicon.ico" />
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-22714867-2']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
</head>
<body>
<div id="header" class="centered">
<a href="<?php print($ROOT) ?>"><div id="title">WebMGA</div><div id="subtitle">web services for metagenomic analysis</div></a>
<!-- 
<img src="<?php print($ROOT) ?>/image/cooltextlogo16.png" /><div id="subtitle"><p style="color:red">Notice! this new site is being tested, Please submit your job to the <a href="http://weizhong-lab.ucsd.edu/metagenomic-analysis">current server at http://weizhong-lab.ucsd.edu/metagenomic-analysis</A> !!!!!</p></div>
-->
<div id="topmenu" class="centered">
<ul>
<?php
// Menu items (URL, Title)
$menu = array();
$menu[] = array("$ROOT/", 'Home');
$menu[] = array("$ROOT/server/", 'Server');
$menu[] = array("$ROOT/result/", 'Results');
$menu[] = array("$ROOT/scripts/", 'Scripts');
$menu[] = array("$ROOT/help/", 'Help');
$menu[] = array("$ROOT/contact/", 'Contact Us');

// Generate menu
foreach($menu as $page)
{
    $ln = '<li';
    if ($page[1] == $title)
        $ln .= ' class="current"';
    $ln .= '><a href="' . $page[0] . '">' . $page[1] . '</a></li>' . "\n";
    print($ln);
}
?>
</ul>
<div class="clear"></div>
</div> <!--End Topmenu-->
</div><!--End Header-->
<div id="main" class="centered shadowmain">
