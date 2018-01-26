<?php
//Overall description for this program
$prog_overview="<h3> <center>ORF prediction (orf_finder)</center> </h3>
This program predicts ORF by six-reading-frame technique. 
<br />
<h5>Inputs:</h5>
(1) DNA FASTA file (required)<br />
(2) Email address (optional)<br />
(3) Parameters (optional)<br />
<h5>Outputs:</h5>output.zip(including the following three files<br />
(1) README.txt: description of the three output files <br />
(2) output.1: Predicted orf files in FASTA format <br />
(3) output.2: Table of information of predicted orfs<br />
<h5>Usage of web server:</h5>
(1) Select the DNA fasta file in user's local computer. (required) <br />
(2) Fill in user's email adress. (optional) <br />
(3) Fill in parameters. (optional, modifiy it according to user's requirement)<br />
(4) Click \"Submit\" button. (required) <br />
";

$opt="-l 30 -L 30 -t 11";
$opt_desc="  -l minimal length of orf, default 20
  -L minimal length of orf between stop codon, default 40
  -M max_dna_len, in MB, length of the longest input DNA sequence, default 10
  -t translation table, default 1
  -b ORF begin option: default 2
     1: start at the begining of DNA sequence or after pervious stop codon
     2: start with the first ATG if there is a stop codon upstream
     We don't know which ATG is the real start, but for prokaryotic DNA,
     a fragment between a stop codon and the first ATG can not be part of real gene.
     Therefore, -b 2 is recommanded for prokaryotic
  -e ORF end option: default 1
     1: end at the end of DNA sequence or at a stop codon
     2: must end at a stop codon
";
//Reference
$cmd='./client_submit_job.pl input.fasta orf_finder output.zip "you@example.com" "-l 30 -L 30 -t 11"

Notes:
input.fasta: DNA input FASTA file (required)
blastn_rRNA: program name (required)
output.zip: output file (required)
you@example.com: your email (optional)
"-l 30 -L 30 -t 11": parameters (optional)

For email and parameters, if they are empty, you must use double quotes like "". If they (empty string) are the last term of command line, you can omit it.
For an example, email is empty:
./client_submit_job.pl input.fasta orf_finder output.zip "" "-l 30 -L 30 -t 11"
For the second example, paramters are empty:
./client_submit_job.pl input.fasta orf_finder output.zip "you@example.com"
For the third example, both email and parameters are empty(using default parameters):
./client_submit_job.pl input.fasta orf_finder output.zip
';

?>
