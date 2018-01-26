<?php
//Overall description for this program
$prog_overview="<h3> <center>function annotation (TIGRFAM)</center> </h3>
This program performs function annotation by using HMMER 3.0 program on TIGRFAM database. 
<br />
<h5>Inputs:</h5>
Protein FASTA file (required), can be in .gz format<br />
<h5>Outputs:</h5>
output.zip will be produced with a README file describing the output files and format
";

//Reference
$ref="1.\"Profile hidden Markov models\", S. R. Eddy Bioinformatics (1998) 14(9):755-763.
<br />
2. \"The TIGRFAMs database of protein families\", D. H., Haft et al. Nucleic Acids Research (2010) 38: D211-D222.
";

$opt="-E 0.001";
$opt_desc="-E e-value cutoff for prediction 
";

$cmd='./client_submit_job.pl input.fasta tigrfam output.zip "you@example.com" "-E 0.001"

Notes:
input.fasta: protein input FASTA file (required)
tigrfam: program name (required)
output.zip: output file (required)
you@example.com: your email (optional)
"-E 0.001": parameters (optional)

For email and parameters, if they are empty, you must use double quotes like "". If they (empty string) are the last term of command line, you can omit it.
For an example, email is empty:
./client_submit_job.pl input.fasta tigrfam output.zip "" "-E 0.001"
For the second example, paramters are empty:
./client_submit_job.pl input.fasta tigrfam output.zip "you@example.com"
For the third example, both email and parameters are empty(using default parameters):
./client_submit_job.pl input.fasta tigrfam output.zip
';

?>
