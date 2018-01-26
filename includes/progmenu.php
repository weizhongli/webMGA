<div id="srvmenu">
<ul>
<?php
$SRV = "server";
// Generate menu
$groupidx = 0;
foreach($programs as $p)
{
    $ln = '';
    if ($p[0] == '__group')
    {
        $groupidx++;
        if ($groupidx > 1)
            $ln .= "</ul>\n";
        $ln .= '<li class="group"';
        $ln .= '><a href="#">' . $p[1] .'</a></li>' . "\n";
        $ln .= '<ul class="group">'."\n";
    }
    else
    {
        $URL = "$ROOT/$SRV/$p[0]/";
        $ln .= '<li class="program';
        if ($p[0] == $program)
            $ln .= ' srvcurrent';
        $ln .= '" title="' . $p[2] . '"><a href="' . $URL . '">' . $p[0] . '</a></li>' . "\n";
    }
    print($ln);
}
?>
</ul>
</div> <!--End srvmenu-->
