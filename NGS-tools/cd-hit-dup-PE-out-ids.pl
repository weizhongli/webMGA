#!/usr/bin/perl

my $script_name = $0;
my $script_dir = $0;
   $script_dir =~ s/[^\/]+$//;
   chop($script_dir);
   $script_dir = "./" unless ($script_dir);


use Getopt::Std;
getopts("i:j:o:p:c:t:",\%opts);
die usage() unless ($opts{t} and $opts{o} and $opts{c} );
my ($i, $j, $k, $cmd);
my ($ll, $lla, $llb, $id, $ida, $idb, $seq, $seqa, $seqb, $qua, $quaa, $quab);
my ($len, $lena, $lenb);

my $clstr_file    = $opts{c};
my $outfile       = $opts{o};
my $cutoff        = $opts{t}; $cutoff = 1 unless ($cutoff); #### how many pairs to keep

my @ids = ();
open(TMP, $clstr_file) || die "can not open $clstr_file";
open(OUT, ">$outfile") || die "can not write to $outfile";
while($ll = <TMP>){
  if ($ll =~ /^>/) {
    if (@ids) {
      for ($i=0; $i<=$#ids; $i++) {
        last if ($i == $cutoff);
        print OUT "$ids[$i]\n";
      }
    }
    @ids = ();
  }
  else {
    chop($ll);
    if ($ll =~ /\s(\d+)(aa|nt), >(.+)\.\.\./) {
      my $id = $3;
      if ($ll =~ /\*$/) { unshift(@ids, $id); }
      else              { push(   @ids, $id); }
    }
  }
}
    if (@ids) {
      for ($i=0; $i<=$#ids; $i++) {
        last if ($i == $cutoff);
        print OUT "$ids[$i]\n";
      }
    }
close(TMP);
close(OUT);

sub usage {
<<EOD
This script exports the representative PE reads into two seperate files after running
cd-hit-dup
 
         -c .clstr file produced by cd-hit-dup
         -o output file of representative reads ids
         -t cutoff, default 1
            how many reads to keep in a cluster

EOD
}
######### END usage

