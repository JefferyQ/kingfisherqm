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

use IO::Socket::INET;

sub get_host {

    my $job_id = shift;

    my $client = new IO::Socket::INET(
        PeerAddr => '127.0.0.1',
        PeerPort => 631,
        Proto => 'tcp',
        Type => SOCK_STREAM ) or die('cannot connect to server');


    my $r_content = pack("CCnNC", 1, 1, 0x0009, 1, 1);
    $r_content .= pack("Cn", 0x47, 0x12).'attributes-charset'.pack("n", 0x05).'utf-8';
    $r_content .= pack("Cn", 0x48, 0x1b).'attributes-natural-language'.pack("n", 0x02).'en';

    my $temp = "ipp://localhost:631/jobs/$job_id";

    $r_content .= pack("Cn", 0x45, 0x07).'job-uri'.pack("n", length($temp))."ipp://localhost:631/jobs/$job_id";

    $r_content .= pack("C", 0x0003);



    my $r_con_len = length($r_content);


    my $r_header = "POST /jobs/$job_id HTTP/1.1".pack("CC", 0x000d, 0x000a);
    $r_header .= "Content-Length: $r_con_len".pack("CC", 0x000d, 0x000a);
    $r_header .= 'Content-Type: application/ipp'.pack("CC", 0x000d, 0x000a);
    $r_header .= 'Host: localhost'.pack("CC", 0x000d, 0x000a);
    $r_header .= 'User-Agent: CUPS/1.3.8'.pack("CC", 0x000d, 0x000a);
    $r_header .= 'Expect: 100-continue'.pack("CC", 0x000d, 0x000a);
    $r_header .= pack("CC", 0x000d, 0x000a);

    print $client $r_header, $r_content;


    my $response = '';

    while($response !~ /job-originating-host-name/) {
        $response .= <$client>;
    }

    close($client);

    $response =~ /job-originating-host-name.*?(f{4}.*?\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}|\w+)/;
    $temp = $1;
    $temp =~ s/ffff://;
    return $temp;

}

1;
