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

package ReadConf;

use strict;
use warnings;

# Read Conf File

sub new {

    my $class = shift;
    my $self = {};

    open(CONF, '</etc/kingfisher/kingfisher.conf') or die "Can't open /etc/kingfisher/kingfisher.conf: $!";
        while(<CONF>) {
            chomp;
            next if /^\s*(#|$)/;
	        next if /^#/;

	        if(/^DB_HOST:\s*\w+/) {
                (undef, $self->{db_host}) = split /:\s*/;
	        }
	        elsif(/^DB_NAME:\s*\w+/) {
                (undef, $self->{db_name}) = split /:\s*/;
	        }
	        elsif(/^DB_USER:\s*\w+/) {
                (undef, $self->{db_user}) = split /:\s*/;
	        }
	        elsif(/^DB_PASS:\s*\w+/) {
                (undef, $self->{db_pass}) = split /:\s*/;
	        }
            elsif(/^KF_SPOOL_PATH:\s*[\w\/]+/) {
                (undef, $self->{kf_spool_path}) = split /:\s*/;
            }
	        elsif(/^PYTHON_PATH:\s*[\w\/]+/) {
                (undef, $self->{python_path}) = split /:\s*/;
	        }
	        elsif(/^PKPGCOUNTER_PATH:\s*[\w\/]+/) {
                (undef, $self->{pkpgcounter_path}) = split /:\s*/;
	        }
	        elsif(/^LOG_LEVEL:\s*\d+/) {
                (undef, $self->{log_level}) = split /:\s*/;
	        }
        }
    close(CONF);

    bless($self, $class);

    return $self;

}

1;
