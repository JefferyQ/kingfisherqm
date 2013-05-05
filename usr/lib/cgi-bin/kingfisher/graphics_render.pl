#!/usr/bin/perl
#
#
#
# Kingfisher Quota Manager
#
# (c) 2008 Geovanny Junio <geovanny@eutsiv.com.br>
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#



use strict;
use warnings;
use CGI qw/ :standard /;
use GD::Graph::bars3d; 
use GD::Graph::colour qw/ :lists /;
use DBI; 

# Variables
my($db_host, $db_name, $db_user, $db_pass);

open(CONF, '</etc/kingfisher/kingfisher.conf') or die "Can't open /etc/kingfisher/kingfisher.conf: $!";
    while(<CONF>) {
        chomp;
        next if /^\s*(#|$)/;
	next if /^#/;

	if(/^DB_HOST:\s*\w+/) {
            (undef, $db_host) = split /:\s*/;
	}
	elsif(/^DB_NAME:\s*\w+/) {
            (undef, $db_name) = split /:\s*/;
	}
	elsif(/^DB_USER:\s*\w+/) {
            (undef, $db_user) = split /:\s*/;
	}
	elsif(/^DB_PASS:\s*\w+/) {
            (undef, $db_pass) = split /:\s*/;
	}
    }
close(CONF);


my $type = param('type');
my $byear = param('byear'); 
my $bmonth = param('bmonth');
my $bday = param('bday');
my $bhour = param('bhour');
my $eyear = param('eyear');
my $emonth = param('emonth');
my $eday = param('eday');
my $ehour = param('ehour');
my($field, $bdate, $btime, $edate, $etime);


if($type eq 'users') {
    $field = 'username';
}
elsif($type eq 'printers') {
    $field = 'printername';
}
elsif($type eq 'paperformats') {
    $field = 'paperformatname';
}

# Formatting Date - Begin
if($byear !~ /^\s*$/) {
    if($bmonth !~ /^\s*$/) {
	if($bday !~ /^\s*$/) {
	    $bdate = $byear.'-'.$bmonth.'-'.$bday;
	    if($bhour !~ /^\s*$/) {
		$btime = $bhour.':00:00';
	    }
	    else {
		$btime = '00:00:00';
	    }
	}
	else {
	    $bdate = $byear.'-'.$bmonth.'-01';
	    $btime = '00:00:00';
	}
    }
    else {
	$bdate = $byear.'01-01';
	$btime = '00:00:00';
    }
}
else {
    $bdate = '0001-01-01';
    $btime = '00:00:00';
}


# Formatting Date - End
if($eyear !~ /^\s*$/) {
    if($emonth !~ /^\s*$/) {
	if($eday !~ /^\s*$/) {
	    $edate = $eyear.'-'.$emonth.'-'.$eday;
	    if($ehour !~ /^\s*$/) {
		$etime = $ehour.':59:59';
	    }
	    else {
		$etime = '23:59:59';
	    }
	}
	else {
	    $edate = $eyear.'-'.$emonth.'-31';
	    $etime = '23:59:59';
	}
    }
    else {
	$edate = $eyear.'12-31';
	$etime = '23:59:59';
    }
}
else {
    my($mday, $mon, $year);

    (undef, undef, undef, $mday, $mon, $year, undef, undef, undef) = localtime();

    $year += 1900;
    $mon++;

    $mday = sprintf "%02d", $mday;
    $mon = sprintf "%02d", $mon;

    $edate = "$year-$mon-$mday";
    $etime = '23:59:59';
}

    my(@values, @fields);

    my $dbh = DBI->connect("dbi:Pg:dbname=$db_name;host=$db_host", $db_user, $db_pass, { AutoCommit => 0 } ) or die;
    my $sth = $dbh->prepare("SELECT $field, sum(total_pages) as total_pages from printlogs, $type where printlogs.".$type."_id=$type.id and job_date between '$bdate' and '$edate' and job_time between '$btime' and '$etime' group by $field  order by total_pages desc limit 10");
    $sth->execute() or die;

    my @result;
    while( @result = $sth->fetchrow_array()) {
	push @fields, $result[0].' ('.$result[1].')';
	push @values, $result[1];
    }

    $dbh->disconnect();


my @graf = (['']);
my $i = 1;
my $y_max_value = 0;

foreach(@values) {
    $graf[$i][0] = $_;
    $i++;

    $y_max_value = $_ if($_ > $y_max_value);
}

$y_max_value += 100;

$y_max_value++ while($y_max_value%10 != 0);

###############################################################

############################ Criação da imagem ######################
my $grafico = GD::Graph::bars3d->new(500, 300); # Os valores de new são as dimensões do gráfico

$grafico->set(
bar_width => '20',             # Expessura das barras
bar_spacing => '0',            # Espaçamento entre as barras
x_label => '',                 # Rótulo horizontal
y_label => 'Total Pages',      # Rótulo vertical
title => '',                   # Título do gráfico
long_ticks  => 1,
show_values => 1,
dclrs => [ qw/ yellow blue green red purple orange pink marine cyan dbrown / ],
legend_placement => 'RT',
y_max_value => $y_max_value
) or warn $grafico->error;

$grafico->set_legend_font(GD::gdMediumBoldFont);

$grafico->set_legend(@fields);

my $imagem = $grafico->plot(\@graf) or die $grafico->error;

print "Content-type: image/png\n\n";
print $imagem->png;

