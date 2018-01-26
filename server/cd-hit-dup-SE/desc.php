<?php
//Overall description for this program
$prog_overview="<h3> <center>Identify duplicated single-ended (SE) reads (cd-hit-dup-SE)</center> </h3>
cd-hit-dup (<a href=\"http://cd-hit.org\">http://cd-hit.org</a>) is a very widely used program for clustering and comparing large sets of biological sequences. cd-hit-dup is a program in cd-hit packate for identifying duplicated reads, specially Illumina pair-ended (PE) or single ended (SE) reads.

<br />
<br />
<br />
<h5>Inputs:</h5>
<OL>
  <LI>reads in FASTA format (required), can be in .gz format
</OL>

<h5>Outputs:</h5>
output.zip will be produced with a README file describing the output files and format
";

//Reference
$ref="1. \"Clustering of highly homologous sequences to reduce the size of large protein database\", Weizhong Li, Lukasz Jaroszewski and Adam Godzik Bioinformatics (2001) 17:282-283. 
<br />

2. \"Tolerating some redundancy significantly speeds up clustering of large protein databases\", Weizhong Li, Lukasz Jaroszewski and Adam Godzik Bioinformatics (2002) 18:77-82.
<br />

3. \"Cd-hit: a fast program for clustering and comparing large sets of protein or nucleotide sequences\", Weizhong Li and Adam Godzik Bioinformatics (2006) 22:1658-1659.
<br />

4. \"CD-HIT Suite: a web server for clustering and comparing biological sequences\", Ying Huang, Beifang Niu, Ying Gao, Limin Fu and Weizhong Li Bioinformatics (2010) 26:680-682.
";

//Parameter Switch, Initial Value, Short Name and Long Description of each parameter used
$opt="-u 50 -e 2";
$opt_desc="
    -u        Length of prefix to be used in the analysis (default 0, for full/maximum length);
    -m        Match length (true/false, default true);
    -e        Maximum number of mismatches allowd;
";

$cmd='./client_submit_job.pl input.fasta cd-hit output.zip "you@example.com" "-d 0 -n 5 -p 1 -G 0 -c 0.90 -aS 0.8"

Notes:
input.fasta: protein input FASTA file (required)
cd-hit: program name (required)
output.zip: output file (required)
you@example.com: your email (optional)
"-d 0 -n 5 -p 1 -G 0 -c 0.90 -aS 0.8": parameters for cd-hit program (optional)

For email and parameters, if they are empty, you must use double quotes like "". If they (empty string) are the last term of command line, you can omit it.
For an example, email is empty:
./client_submit_job.pl input.fasta cd-hit output.zip "" "-d 0 -n 5 -p 1 -G 0 -c 0.90 -aS 0.8"
For the second example, paramters are empty:
./client_submit_job.pl input.fasta cd-hit output.zip "you@example.com"
For the third example, both email and parameters are empty(using default parameters):
./client_submit_job.pl input.fasta cd-hit output.zip
';

?>
