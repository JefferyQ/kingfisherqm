#!/usr/bin/perl

use warnings;
use strict;

use Cwd;
use File::Copy;
use File::Copy::Recursive qw/ dircopy /;


my $dir = getcwd();
my $cups_backend_dir = '/usr/lib/cups/backend/';


print "\n\nCoping files...wait.\n";
dircopy($dir.'/etc', '/etc/') or die $!;
dircopy($dir.'/usr', '/usr/') or die $!;


my @backends = glob($cups_backend_dir.'*');
my $ipp_backend = 0;
foreach(@backends) {
    $ipp_backend = 1 if /\/ipp$/;
}

if(!$ipp_backend) {
    print "Apparently $cups_backend_dir is not a CUPS backend dir.\n";
    print "Enter correct CUPS backend dir path [$cups_backend_dir]:";
    my $backend_dir = <STDIN>;
    chomp($backend_dir);
    if($backend_dir != /^$/) {
        system('mv '.$cups_backend_dir.'kfbackend '.$backend_dir);
    }
}

print "Creating directory /var/spool/kingfisher\n";
mkdir('/var/spool/kingfisher');
chmod(0777, '/var/spool/kingfisher');

print "\n\nIMPORTANT:\nNow, create tables in database with /usr/share/doc/kingfisher/kingfisher.pg.sql\n";
print "And edit /etc/kingfisher/kingfisher.conf and /usr/share/kingfisher/inc/config.inc.php\n\n";
print "Init Kingfisher Daemon with: /etc/init.d/kingfisherd start\n\n";
