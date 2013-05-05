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


=item number_of_pages()

    This function returns the number of pages, using pkpgcounter
    program written by Jerome Alet

    @params $python_path = PATH of Python
    @params $pkpgcounter = PATH of Pkpgcounter
    @params $doc_path = PATH of doc for print

=cut

sub number_of_pages {

    my($source, $python_path, $pkpgcounter_path, $doc_path) = @_;

    # Check Python path
    if(! -e $python_path) {
	    logger($source, 'err', "Python not found on $python_path : Check your Python installation.");
	    die;
    }

    # Check Pkpgcounter path
    if(! -e $pkpgcounter_path) {
	    logger($source, 'err', "Pkpgcounter not found on $pkpgcounter_path : Check your Pkpgcounter installation.");
	    die;
    }

    # Number of pages
    my $number_of_pages = `$python_path $pkpgcounter_path $doc_path 2> /dev/null`;

    # Check return format
    if($number_of_pages !~ /^\d+$/) {
	    logger($source, 'err', 'Pkpgcounter could not get a valid number of pages.');
	    die;
    }

    return $number_of_pages;

}


1;
