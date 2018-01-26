<?php
$categorytable = "<table>";
// Generate table
foreach($programs as $sp)
{
    if ($sp[0] == '__group')
    {
        $categorytable .= "<tr><td><b>".$sp[1]."</b></td><tr>";
    }
}
$categorytable .= "</table> <!--End progtable-->";
?>
