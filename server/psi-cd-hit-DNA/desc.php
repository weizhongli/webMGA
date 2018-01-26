<?php
//Overall description for this program
$prog_overview="<h3> <center>psi-cd-hit-DNA, clustering of very long sequences (genomes or contigs) by psi-cd-hit through blastn or megablast </center> </h3>
cd-hit (<a href=\"http://cd-hit.org/\">http://cd-hit.org/</a>) is a very widely used program for clustering and comparing large sets of protein sequences. cd-hit is very fast and can handle extremely large databases. cd-hit helps to significantly reduce the computational and manual efforts in many sequence analysis tasks and aids in understanding the data structure and correct the bias within a dataset.
<br />
<br />
cd-hit and cd-hit-est can not cluster sequences at low sequence identity cutoffs (e.g. 30% for cd-hit), 
they can not cluster very long sequences either (e.g. genome sized DNAs). 
Psi-cd-hit is a script that uses the similar greedy incremental clustering
strategy like cd-hit, but it uses BLAST to calculate the sequence similarities.

<br />
<br />
This server is desinged for clustering very long DNA sequences 

<br />
<h5>Inputs:</h5>
DNA FASTA file (required), can be in .gz format<br/>
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
$opt="-c 0.9 -prog megablast";
$opt_desc="
    -c  sequence identity threshold, default 0.3
    -ce clustering threshold (blast expect), default -1, 
        it means by default it doesn't use expect threshold, 
        but with positive value, the program cluster seqs if similarities
        meet either identity threshold or expect threshold 
    -G  (1/0) use global identity? default 1
        two sequences Long (i.e. representative) and Short (redunant) may have multiple
        alignment fragments (i.e. HSPs), see:
        seq1  xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx   Long sequence
                   ||||||||||||||||||             /////////////          i.e. representative
                   ||||||||||||||||||            /////////////                sequence
                   ||||||||HSP 1 ||||           ////HSP 2 ///
                   ||||||||||||||||||          /////////////
                   ||||||||||||||||||         /////////////
        seq2    xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx          Short sequence
                   <<  length 1    >>        <<   len 2 >>               i.e. redundant
                <<<<<<<<<<<< length of short sequence >>>>>>>>>>>>>>          sequence

                          total identical letters from all co-linear and non-overlapping HSPs
        Glogal identity = -------------------------------------------------------------------
                                        length of short sequence
        Local identity  = identity of the top high score HSP
        if you prefer to use -G 0, it is suggested that you also
        use -aS, -aL, such as -aS 0.8, to prevent very short matches.
    -aL	alignment coverage for the longer sequence, default 0.0
 	if set to 0.9, the alignment must covers 90% of the sequence
    -aS	alignment coverage for the shorter sequence, default 0.0
 	if set to 0.9, the alignment must covers 90% of the sequence
    -g  (1/0), default 0
        by cd-hit's default algorithm, a sequence is clustered to the first 
        cluster that meet the threshold (fast cluster). If set to 1, the program
        will cluster it into the most similar cluster that meet the threshold
        (accurate but slow mode)
        but either 1 or 0 won't change the representatives of final clusters
    -circle (1/0), default 0
        when set to 1, treat sequences as circular sequence.
        bacterial genomes, plasmids are circular, but their genome coordinate maybe arbitary, 
        the 2 HSPs below will be treated as non co-linear with -circle 0
        the 2 HSPs below will be treated as     co-linear with -circle 1
              -------------circle-----------    
              |                            |   
        seq1  xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx      genome / plasmid 1 
               \\\\      /////////////         
                \\\\    /////////////                
                  HSP 2 -> ////HSP 1 ///   <-HSP 2
                          /////////////     \\\\
                         /////////////       \\\\
        seq2           xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx   genome / plasmid 2
                       |                             |
                       -----------circle--------------
   program:
     -prog (blastp, blastn, megablast, blastpgp), default blastp 

";

$cmd='./client_submit_job.pl input.fasta h-cd-hit output.zip "you@example.com" "-d 0 -n 5 -p 1 -G 0 -c 0.90 -aS 0.8" "-d 0 -n 4 -p 1 -G 0 -c 0.60 -aS 0.8"

Notes:
input.fasta: protein input FASTA file (required)
h-cd-hit: program name (required)
output.zip: output file (required)
you@example.com: your email (optional)
"-d 0 -n 5 -p 1 -G 0 -c 0.90 -aS 0.8": parameters for h-cd-hit program at first run (optional)
"-d 0 -n 4 -p 1 -G 0 -c 0.60 -aS 0.8": parameters for h-cd-hit program at second run (optional)

For email and parameters, if they are empty, you must use double quotes like "". If they (empty string) are the last term of command line, you can omit it.
For an example, email is empty:
./client_submit_job.pl input.fasta h-cd-hit output.zip "" "-d 0 -n 5 -p 1 -G 0 -c 0.90 -aS 0.8" "-d 0 -n 4 -p 1 -G 0 -c 0.60 -aS 0.8"
For the second example, paramters are empty:
./client_submit_job.pl input.fasta h-cd-hit output.zip "you@example.com"
For the third example, both email and parameters are empty(using default parameters):
./client_submit_job.pl input.fasta h-cd-hit output.zip
';
?>
