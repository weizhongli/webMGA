<?php
//Overall description for this program
$prog_overview="<h3> <center>pathway annotation (KEGG)</center> </h3>
This program uses BLAST to search protein sequences against KEGG protein database. The KEGG number and its pathway/functions will be outputted.
<br />
<h5>Inputs:</h5>
(1) Protein FASTA file (required)<br />
(2) Email address (optional)<br />
(3) Parameters (optional)<br />
<h5>Outputs:</h5>output.zip(including the following four files<br />
(1) README.txt: description of the four output files <br />
(2) output.1: Short table of brief blast results against KEGG database<br />
(3) output.2: Long table of detailed blast results against KEGG database<br />
(4) output.3: Statistical results of hits in KEGG database<br />
<h5>Usage of web server:</h5>
(1) Select the protein fasta file in user's local computer. (required) <br />
(2) Fill in user's email adress. (optional) <br />
(3) Fill in parameters. (optional, modifiy it according to user's requirement)<br />
(4) Click \"Submit\" button. (required) <br />
";

//Reference
$ref="1. \"Basic Local Alignment Search Tool\", S. F. Altschul, et al. Journal of Molecular Biology (1990) 215(3):403-410.
<br />
2. \"Kyoto Encyclopedia of Genes and Genomes\", H. Ogata, et al. Nucleic Acids Research (1999) 27(1):29-34.
";

$opt="-e 0.001";
$opt_desc="-e e-value cutoff for prediction 
";
$cmd='./client_submit_job.pl input.fasta kegg output.zip "you@example.com" "-e 0.001"

Notes:
input.fasta: protein input FASTA file (required)
kegg: program name (required)
output.zip: output file (required)
you@example.com: your email (optional)
"-e 0.001": parameters (optional)

For email and parameters, if they are empty, you must use double quotes like "". If they (empty string) are the last term of command line, you can omit it.
For an example, email is empty:
./client_submit_job.pl input.fasta kegg output.zip "" "-e 0.001"
For the second example, paramters are empty:
./client_submit_job.pl input.fasta kegg output.zip "you@example.com"
For the third example, both email and parameters are empty(using default parameters):
./client_submit_job.pl input.fasta kegg output.zip
';

?>
