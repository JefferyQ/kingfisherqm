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

sub qpdl {

    my $file = shift;
    my $buffer = '';
    my $tmp = 1;

    # Open File
    open(FILE, "<$file") or die("Cannot open file: $!");

    while($buffer !~ /ENTER\s*LANGUAGE\s*=\s*QPDL/) {
	    $buffer = <FILE>;

	    if($tmp > 48) {
	        return '';
	    }
	    $tmp++;
    }

    $tmp = qpdl_info(\*FILE);

    close(FILE);

    return $tmp;

}

sub qpdl_info {

    my $qpdlfile = shift;
    my $data;

    seek $qpdlfile, 4, 1;
    read $qpdlfile, $data, 1;

    if($data eq pack("C", 0x00)) {
	    return 'Letter';
    }
    elsif($data eq pack("C", 0x01)) {
	    return 'Legal';
    }
    elsif($data eq pack("C", 0x02)) {
	    return 'A4';
    }
    elsif($data eq pack("C", 0x03)) {
	    return 'Executive';
    }
    elsif($data eq pack("C", 0x04)) {
	    return 'Ledger';
    }
    elsif($data eq pack("C", 0x05)) {
	    return 'A3';
    }
    elsif($data eq pack("C", 0x10)) {
	    return 'A5';
    }
    else {
    	return 'Unknow';
    }
    
}

1;

