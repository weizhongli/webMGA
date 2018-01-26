<?php
$programs = array();
$programs[] = array('__group','clustering');
$programs[] = array('cd-hit-est','DNA (cd-hit-est)','fast DNA clustering','cd-hit-est 4.5.3; N/A');
$programs[] = array('cd-hit','protein (cd-hit 1-step)','protein clustering','cd-hit 4.5.3; N/A');
$programs[] = array('cd-hit-dup-PE','PE reads (cd-hit-dup)','de-duplicate PE reads','cd-hit-dup; N/A');
$programs[] = array('cd-hit-dup-SE','SE reads (cd-hit-dup)','de-duplicate SE reads','cd-hit-dup; N/A');
$programs[] = array('h-cd-hit','protein (cd-hit 2-steps)','hierarchical protein clustering','cd-hit 4.5.3; N/A');
$programs[] = array('h3-cd-hit','protein (cd-hit 3-steps)','hierarchical protein clustering','cd-hit 4.5.3; N/A');
$programs[] = array('psi-cd-hit-protein','psi-cd-hit-protein','protein clustering with psi-cd-hit','psi-cd-hit beta; N/A');
$programs[] = array('psi-cd-hit-DNA','psi-cd-hit-DNA','DNA clustering with psi-cd-hit','psi-cd-hit beta; N/A');
$programs[] = array('cd-hit-454','filtering duplicates (cd-hit-454)','filtering 454 duplicate reads','cd-hit-454 4.5.3; N/A');
$programs[] = array('cd-hit-otu-miseq','cd-hit-OTU for MiSEQ data','OTU clustering for miseq data','cd-hit-otu-miseq 1.0.0; N/A');

$programs[] = array('__group','orf prediction');
$programs[] = array('metagene','metagene','orf prediction by metagene program','metagene 10/12/2006; N/A');

$programs[] = array('__group','function annotation');
$programs[] = array('cog','COG','protein function annotation by COG database','rpsblast 2.2.15; NCBI COG 2/2/2011');
$programs[] = array('kog','KOG','protein function annotation by KOG database','rpsblast 2.2.15; NCBI KOG 2/2/2011');
$programs[] = array('prk','PRK','protein function annotation by NCBI PRK database','rpsblast 2.2.15; NCBI PRK 2/2/2011');
$programs[] = array('pfam','PFAM','protein function annotation by pfam database','hmmscan 3.0; PFAM 24.0');
$programs[] = array('tigrfam','TIGRFAM','protein function annotation by tigrfam database','hmmscan 3.0; TIGRFAM 10.0');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$programlist = array();
foreach ($programs as $p) {
    if ($p[0] == '__group') continue;
    $programlist[] = $p[0];
}
?>
