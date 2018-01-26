<?php
$progtable = "\n<table class=\"progtable\">
<tr><th>Category</th><th>Name";
if ($title=='Services')
{
    $progtable .= "<span style=\"float:right\">help</span>";
}
$progtable .= "</th><th>Description</th></tr>\n";
// Generate table
$groups = array();
$currentgroup = '';
foreach($programs as $sp)
{
    if ($sp[0] == '__group')
    {
        $currentgroup = $sp[1];
        $groups[$currentgroup] = array();
        $groups[$currentgroup][] = $currentgroup;
    }
    else
    {
        $groups[$currentgroup][] = $sp;
    }
}

foreach($groups as $g)
{
    $progtable .= "<tr><td rowspan=\"".(count($g)-1)."\" style=\"text-align:left\"><b>".$g[0]."</b></td><td style=\"text-align:left\">";
    if ($title =='Server')
    {
        $progtable .= "<a href=\"".$g[1][0]."\">".$g[1][0]."</a></td>";
    }
    else {
        $progtable .= $g[1][0]."<a href=\"gethelp.php?p=".$g[1][0]."\" target=\"_new\"><span class=\"tagcmd\" style=\"float:right\">?</span></a></td>";
    }
    $progtable .= "<td>".$g[1][2]."</td></tr>\n";
    array_shift($g);
    array_shift($g);
    foreach($g as $p)
    {
        $progtable .= "<tr><td style=\"text-align:left\">";
        if ($title=='Server')
        {
            $progtable .= "<a href=\"$p[0]\">$p[0]</a></td>";
        }
        else {
            $progtable .= "$p[0]<a href=\"gethelp.php?p=".$p[0]."\" target=\"_new\"><span class=\"tagcmd\" style=\"float:right\">?</span></td>";
        }
        $progtable .= "<td>$p[2]</td></tr>\n";
    }
}
$progtable .= "</table> <!--End progtable-->\n";
?>
