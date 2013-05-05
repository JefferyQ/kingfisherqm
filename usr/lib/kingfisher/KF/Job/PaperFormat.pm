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


sub get_paperformat {

    my $doc_path = shift;
    my $paperformat = '';

    open(JOB, "<$doc_path");
    while(<JOB>) {
	# Postscript
	if(/\%\%BeginFeature:\s+?\*PageSize\s+?(\w+)/) {
	    $paperformat = $1;
	    last;
	}
	# PCL 6 / XL - 1
	elsif(/\310\300.(\w+)/) {
	    $paperformat = $1;
	    last;
	}
	# PCL 6 / XL - 2
	elsif(/PJL\s+SET\s+PAPER=(\w+)/i) {
	    $paperformat = $1;
	    last;
	}
	# PCL 5
	elsif(/\033\046\154(\d+)A/i) {
	    if($1 == 1) {
		$paperformat = 'Executive';
		last;
	    }
	    elsif($1 == 2) {
		$paperformat = 'Letter';
		last;
	    }
	    elsif($1 == 3) {
		$paperformat = 'Legal';
		last;
	    }
	    elsif($1 == 6) {
		$paperformat = 'Ledger';
		last;
	    }
	    elsif($1 == 25 || $1 == 2000) {
		$paperformat = 'A5';
		last;
	    }
	    elsif($1 == 26) {
		$paperformat = 'A4';
		last;
	    }
	    elsif($1 == 27) {
		$paperformat = 'A3';
		last;
	    }
	    elsif($1 == 91) {
		$paperformat = 'C5';
		last;
	    }
	    else {
		$paperformat = 'Unknow';
		last;
	    }
	}
	# Brother HBP
	elsif(/PJL\s+ENTER\s+LANGUAGE\s*=\s*HBP/) {
	    $paperformat = 'A4';
	    last;
	}

    }

    close(JOB);

    $paperformat = 'Executive' if($paperformat =~ /EXEC/i);

    $paperformat = pclxl($doc_path) if($paperformat !~ /Unknow|Letter|Legal|A4|Executive|Ledger|A3|C5|A5/i);

    $paperformat = qpdl($doc_path) if($paperformat !~ /Unknow|Letter|Legal|A4|Executive|Ledger|A3|C5|A5/i);

    # Default format: lower with first letter upper
    $paperformat = ucfirst(lc($paperformat));

    return $paperformat;

}

1;

