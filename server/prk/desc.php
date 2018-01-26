<?php
//Overall description for this program
$prog_overview="<h3> <center>function annotation (PRK)</center> </h3>
This program performs function annotation by using RPSBLAST program on NCBI PRK database (Reference Sequence proteins). 
<br />
<h5>Inputs:</h5>
Protein FASTA file (required), can be in .gz format<br />
<h5>Outputs:</h5>
output.zip will be produced with a README file describing the output files and format
";

//Reference
$ref="1. \"Basic Local Alignment Search Tool\", S. F. Altschul, et al. Journal of Molecular Biology (1990) 215(3):403-410.
<br />
";

$opt="-evalue 0.001";
$opt_desc="-evalue e-value cutoff for prediction 
";

$cmd='./client_submit_job.pl input.fasta prk output.zip "you@example.com" "-evalue 0.001"

Notes:
input.fasta: protein input FASTA file (required)
prk: program name (required)
output.zip: output file (required)
you@example.com: your email (optional)
"-evalue 0.001": parameters (optional)
For email and parameters, if they are empty, you must use double quotes like "". If they (empty string) are the last term of command line, you can omit it.
For an example, email is empty:
./client_submit_job.pl input.fasta prk output.zip "" "-evalue 0.001"
For the second example, paramters are empty:
./client_submit_job.pl input.fasta prk output.zip "you@example.com"
For the third example, both email and parameters are empty(using default parameters):
./client_submit_job.pl input.fasta prk output.zip
';

?>
