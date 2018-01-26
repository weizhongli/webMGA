<?php
//Overall description for this program
$prog_overview="<h3> <center>identify duplicated 454 sequence reads (cd-hit-454)</center> </h3>
cd-hit-454 (<a href=\"http://cd-hit.org/\">http://cd-hit.org/</a>) identifies the duplicates from 454 reads, including exact duplicates and near identical duplicates. These duplicates are mostly sequencing artifacts in metagenomic samples, and therefore should be removed. However, most duplicates in transcriptomic reads may not be artificial, so it is not suggested to run this program for transcriptomic datasets.
<br />
<br />
<h5>Inputs:</h5>
DNA FASTA file, 454 reads (required), can be in .gz format<br />
<h5>Outputs:</h5>
output.zip will be produced with a README file describing the output files and format
";

//Reference
$ref="1. \"Artificial and natural duplicates in pyrosequencing reads of metagenomic data\", Beifang Niu, Limin Fu, Shulei Sun and Weizhong Li BMC Bioinformatics (2010) 11:187doi:10.1186/1471-2105-11-187. 
";

//Parameter Switch, Initial Value, Short Name and Long Description of each parameter used
$opt="-c 0.98 -D 1";
$opt_desc="
    -c  sequence identity threshold, default 0.98
        this is a \"global sequence identity\" calculated as :
        number of identical amino acids in alignment
        divided by the full length of the shorter sequence + gaps
    -b  band_width of alignment, default 10
    -M  max available memory (Mbyte), default 1000
    -n  word_length, default 10, see user's guide for choosing it
    -aL alignment coverage for the longer sequence, default 0.0
        if set to 0.9, the alignment must covers 90% of the sequence
    -AL alignment coverage control for the longer sequence, default 99999999
        if set to 60, and the length of the sequence is 400,
        then the alignment must be >= 340 (400-60) residues
    -aS alignment coverage for the shorter sequence, default 0.0
        if set to 0.9, the alignment must covers 90% of the sequence
    -AS alignment coverage control for the shorter sequence, default 99999999
        if set to 60, and the length of the sequence is 400,
        then the alignment must be >= 340 (400-60) residues
    -B  1 or 0, default 0, by default, sequences are stored in RAM
        if set to 1, sequence are stored on hard drive
        it is recommended to use -B 1 for huge databases
    -g  1 or 0, default 0
        by cd-hit's default algorithm, a sequence is clustered to the first
        cluster that meet the threshold (fast cluster). If set to 1, the program
        will cluster it into the most similar cluster that meet the threshold
        (accurate but slow mode)
        but either 1 or 0 won't change the representatives of final clusters
    -D  max size per indel, default 1
";

$cmd='./client_submit_job.pl input.fasta cd-hit-454 output.zip "you@example.com" "-c 0.98 -D 1"

Notes:
input.fasta: DNA input FASTA file (required)
cd-hit-454: program name (required)
output.zip: output file (required)
you@example.com: your email (optional)
"-c 0.98 -D 1": parameters for cd-hit program at first run (optional)

For email and parameters, if they are empty, you must use double quotes like "". If they (empty string) are the last term of command line, you can omit it.
For an example, email is empty:
./client_submit_job.pl input.fasta cd-hit-454 output.zip "" "-c 0.98 -D 1"
For the second example, paramters are empty:
./client_submit_job.pl input.fasta cd-hit-454 output.zip "you@example.com"
For the third example, both email and parameters are empty(using default parameters):
./client_submit_job.pl input.fasta cd-hit-454 output.zip
';
?>
