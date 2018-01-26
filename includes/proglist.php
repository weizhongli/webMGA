<dl class="proglist">
<?php
// Generate list
foreach($programs as $sp)
{
    $ln = '';
    if ($sp[0] == '__group')
    {
        $ln .= '<dt>' . $sp[1] . ":</dt>\n";
    }
    else
    {
        $ln .= '<dd>' . $sp[0] . '  --  ' . $sp[1] . ' : ' . $sp[2] . "</dd>";
    }
    print($ln);
}
?>
</dl> <!--End proglist-->
