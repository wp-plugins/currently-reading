<?php
/*
	Plugin Name: Currently Reading
	Plugin URI: http://blog.damn.org.za/widgets/
	Description: Display a Currently Reading widget using the Google Books API
	Author: Eugéne Roux
	Version: 4.0
	Author URI: http://damn.org.za/
 */

//
//	CurrentlyReading Class
//
class CurrentlyReading extends WP_Widget {
	function CurrentlyReading() {
		$widget_ops = array( 'classname' => 'widget_reading', 'description' => __( 'Display a Currently Reading widget using the Google Books API' ), 'internalcss' => true );
		$this->WP_Widget( 'reading', __( 'Reading', 'reading_widget' ), $widget_ops );
		$this->widget_defaults = [
			'internalcss' => true,
			'boxshadow' => true,
			'domain' => 'google.co.za',
		];
	}

	//
	//	@see WP_Widget::widget
	//
	function widget( $args, $instance ) {
		$args = wp_parse_args( $args, $this->widget_defaults );
		extract( $args );
		//$widget_options = wp_parse_args( $instance, $this->widget_defaults );

		$title = apply_filters( 'widget_title', $instance[ 'title' ]);
		$internalcss = $instance[ "internalcss" ] ? true : false;
		$boxshadow   = $instance[ "boxshadow" ]   ? true : false;
		$localdomain = $instance[ "domain" ]      ? $instance[ "domain" ] : "google.co.za";

		if ( $instance['isbn'] != "" ) {	  // No point in a "Currently Reading" if you aren't, is there?

			$spacechars = array( ' ', '-', '_' );
			$myisbn = str_replace( $spacechars, "", $instance[ 'isbn' ]);
			$isbnjson = json_decode( file_get_contents( "https://www.googleapis.com/books/v1/volumes?q=isbn:" . $myisbn ), true );

			if ( $isbnjson[ "totalItems" ] > 0 ) {

				echo $before_widget;

				if ( $title )
					echo $before_title . $title . $after_title; // This way we get to choose a "No Title" scenario...


				print("\n\t<!-- ISBN: " . $myisbn . " / Title: " . $isbnjson[ 'items' ][0][ 'volumeInfo' ][ 'title' ] . " -->\n");

				print( "\t\t<div" );
				if ( $internalcss ) {
					print( " style='margin: 1em; padding: 2ex;'" );
				}
				print( " class='currentlyreading' id='currenlyreading-ISBN" . $myisbn . "'>\n");

				$googlelink = $isbnjson[ 'items' ][0][ 'volumeInfo' ][ 'canonicalVolumeLink' ];
				print("\n\t<!-- Google Link: " . $googlelink . " -->\n");

				print( "\t\t\t<a href='" . str_replace( "google.com", $localdomain, $googlelink ) . "'>");
				print( "<img class='currentlyreading' id='currenlyreading-ISBN" . $myisbn . "-img' " );
				if ( $boxshadow ) {
					print( "style='-moz-box-shadow: #CCC 5px 5px 5px; -webkit-box-shadow: #CCC 5px 5px 5px; " );
					print( "-khtml-box-shadow: #CCC 5px 5px 5px; box-shadow: #CCC 5px 5px 5px;' " );
				}
				print( "src='"   . $isbnjson[ 'items' ][0][ 'volumeInfo' ][ 'imageLinks' ][ 'thumbnail' ] 	. "' " );
				print( "alt='"   . $isbnjson[ 'items' ][0][ 'volumeInfo' ][ 'title' ]						. "' ");
				print( "title='" . $isbnjson[ 'items' ][0][ 'volumeInfo' ][ 'title' ]						. "'/></a>\n");
				print( "\t\t</div>\n");

				echo $after_widget;
			}
		}
	}

	//
	//	@see WP_Widget::update
	//
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'title' ]		= strip_tags( $new_instance[ 'title' ]);
		$instance[ 'isbn' ]			= strip_tags( $new_instance[ 'isbn' ]);
		$instance[ 'internalcss' ]	= $new_instance[ 'internalcss' ] ? 1 : 0;
		$instance[ 'boxshadow' ]	= $new_instance[ 'boxshadow'   ] ? 1 : 0;
		$instance[ "domain" ]		= $new_instance[ "domain" ]      ? $new_instance[ "domain" ] : "google.co.za";
		return $instance;
	}

	//
	//	@see WP_Widget::form
	//
	function form( $instance ) {
		$instance = wp_parse_args( $instance, $this->widget_defaults );
		extract( $instance );

		$title       = esc_attr( $instance[ 'title' ]);
		$isbn        = esc_attr( strip_tags( $instance[ 'isbn' ]));
		$internalcss = $instance[ 'internalcss' ] ? "checked='checked'" : "";
		$boxshadow   = $instance[ 'boxshadow' ]   ? "checked='checked'" : "";
		$activedom   = $instance[ 'domain' ];

		$googledomains = [
			'Worldwide' => 'google.com',
			'Afghanistan' => 'google.com.af',
			'Albania' => 'google.al',
			'Algeria' => 'google.dz',
			'American Samoa' => 'google.as',
			'Andorra' => 'google.ad',
			'Angola' => 'google.co.ao',
			'Anguilla' => 'google.com.ai',
			'Antigua and Barbuda' => 'google.com.ag',
			'Argentina' => 'google.com.ar',
			'Armenia' => 'google.am',
			'Ascension Island' => 'google.ac',
			'Australia' => 'google.com.au',
			'Austria' => 'google.at',
			'Azerbaijan' => 'google.az',
			'Bahamas' => 'google.bs',
			'Bahrain' => 'google.com.bh',
			'Bangladesh' => 'google.com.bd',
			'Belarus' => 'google.by',
			'Belgium' => 'google.be',
			'Belize' => 'google.com.bz',
			'Benin' => 'google.bj',
			'Bhutan' => 'google.bt',
			'Bolivia' => 'google.com.bo',
			'Bosnia and Herzegovina' => 'google.ba',
			'Botswana' => 'google.co.bw',
			'Brazil' => 'google.com.br',
			'British Indian Ocean Territory' => 'google.io',
			'British Virgin Islands' => 'google.vg',
			'Brunei' => 'google.com.bn',
			'Bulgaria' => 'google.bg',
			'Burkina Faso' => 'google.bf',
			'Burma' => 'google.com.mm',
			'Burundi' => 'google.bi',
			'Cambodia' => 'google.com.kh',
			'Cameroon' => 'google.cm',
			'Canada' => 'google.ca',
			'Cape Verde' => 'google.cv',
			'Catalonia Catalan Countries' => 'google.cat',
			'Central African Republic' => 'google.cf',
			'Chad' => 'google.td',
			'Chile' => 'google.cl',
			'China' => 'g.cn',
			'China' => 'google.cn',
			'Cocos (Keeling) Islands' => 'google.cc',
			'Colombia' => 'google.com.co',
			'Cook Islands' => 'google.co.ck',
			'Costa Rica' => 'google.co.cr',
			'Croatia' => 'google.hr',
			'Cuba' => 'google.com.cu',
			'Cyprus' => 'google.com.cy',
			'Czech Republic' => 'google.cz',
			'Democratic Republic of the Congo' => 'google.cd',
			'Denmark' => 'google.dk',
			'Djibouti' => 'google.dj',
			'Dominica' => 'google.dm',
			'Dominican Republic' => 'google.com.do',
			'Ecuador' => 'google.com.ec',
			'Egypt' => 'google.com.eg',
			'El Salvador' => 'google.com.sv',
			'Estonia' => 'google.ee',
			'Ethiopia' => 'google.com.et',
			'Federated States of Micronesia' => 'google.fm',
			'Fiji' => 'google.com.fj',
			'Finland' => 'google.fi',
			'France' => 'google.fr',
			'French Guiana' => 'google.gf',
			'Gabon' => 'google.ga',
			'Gambia' => 'google.gm',
			'Georgia' => 'google.ge',
			'Germany' => 'google.de',
			'Ghana' => 'google.com.gh',
			'Gibraltar' => 'google.com.gi',
			'Greece' => 'google.gr',
			'Greenland' => 'google.gl',
			'Guadeloupe' => 'google.gp',
			'Guatemala' => 'google.com.gt',
			'Guernsey' => 'google.gg',
			'Guyana' => 'google.gy',
			'Haiti' => 'google.ht',
			'Honduras' => 'google.hn',
			'Hong Kong' => 'google.com.hk',
			'Hungary' => 'google.hu',
			'Iceland' => 'google.is',
			'India' => 'google.co.in',
			'Indonesia' => 'google.co.id',
			'Iran' => 'google.ir',
			'Iraq' => 'google.iq',
			'Ireland' => 'google.ie',
			'Isle of Man' => 'google.im',
			'Israel' => 'google.co.il',
			'Italy' => 'google.it',
			'Ivory Coast' => 'google.ci',
			'Jamaica' => 'google.com.jm',
			'Japan' => 'google.co.jp',
			'Jersey' => 'google.je',
			'Jordan' => 'google.jo',
			'Kazakhstan' => 'google.kz',
			'Kenya' => 'google.co.ke',
			'Kiribati' => 'google.ki',
			'Kuwait' => 'google.com.kw',
			'Kyrgyzstan' => 'google.kg',
			'Laos' => 'google.la',
			'Latvia' => 'google.lv',
			'Lebanon' => 'google.com.lb',
			'Lesotho' => 'google.co.ls',
			'Libya' => 'google.com.ly',
			'Liechtenstein' => 'google.li',
			'Lithuania' => 'google.lt',
			'Luxembourg' => 'google.lu',
			'Macedonia' => 'google.mk',
			'Madagascar' => 'google.mg',
			'Malawi' => 'google.mw',
			'Malaysia' => 'google.com.my',
			'Maldives' => 'google.mv',
			'Mali' => 'google.ml',
			'Malta' => 'google.com.mt',
			'Mauritius' => 'google.mu',
			'Mexico' => 'google.com.mx',
			'Moldova' => 'google.md',
			'Mongolia' => 'google.mn',
			'Montenegro' => 'google.me',
			'Montserrat' => 'google.ms',
			'Morocco' => 'google.co.ma',
			'Mozambique' => 'google.co.mz',
			'Namibia' => 'google.com.na',
			'Nauru' => 'google.nr',
			'Nepal' => 'google.com.np',
			'Netherlands' => 'google.nl',
			'New Zealand' => 'google.co.nz',
			'Nicaragua' => 'google.com.ni',
			'Niger' => 'google.ne',
			'Nigeria' => 'google.com.ng',
			'Niue' => 'google.nu',
			'Norfolk Island' => 'google.com.nf',
			'Norway' => 'google.no',
			'Oman' => 'google.com.om',
			'Pakistan' => 'google.com.pk',
			'Palestine' => 'google.ps',
			'Panama' => 'google.com.pa',
			'Papua New Guinea' => 'google.com.pg',
			'Paraguay' => 'google.com.py',
			'Peru' => 'google.com.pe',
			'Philippines' => 'google.com.ph',
			'Pitcairn Islands' => 'google.pn',
			'Poland' => 'google.pl',
			'Portugal' => 'google.pt',
			'Puerto Rico' => 'google.com.pr',
			'Qatar' => 'google.com.qa',
			'Republic of the Congo' => 'google.cg',
			'Romania' => 'google.ro',
			'Russia' => 'google.ru',
			'Rwanda' => 'google.rw',
			'Saint Helena, Ascension, Tristan da Cunha' => 'google.sh',
			'Saint Lucia' => 'google.com.lc',
			'Saint Vincent and the Grenadines' => 'google.com.vc',
			'Samoa' => 'google.ws',
			'San Marino' => 'google.sm',
			'Saudi Arabia' => 'google.com.sa',
			'Senegal' => 'google.sn',
			'Serbia' => 'google.rs',
			'Seychelles' => 'google.sc',
			'Sierra Leone' => 'google.com.sl',
			'Singapore' => 'google.com.sg',
			'Slovakia' => 'google.sk',
			'Slovenia' => 'google.si',
			'Solomon Islands' => 'google.com.sb',
			'Somalia' => 'google.so',
			'South Africa' => 'google.co.za',
			'South Korea' => 'google.co.kr',
			'Spain' => 'google.es',
			'Sri Lanka' => 'google.lk',
			'Sweden' => 'google.se',
			'Switzerland' => 'google.ch',
			'São Tomé and Príncipe' => 'google.st',
			'Taiwan' => 'google.com.tw',
			'Tajikistan' => 'google.com.tj',
			'Tanzania' => 'google.co.tz',
			'Thailand' => 'google.co.th',
			'Timor-Leste' => 'google.tl',
			'Togo' => 'google.tg',
			'Tokelau' => 'google.tk',
			'Tonga' => 'google.to',
			'Trinidad and Tobago' => 'google.tt',
			'Tunisia' => 'google.com.tn',
			'Tunisia' => 'google.tn',
			'Turkey' => 'google.com.tr',
			'Turkmenistan' => 'google.tm',
			'Uganda' => 'google.co.ug',
			'Ukraine' => 'google.com.ua',
			'United Arab Emirates' => 'google.ae',
			'United Kingdom' => 'google.co.uk',
			'United States Virgin Islands' => 'google.co.vi',
			'United States' => 'google.us',
			'Uruguay' => 'google.com.uy',
			'Uzbekistan' => 'google.co.uz',
			'Vanuatu' => 'google.vu',
			'Venezuela' => 'google.co.ve',
			'Vietnam' => 'google.com.vn',
			'Zambia' => 'google.co.zm',
			'Zimbabwe' => 'google.co.zw',
		];

		print( "\t<p>\n\t\t<label for='" . $this->get_field_id("title") . "'>" ); _e( "Title:" );
		print( "\n\t\t\t<input class='widefat' id='" . $this->get_field_id('title') . "' name='" );
		print( $this->get_field_name( 'title' ) . "' type='text' value='" . $title );
		print( "' />\n\t\t</label>\n\t\t<em>Leave blank for no title</em>\n\t</p>\n" );

		print( "\t<p>\n\t\t<label for='" . $this->get_field_id( "isbn" ) . "'>" ); _e( "ISBN:" );
		print( "\n\t\t\t<input class='widefat' id='" . $this->get_field_id( 'isbn' ) . "' name='" );
		print( $this->get_field_name( "isbn" ) . "' type='text' value='" . $isbn . "' />\n\t\t</label>\n\t</p>\n" );

		print( "\t<p>\n" );
		print( "\t\t<input class='checkbox' type='checkbox' " . $internalcss );
		print( " id='" . $this->get_field_id( "internalcss" ) . "' name='" . $this->get_field_name( "internalcss" ) . "'/>\n" );
		print( "\t\t<label for='" . $this->get_field_id( "internalcss" ) . "'>" ); _e( "Pad the Image" );
		print( "\n\t\t<br />\n" );
		print( "\t\t<input class='checkbox' type='checkbox' " . $boxshadow );
		print( " id='" . $this->get_field_id( "boxshadow" ) . "' name='" . $this->get_field_name( "boxshadow" ) . "'/>\n" );
		print( "\t\t<label for='" . $this->get_field_id( "boxshadow" ) . "'>" ); _e( "Display a Box-Shadow" );
		print( "</label>\n\t</p>\n" );

		print( "\t<p>\n" );
		_e( "Choose Alternate Google Country" );
		print( "\t\t<select class='select' type='select' id='" . $this->get_field_id( "domain" ) . "' name='" . $this->get_field_name( "domain" ) . "'>\n");
		foreach ( $googledomains as $country => $domain ) {
			if ( $domain == $activedom )
				print( "\t\t\t<option value='$domain' selected>$country</option>\n" );
			else
				print( "\t\t\t<option value='$domain'>$country</option>\n" );
		}
		print( "\t\t</select>\n");
		print( "\t\t<br /><em>Please change if your audience gets a Google '500' error</em>\n\t</p>\n" );
	}
}

//
//	register CurrentlyReading widget
//
add_action( 'widgets_init', create_function( '', 'return register_widget( "CurrentlyReading" );' ));
?>
