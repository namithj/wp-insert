<?php
$wpInsertGeoLocation = false;

function wp_insert_form_accordion_tabs_geo_targeting( $control, $identifier, $location ) {
	echo '<h3>Geo Targeting</h3>';
	echo '<div>';
		echo '<p>';
			echo 'A Geo Targeted Ads have a higher priority than Ads configured via Multiple Ad Networks / A-B Testing.<br />';
			echo 'If a Geo Targeting match is found all other Ads (Primary, Secondary and Tertiary Networks) will be ignored.';
		echo '</p>';
		$control->add_control(
			[
				'type'       => 'choosen-multiselect',
				'label'      => 'Countries',
				'optionName' => 'geo_group1_countries',
				'options'    => wp_insert_get_countries(),
			]
		);
		$control->add_control(
			[
				'type'       => 'textarea',
				'label'      => 'Ad Code',
				'style'      => 'height: 220px;',
				'optionName' => 'geo_group1_adcode',
			]
		);
		$control->create_section( 'Group 1' );
		$control->set_HTML( '<div class="wp_insert_rule_block">' . $control->HTML . '</div>' );
		echo $control->HTML;
		$control->clear_controls();

		$control->add_control(
			[
				'type'       => 'choosen-multiselect',
				'label'      => 'Countries',
				'optionName' => 'geo_group2_countries',
				'options'    => wp_insert_get_countries(),
			]
		);
		$control->add_control(
			[
				'type'       => 'textarea',
				'label'      => 'Ad Code',
				'style'      => 'height: 220px;',
				'optionName' => 'geo_group2_adcode',
			]
		);
		$control->create_section( 'Group 2' );
		$control->set_HTML( '<div class="wp_insert_rule_block">' . $control->HTML . '</div><div style="clear: both;"></div>' );
		echo $control->HTML;
		$control->clear_controls();
		echo '<p>';
			echo 'This feature uses the Free Geo ip service from <a href="http://freegeoip.net/">freegeoip.net</a>, if you find this feature useful please consider donating to the project at <a href="http://freegeoip.net/">freegeoip.net</a>';
		echo '</p>';
	echo '</div>';
	return $control;
}

/* Begin Generate Country List */
function wp_insert_get_countries() {
	$data = [
		[
			'value' => 'AD',
			'text'  => 'Andorra',
		],
		[
			'value' => 'AE',
			'text'  => 'United Arab Emirates',
		],
		[
			'value' => 'AF',
			'text'  => 'Afghanistan',
		],
		[
			'value' => 'AG',
			'text'  => 'Antigua and Barbuda',
		],
		[
			'value' => 'AI',
			'text'  => 'Anguilla',
		],
		[
			'value' => 'AL',
			'text'  => 'Albania',
		],
		[
			'value' => 'AM',
			'text'  => 'Armenia',
		],
		[
			'value' => 'AN',
			'text'  => 'Netherlands Antilles',
		],
		[
			'value' => 'AO',
			'text'  => 'Angola',
		],
		[
			'value' => 'AQ',
			'text'  => 'Antarctica',
		],
		[
			'value' => 'AR',
			'text'  => 'Argentina',
		],
		[
			'value' => 'AS',
			'text'  => 'American Samoa',
		],
		[
			'value' => 'AT',
			'text'  => 'Austria',
		],
		[
			'value' => 'AU',
			'text'  => 'Australia',
		],
		[
			'value' => 'AW',
			'text'  => 'Aruba',
		],
		[
			'value' => 'AZ',
			'text'  => 'Azerbaijan',
		],
		[
			'value' => 'BA',
			'text'  => 'Bosnia and Herzegovina',
		],
		[
			'value' => 'BB',
			'text'  => 'Barbados',
		],
		[
			'value' => 'BD',
			'text'  => 'Bangladesh',
		],
		[
			'value' => 'BE',
			'text'  => 'Belgium',
		],
		[
			'value' => 'BF',
			'text'  => 'Burkina Faso',
		],
		[
			'value' => 'BG',
			'text'  => 'Bulgaria',
		],
		[
			'value' => 'BH',
			'text'  => 'Bahrain',
		],
		[
			'value' => 'BI',
			'text'  => 'Burundi',
		],
		[
			'value' => 'BJ',
			'text'  => 'Benin',
		],
		[
			'value' => 'BM',
			'text'  => 'Bermuda',
		],
		[
			'value' => 'BN',
			'text'  => 'Brunei Darussalam',
		],
		[
			'value' => 'BO',
			'text'  => 'Bolivia',
		],
		[
			'value' => 'BR',
			'text'  => 'Brazil',
		],
		[
			'value' => 'BS',
			'text'  => 'Bahamas',
		],
		[
			'value' => 'BT',
			'text'  => 'Bhutan',
		],
		[
			'value' => 'BV',
			'text'  => 'Bouvet Island',
		],
		[
			'value' => 'BW',
			'text'  => 'Botswana',
		],
		[
			'value' => 'BY',
			'text'  => 'Belarus',
		],
		[
			'value' => 'BZ',
			'text'  => 'Belize',
		],
		[
			'value' => 'CA',
			'text'  => 'Canada',
		],
		[
			'value' => 'CC',
			'text'  => 'Cocos (Keeling) Islands',
		],
		[
			'value' => 'CD',
			'text'  => 'The Democratic Republic of the Congo',
		],
		[
			'value' => 'CF',
			'text'  => 'Central African Republic',
		],
		[
			'value' => 'CG',
			'text'  => 'Congo',
		],
		[
			'value' => 'CH',
			'text'  => 'Switzerland',
		],
		[
			'value' => 'CI',
			'text'  => 'Cote D\'Ivoire',
		],
		[
			'value' => 'CK',
			'text'  => 'Cook Islands',
		],
		[
			'value' => 'CL',
			'text'  => 'Chile',
		],
		[
			'value' => 'CM',
			'text'  => 'Cameroon',
		],
		[
			'value' => 'CN',
			'text'  => 'China',
		],
		[
			'value' => 'CO',
			'text'  => 'Colombia',
		],
		[
			'value' => 'CR',
			'text'  => 'Costa Rica',
		],
		[
			'value' => 'CU',
			'text'  => 'Cuba',
		],
		[
			'value' => 'CV',
			'text'  => 'Cape Verde',
		],
		[
			'value' => 'CX',
			'text'  => 'Christmas Island',
		],
		[
			'value' => 'CY',
			'text'  => 'Cyprus',
		],
		[
			'value' => 'CZ',
			'text'  => 'Czech Republic',
		],
		[
			'value' => 'DE',
			'text'  => 'Germany',
		],
		[
			'value' => 'DJ',
			'text'  => 'Djibouti',
		],
		[
			'value' => 'DK',
			'text'  => 'Denmark',
		],
		[
			'value' => 'DM',
			'text'  => 'Dominica',
		],
		[
			'value' => 'DO',
			'text'  => 'Dominican Republic',
		],
		[
			'value' => 'DZ',
			'text'  => 'Algeria',
		],
		[
			'value' => 'EC',
			'text'  => 'Ecuador',
		],
		[
			'value' => 'EE',
			'text'  => 'Estonia',
		],
		[
			'value' => 'EG',
			'text'  => 'Egypt',
		],
		[
			'value' => 'EH',
			'text'  => 'Western Sahara',
		],
		[
			'value' => 'ER',
			'text'  => 'Eritrea',
		],
		[
			'value' => 'ES',
			'text'  => 'Spain',
		],
		[
			'value' => 'ET',
			'text'  => 'Ethiopia',
		],
		[
			'value' => 'FI',
			'text'  => 'Finland',
		],
		[
			'value' => 'FJ',
			'text'  => 'Fiji',
		],
		[
			'value' => 'FK',
			'text'  => 'Falkland Islands (Malvinas)',
		],
		[
			'value' => 'FM',
			'text'  => 'Federated States of Micronesia',
		],
		[
			'value' => 'FO',
			'text'  => 'Faroe Islands',
		],
		[
			'value' => 'FR',
			'text'  => 'France',
		],
		[
			'value' => 'FX',
			'text'  => 'France Metropolitan',
		],
		[
			'value' => 'GA',
			'text'  => 'Gabon',
		],
		[
			'value' => 'GB',
			'text'  => 'United Kingdom',
		],
		[
			'value' => 'GD',
			'text'  => 'Grenada',
		],
		[
			'value' => 'GE',
			'text'  => 'Georgia',
		],
		[
			'value' => 'GF',
			'text'  => 'French Guiana',
		],
		[
			'value' => 'GH',
			'text'  => 'Ghana',
		],
		[
			'value' => 'GI',
			'text'  => 'Gibraltar',
		],
		[
			'value' => 'GL',
			'text'  => 'Greenland',
		],
		[
			'value' => 'GM',
			'text'  => 'Gambia',
		],
		[
			'value' => 'GN',
			'text'  => 'Guinea',
		],
		[
			'value' => 'GP',
			'text'  => 'Guadeloupe',
		],
		[
			'value' => 'GQ',
			'text'  => 'Equatorial Guinea',
		],
		[
			'value' => 'GR',
			'text'  => 'Greece',
		],
		[
			'value' => 'GS',
			'text'  => 'South Georgia and the South Sandwich Islands',
		],
		[
			'value' => 'GT',
			'text'  => 'Guatemala',
		],
		[
			'value' => 'GU',
			'text'  => 'Guam',
		],
		[
			'value' => 'GW',
			'text'  => 'Guinea-Bissau',
		],
		[
			'value' => 'GY',
			'text'  => 'Guyana',
		],
		[
			'value' => 'HK',
			'text'  => 'Hong Kong',
		],
		[
			'value' => 'HM',
			'text'  => 'Heard Island and McDonald Islands',
		],
		[
			'value' => 'HN',
			'text'  => 'Honduras',
		],
		[
			'value' => 'HR',
			'text'  => 'Croatia',
		],
		[
			'value' => 'HT',
			'text'  => 'Haiti',
		],
		[
			'value' => 'HU',
			'text'  => 'Hungary',
		],
		[
			'value' => 'ID',
			'text'  => 'Indonesia',
		],
		[
			'value' => 'IE',
			'text'  => 'Ireland',
		],
		[
			'value' => 'IL',
			'text'  => 'Israel',
		],
		[
			'value' => 'IN',
			'text'  => 'India',
		],
		[
			'value' => 'IO',
			'text'  => 'British Indian Ocean Territory',
		],
		[
			'value' => 'IQ',
			'text'  => 'Iraq',
		],
		[
			'value' => 'IR',
			'text'  => 'Islamic Republic of Iran',
		],
		[
			'value' => 'IS',
			'text'  => 'Iceland',
		],
		[
			'value' => 'IT',
			'text'  => 'Italy',
		],
		[
			'value' => 'JM',
			'text'  => 'Jamaica',
		],
		[
			'value' => 'JO',
			'text'  => 'Jordan',
		],
		[
			'value' => 'JP',
			'text'  => 'Japan',
		],
		[
			'value' => 'KE',
			'text'  => 'Kenya',
		],
		[
			'value' => 'KG',
			'text'  => 'Kyrgyzstan',
		],
		[
			'value' => 'KH',
			'text'  => 'Cambodia',
		],
		[
			'value' => 'KI',
			'text'  => 'Kiribati',
		],
		[
			'value' => 'KM',
			'text'  => 'Comoros',
		],
		[
			'value' => 'KN',
			'text'  => 'Saint Kitts and Nevis',
		],
		[
			'value' => 'KP',
			'text'  => 'Democratic People\'s Republic of Korea',
		],
		[
			'value' => 'KR',
			'text'  => 'Republic of Korea',
		],
		[
			'value' => 'KW',
			'text'  => 'Kuwait',
		],
		[
			'value' => 'KY',
			'text'  => 'Cayman Islands',
		],
		[
			'value' => 'KZ',
			'text'  => 'Kazakhstan',
		],
		[
			'value' => 'LA',
			'text'  => 'Lao People\'s Democratic Republic',
		],
		[
			'value' => 'LB',
			'text'  => 'Lebanon',
		],
		[
			'value' => 'LC',
			'text'  => 'Saint Lucia',
		],
		[
			'value' => 'LI',
			'text'  => 'Liechtenstein',
		],
		[
			'value' => 'LK',
			'text'  => 'Sri Lanka',
		],
		[
			'value' => 'LR',
			'text'  => 'Liberia',
		],
		[
			'value' => 'LS',
			'text'  => 'Lesotho',
		],
		[
			'value' => 'LT',
			'text'  => 'Lithuania',
		],
		[
			'value' => 'LU',
			'text'  => 'Luxembourg',
		],
		[
			'value' => 'LV',
			'text'  => 'Latvia',
		],
		[
			'value' => 'LY',
			'text'  => 'Libyan Arab Jamahiriya',
		],
		[
			'value' => 'MA',
			'text'  => 'Morocco',
		],
		[
			'value' => 'MC',
			'text'  => 'Monaco',
		],
		[
			'value' => 'MD',
			'text'  => 'Republic of Moldova',
		],
		[
			'value' => 'MG',
			'text'  => 'Madagascar',
		],
		[
			'value' => 'MH',
			'text'  => 'Marshall Islands',
		],
		[
			'value' => 'MK',
			'text'  => 'Macedonia',
		],
		[
			'value' => 'ML',
			'text'  => 'Mali',
		],
		[
			'value' => 'MM',
			'text'  => 'Myanmar',
		],
		[
			'value' => 'MN',
			'text'  => 'Mongolia',
		],
		[
			'value' => 'MO',
			'text'  => 'Macau',
		],
		[
			'value' => 'MP',
			'text'  => 'Northern Mariana Islands',
		],
		[
			'value' => 'MQ',
			'text'  => 'Martinique',
		],
		[
			'value' => 'MR',
			'text'  => 'Mauritania',
		],
		[
			'value' => 'MS',
			'text'  => 'Montserrat',
		],
		[
			'value' => 'MT',
			'text'  => 'Malta',
		],
		[
			'value' => 'MU',
			'text'  => 'Mauritius',
		],
		[
			'value' => 'MV',
			'text'  => 'Maldives',
		],
		[
			'value' => 'MW',
			'text'  => 'Malawi',
		],
		[
			'value' => 'MX',
			'text'  => 'Mexico',
		],
		[
			'value' => 'MY',
			'text'  => 'Malaysia',
		],
		[
			'value' => 'MZ',
			'text'  => 'Mozambique',
		],
		[
			'value' => 'NA',
			'text'  => 'Namibia',
		],
		[
			'value' => 'NC',
			'text'  => 'New Caledonia',
		],
		[
			'value' => 'NE',
			'text'  => 'Niger',
		],
		[
			'value' => 'NF',
			'text'  => 'Norfolk Island',
		],
		[
			'value' => 'NG',
			'text'  => 'Nigeria',
		],
		[
			'value' => 'NI',
			'text'  => 'Nicaragua',
		],
		[
			'value' => 'NL',
			'text'  => 'Netherlands',
		],
		[
			'value' => 'NO',
			'text'  => 'Norway',
		],
		[
			'value' => 'NP',
			'text'  => 'Nepal',
		],
		[
			'value' => 'NR',
			'text'  => 'Nauru',
		],
		[
			'value' => 'NU',
			'text'  => 'Niue',
		],
		[
			'value' => 'NZ',
			'text'  => 'New Zealand',
		],
		[
			'value' => 'OM',
			'text'  => 'Oman',
		],
		[
			'value' => 'PA',
			'text'  => 'Panama',
		],
		[
			'value' => 'PE',
			'text'  => 'Peru',
		],
		[
			'value' => 'PF',
			'text'  => 'French Polynesia',
		],
		[
			'value' => 'PG',
			'text'  => 'Papua New Guinea',
		],
		[
			'value' => 'PH',
			'text'  => 'Philippines',
		],
		[
			'value' => 'PK',
			'text'  => 'Pakistan',
		],
		[
			'value' => 'PL',
			'text'  => 'Poland',
		],
		[
			'value' => 'PM',
			'text'  => 'Saint Pierre and Miquelon',
		],
		[
			'value' => 'PN',
			'text'  => 'Pitcairn Islands',
		],
		[
			'value' => 'PR',
			'text'  => 'Puerto Rico',
		],
		[
			'value' => 'PS',
			'text'  => 'Palestinian Territory',
		],
		[
			'value' => 'PT',
			'text'  => 'Portugal',
		],
		[
			'value' => 'PW',
			'text'  => 'Palau',
		],
		[
			'value' => 'PY',
			'text'  => 'Paraguay',
		],
		[
			'value' => 'QA',
			'text'  => 'Qatar',
		],
		[
			'value' => 'RE',
			'text'  => 'Reunion',
		],
		[
			'value' => 'RO',
			'text'  => 'Romania',
		],
		[
			'value' => 'RU',
			'text'  => 'Russian Federation',
		],
		[
			'value' => 'RW',
			'text'  => 'Rwanda',
		],
		[
			'value' => 'SA',
			'text'  => 'Saudi Arabia',
		],
		[
			'value' => 'SB',
			'text'  => 'Solomon Islands',
		],
		[
			'value' => 'SC',
			'text'  => 'Seychelles',
		],
		[
			'value' => 'SD',
			'text'  => 'Sudan',
		],
		[
			'value' => 'SE',
			'text'  => 'Sweden',
		],
		[
			'value' => 'SG',
			'text'  => 'Singapore',
		],
		[
			'value' => 'SH',
			'text'  => 'Saint Helena',
		],
		[
			'value' => 'SI',
			'text'  => 'Slovenia',
		],
		[
			'value' => 'SJ',
			'text'  => 'Svalbard and Jan Mayen',
		],
		[
			'value' => 'SK',
			'text'  => 'Slovakia',
		],
		[
			'value' => 'SL',
			'text'  => 'Sierra Leone',
		],
		[
			'value' => 'SM',
			'text'  => 'San Marino',
		],
		[
			'value' => 'SN',
			'text'  => 'Senegal',
		],
		[
			'value' => 'SO',
			'text'  => 'Somalia',
		],
		[
			'value' => 'SR',
			'text'  => 'Suriname',
		],
		[
			'value' => 'ST',
			'text'  => 'Sao Tome and Principe',
		],
		[
			'value' => 'SV',
			'text'  => 'El Salvador',
		],
		[
			'value' => 'SY',
			'text'  => 'Syrian Arab Republic',
		],
		[
			'value' => 'SZ',
			'text'  => 'Swaziland',
		],
		[
			'value' => 'TC',
			'text'  => 'Turks and Caicos Islands',
		],
		[
			'value' => 'TD',
			'text'  => 'Chad',
		],
		[
			'value' => 'TF',
			'text'  => 'French Southern Territories',
		],
		[
			'value' => 'TG',
			'text'  => 'Togo',
		],
		[
			'value' => 'TH',
			'text'  => 'Thailand',
		],
		[
			'value' => 'TJ',
			'text'  => 'Tajikistan',
		],
		[
			'value' => 'TK',
			'text'  => 'Tokelau',
		],
		[
			'value' => 'TM',
			'text'  => 'Turkmenistan',
		],
		[
			'value' => 'TN',
			'text'  => 'Tunisia',
		],
		[
			'value' => 'TO',
			'text'  => 'Tonga',
		],
		[
			'value' => 'TL',
			'text'  => 'Timor-Leste',
		],
		[
			'value' => 'TR',
			'text'  => 'Turkey',
		],
		[
			'value' => 'TT',
			'text'  => 'Trinidad and Tobago',
		],
		[
			'value' => 'TV',
			'text'  => 'Tuvalu',
		],
		[
			'value' => 'TW',
			'text'  => 'Taiwan',
		],
		[
			'value' => 'TZ',
			'text'  => 'United Republic of Tanzania',
		],
		[
			'value' => 'UA',
			'text'  => 'Ukraine',
		],
		[
			'value' => 'UG',
			'text'  => 'Uganda',
		],
		[
			'value' => 'UM',
			'text'  => 'United States Minor Outlying Islands',
		],
		[
			'value' => 'US',
			'text'  => 'United States',
		],
		[
			'value' => 'UY',
			'text'  => 'Uruguay',
		],
		[
			'value' => 'UZ',
			'text'  => 'Uzbekistan',
		],
		[
			'value' => 'VA',
			'text'  => 'Holy See (Vatican City State)',
		],
		[
			'value' => 'VC',
			'text'  => 'Saint Vincent and the Grenadines',
		],
		[
			'value' => 'VE',
			'text'  => 'Venezuela',
		],
		[
			'value' => 'VG',
			'text'  => 'British Virgin Islands',
		],
		[
			'value' => 'VI',
			'text'  => 'U.S. Virgin Islands',
		],
		[
			'value' => 'VN',
			'text'  => 'Vietnam',
		],
		[
			'value' => 'VU',
			'text'  => 'Vanuatu',
		],
		[
			'value' => 'WF',
			'text'  => 'Wallis and Futuna',
		],
		[
			'value' => 'WS',
			'text'  => 'Samoa',
		],
		[
			'value' => 'YE',
			'text'  => 'Yemen',
		],
		[
			'value' => 'YT',
			'text'  => 'Mayotte',
		],
		[
			'value' => 'RS',
			'text'  => 'Serbia',
		],
		[
			'value' => 'ZA',
			'text'  => 'South Africa',
		],
		[
			'value' => 'ZM',
			'text'  => 'Zambia',
		],
		[
			'value' => 'ME',
			'text'  => 'Montenegro',
		],
		[
			'value' => 'ZW',
			'text'  => 'Zimbabwe',
		],
		[
			'value' => 'A1',
			'text'  => 'Anonymous Proxy',
		],
		[
			'value' => 'A2',
			'text'  => 'Satellite Provider',
		],
		[
			'value' => 'O1',
			'text'  => 'Other',
		],
		[
			'value' => 'AX',
			'text'  => 'Aland Islands',
		],
		[
			'value' => 'GG',
			'text'  => 'Guernsey',
		],
		[
			'value' => 'IM',
			'text'  => 'Isle of Man',
		],
		[
			'value' => 'JE',
			'text'  => 'Jersey',
		],
		[
			'value' => 'BL',
			'text'  => 'Saint Barthelemy',
		],
		[
			'value' => 'MF',
			'text'  => 'Saint Martin',
		],
	];
	return $data;
}
/* End Generate Country List */

/* Begin Get Geo Targeted Ad Code */
add_action( 'init', 'wp_insert_ip_to_country' );
function wp_insert_ip_to_country() {
	global $wpInsertGeoLocation;
	$userIp = ( ( isset( $_SERVER['REMOTE_ADDR'] ) ) ? $_SERVER['REMOTE_ADDR'] : '' );
	if ( $wpInsertGeoLocation != false ) {
		return $wpInsertGeoLocation;
	} elseif ( $userIp != '' ) {
			$countryCode = get_transient( 'wp_insert_ip_' . $userIp );
		if ( $countryCode === false ) {
			if ( wp_insert_is_geoip_enabled() ) {
				$geoIp               = new \iriven\GeoIPCountry();
				$wpInsertGeoLocation = $geoIp->resolve( $userIp );
				set_transient( 'wp_insert_ip_' . $userIp, $wpInsertGeoLocation, WEEK_IN_SECONDS );
			}
		} else {
			$wpInsertGeoLocation = $countryCode;
		}
	}
}

function wp_insert_is_geoip_enabled() {
	$inpostads = get_option( 'wp_insert_inpostads' );
	if ( isset( $inpostads ) && is_array( $inpostads ) ) {
		foreach ( $inpostads as $inpostad ) {
			if ( isset( $inpostad['geo_group1_countries'] ) && isset( $inpostad['geo_group2_countries'] ) && ( ( is_array( $inpostad['geo_group1_countries'] ) && ( count( $inpostad['geo_group1_countries'] ) > 0 ) ) || ( is_array( $inpostad['geo_group2_countries'] ) && ( count( $inpostad['geo_group2_countries'] ) > 0 ) ) ) ) {
				return true;
			}
		}
	}

	$adwidgets = get_option( 'wp_insert_adwidgets' );
	if ( isset( $adwidgets ) && is_array( $adwidgets ) ) {
		foreach ( $adwidgets as $adwidget ) {
			if ( isset( $adwidget['geo_group1_countries'] ) && isset( $adwidget['geo_group2_countries'] ) && ( ( is_array( $adwidget['geo_group1_countries'] ) && ( count( $adwidget['geo_group1_countries'] ) > 0 ) ) || ( is_array( $adwidget['geo_group2_countries'] ) && ( count( $adwidget['geo_group2_countries'] ) > 0 ) ) ) ) {
				return true;
			}
		}
	}

	$inthemeads = get_option( 'wp_insert_inthemeads' );
	if ( isset( $inthemeads ) && is_array( $inthemeads ) ) {
		foreach ( $inthemeads as $inthemead ) {
			if ( isset( $inthemead['geo_group1_countries'] ) && isset( $inthemead['geo_group2_countries'] ) && ( ( is_array( $inthemead['geo_group1_countries'] ) && ( count( $inthemead['geo_group1_countries'] ) > 0 ) ) || ( is_array( $inthemead['geo_group2_countries'] ) && ( count( $inthemead['geo_group2_countries'] ) > 0 ) ) ) ) {
				return true;
			}
		}
	}

	$shortcodeads = get_option( 'wp_insert_shortcodeads' );
	if ( isset( $shortcodeads ) && is_array( $shortcodeads ) ) {
		foreach ( $shortcodeads as $shortcodead ) {
			if ( isset( $shortcodead['geo_group1_countries'] ) && isset( $shortcodead['geo_group2_countries'] ) && ( ( is_array( $shortcodead['geo_group1_countries'] ) && ( count( $shortcodead['geo_group1_countries'] ) > 0 ) ) || ( is_array( $shortcodead['geo_group2_countries'] ) && ( count( $shortcodead['geo_group2_countries'] ) > 0 ) ) ) ) {
				return true;
			}
		}
	}

	$pagelevelads = get_option( 'wp_insert_pagelevelads' );
	if ( isset( $pagelevelads ) && is_array( $pagelevelads ) ) {
		foreach ( $pagelevelads as $pagelevelad ) {
			if ( isset( $pagelevelad['geo_group1_countries'] ) && isset( $pagelevelad['geo_group2_countries'] ) && ( ( is_array( $pagelevelad['geo_group1_countries'] ) && ( count( $pagelevelad['geo_group1_countries'] ) > 0 ) ) || ( is_array( $pagelevelad['geo_group2_countries'] ) && ( count( $pagelevelad['geo_group2_countries'] ) > 0 ) ) ) ) {
				return true;
			}
		}
	}
	return false;
}
/* End Get Geo Targeted Ad Code */
