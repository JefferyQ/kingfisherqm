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


=item logger()

    This function send logs

    @params $priority = type of log (err, info, warning)
    @params $msg = Message for log

=cut

sub logger {
    
    my($source, $priority, $msg) = @_;

    return 0 unless ($priority =~ /info|err|warning/);

    openlog($source, 'cons', 'log_lpr');
    syslog($priority, $msg);
    closelog();
    return 1;

}


=item size_human_readable

    This functions returns a file size in human readable format

    @params $size = size of file

=cut

sub size_human_readable {
    my $size = shift;
    my $unit = 0;

    while(int($size) > 1024) {
	    $size /= 1024;
	    $unit++;
    }

    if($unit == 0) {
	    $unit = "";
    }
    elsif($unit == 1) {
        $unit = "K";
    }
    elsif($unit == 2) {
	    $unit = "M";
    }
    elsif($unit == 3) {
	    $unit = "G";
    }

    return sprintf("%.1f", $size)."$unit";

}

1;
