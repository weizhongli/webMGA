<?php
//Overall description for this program
$prog_overview="<h3> <center>OTU finder (cd-hit-otu-miseq)</center> </h3>
cd-hit (<a href=\"http://cd-hit.org/\">http://cd-hit.org/</a>) is a very widely used program for clustering and comparing large sets of protein sequences.
This program clusters miseq sequences to find Operantional Taxonomic Units (OTUs) through multiple steps of clustering and filtering process to 
remove sequences with high sequencing errors.

<br />
<br />
The input need to be processed high quality reads (single end) or merged sequences from paired reads.
<br />
<br />
<h5>Inputs:</h5>
DNA FASTA file (required), can be in .gz format<br/>
<h5>Outputs:</h5>
output.zip will be produced with a README file describing the output files and format
";

$opt="-c 0.97 -a 0.00005 -m true";
$opt_desc="
    -c OTU cutoff, default 0.97
    -m whether to perform chimera checking (true/false), default true
    -a abundance cutoff, default 0.00005
       small clusters < this size will be considiered as noise and will be removed
       if total input sequence is 50,000, then clusters < 2 (i.e. singletons) are removed
";
//Reference
$ref=" 1. \"Ultrafast Clustering Algorithms for Metagenomic Sequence Analysis\", W. Li, L. Fu, B. Niu, S. Wu &amp; J. Wooley
<a href=\"http://bib.oxfordjournals.org/content/13/6/656\">Briefings in Bioinformatics, (2012) 13 (6):656-668.  doi: 10.1093/bib/bbs035</a> <br />
2. \"WebMGA: a Customizable Web Server for Fast Metagenomic Sequence Analysis\", S. Wu, Z. Zhu, L. Fu, B. Niu &amp; W. Li BMC Genomics 2011, 12:444. <a href=\"http://www.biomedcentral.com/content/pdf/1471-2164-12-444.pdf\" target=\"_new\">PDF</a>
<a href=\"http://www.ncbi.nlm.nih.gov/pubmed/21899761?dopt=Abstract\">Pubmed</a> <a href=\"http://scholar.google.com/scholar?cites=6477536281400894883\">Citations</a>
<br />
";

?>
