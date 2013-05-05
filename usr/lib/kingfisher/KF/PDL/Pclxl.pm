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

use constant {
	PALETTE_DEPTH			=>      2,
	COLOR_SPACE			=>	3,
	NULL_BRUSH			=>	4,
	NULL_PEN			=>	5,
	PALETTE_DATA			=>	6,
	PATTERN_SELECT_ID		=>	8,
	GRAY_LEVEL			=>	9,
	RGB_COLOR			=>	11,
	PATTERN_ORIGIN			=>	12,
	NEW_DESTINATION_SIZE		=>	13,
	PRIMARY_ARRAY			=>	14,
	PRIMARY_DEPTH			=>	15,
	DEVICE_MATRIX			=>	33,
	DITHER_MATRIX_DATA_TYPE 	=>	34,
	DITHER_ORIGIN			=>	35,
	MEDIA_SIZE			=>	0x25,
	MEDIA_SOURCE			=>	38,
	MEDIA_TYPE			=>	39,
	ORIENTATION			=>	40,
	PAGE_ANGLE			=>	41,
	PAGE_ORIGIN			=>	42,
	PAGE_SCALE			=>	43,
	ROP3				=>	44,
	TX_MODE       			=>	45,
	CUSTOM_MEDIA_SIZE		=>	47,
	CUSTOM_MEDIA_SIZE_UNITS		=>	48,
	PAGE_COPIES			=>	49,
	DITHER_MATRIX_SIZE		=>	50,
	DITHER_MATRIX_DEPTH		=>	51,
	SIMPLEX_PAGE_MODE		=>	52,
	DUPLEX_PAGE_MODE		=>	53,
	DUPLEX_PAGE_SIDE		=>	54,
	ARC_DIRECTION			=>	65,
	BOUNDING_BOX			=>	66,
	DASH_OFFSET			=>	67,
	ELLIPSE_DIMENSION		=>	68,
	END_POINT			=>	69,
	FILL_MODE			=>	70,
	LINE_CAP_STYLE			=>	71,
	LINE_JOIN_STYLE			=>	72,
	MITER_LENGTH			=>	73,
	LINE_DASH_STYLE			=>	74,
	PEN_WIDTH			=>	75,
	POINT				=>	76,
	NUMBER_OF_POINTS		=>	77,
	SOLID_LINE			=>	78,
	START_POINT			=>	79,
	POINT_TYPE			=>	80,
	CONTROL_POINT_1			=>	81,
	CONTROL_POINT_2			=>	82,
	CLIP_REGION			=>	83,
	CLIP_MODE			=>	84,
	COLOR_DEPTH			=>	98,
	BLOCK_HEIGHT			=>	99,
	COLOR_MAPPING			=>	100,
	COMPRESS_MODE			=>	101,
	DESTINATION_BOX			=>	102,
	DESTINATION_SIZE		=>	103,
	PATTERN_PERSISTENCE		=>	104,
	PATTERN_DEFINE_ID		=>	105,
	SOURCE_HEIGHT			=>	107,
	SOURCE_WIDTH			=>	108,
	START_LINE			=>	109,
	PAD_BYTES_MULTIPLE		=>	110,
	BLOCK_BYTE_LENGTH		=>	111,
	NUMBER_OF_SCAN_LINES		=>	115,
	COMMENT_DATA			=>	129,
	DATA_ORG			=>	130,
	MEASURE				=>	134,
	SOURCE_TYPE			=>	136,
	UNITS_PER_MEASURE		=>	137,
	STREAM_NAME			=>	139,
	STREAM_DATA_LENGTH		=>	140,
	ERROR_REPORT			=>	143,
	RESERVED			=>	145,
	CHAR_ANGLE			=>	161,
	CHAR_CODE			=>	162,
	CHAR_DATA_SIZE			=>	163,
	CHAR_SCALE			=>	164,
	CHAR_SHEAR			=>	165,
	CHAR_SIZE			=>	166,
	FONT_HEADER_LENGTH		=>	167,
	FONT_NAME			=>	168,
	FONT_FORMAT			=>	169,
	SYMBOL_SET			=>	170,
	TEXT_DATA			=>	171,
	CHAR_SUB_MODE_ARRAY		=>	172,
	X_SPACING_DATA			=>	175,
	Y_SPACING_DATA			=>	176,
	CHAR_BOLD_VALUE			=>	177,
	NULL_VALUE			=>	0x00,    #0x00
	H_TAB				=>	0x09,
	NEW_LINE			=>	0x0a,
	V_TAB				=>	0x0b,
	FORM_FEED			=>	0x0c,
	CARRIAGE_RETURN			=>	0x0d,
	WHITE_SPACE			=>	0x14,
	BEGIN_ASCII_BIND		=>	0x27,   #0x27
	BEGIN_BIN_BIND_H		=>	0x28,   #0x28
	BEGIN_BIN_BIND_L		=>	0x29,   #0x29
	BEGIN_SESSION			=>	0x41,   #0x41
	END_SESSION			=>	0x42,   #0x42
	BEGIN_PAGE			=>	0x43,   #0x43
	END_PAGE			=>	0x44,   #0x44
	COMMENT				=>	0x47,   #0x47
	OPEN_DATA_SOURCE		=>	0x48,   #0x48
	CLOSE_DATA_SOURCE		=>	0x49,   #0x49
	BEGIN_FONT_HEADER		=>	0x4f,   #0x4f
	READ_FONT_HEADER		=>	0x50,   #0x50
	END_FONT_HEADER			=>	0x51,   #0x51
	BEGIN_CHAR			=>	0x52,   #0x52
	READ_CHAR			=>	0x53,   #0x53
	END_CHAR			=>	0x54,   #0x54
	REMOVE_FONT			=>	0x55,   #0x55
	SET_CHAR_ATTRIBUTES		=>	0x56,   #0x56
	BEGIN_STREAM			=>	0x5b,   #0x5b
	READ_STREAM			=>	0x5c,   #0x5c
	END_STREAM			=>	0x5d,   #0x5d
	EXEC_STREAM			=>	0x5e,   #0x5e
	REMOVE_STREAM			=>	0x5f,   #0x5f
	POP_GS				=>	0x60,   #0x60
	PUSH_GS				=>	0x61,   #0x61
	SET_CLIP_REPLACE		=>	0x62,   #0x62
	SET_BRUSH_SOURCE		=>	0x63,   #0x63
	SET_CHAR_ANGLE			=>	0x64,  #0x64
	SET_CHAR_SCALE			=>	0x65,  #0x65
	SET_CHAR_SHEAR			=>	0x66,  #0x66
	SET_CLIP_INTERSECT		=>	0x67,  #0x67
	SET_CLIP_RECTANGLE		=>	0x68,  #0x68
	SET_CLIP_TO_PAGE		=>	0x69,  #0x69
	SET_COLOR_SPACE			=>	0x6a,  #0x6a
	SET_CURSOR			=>	0x6b,  #0x6b
	SET_CURSOR_REL			=>	0x6c,  #0x6c
	SET_HALFTONE_METHOD		=>	0x6d,  #0x6d
	SET_FILL_MODE			=>	0x6e,  #0x6e
	SET_FONT			=>	0x6f,  #0x6f
	SET_LINE_DASH			=>	0x70,  #0x70
	SET_LINE_CAP			=>	113,  #0x71
	SET_LINE_JOIN			=>	114,  #0x72
	SET_MITER_LIMIT			=>	115,  #0x73
	SET_PAGE_DEFAULT_CTM		=>	116,  #0x74
	SET_PAGE_ORIGIN			=>	117,  #0x75
	SET_PAGE_ROTATION		=>	118,  #0x76
	SET_PAGE_SCALE			=>	119,  #0x77
	SET_PATTERN_TX_MODE		=>	120,  #0x78
	SET_PEN_SOURCE			=>	121,  #0x79
	SET_PEN_WIDTH			=>	122,  #0x7a
	SET_ROP				=>	123,  #0x7b
	SET_SOURCE_TX_MODE		=>	124,  #0x7c
	SET_CHAR_BOLD_VALUE		=>	125,  #0x7d
	SET_CLIP_MODE			=>	126,  #0x7f
	SET_PATH_TO_CLIP		=>	127,  #0x80
	SET_CHAR_SUB_MODE		=>	128,  #0x81
	CLOSE_SUB_PATH			=>	132,  #0x84
	NEW_PATH			=>	133,  #0x85
	PAINT_PATH			=>	134,  #0x86
	ARC_PATH			=>	145,  #0x91
	BEZIER_PATH			=>	147,  #0x93
	BEZIER_REL_PATH			=>	149,  #0x95
	CHORD				=>	150,  #0x96
	CHORD_PATH			=>	151,  #0x97
	ELLIPSE				=>	152,  #0x98
	ELLIPSE_PATH			=>	153,  #0x99
	LINE_PATH			=>	155,  #0x9b
	LINE_REL_PATH			=>	157,  #0x9d
	PIE				=>	158,  #0x9e
	PIE_PATH			=>	159,  #0x9f
	RECTANGLE			=>	160,  #0xa0
	RECTANGLE_PATH			=>	161,  #0xa1
	ROUND_RECTANGLE			=>	0xa2,  #0xa2
	ROUND_RECTANGLE_PATH		=>	0xa3,  #0xa3
	TEXT				=>	0xa8,  #0xa8
	TEXT_PATH			=>	0xa9,  #0xa9
	BEGIN_IMAGE			=>	0xb0,  #0xb0
	READ_IMAGE			=>	0xb1,  #0xb1
	END_IMAGE			=>	0xb2,  #0xb2
	BEGIN_RAST_PATTERN		=>	0xb3,  #0xb3
	READ_RAST_PATTERN		=>	0xb4,  #0xb4
	END_RAST_PATTERN		=>	0xb5,  #0xb5
	BEGIN_SCAN			=>	0xb6,  #0xb6
	END_SCAN			=>	0xb8,  #0xb8
	SCAN_LINE_REL			=>	0xb9,  #0xb9
	UBYTE				=>	0xc0,  #0xc0
	UINT16				=>	0xc1,  #0xc1
	UINT32				=>	0xc2,  #0xc2
	SINT16				=>	0xc3,  #0xc3
	SINT32				=>	0xc4,  #0xc4
	REAL32				=>	0xc5,  #0xc5
	UBYTE_ARRAY			=>	0xc8,  #0xc8
	UINT16_ARRAY			=>	0xc9,  #0xc9
	UINT32_ARRAY			=>	0xca,  #0xca
	SINT16_ARRAY			=>	0xcb,  #0xcb
	SINT32_ARRAY			=>	0xcc,  #0xcc
	REAL32_ARRAY			=>	0xcd,  #0xcd
	UBYTE_XY			=>	0xd0,  #0xd0
	UINT16_XY			=>	0xd1,  #0xd1
	UINT32_XY			=>	0xd2,  #0xd2
	SINT16_XY			=>	0xd3,  #0xd3
	SINT32_XY			=>	0xd4,  #0xd4
	REAL32_XY			=>	0xd5,  #0xd5
	UBYTE_BOX			=>	0xe0,  #0xe0
	UINT16_BOX			=>	0xe1,  #0xe1
	UINT32_BOX			=>	0xe2,  #0xe2
	SINT16_BOX			=>	0xe3,  #0xe3
	SINT32_BOX			=>	0xe4,  #0xe4
	REAL32_BOX			=>	0xe5,  #0xe5
	ATTR_UBYTE			=>	0xf8,  #0xf8
	ATTR_UINT16			=>	0xf9,  #0xf9
	DATA_LENGTH			=>	0xfa,  #0xfa
	DATA_LENGTH_BYTE		=>	0xfb,   #0xfb

	ERROR_PCL_FORMAT		=>	"Formato do arquivo PCL6 invalido!\n",
	ERROR_UNEXPECTED_EOF		=>	"Fim do arquivo nao esperado!\n",
	ENTER_PCL_XL_1			=>	"\@PJL ENTER LANGUAGE = PCLXL",
	ENTER_PCL_XL_2			=>	"\@PJL ENTER LANGUAGE=PCLXL",
	SET_DUPLEX			=>	"\@PJL SET DUPLEX=ON",
	ENTER_PJL			=>	"\033%-12345X",
	ENTER_PJL_SIZE			=>	9,
	STACK_SIZE			=>	10

};

sub pclxl {

    my $file = shift;
    my $buffer = '';
    my $tmp = 1;

    # Open File
    open(FILE, "<$file") or die("Cannot open file: $!");

    while(($buffer !~ /HP-PCL\s+XL;/) && ($buffer !~ /BROTHER\s+XL2HB;/)) {
	$buffer = <FILE>;

	if($tmp > 48) {
	    return '';
	}
	$tmp++;
    }

    $tmp = pclxl_info(\*FILE);

    close(FILE);

    return $tmp;

}


sub pclxl_info {

    my $pclfile = shift;
    my $terminado = 0;
    my $i = 0;
    my @node;


    while(!$terminado) {
	alimentaPilha(\@node, $pclfile);

	if($node[ $#node ]->{'datatype'} eq pack("C", BEGIN_ASCII_BIND)) {
	    popnode(\@node);
	}
	elsif($node[ $#node ]->{'datatype'} eq pack("C", BEGIN_BIN_BIND_H)) {
	    popnode(\@node);
	}
	elsif($node[ $#node ]->{'datatype'} eq pack("C", BEGIN_BIN_BIND_L)) {
	    popnode(\@node);
	}
	elsif($node[ $#node ]->{'datatype'} eq pack("C", END_SESSION)) {
	    ClearStack(\@node);
	    $terminado = 1;
	}
	elsif($node[ $#node ]->{'datatype'} eq pack("C", BEGIN_PAGE)) {

	    for(my $i = ($#node - 1); $i > 0; $i--) {
		# DEBUG print "Attr: $i - ", $node[$i]->{'attr_name'}, "\n";
		# DEBUG print "Datatype: $i - ", $node[$i]->{'datatype'}, "\n";
		# DEBUG print "Data: $i - ", $node[$i]->{'data'}, "\n\n";
		if($node[$i]->{'attr_name'} eq '%') {
		    if($node[$i]->{'data'} eq pack("C", 0x00)) {
			return 'Letter';
		    }
		    elsif($node[$i]->{'data'} eq pack("C", 0x01)) {
			return 'Legal';
		    }
		    elsif($node[$i]->{'data'} eq pack("C", 0x02)) {
			return 'A4';
		    }
		    elsif($node[$i]->{'data'} eq pack("C", 0x03)) {
			return 'Executive';
		    }
		    elsif($node[$i]->{'data'} eq pack("C", 0x04)) {
			return 'Ledger';
		    }
		    elsif($node[$i]->{'data'} eq pack("C", 0x05)) {
			return 'A3';
		    }
		    elsif($node[$i]->{'data'} eq pack("C", 0x08)) {
			return 'C5';
		    }
		    elsif($node[$i]->{'data'} eq pack("C", 0x10)) {
			return 'A5';
		    }
		    else {
			return 'Unknow';
		    }

		}
	    }

            # Some PCL-XL (Gestetner)
            my $char = '';
	    while($char ne '%') {
		read $pclfile, $char, 1;
		seek $pclfile, -2, 1;
	    }
	    seek $pclfile, -1, 1;
	    read $pclfile, $char, 1;

	    if($char eq pack("C", 0x00)) {
		return 'Letter';
	    }
	    elsif($char eq pack("C", 0x01)) {
		return 'Legal';
	    }
	    elsif($char eq pack("C", 0x02)) {
		return 'A4';
	    }
	    elsif($char eq pack("C", 0x03)) {
		return 'Executive';
	    }
	    elsif($char eq pack("C", 0x04)) {
		return 'Ledger';
	    }
	    elsif($char eq pack("C", 0x05)) {
		return 'A3';
	    }
	    elsif($char eq pack("C", 0x08)) {
		return 'C5';
	    }
	    elsif($char eq pack("C", 0x0f)) {
		return 'A5';
	    }
	    else {
		return 'Unknow';
	    }

	    return 'Unknow';

	    ClearStack(\@node);
	}
	elsif($node[ $#node ]->{'datatype'} eq pack("C", END_PAGE)) {

	    # DEBUG print "END_PAGE\n"; # Debug

	    ClearStack(\@node);
	}
	else {
	    ClearStack(\@node);
	}
    }


}


sub alimentaPilha {

    my($node, $pclfile) = @_;
    my $data;
    my $encontrado = 0;


    while(!$encontrado) {

	read $pclfile, $data, 1;

# DEBUG print "POS: ", tell($pclfile), "\n"; #DEBUG

	$$node[ $#{$node} + 1 ]->{'datatype'} = $data;

	if(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", UBYTE)) {
	    # DEBUG print "ubyte\n";
	    readNumber($node, UBYTE, $pclfile);
	    readAttributeName($node, $pclfile);
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", UINT16)) {
	    # DEBUG print "uint16\n";
	    readNumber($node, UINT16, $pclfile);
	    readAttributeName($node, $pclfile);
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", SINT16)) {
	    # DEBUG print "sint16\n";
	    readNumber($node, SINT16, $pclfile);
	    readAttributeName($node, $pclfile);
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", UINT32)) {
	    # DEBUG print "uint32\n";
	    readNumber($node, UINT32, $pclfile);
	    readAttributeName($node, $pclfile);
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", SINT32)) {
	    # DEBUG print "sint32\n";
	    readNumber($node, SINT32, $pclfile);
	    readAttributeName($node, $pclfile);
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", REAL32)) {
	    # DEBUG print "real32\n";
	    readNumber($node, REAL32, $pclfile);
	    readAttributeName($node, $pclfile);
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", UBYTE_XY)) {
	    # DEBUG print "ubyte_xy\n";
	    readCoordinate($node, UBYTE_XY, $pclfile);
	    readAttributeName($node, $pclfile);
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", UINT16_XY)) {
	    # DEBUG print "uint16_xy\n";
	    readCoordinate($node, UINT16_XY, $pclfile);
	    readAttributeName($node, $pclfile);
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", SINT16_XY)) {
	    # DEBUG print "sint16_xy\n";
	    readCoordinate($node, SINT16_XY, $pclfile);
	    readAttributeName($node, $pclfile);
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", UINT32_XY)) {
	    # DEBUG print "uint32_xy\n";
	    readCoordinate($node, UINT32_XY, $pclfile);
	    readAttributeName($node, $pclfile);
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", SINT32_XY)) {
	    # DEBUG print "sint32_xy\n";
	    readCoordinate($node, SINT32_XY, $pclfile);
	    readAttributeName($node, $pclfile);
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", REAL32_XY)) {
	    # DEBUG print "real32_xy\n";
	    readCoordinate($node, REAL32_XY, $pclfile);
	    readAttributeName($node, $pclfile);
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", UBYTE_BOX)) {
	    # DEBUG print "ubyte_box\n";
	    readBox($node, UBYTE_BOX, $pclfile);
	    readAttributeName($node, $pclfile);
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", UINT16_BOX)) {
	    # DEBUG print "uint16_box\n";
	    readBox($node, UINT16_BOX, $pclfile);
	    readAttributeName($node, $pclfile);
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", SINT16_BOX)) {
	    # DEBUG print "sint16_box\n";
	    readBox($node, SINT16_BOX, $pclfile);
	    readAttributeName($node, $pclfile);
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", UINT32_BOX)) {
	    # DEBUG print "uint32_box\n";
	    readBox($node, UINT32_BOX, $pclfile);
	    readAttributeName($node, $pclfile);
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", SINT32_BOX)) {
	    # DEBUG print "sint32_box\n";
	    readBox($node, SINT32_BOX, $pclfile);
	    readAttributeName($node, $pclfile);
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", REAL32_BOX)) {
	    # DEBUG print "real32_box\n";
	    readBox($node, REAL32_BOX, $pclfile);
	    readAttributeName($node, $pclfile);
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", UBYTE_ARRAY)) {
	    # DEBUG print "ubyte_array\n";
	    readArray($node, UBYTE_ARRAY, $pclfile);
	    readAttributeName($node, $pclfile);
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", UINT16_ARRAY)) {
	    # DEBUG print "uint16_array\n";
	    readArray($node, UINT16_ARRAY, $pclfile);
	    readAttributeName($node, $pclfile);
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", SINT16_ARRAY)) {
	    # DEBUG print "sint16_array\n";
	    readArray($node, SINT16_ARRAY, $pclfile);
	    readAttributeName($node, $pclfile);
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", UINT32_ARRAY)) {
	    # DEBUG print "uint32_array\n";
	    readArray($node, UINT32_ARRAY, $pclfile);
	    readAttributeName($node, $pclfile);
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", SINT32_ARRAY)) {
	    # DEBUG print "sint16_array\n";
	    readArray($node, SINT32_ARRAY, $pclfile);
	    readAttributeName($node, $pclfile);
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", REAL32_ARRAY)) {
	    # DEBUG print "real32_array\n";
	    readArray($node, REAL32_ARRAY, $pclfile);
	    readAttributeName($node, $pclfile);
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", BEGIN_ASCII_BIND)) {
	    # DEBUG print "begin_ascii_bind\n";
	    seek $pclfile, 1, 1;
	    SkipUntilChar(NEW_LINE, $pclfile);
	    $encontrado = 1;
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", BEGIN_BIN_BIND_H)) {
	    # DEBUG print "begin_bin_bind_h\n";
	    seek $pclfile, 1, 1;
	    SkipUntilChar(NEW_LINE, $pclfile);
	    $encontrado = 1;
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", BEGIN_BIN_BIND_L)) {
	    # DEBUG print "begin_bin_bind_l\n";
	    seek $pclfile, 1, 1;
	    SkipUntilChar(NEW_LINE, $pclfile);
	    $encontrado = 1;
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", END_SESSION)) {
	    # DEBUG print "end_session\n";
	    $encontrado = 1;
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", BEGIN_PAGE)) {
	    # DEBUG print "begin_page\n";
	    $encontrado = 1;
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", END_PAGE)) {
	    # DEBUG print "end_page\n";
	    $encontrado = 1;
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", READ_FONT_HEADER)) {
	    # DEBUG print "read_font_header\n";
	    readData($node, $pclfile);
	    $encontrado = 1;
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", READ_CHAR)) {
	    # DEBUG print "read_char\n";
	    readData($node, $pclfile);
	    $encontrado = 1;
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", SET_HALFTONE_METHOD)) {
	    # DEBUG print "set_halftone_method\n";
	    $encontrado = 1;
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", BEZIER_PATH)) {
	    # DEBUG print "bezier_path\n";
	    $encontrado = 1;
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", BEZIER_REL_PATH)) {
	    # DEBUG print "bezier_rel_path\n";
	    $encontrado = 1;
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", LINE_PATH)) {
	    # DEBUG print "line_path\n";
	    $encontrado = 1;
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", LINE_REL_PATH)) {
	    # DEBUG print "line_rel_path\n";
	    $encontrado = 1;
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", READ_IMAGE)) {
	    # DEBUG print "read_image\n";
	    readData($node, $pclfile);
	    $encontrado = 1;
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", READ_RAST_PATTERN)) {
	    # DEBUG print "read_rast_pattern\n";
	    readData($node, $pclfile);
	    $encontrado = 1;
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", END_RAST_PATTERN)) {
	    # DEBUG print "end_rast_pattern\n";
	    $encontrado = 1;
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", BEGIN_SCAN)) {
	    # DEBUG print "begin_scan\n";
	    readData($node, $pclfile);
	    $encontrado = 1;
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", READ_STREAM)) {
	    # DEBUG print "read_stream\n";
	    readData($node, $pclfile);
	    $encontrado = 1;
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", NULL_VALUE)) {
	    # DEBUG print "null_value\n";
	    printf "%s", ERROR_PCL_FORMAT;
	    return;
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", H_TAB)) {
	    # DEBUG print "h_tab\n";
	    printf "%s", ERROR_PCL_FORMAT;
	    return;
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", NEW_LINE)) {
	    # DEBUG print "new_line\n";
	    printf "%s", ERROR_PCL_FORMAT;
	    return;
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", V_TAB)) {
	    # DEBUG print "v_tab\n";
	    printf "%s", ERROR_PCL_FORMAT;
	    return;
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", FORM_FEED)) {
	    # DEBUG print "form_feed\n";
	    printf "%s", ERROR_PCL_FORMAT;
	    return;
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", CARRIAGE_RETURN)) {
	    # DEBUG print "carriage_return\n";
	    printf "%s", ERROR_PCL_FORMAT;
	    return;
	}
	elsif(($$node[ $#{$node} ]->{'datatype'}) eq pack("C", WHITE_SPACE)) {
	    # DEBUG print "white_space\n";
	    printf "%s", ERROR_PCL_FORMAT;
	    return;
	}
	else {
	    $encontrado = 1;
	}


    }

}

sub readNumber {
    my($node, $type, $pclfile) = @_;

    if($type == UBYTE) {
        # DEBUG print "ubyte2\n";
	read $pclfile, $$node[ $#{$node} ]->{'data'}, length(pack("C", 0x41));
	$$node[ $#{$node} ]->{'has_data'} = 1;
    }
    elsif($type == UINT16) {
	# DEBUG print "uint16 2\n";
	read $pclfile, $$node[ $#{$node} ]->{'data'}, length(pack("S", 0x41));
	$$node[ $#{$node} ]->{'has_data'} = 1;
    }
    elsif($type == SINT16) {
	# DEBUG print "sint16 2\n";
	read $pclfile, $$node[ $#{$node} ]->{'data'}, length(pack("s", 0x41));
	$$node[ $#{$node} ]->{'has_data'} = 1;
    }
    elsif($type == UINT32) {
	# DEBUG print "uint32 2\n";
	read $pclfile, $$node[ $#{$node} ]->{'data'}, length(pack("L", 0x41));
	$$node[ $#{$node} ]->{'has_data'} = 1;
    }
    elsif($type == SINT32) {
	# DEBUG print "sint32 2\n";
	read $pclfile, $$node[ $#{$node} ]->{'data'}, length(pack("l", 0x41));
	$$node[ $#{$node} ]->{'has_data'} = 1;
    }
    elsif($type == REAL32) {
	# DEBUG print "real32 2\n";
	read $pclfile, $$node[ $#{$node} ]->{'data'}, length(pack("f", 0x41));
	$$node[ $#{$node} ]->{'has_data'} = 1;
    }
}

sub readCoordinate {

    my($node, $type, $pclfile) = @_;

    if($type == UBYTE_XY) {
	# DEBUG print "ubyte_xy 2\n";
	seek $pclfile, 2, 1;
	$$node[ $#{$node} ]->{'has_data'} = 0;
    }
    elsif($type == UINT16_XY) {
	# DEBUG print "uint16_xy 2\n";
	seek $pclfile, 4, 1;
	$$node[ $#{$node} ]->{'has_data'} = 0;
    }
    elsif($type == SINT16_XY) {
	# DEBUG print "sint16_xy 2\n";
	seek $pclfile, 4, 1;
	$$node[ $#{$node} ]->{'has_data'} = 0;
    }
    elsif($type == UINT32_XY) {
	# DEBUG print "uint32_xy 2\n";
	seek $pclfile, 8, 1;
	$$node[ $#{$node} ]->{'has_data'} = 0;
    }
    elsif($type == SINT32_XY) {
	# DEBUG print "sint32_xy 2\n";
	seek $pclfile, 8, 1;
	$$node[ $#{$node} ]->{'has_data'} = 0;
    }
    elsif($type == REAL32_XY) {
	# DEBUG print "real32_xy 2\n";
	seek $pclfile, 8, 1;
	$$node[ $#{$node} ]->{'has_data'} = 0;
    }

}

sub readBox {

    my($node, $type, $pclfile) = @_;

    if($type == UBYTE_BOX) {
	# DEBUG print "ubyte_box 2\n";
	seek $pclfile, 4, 1;
	$$node[ $#{$node} ]->{'has_data'} = 0;
    }
    elsif($type == UINT16_BOX) {
	# DEBUG print "uint16_box 2\n";
	seek $pclfile, 8, 1;
	$$node[ $#{$node} ]->{'has_data'} = 0;
    }
    elsif($type == SINT16_BOX) {
	# DEBUG print "sint16_box 2\n";
	seek $pclfile, 8, 1;
	$$node[ $#{$node} ]->{'has_data'} = 0;
    }
    elsif($type == UINT32_BOX) {
	# DEBUG print "uint32_box 2\n";
	seek $pclfile, 16, 1;
	$$node[ $#{$node} ]->{'has_data'} = 0;
    }
    elsif($type == SINT32_BOX) {
	# DEBUG print "sint32_box 2\n";
	seek $pclfile, 16, 1;
	$$node[ $#{$node} ]->{'has_data'} = 0;
    }
    elsif($type == REAL32_BOX) {
	# DEBUG print "real32_box 2\n";
	seek $pclfile, 16, 1;
	$$node[ $#{$node} ]->{'has_data'} = 0;
    }

}


sub readArray {

    my($node, $type, $pclfile) = @_;
    my $skipfactor = 0;
    my($c_char, $ubyte_skip, $uint16_skip, $uint32_skip);

    if($type == UBYTE_ARRAY) {
        # DEBUG print "ubyte_array 2\n"; # Debug
        $skipfactor = 1;
    }
    elsif($type == UINT16_ARRAY) {
        # DEBUG print "uint16_array 2\n"; # Debug
	$skipfactor = 2;
    }
    elsif($type == SINT16_ARRAY) {
    	# DEBUG print "sint16_array 2\n"; # Debug
	$skipfactor = 2;
    }
    elsif($type == UINT32_ARRAY) {
    	# DEBUG print "uint32_array 2\n"; # Debug
	$skipfactor = 4;
    }
    elsif($type == SINT32_ARRAY) {
    	# DEBUG print "sint32_array 2\n"; # Debug
	$skipfactor = 4;
    }
    elsif($type == REAL32_ARRAY) {
    	# DEBUG print "real32_array 2\n"; # Debug
	$skipfactor = 4;
    }

    read $pclfile, $c_char, 1;

    if($c_char eq pack("C", UBYTE)) {
    	
	# DEBUG print "Array UBYTE\n";
	
	read $pclfile, $ubyte_skip, length(pack("C", 0x41));
	seek $pclfile, ( ord($ubyte_skip) * $skipfactor), 1;
    }
    elsif($c_char eq pack("C", UINT16)) {

	# DEBUG print "Array UINT16\n";

	read $pclfile, $uint16_skip, length(pack("S", 0x41));
	seek $pclfile, (ord($uint16_skip) * $skipfactor), 1;
    }
    elsif($c_char eq pack("C", UINT32)) {

	# DEBUG print "Array UINT32\n";

	read $pclfile, $uint32_skip, length(pack("L", 0x41));
	seek $pclfile, (ord($uint32_skip) * $skipfactor), 1;
    }

    $$node[ $#{$node} ]->{'has_data'} = 0;
}


sub readData {

    my($node, $pclfile) = @_;
    my $c_char;

    read $pclfile, $c_char, length(pack("C", 0x41));

    if($c_char eq pack("C", DATA_LENGTH_BYTE)) {
	
	# DEBUG print "DATA_LENGTH_BYTE\n"; # Debug
    }
    elsif($c_char eq pack("C", DATA_LENGTH)) {

	# DEBUG print "DATA_LENGTH\n"; # Debug

    }
    else {
	printf "%s", ERROR_PCL_FORMAT;
    }

    $$node[ $#{$node} ]->{'has_data'} = 0;

}


sub readAttributeName {
    my($node, $pclfile) = @_;
    my $c_char;

    read $pclfile, $c_char, 1;

    if($c_char eq pack("C", ATTR_UBYTE)) {
	read $pclfile, $$node[ $#{$node} ]->{'attr_name'}, 1;
    }
    else {
	printf "%s\n", ERROR_PCL_FORMAT;
	return;
    }
}

sub SkipUntilChar {
    my($ch, $pclfile) = @_;
    my $c_char = 255;

    while($c_char ne pack("C", $ch)) {
	read $pclfile, $c_char, length(pack("C", 0x41));
    }
}

sub popnode {

    my $node = shift;
    
    if(($#{$node}) >= 0) {
        delete $$node[ $#{$node} ];
    }

}

sub ClearStack {
    my $node = shift;

    popnode($node) while($#{$node} >= 0);

    # DEBUG print "ClearStack\n"; #DEBUG

}

1;
