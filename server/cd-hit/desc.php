<?php
//Overall description for this program
$prog_overview="<h3> <center>protein clustering (cd-hit)</center> </h3>
cd-hit (<a href=\"http://cd-hit.org/\">http://cd-hit.org/</a>) is a very widely used program for clustering and comparing large sets of protein sequences. cd-hit is very fast and can handle extremely large databases. cd-hit helps to significantly reduce the computational and manual efforts in many sequence analysis tasks and aids in understanding the data structure and correct the bias within a dataset.
<br />
<br />
<h5>Inputs:</h5>
Protein FASTA file (required), can be in .gz format<br/>
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
$opt="-d 0 -n 5 -p 1 -G 0 -c 0.9 -aS 0.8";
$opt_desc="
    -c  sequence identity threshold, default 0.9
        this is the default cd-hit's \"global sequence identity\" calculated as:
        number of identical amino acids in alignment
        divided by the full length of the shorter sequence
    -G  use global sequence identity, default 1
        if set to 0, then use local sequence identity, calculated as :
        number of identical amino acids in alignment
        divided by the length of the alignment
        NOTE!!! don't use -G 0 unless you use alignment coverage controls
        see options -aL, -AL, -aS, -AS
    -b  band_width of alignment, default 20
    -M  memory limit (in MB) for the program, default 800; 0 for unlimitted;
    -n  word_length, default 5, see user's guide for choosing it
    -l  length of throw_away_sequences, default 10
    -t  tolerance for redundance, default 2
    -d  length of description in .clstr file, default 20
        if set to 0, it takes the fasta defline and stops at first space
    -s  length difference cutoff, default 0.0
        if set to 0.9, the shorter sequences need to be
        at least 90% length of the representative of the cluster
    -S  length difference cutoff in amino acid, default 999999
        if set to 60, the length difference between the shorter sequences
        and the representative of the cluster can not be bigger than 60
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
    -A  minimal alignment coverage control for the both sequences, default 0
        alignment must cover >= this value for both sequences 
    -B  1 or 0, default 0, by default, sequences are stored in RAM
        if set to 1, sequence are stored on hard drive
        it is recommended to use -B 1 for huge databases
    -p  1 or 0, default 0
        if set to 1, print alignment overlap in .clstr file
    -g  1 or 0, default 0
        by cd-hit's default algorithm, a sequence is clustered to the first 
        cluster that meet the threshold (fast cluster). If set to 1, the program
        will cluster it into the most similar cluster that meet the threshold
        (accurate but slow mode)
        but either 1 or 0 won't change the representatives of final clusters
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
