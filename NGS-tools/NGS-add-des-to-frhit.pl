#!/usr/bin/perl
## =========================== NGS tools ==========================================
## NGS tools for metagenomic sequence analysis
## May also be used for other type NGS data analysis
##
##                                      Weizhong Li, UCSD
##                                      liwz@sdsc.edu
## http://weizhongli-lab.org/
## ================================================================================
## 

#after a frhit run
#add description to the last column

use Getopt::Std;

getopts("i:o:d:f:",\%opts);
die usage() unless ($opts{i} and defined($opts{d}));

my $bl_in    = $opts{i};  # blast -m 8 input
my $fasta    = $opts{d};  # reference fasta
my $output   = $opts{o};  $output = "-" unless (defined($output)); # default is stdout

my %id_in = ();
open(TMP, $bl_in) || die "can not open $bl_in";
while($ll=<TMP>){
  chop($ll);
  my @lls = split(/\t/,$ll);
  $id = $lls[8];
  $id_in{$id} = 1;
}
close(TMP);


my %name_2_des = ();

my ($i, $j, $k, $ll, $cmd);

open(TMP, $fasta) || die "can not open $fasta";
while($ll=<TMP>){
  next unless ($ll =~ /^>/);
  chop($ll);
  $ll =~ s/\s+>gi.+$//; # cut cut extra deflines for NR, refseq etc
  my ($name, $des) = split(/\s+/, $ll, 2);
  $name = substr($name,1);
  next unless ( $id_in{$name} );
  $name_2_des{$name} = $des;
}
close(TMP);

my $fh = "";
if ($output eq "-") { 
  $fh = "STDOUT";
}
else {
  open(OUT, "> $output") || die "can not write to $output";
  $fh = "OUT";
}

open(TMP, $bl_in) || die "can not open $bl_in";
while($ll=<TMP>){
  chop($ll);
  my @lls = split(/\t/,$ll);
  $id = $lls[8];
  $des = $name_2_des{$id};
  print $fh "$ll\t$des\n";
}
close(TMP);

close(OUT) unless ($output eq "-");




