#!/usr/bin/perl -w
## ==============================================================================
## Automated annotation tools
##
## program written by
##                                      Weizhong Li, UCSD
##                                      liwz@sdsc.edu
##                                      http://weizhong-lab.ucsd.edu
## ==============================================================================

my $script_name = $0;
my $script_dir = $0;
   $script_dir =~ s/[^\/]+$//;
   $script_dir = "./" unless ($script_dir);
require "$script_dir/ann_local.pl";

use Getopt::Std;
getopts("i:a:o:e:",\%opts);
die usage() unless ($opts{i} and $opts{o});

my $results_dir  = $opts{i};
my $parse_output = $opts{o};
my $e_cutoff     = $opts{e}; $e_cutoff = 0.001 unless (defined($e_cutoff));
my $overlap_cutoff = 0.5;
die "hmmer3 output results dir $results_dir not found" unless (-e $results_dir);
my ($i, $j, $k, $ll, $cmd);

open(OUT, "> $parse_output") || die "Can not write to $parse_output";
my @os = LL_get_active_ids($results_dir); 
   @os = sort @os;
foreach $i (@os) { parse_it($i);}
close(OUT);

#### using output from hmmscan option --domtblout  -E 0.001 --notextw --cut_tc --noali 
sub parse_it {
  my $id = shift;
  my ($i, $j, $k, $ll);
  my $tout = "$results_dir/$id";

  my $last_seq_id = "";
  my @last_e;
  my @last_b;
  open(TMP, $tout) || next;
  while($ll=<TMP>) {
    chop($ll);
    next if ($ll =~ /^#/);
    my @lls = split(/\s+/, $ll, 23); 
    my $output_looks_like = <<EOD; 
ABC2_membrane        PF01061.19   210 mHE-SRS012902|scaffold|2.77 -            278   2.8e-21   75.6  24.6   1   2   1.9e-25   2.8e-21   75.6  17.1     5   205    27   234    23   239 0.84 ABC-2 type transporter
ABC2_membrane        PF01061.19   210 mHE-SRS012902|scaffold|2.77 -            278   2.8e-21   75.6  24.6   2   2     0.091   1.4e+03   -1.8   1.1   122   149   248   264   234   274 0.46 ABC-2 type transporter
EOD
    my $hmm_name = $lls[0];
    my $hmm_acc  = $lls[1];
    my $hmm_len  = $lls[2];
    my $seq_id   = $lls[3];
    my $seq_len  = $lls[5];
    my $e_value  = $lls[6];
    my $hmm_b    = $lls[15];
    my $hmm_e    = $lls[16];
    my $seq_b    = $lls[17];
    my $seq_e    = $lls[18];
    my $hmm_des  = $lls[22];
    my $hmm_aln_ln = $hmm_e - $hmm_b + 1; 
    next unless ($e_value <= $e_cutoff);

    if ($seq_id ne $last_seq_id) { @last_e = (); @last_b = (); } #### start a new sequence
    my $overlap_with_before = 0;
    for ($j=0; $j<@last_b; $j++) {
      my $lb=$last_b[$j];
      my $le=$last_e[$j];
      if ( overlap1($lb,$le,$seq_b,$seq_e) > ($seq_e-$seq_b+1) * $overlap_cutoff) {
       $overlap_with_before=1; last;
      }
    }
    #print $overlap_with_before ? "$ll***\n": "$ll\n";

    next if ($overlap_with_before);
    print OUT "$ll\n";
    push(@last_e, $seq_e);
    push(@last_b, $seq_b);
    $last_seq_id = $seq_id;
  }
  close(TMP);
}


sub overlap1 {
  my ($b1, $e1, $b2, $e2) = @_;
  return 0 if ($e2 < $b1);
  return 0 if ($b2 > $e1);
  return ( ($e1<$e2)? $e1:$e2 )-( ($b1>$b2)? $b1:$b2);
}

