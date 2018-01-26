#!/usr/bin/perl

## =========================== NGS tools ==========================================
### NGS tools for metagenomic sequence analysis
### May also be used for other type NGS data analysis
###
###                                      Weizhong Li, UCSD
###                                      liwz@sdsc.edu
### http://weizhongli-lab.org/
### ================================================================================

use CGI;
use DBI;
use DBD::mysql;
use Email::Valid;
use POSIX;

my $script_name = $0;
my $script_dir = $0;
   $script_dir =~ s/[^\/]+$//;
   $script_dir = "./" unless ($script_dir);
my $input_conf   = "$script_dir/NGS-web-wf-webmga-v1.0.pl";
require $input_conf;

my $i, $j, $k, $ll, $cmd, $th, $counter, $status, $ip, $job_id, $job_dir;

print "Content-type: text/html\n\n";
my $IN = new CGI;
my $program  = $IN->param('PROGRAM');
my $email    = $IN->param('EMAIL');
my $seqfile  = $IN->param('SEQ_FILE');
my $seqfile2 = $IN->param('SEQ_FILE2');
my $cmd_opt  = $IN->param('OPT');
my $cmd_opt2 = $IN->param('OPT2');
my $cmd_opt3 = $IN->param('OPT3');
my $cmd_opt4 = $IN->param('OPT4');
my $cmd_opt5 = $IN->param('OPT5');
my $cmd_opt6 = $IN->param('OPT6');
my $cmd_opt7 = $IN->param('OPT7');
my $cmd_opt8 = $IN->param('OPT8');
my $cmd_opt9 = $IN->param('OPT9');

$CGI::POST_MAX = 1024 * 1024 * 1024 * 4;
my $tmpfile = $IN->tmpFileName($seqfile);

if($email and (!Email::Valid->address($email))) {my_exit("Error! Please give your email address!");}
if(!$seqfile                                  ) {my_exit("Error! Please upload your sequence!");   }
if(!check_opt($cmd_opt)                       ) {my_exit("Error! Parameter set is wrong!");        }
if(!check_opt($cmd_opt2)                      ) {my_exit("Error! Parameter set 2 is wrong!");      }
if(!check_opt($cmd_opt3)                      ) {my_exit("Error! Parameter set 3 is wrong!");      }
if(!check_opt($cmd_opt4)                      ) {my_exit("Error! Parameter set 4 is wrong!");      }
if(!check_opt($cmd_opt5)                      ) {my_exit("Error! Parameter set 5 is wrong!");      }
if(!check_opt($cmd_opt6)                      ) {my_exit("Error! Parameter set 6 is wrong!");      }
if(!check_opt($cmd_opt7)                      ) {my_exit("Error! Parameter set 7 is wrong!");      }
if(!check_opt($cmd_opt8)                      ) {my_exit("Error! Parameter set 8 is wrong!");      }
if(!check_opt($cmd_opt9)                      ) {my_exit("Error! Parameter set 9 is wrong!");      }
if(!$program                                  ) {my_exit("Error! no program specified!");          }


my $dbh = DBI->connect($NGS_mysql_connect_info, $NGS_mysql_userid, $NGS_mysql_passwd, { RaiseError => 1, AutoCommit => 0}) || 
  my_exit("Unalbe to connect to $DataBaseHost because $DBI::errstr");

$ip = $ENV{'REMOTE_ADDR'};
$th = $dbh->prepare(qq{SELECT COUNT(ip_address) FROM log WHERE ip_address = '$ip' && (status = 'R' || status = 'W') });
$th->execute();
$cc = $th->fetchrow_array();
my_exit_n_db("Error! Each IP (yours is $ip) can submit at most $MAXJOB jobs. Please wait until one of these jobs is finished!") if ($cc > $NGS_max_job_per_ip);

#### mkdir and write uploaded files
$job_id = random_ID(); $job_dir = "$NGS_working_dir/$job_id"; $cmd = `mkdir -p $job_dir`;
prepare_upload_files($seqfile, $seqfile2);

#### log
my $f_log = "$job_dir/LOG"; $cmd = `date >> $f_log`;
open(OUT, ">> $f_log");
print OUT "program\t$program\n";
print OUT "Seqfile\t$seqfile\n"          if ($seqfile);
print OUT "Seqfile2\t$seqfile2\n"        if ($seqfile2);
print OUT "Parameter set\t$cmd_opt\n"    if ($cmd_opt);
print OUT "Parameter set 2\t$cmd_opt2\n" if ($cmd_opt2);
print OUT "Parameter set 2\t$cmd_opt3\n" if ($cmd_opt3);
print OUT "Parameter set 2\t$cmd_opt4\n" if ($cmd_opt4);
print OUT "Parameter set 2\t$cmd_opt5\n" if ($cmd_opt5);
print OUT "Parameter set 2\t$cmd_opt6\n" if ($cmd_opt6);
print OUT "Parameter set 2\t$cmd_opt7\n" if ($cmd_opt7);
print OUT "Parameter set 2\t$cmd_opt8\n" if ($cmd_opt8);
print OUT "Parameter set 2\t$cmd_opt9\n" if ($cmd_opt9);
foreach $i (keys %ENV) { print OUT "Environmental:$i\t$ENV{$i}\n";}
close(OUT);

#### prepare sh script and submit
my ($t_sample_id, $t_job_id, $t_execution_id);
my ($t_sample,    $t_job,    $t_execution, $t_sh_file);
if (1) {
  $t_job_id = $program;
  $t_job = $NGS_batch_jobs{$t_job_id};
  my_exit_n_db("$t_job_id not defined") unless (defined($t_job));
  $t_execution = $NGS_executions{ $t_job->{"execution"} };

  open(README, "> $job_dir/README") || die "can not write to $job_dir/README";
  print README $t_job->{"readme"};
  close(README);

  my $c1 = $t_job->{"command"};
     $c1 =~ s/\\SELF/$t_job_id/g;

     $c1 =~ s/\\UPLOADS\.0/input.0/g; $c1 =~ s/\\UPLOADS\.10/input.10/g;
     $c1 =~ s/\\UPLOADS\.1/input.1/g; $c1 =~ s/\\UPLOADS\.11/input.11/g;
     $c1 =~ s/\\UPLOADS\.2/input.2/g; $c1 =~ s/\\UPLOADS\.12/input.12/g;
     $c1 =~ s/\\UPLOADS\.3/input.3/g; $c1 =~ s/\\UPLOADS\.13/input.13/g;
     $c1 =~ s/\\UPLOADS\.4/input.4/g; $c1 =~ s/\\UPLOADS\.14/input.14/g;
     $c1 =~ s/\\UPLOADS\.5/input.5/g; $c1 =~ s/\\UPLOADS\.15/input.15/g;
     $c1 =~ s/\\UPLOADS\.6/input.6/g; $c1 =~ s/\\UPLOADS\.16/input.16/g;
     $c1 =~ s/\\UPLOADS\.7/input.7/g; $c1 =~ s/\\UPLOADS\.17/input.17/g;
     $c1 =~ s/\\UPLOADS\.8/input.8/g; $c1 =~ s/\\UPLOADS\.18/input.18/g;
     $c1 =~ s/\\UPLOADS\.9/input.9/g; $c1 =~ s/\\UPLOADS\.19/input.19/g;

     $c1 =~ s/\\CMDOPTS\.0/$cmd_opt/g;
     $c1 =~ s/\\CMDOPTS\.1/$cmd_opt2/g;
     $c1 =~ s/\\CMDOPTS\.2/$cmd_opt3/g;
     $c1 =~ s/\\CMDOPTS\.3/$cmd_opt4/g;
     $c1 =~ s/\\CMDOPTS\.4/$cmd_opt5/g;
     $c1 =~ s/\\CMDOPTS\.5/$cmd_opt6/g;
     $c1 =~ s/\\CMDOPTS\.6/$cmd_opt7/g;
     $c1 =~ s/\\CMDOPTS\.7/$cmd_opt8/g;
     $c1 =~ s/\\CMDOPTS\.8/$cmd_opt9/g;
     
  $t_sh_file  = "$job_dir/job.sh";
  my $f_start    = "$job_dir/WF.start.date";
  my $f_complete = "$job_dir/WF.complete.date";
  my $f_cpu      = "$job_dir/WF.cpu";
  my $f_stderr   = "$job_dir/WF.stderr";
  my $f_stdout   = "$job_dir/WF.stdout";
  my $f_queued   = "$job_dir/WF.queued";

  my $v_command = "";
  foreach my $vf (@{$t_job->{"non_zero_files"}}) {
    $v_command .= "if ! [ -s $t_job_id/$vf ]; then echo \"zero size $t_job_id/$vf\"; exit; fi\n";
  }

  open(TSH, "> $t_sh_file") || die "can not write to $t_sh_file\n";
  print TSH <<EOD;
$t_execution->{"template"}
#\$ -pe orte $t_job->{cores_per_cmd}

cd $job_dir
mkdir $t_job_id
if ! [ -f $f_start ]; then date +\%s > $f_start;  fi
$c1
$v_command
date +\%s > $f_complete
times >> $f_cpu
grep -v "^Environmental" $f_log > $job_dir/$t_job_id/LOG
mv $job_dir/README $t_job_id
zip $job_dir/$job_id.zip $t_job_id/*
ln -s $job_dir/$job_id.zip $NGS_www_job_download_dir

EOD
  close(TSH);


  $cmd = `$t_execution->{"command"} $t_execution->{"command_name_opt"} $t_job_id $t_execution->{"command_err_opt"} $f_stderr $t_execution->{"command_out_opt"} $f_stdout $t_sh_file 2>$job_dir/qsub.err 1>$job_dir/qsub.out`;
  $cmd = `date +\%s > $f_queued`;
} #### END if (1)


$t1 = `date +20%y/%m/%d`; $t1 =~ s/\s//g;
$t2 = `date +%H:%M:%S`;   $t2 =~ s/\s//g;
$dbh->do("INSERT INTO log (ip_address, submission_date, submission_time, program_name, file_name, job_id,   status,cmd_opt,   cmd_opt2,   email,   from_web, random_dir, file_name2) 
                   VALUES ('$ip',      '$t1',           '$t2',           '$program',   '$seqfile','$job_id','W',   '$cmd_opt','$cmd_opt2','$email','1',      '$job_id', '$seqfile2')");
$dbh->disconnect();


print <<EOD;
Your job has been submitted. Your job id is $job_id. You can check <a href="$NGS_job_download_path/?jobid=$job_id">job status</a>.
EOD

if($email){
    open(MAIL, "|/usr/sbin/sendmail -t");
    print MAIL <<EOD;
To: $email
From: liwz\@sdsc.edu
Subject: WebMGA jot status

Dear User, 
  Your job of "$program" has started. The job id is $job_id. You can check job status from "/webMGA/result/?jobid=$job_id".
  Thanks,
EOD
    close(MAIL);
}   

########## finished


sub random_ID{
   my $id0 = int(rand() * 1000000);
   my $id1 = `date +%C%y%m%d%H%M%S`; chop($id1);
   my $sid = $id1 . sprintf("%6s",$id0) . sprintf("%6s",$$); $sid =~ s/ /0/g;
   return $sid;
}
########## END random_ID

sub check_opt {
  my $cmd = shift;
  if ($cmd =~ /\S/) {  
    if ($cmd =~ /^( |-|_|\.|\d|\w)+$/ ) { return 1; }
    else                                { return 0; }
  }
  else {
    return 1;
  }
}
########## END check_opt

sub my_exit {
  my $message = shift;
  print $message, "\n";
  exit 1;
}
########## END my_exit;

sub my_exit_n_db {
  my $message = shift;
  print $message, "\n";
  $dbh->disconnect(); 
  exit 1;
}
########## END my_exit_n_db;


sub prepare_upload_files {
  my @up_files = @_;
  my ($i, $j, $k);

  for ($i=0; $i<@up_files; $i++) {
    my $fh = $up_files[$i];
    next unless $fh;
    my $f1 = "$NGS_working_dir/$job_id/input.$i";
    open(wfl, "> $f1") || my_exit("Error! can not write to $f1");
    while($line = <$fh>){ print wfl $line; }
    close(wfl);

    if ($fh =~ /\.gz$/) {
      my $cmd = `gunzip < $f1 > $f1-raw`;
         $cmd = `mv $f1-raw $f1`;
    }
  }
}
########## END prepare_upload_files

