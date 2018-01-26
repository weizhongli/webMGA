#!/usr/bin/perl
################################################################################
# NGS workflow by Weizhong Li, http://weizhongli-lab.org
################################################################################

########## local variables etc. Please edit
$NGS_root     = "/home/oasis/data/NGS-ann-project";
$NGS_root     = $G_NGS_root if ($G_NGS_root); #### taking from command line option from main NGS-wf.pl

########## more local variables, do not edit next three lines
$NGS_tool_dir = "$NGS_root/NGS-tools";
$NGS_prog_dir = "$NGS_root/apps";
$NGS_bin_dir  = "$NGS_root/apps/bin";
$NGS_ref_dir  = "$NGS_root/refs";

########## local settings
$NGS_working_dir = "/home/oasis/data/webcomp/webmga/web-session/metagenomics";
$NGS_max_job_per_ip = 100;
$NGS_job_download_path = "http://weizhongli-lab.org/webMGA/result";
$NGS_www_job_download_dir = "/home/oasis/data/www/home/webMGA/result/output";

########## computation resources for execution of jobs
########## http://wiki.ibest.uidaho.edu/index.php/Tutorials:_SGE_PBS_Converting 
########## converting SGE -> PBS
#
%NGS_executions = ();
$NGS_executions{"qsub_1"} = {
  "type"                => "qsub",
  "cores_per_node"      => 32,
  "ram_per_node"        => 64,
  "number_nodes"        => 64,         #### in GB
  "user"                => "weizhong", #### I will use command such as qstat -u weizhong to query submitted jobs
  "command"             => "/opt/sge6/bin/linux-x64/qsub",
  "command_name_opt"    => "-N",
  "command_err_opt"     => "-e",
  "command_out_opt"     => "-o",
  "template"            => <<EOD,
#!/bin/sh
#PBS -v PATH
#PBS -V

#\$ -v PATH
#\$ -V
##\$ -pe orte 4
EOD
};


########## batch jobs description 
########## jobs will be run for each @NGS_samples
%NGS_batch_jobs = ();

$NGS_batch_jobs{"cd-hit-dup-PE"} = {
  "non_zero_files"    => ["output.clstr"],
  "allowed_opts"      => [qw/-u -e -m/],
  "execution"         => "qsub_1",
  "cores_per_cmd"     => 4,
  "command"           => <<EOD,
$NGS_bin_dir/cd-hit-dup -i \\UPLOADS.0 -i2 \\UPLOADS.1 -o \\SELF/output -u 50 \\CMDOPTS.0 > \\SELF/output.log
$NGS_bin_dir/clstr_sort_by.pl < \\SELF/output.clstr > \\SELF/output-sorted.clstr
rm -f \\SELF/output \\SELF/output2.clstr
mv -f \\SELF/output-sorted.clstr \\SELF/output.clstr
$NGS_tool_dir/cd-hit-dup-PE-out-ids.pl -c \\SELF/output.clstr -o \\SELF/output.ids -t 1
$NGS_tool_dir/NGS-fasta-fetch-by-ids.pl -i \\SELF/output.ids -s \\UPLOADS.0 -o  \\SELF/R1.fa
$NGS_tool_dir/NGS-fasta-fetch-by-ids.pl -i \\SELF/output.ids -s \\UPLOADS.1 -o  \\SELF/R2.fa

EOD
  "tooltip"           => <<EOD,
    -u        Length of prefix to be used in the analysis (default 0, for full/maximum length);
    -m        Match length (true/false, default true);
    -e        Maximum number of mismatches allowd;
EOD
  "readme"            => <<EOD,
output.clstr: clusters of unique read pairs
output.ids: IDs of unique read pairs
R1.fa: R1 reads from unique read pairs
R2.fa: R2 reads from unique read pairs
EOD
};



$NGS_batch_jobs{"cd-hit-dup-SE"} = {
  "non_zero_files"    => ["output.clstr"],
  "allowed_opts"      => [qw/-u -e -m/],
  "execution"         => "qsub_1",
  "cores_per_cmd"     => 4,
  "command"           => <<EOD,
$NGS_bin_dir/cd-hit-dup -i \\UPLOADS.0 -o \\SELF/output -u 50 \\CMDOPTS.0 > \\SELF/output.log
$NGS_bin_dir/clstr_sort_by.pl < \\SELF/output.clstr > \\SELF/output-sorted.clstr
rm -f \\SELF/output2.clstr
mv -f \\SELF/output-sorted.clstr \\SELF/output.clstr
mv -f \\SELF/output \\SELF/R1.fa

EOD
  "tooltip"           => <<EOD,
    -u        Length of prefix to be used in the analysis (default 0, for full/maximum length);
    -m        Match length (true/false, default true);
    -e        Maximum number of mismatches allowd;
EOD
  "readme"            => <<EOD,
output.clstr: clusters of unique read pairs
output.ids: IDs of unique read pairs
R1.fa: R1 reads from unique read pairs
R2.fa: R2 reads from unique read pairs
EOD
};


$NGS_batch_jobs{"metagene"} = {
  "non_zero_files"    => ["ORF.faa"],
  "execution"         => "qsub_1",
  "cores_per_cmd"     => 1,
  "command"           => <<EOD,
$NGS_prog_dir/metagene/metagene_run.pl \\UPLOADS.0 \\SELF/ORF.faa
$NGS_prog_dir/metagene/orf_2_tbl.pl < \\SELF/ORF.faa > \\SELF/ORF.tab
EOD
  "readme"            => <<EOD,
ORF.faa: ORFs in FASTA format
ORF.tab: Text file lists ORF_id, Source ID, start pos, end pos, strand, length
EOD
};


$NGS_batch_jobs{"orf_finder"} = {
  "non_zero_files"    => ["ORF.faa"],
  "allowed_opts"      => [qw/-l -L -X -t -b -e/],
  "execution"         => "qsub_1",
  "cores_per_cmd"     => 1,
  "command"           => <<EOD,
$NGS_prog_dir/orf_finder/orf_finder -i \\UPLOADS.0 -o \\SELF/ORF.faa -M 10000 \\CMDOPTS.0 > \\SELF/log
$NGS_prog_dir/metagene/orf_2_tbl.pl < \\SELF/ORF.faa > \\SELF/ORF.tab
EOD
  "tooltip"           => <<EOD,
  -i input_file, default stdin
  -o output_file, default stdout
  -l minimal length of orf, default 20
  -L minimal length of orf between stop codon, default 40
  -M max_dna_len, in MB, length of the longest input DNA sequence, default 20
  -X max letter X (ratio) default 0.1
  -t translation table, default 1
  -b ORF begin option: default 2
     1: start at the begining of DNA sequence or right after pervious stop codon
     2: start at the begining of DNA sequence or the first ATG after pervious stop codon
        -b 2 is recommanded for prokaryotic
  -e ORF end option: default 1
     1: end at the end of DNA sequence or at a stop codon
     2: must end at a stop codon
EOD
  "readme"            => <<EOD,
ORF.faa: ORFs in FASTA format
ORF.tab: Text file lists ORF_id, Source ID, start pos, end pos, strand, length
EOD
};

$NGS_batch_jobs{"cd-hit"} = {
  "non_zero_files"    => ["output","output.clstr"],
  "allowed_opts"      => [qw/-c -n -b -aS -aL -g -G -s -S -AL -AS -A/],
  "execution"         => "qsub_1",
  "cores_per_cmd"     => 4,
  "command"           => <<EOD,
$NGS_bin_dir/cd-hit -i \\UPLOADS.0 -o \\SELF/output -c 0.9 -n 5 -d 0 -p 1 -T 4 -M 16000 \\CMDOPTS.0 > \\SELF/output.log
$NGS_bin_dir/clstr_sort_by.pl < \\SELF/output.clstr > \\SELF/output-sorted.clstr

#OLD webmga cmd lines
#echo "#sequence\tlength\tcluster\trepresentative" > $output1_txt
#$SL_rammcap_dir/cd-hit_wst_v0/clstr_sql_tbl.pl $output1.clstr $output1_txt.$$
#cat $output1_txt.$$ >> $output1_txt

EOD
  "tooltip"           => <<EOD,
EOD
  "readme"            => <<EOD,
output: representative sequences
output.clstr: clusters sorted by sequence length
output-sorted.clstr: clusters sorted by cluster size
EOD
};

$NGS_batch_jobs{"h-cd-hit"} = {
  "non_zero_files"    => ["output","output.clstr"],
  "allowed_opts"      => [qw/-c -n -b -aS -aL -g -G -s -S -AL -AS -A/],
  "execution"         => "qsub_1",
  "cores_per_cmd"     => 4,
  "command"           => <<EOD,
$NGS_bin_dir/cd-hit -i \\UPLOADS.0     -o \\SELF/output.1 -c 0.9 -n 5 -d 0 -p 1 -T 4 -M 16000 \\CMDOPTS.0 > \\SELF/output1.log
$NGS_bin_dir/cd-hit -i \\SELF/output.1 -o \\SELF/output.2 -c 0.6 -n 4 -d 0 -p 1 -T 4 -M 16000 \\CMDOPTS.1 > \\SELF/output2.log
$NGS_prog_dir/cd-hit/clstr_rev.pl \\SELF/output.1.clstr \\SELF/output.2.clstr > \\SELF/output.clstr
$NGS_bin_dir/clstr_sort_by.pl < \\SELF/output.clstr > \\SELF/output-sorted.clstr
mv -f \\SELF/output-sorted.clstr \\SELF/output.clstr
mv -f \\SELF/output.2 \\SELF/output

#OLD webmga cmd lines
#echo "#sequence\tlength\tcluster\trepresentative" > $output1_txt
#$SL_rammcap_dir/cd-hit_wst_v0/clstr_sql_tbl.pl $output1.clstr $output1_txt.$$
#cat $output1_txt.$$ >> $output1_txt

EOD
  "tooltip"           => <<EOD,
EOD
  "readme"            => <<EOD,
output: representative sequences
output.clstr: clusters sorted by sequence length
output-sorted.clstr: clusters sorted by cluster size
EOD
};



$NGS_batch_jobs{"h3-cd-hit"} = {
  "non_zero_files"    => ["output","output.clstr"],
  "allowed_opts"      => [qw/-c -n -b -aS -aL -g -G -s -S -AL -AS -A/],
  "execution"         => "qsub_1",
  "cores_per_cmd"     => 4,
  "command"           => <<EOD,
$NGS_bin_dir/cd-hit                    -i \\UPLOADS.0     -o \\SELF/output.1 -c 0.9 -n 5 -d 0 -p 1 -T 4 -M 16000 \\CMDOPTS.0 > \\SELF/output1.log
$NGS_bin_dir/cd-hit                    -i \\SELF/output.1 -o \\SELF/output.2 -c 0.6 -n 4 -d 0 -p 1 -T 4 -M 16000 \\CMDOPTS.1 > \\SELF/output2.log
$NGS_prog_dir/psi-cd-hit/psi-cd-hit.pl -i \\SELF/output.2 -o \\SELF/output.3 -c 0.3 -P $NGS_bin_dir -core 4 \\CMDOPTS.2 > \\SELF/output3.log
$NGS_prog_dir/cd-hit/clstr_rev.pl \\SELF/output.1.clstr       \\SELF/output.2.clstr > \\SELF/output.2-full.clstr
$NGS_prog_dir/cd-hit/clstr_rev.pl \\SELF/output.2-full.clstr  \\SELF/output.3.clstr > \\SELF/output.clstr
$NGS_bin_dir/clstr_sort_by.pl < \\SELF/output.clstr > \\SELF/output-sorted.clstr
mv -f \\SELF/output-sorted.clstr \\SELF/output.clstr
mv -f \\SELF/output.3 \\SELF/output

#OLD webmga cmd lines
#echo "#sequence\tlength\tcluster\trepresentative" > $output1_txt
#$SL_rammcap_dir/cd-hit_wst_v0/clstr_sql_tbl.pl $output1.clstr $output1_txt.$$
#cat $output1_txt.$$ >> $output1_txt

EOD
  "tooltip"           => <<EOD,
EOD
  "readme"            => <<EOD,
output: representative sequences
output.clstr: clusters sorted by sequence length
output-sorted.clstr: clusters sorted by cluster size
EOD
};


$NGS_batch_jobs{"psi-cd-hit-DNA"} = {
  "non_zero_files"    => ["output","output.clstr"],
  "allowed_opts"      => [qw/-c -aS -aL -g -G/],
  "execution"         => "qsub_1",
  "cores_per_cmd"     => 4,
  "command"           => <<EOD,
$NGS_prog_dir/psi-cd-hit/psi-cd-hit.pl -i \\UPLOADS.0  -o \\SELF/output -c 0.9 -prog megablast -P $NGS_bin_dir -core 4 \\CMDOPTS.0 > \\SELF/output.log
$NGS_bin_dir/clstr_sort_by.pl < \\SELF/output.clstr > \\SELF/output-sorted.clstr
mv -f \\SELF/output-sorted.clstr \\SELF/output.clstr

EOD
  "tooltip"           => <<EOD,
EOD
  "readme"            => <<EOD,
output: representative sequences
output.clstr: clusters sorted by sequence length
output-sorted.clstr: clusters sorted by cluster size
EOD
};


$NGS_batch_jobs{"psi-cd-hit-protein"} = {
  "non_zero_files"    => ["output","output.clstr"],
  "allowed_opts"      => [qw/-c -aS -aL -g -G/],
  "execution"         => "qsub_1",
  "cores_per_cmd"     => 4,
  "command"           => <<EOD,
$NGS_prog_dir/psi-cd-hit/psi-cd-hit.pl -i \\UPLOADS.0  -o \\SELF/output -c 0.3 -P $NGS_bin_dir -core 4 \\CMDOPTS.0 > \\SELF/output.log
$NGS_bin_dir/clstr_sort_by.pl < \\SELF/output.clstr > \\SELF/output-sorted.clstr
mv -f \\SELF/output-sorted.clstr \\SELF/output.clstr

EOD
  "tooltip"           => <<EOD,
EOD
  "readme"            => <<EOD,
output: representative sequences
output.clstr: clusters sorted by sequence length
output-sorted.clstr: clusters sorted by cluster size
EOD
};



$NGS_batch_jobs{"cd-hit-est"} = {
  "non_zero_files"    => ["output","output.clstr"],
  "allowed_opts"      => [qw/-c -n -b -aS -aL -g -G -s -S -AL -AS -A -r/],
  "execution"         => "qsub_1",
  "cores_per_cmd"     => 4,
  "command"           => <<EOD,
$NGS_bin_dir/cd-hit-est -i \\UPLOADS.0 -o \\SELF/output -c 0.9 -n 10 -d 0 -p 1 -T 4 -r 1 -M 16000 \\CMDOPTS.0 > \\SELF/output.log
$NGS_bin_dir/clstr_sort_by.pl < \\SELF/output.clstr > \\SELF/output-sorted.clstr

#OLD webmga cmd lines
#echo "#sequence\tlength\tcluster\trepresentative" > $output1_txt
#$SL_rammcap_dir/cd-hit_wst_v0/clstr_sql_tbl.pl $output1.clstr $output1_txt.$$
#cat $output1_txt.$$ >> $output1_txt

EOD
  "tooltip"           => <<EOD,
EOD
  "readme"            => <<EOD,
output: representative sequences
output.clstr: clusters sorted by sequence length
output-sorted.clstr: clusters sorted by cluster size
EOD
};


$NGS_batch_jobs{"cd-hit-otu-miseq"} = {
  "non_zero_files"    => ["OTU.clstr","OTU-dist.txt","OTU.fa"],
  "allowed_opts"      => [qw/-c -a/],
  "execution"         => "qsub_1",
  "cores_per_cmd"     => 4,
  "command"           => <<EOD,
$NGS_prog_dir/cd-hit-otu-miseq/cd-hit-otu-miseq.pl -i \\UPLOADS.0 -o \\SELF -c 0.97 -m true -a 0.00005 -d "-M 16000 -T 4" \\CMDOPTS.0  > \\SELF/output.log
$NGS_bin_dir/fr-hit -T 4 -r 5 -m 35 -c 85 -p 8 -d $NGS_ref_dir/silva/LSURef_SSURef99_trunc.faa -a \\SELF/OTU.fa -o \\SELF/OTU-vs-silva 
$NGS_tool_dir/NGS-add-des-to-frhit.pl -i \\SELF/OTU-vs-silva -o \\SELF/OTU-vs-silva-long -d $NGS_ref_dir/silva/LSURef_SSURef99_trunc.faa
$NGS_prog_dir/cd-hit-otu-miseq/silva1.pl < \\SELF/OTU-vs-silva-long > \\SELF/OTU-vs-silva-long.txt

EOD
  "tooltip"           => <<EOD,
EOD
  "readme"            => <<EOD,
output: representative sequences
output.clstr: clusters sorted by sequence length
output-sorted.clstr: clusters sorted by cluster size
EOD
};





$NGS_batch_jobs{"cog"} = {
  "non_zero_files"    => ["cog.txt"],
  "allowed_opts"      => [qw/-evalue/],
  "execution"         => "qsub_1",
  "cores_per_cmd"     => 4,
  "command"           => <<EOD,
mkdir \\SELF/orf-split
$NGS_bin_dir/cd-hit-div.pl \\UPLOADS.0  \\SELF/orf-split/split 64

for i in {1..4};
do
  $NGS_tool_dir/ann_batch_run_dir.pl --INDIR1=\\SELF/orf-split --OUTDIR1=\\SELF/cog --CPU=\\SELF/WF.cpu $NGS_prog_dir/blast+/bin/rpsblast -query {INDIR1} -out {OUTDIR1} \\
    -db $NGS_ref_dir/db/Cog -num_threads 1 -num_alignments 20 -outfmt 6 \\CMDOPTS.0 &
done;
wait
$NGS_tool_dir/ann_parse_cdd.pl -i \\SELF/cog -o \\SELF/cog.txt -d $NGS_ref_dir/db/Cog.faa
$NGS_tool_dir/ann_parse_cdd_class.pl         -i \\SELF/cog.txt -n $NGS_ref_dir/db/Cog-class -d $NGS_ref_dir/db/Cog-class-info -o \\SELF/cog-class.txt
$NGS_tool_dir/ann_parse_cdd-raw.pl -i \\SELF/cog -o \\SELF/cog-raw.txt -d $NGS_ref_dir/db/Cog.faa
rm -rf \\SELF/orf-split \\SELF/cog
#to be added back from RAMMCAP scripts
#$SL_script_dir/cdd_ann_parse_post_COG_wst_v0.pl -i $output1 -o $output2 -d $SL_rammcap_dir/meta_data2/info_COG.txt
EOD
  "readme"            => <<EOD,
cog.txt: COG family annotation
cog-class.txt: COG class annotation
cog-raw.txt: blast output
EOD
};

$NGS_batch_jobs{"kog"} = {
  "non_zero_files"    => ["kog.txt"],
  "allowed_opts"      => [qw/-evalue/],
  "execution"         => "qsub_1",
  "cores_per_cmd"     => 4,
  "command"           => <<EOD,
mkdir \\SELF/orf-split
$NGS_bin_dir/cd-hit-div.pl \\UPLOADS.0  \\SELF/orf-split/split 64

for i in {1..4};
do
  $NGS_tool_dir/ann_batch_run_dir.pl --INDIR1=\\SELF/orf-split --OUTDIR1=\\SELF/kog --CPU=\\SELF/WF.cpu $NGS_prog_dir/blast+/bin/rpsblast -query {INDIR1} -out {OUTDIR1} \\
    -db $NGS_ref_dir/db/Kog -num_threads 1 -num_alignments 20 -outfmt 6 \\CMDOPTS.0 &
done;
wait
$NGS_tool_dir/ann_parse_cdd.pl -i \\SELF/kog -o \\SELF/kog.txt -d $NGS_ref_dir/db/Kog.faa
$NGS_tool_dir/ann_parse_cdd_class.pl         -i \\SELF/kog.txt -n $NGS_ref_dir/db/Kog-class -d $NGS_ref_dir/db/Kog-class-info -o \\SELF/kog-class.txt
$NGS_tool_dir/ann_parse_cdd-raw.pl -i \\SELF/kog -o \\SELF/kog-raw.txt -d $NGS_ref_dir/db/Kog.faa
rm -rf \\SELF/orf-split \\SELF/kog
EOD
  "readme"            => <<EOD,
kog.txt: COG family annotation
kog-class.txt: COG class annotation
kog-raw.txt: blast output
EOD
};


$NGS_batch_jobs{"prk"} = {
  "non_zero_files"    => ["prk.txt"],
  "allowed_opts"      => [qw/-evalue/],
  "execution"         => "qsub_1",
  "cores_per_cmd"     => 4,
  "command"           => <<EOD,
mkdir \\SELF/orf-split
$NGS_bin_dir/cd-hit-div.pl \\UPLOADS.0  \\SELF/orf-split/split 64

for i in {1..4};
do
  $NGS_tool_dir/ann_batch_run_dir.pl --INDIR1=\\SELF/orf-split --OUTDIR1=\\SELF/prk --CPU=\\SELF/WF.cpu $NGS_prog_dir/blast+/bin/rpsblast -query {INDIR1} -out {OUTDIR1} \\
    -db $NGS_ref_dir/db/Prk -num_threads 1 -num_alignments 20 -outfmt 6 \\CMDOPTS.0 &
done;
wait
$NGS_tool_dir/ann_parse_cdd.pl -i \\SELF/prk -o \\SELF/prk.txt -d $NGS_ref_dir/db/Prk.faa
$NGS_tool_dir/ann_parse_cdd-raw.pl -i \\SELF/prk -o \\SELF/prk-raw.txt -d $NGS_ref_dir/db/Prk.faa
rm -rf \\SELF/orf-split \\SELF/prk
EOD
  "readme"            => <<EOD,
prk.txt: COG family annotation
prk-raw.txt: blast output
EOD
};

$NGS_batch_jobs{"pfam"} = {
  "non_zero_files"    => ["pfam.txt"],
  "allowed_opts"      => [qw/-E/],
  "execution"         => "qsub_1",
  "cores_per_cmd"     => 4,
  "command"           => <<EOD,
mkdir \\SELF/orf-split
$NGS_bin_dir/cd-hit-div.pl \\UPLOADS.0  \\SELF/orf-split/split 64

for i in {1..4};
do
  $NGS_tool_dir/ann_batch_run_dir.pl --INDIR1=\\SELF/orf-split --OUTDIR1=\\SELF/pfam --OUTDIR2=\\SELF/pfam.2 --OUTDIR3=\\SELF/pfam.3 --CPU=\\SELF/WF.cpu --CPU=\\SELF/WF.cpu  \\
    $NGS_bin_dir/hmmscan \\CMDOPTS.0 -o {OUTDIR1} --notextw --noali --cpu 1 --tblout {OUTDIR2} --domtblout {OUTDIR3} $NGS_ref_dir/db/Pfam-A.hmm {INDIR1} &
done;
wait
$NGS_tool_dir/ann_parse_hmm.pl -i \\SELF/pfam.3 -o \\SELF/pfam.txt
$NGS_tool_dir/ann_parse_hmm-raw.pl -i \\SELF/pfam.3 -o \\SELF/pfam-raw.txt
#to be added back from RAMMCAP scripts
#$SL_script_dir/hmm_ann_parse_wst_v0.pl $SL_rammcap_dir/HMM_lib/$fam_db $input1 $output1 $E > $log 2>&1
#$SL_script_dir/ann_2_go_wst_v0.pl $output1 > $output2
#$SL_script_dir/go_2_ec_wst_v0.pl $output2 > $output3

EOD
  "readme"            => <<EOD,
pfam.txt: PFAM family annotation
pfam-raw.txt: hmmer output
EOD
};


$NGS_batch_jobs{"tigrfam"} = {
  "non_zero_files"    => ["tigrfam.txt"],
  "allowed_opts"      => [qw/-E/],
  "execution"         => "qsub_1",
  "cores_per_cmd"     => 4,
  "command"           => <<EOD,
mkdir \\SELF/orf-split
$NGS_bin_dir/cd-hit-div.pl \\UPLOADS.0  \\SELF/orf-split/split 64

for i in {1..4};
do
  $NGS_tool_dir/ann_batch_run_dir.pl --INDIR1=\\SELF/orf-split --OUTDIR1=\\SELF/tigrfam --OUTDIR2=\\SELF/tigrfam.2 --OUTDIR3=\\SELF/tigrfam.3 --CPU=\\SELF/WF.cpu --CPU=\\SELF/WF.cpu  \\
    $NGS_bin_dir/hmmscan \\CMDOPTS.0 -o {OUTDIR1} --notextw --noali --cpu 1 --tblout {OUTDIR2} --domtblout {OUTDIR3} $NGS_ref_dir/db/TIGRFAMs_9.0_HMM.LIB {INDIR1} &
done;
wait
$NGS_tool_dir/ann_parse_hmm.pl -i \\SELF/tigrfam.3 -o \\SELF/tigrfam.txt
$NGS_tool_dir/ann_parse_hmm-raw.pl -i \\SELF/tigrfam.3 -o \\SELF/tigrfam-raw.txt
EOD
  "readme"            => <<EOD,
tigrfam.txt: TIGRFAM family annotation
tigrfam-raw.txt: hmmer output
EOD
};


###########BELOW THIS LINE ARE WORKING PROGRESS





##############################################################################################
########## END
1;










