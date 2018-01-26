<?php
//Overall description for this program
$prog_overview="<h3> <center>ORF prediction (metagene)</center> </h3>
This program predicts ORF using metagene program. 
<br />
<h5>inputs:</h5>
DNA FASTA file (required), can be in .gz format<br />
<h5>Outputs:</h5>output.zip(including the following three files<br />
<h5>Outputs:</h5>
output.zip will be produced with a README file describing the output files and format
";

//Reference
$ref="1. \"MetaGene: prokaryotic gene finding from environmental genome shotgun sequence\", H. Noguchi, J. Park and T. Takagi Nucleic Acids Research (2006) 34(19):5623-5630.";
$cmd='./client_submit_job.pl input.fasta metagene output.zip "you@example.com"

Notes:
input.fasta: DNA input FASTA file (required)
metagene: program name (required)
output.zip: output file (required)
you@example.com: your email (optional)

For email, if it is empty, you can omit it.
For an example, email is empty:
./client_submit_job.pl input.fasta metagene output.zip
';

?>
