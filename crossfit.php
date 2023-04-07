<?php
/*
Plugin Name: CrossFit Leaderboard
Plugin URI: 
Description: 
Version: 
Author: A.i - Amir
Author URI: 
License: 
License URI: 
*/


// Our custom post type function for CF Table

//register taxonomy for custom post tags
register_taxonomy( 
'cftag', //taxonomy 
'cftable', //post-type
array( 
    'hierarchical'  => false, 
    'label'         => __( 'CrossFit Events','taxonomy general name'), 
    'singular_name' => __( 'CrossFit Event', 'taxonomy general name' ), 
    'rewrite'       => false, 
    'query_var'     => true 
));


function cftable_init() {
    $args = array(
      'label' => 'CrossFit Leaderboard',
        'public' => false,  // it's not public, it shouldn't have it's own permalink, and so on
		'publicly_queryable' => true,  // you should be able to query it
		'exclude_from_search' => true,  // you should exclude it from search results
		'show_in_nav_menus' => false,  // you shouldn't be able to add it to menus
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
		'has_archive' => false,  // it shouldn't have archive page
        //'rewrite' => array('slug' => 'howto'),
		'rewrite' => false,  // it shouldn't have rewrite rules
		'menu_icon' => 'dashicons-awards',
        'query_var' => true,
		 // This is where we add taxonomies to our CPT
        'taxonomies'          => array( 'cftag' ),
        'supports' => array(
            'title',
           'custom-fields',)
        );
    register_post_type( 'cftable', $args );
}
add_action( 'init', 'cftable_init' );

// Add the custom columns to the book post type:
add_filter( 'manage_cftable_posts_columns', 'set_custom_cftable_columns' );
function set_custom_cftable_columns($columns) {
    unset( $columns['gadwp_stats'] );
    unset( $columns['author'] );
    $columns['shortcode'] = __( 'ShortCode');
    return $columns;
}

add_action( 'manage_cftable_posts_custom_column' , 'custom_cftable_column', 10, 2 );
function custom_cftable_column( $column, $post_id ) {
    switch ( $column ) {
        case 'shortcode' :
            echo '<input type="text" value="[cftable tid='.$post_id .']" readonly/>'; 
            break;
    }
}

////////////////////////// Code start by jitendra kachhadiya on 09 Sep 2020

function countryCode_from_countryName($country){
    $countries = array(
                    'AF' => 'Afghanistan',
                    'AX' => 'Aland Islands',
                    'AL' => 'Albania',
                    'DZ' => 'Algeria',
                    'AS' => 'American Samoa',
                    'AD' => 'Andorra',
                    'AO' => 'Angola',
                    'AI' => 'Anguilla',
                    'AQ' => 'Antarctica',
                    'AG' => 'Antigua And Barbuda',
                    'AR' => 'Argentina',
                    'AM' => 'Armenia',
                    'AW' => 'Aruba',
                    'AU' => 'Australia',
                    'AT' => 'Austria',
                    'AZ' => 'Azerbaijan',
                    'BS' => 'Bahamas',
                    'BH' => 'Bahrain',
                    'BD' => 'Bangladesh',
                    'BB' => 'Barbados',
                    'BY' => 'Belarus',
                    'BE' => 'Belgium',
                    'BZ' => 'Belize',
                    'BJ' => 'Benin',
                    'BM' => 'Bermuda',
                    'BT' => 'Bhutan',
                    'BO' => 'Bolivia',
                    'BA' => 'Bosnia And Herzegovina',
                    'BW' => 'Botswana',
                    'BV' => 'Bouvet Island',
                    'BR' => 'Brazil',
                    'IO' => 'British Indian Ocean Territory',
                    'BN' => 'Brunei Darussalam',
                    'BG' => 'Bulgaria',
                    'BF' => 'Burkina Faso',
                    'BI' => 'Burundi',
                    'KH' => 'Cambodia',
                    'CM' => 'Cameroon',
                    'CA' => 'Canada',
                    'CV' => 'Cape Verde',
                    'KY' => 'Cayman Islands',
                    'CF' => 'Central African Republic',
                    'TD' => 'Chad',
                    'CL' => 'Chile',
                    'CN' => 'China',
                    'CX' => 'Christmas Island',
                    'CC' => 'Cocos (Keeling) Islands',
                    'CO' => 'Colombia',
                    'KM' => 'Comoros',
                    'CG' => 'Congo',
                    'CD' => 'Congo, Democratic Republic',
                    'CK' => 'Cook Islands',
                    'CR' => 'Costa Rica',
                    'CI' => 'Cote D\'Ivoire',
                    'HR' => 'Croatia',
                    'CU' => 'Cuba',
                    'CY' => 'Cyprus',
                    'CZ' => 'Czech Republic',
                    'DK' => 'Denmark',
                    'DJ' => 'Djibouti',
                    'DM' => 'Dominica',
                    'DO' => 'Dominican Republic',
                    'EC' => 'Ecuador',
                    'EG' => 'Egypt',
                    'SV' => 'El Salvador',
                    'GQ' => 'Equatorial Guinea',
                    'ER' => 'Eritrea',
                    'EE' => 'Estonia',
                    'ET' => 'Ethiopia',
                    'FK' => 'Falkland Islands (Malvinas)',
                    'FO' => 'Faroe Islands',
                    'FJ' => 'Fiji',
                    'FI' => 'Finland',
                    'FR' => 'France',
                    'GF' => 'French Guiana',
                    'PF' => 'French Polynesia',
                    'TF' => 'French Southern Territories',
                    'GA' => 'Gabon',
                    'GM' => 'Gambia',
                    'GE' => 'Georgia',
                    'DE' => 'Germany',
                    'GH' => 'Ghana',
                    'GI' => 'Gibraltar',
                    'GR' => 'Greece',
                    'GL' => 'Greenland',
                    'GD' => 'Grenada',
                    'GP' => 'Guadeloupe',
                    'GU' => 'Guam',
                    'GT' => 'Guatemala',
                    'GG' => 'Guernsey',
                    'GN' => 'Guinea',
                    'GW' => 'Guinea-Bissau',
                    'GY' => 'Guyana',
                    'HT' => 'Haiti',
                    'HM' => 'Heard Island & Mcdonald Islands',
                    'VA' => 'Holy See (Vatican City State)',
                    'HN' => 'Honduras',
                    'HK' => 'Hong Kong',
                    'HU' => 'Hungary',
                    'IS' => 'Iceland',
                    'IN' => 'India',
                    'ID' => 'Indonesia',
                    'IR' => 'Iran, Islamic Republic Of',
                    'IQ' => 'Iraq',
                    'IE' => 'Ireland',
                    'IM' => 'Isle Of Man',
                    'IL' => 'Israel',
                    'IT' => 'Italy',
                    'JM' => 'Jamaica',
                    'JP' => 'Japan',
                    'JE' => 'Jersey',
                    'JO' => 'Jordan',
                    'KZ' => 'Kazakhstan',
                    'KE' => 'Kenya',
                    'KI' => 'Kiribati',
                    'KR' => 'Korea',
                    'KW' => 'Kuwait',
                    'KG' => 'Kyrgyzstan',
                    'LA' => 'Lao People\'s Democratic Republic',
                    'LV' => 'Latvia',
                    'LB' => 'Lebanon',
                    'LS' => 'Lesotho',
                    'LR' => 'Liberia',
                    'LY' => 'Libyan Arab Jamahiriya',
                    'LI' => 'Liechtenstein',
                    'LT' => 'Lithuania',
                    'LU' => 'Luxembourg',
                    'MO' => 'Macao',
                    'MK' => 'Macedonia',
                    'MG' => 'Madagascar',
                    'MW' => 'Malawi',
                    'MY' => 'Malaysia',
                    'MV' => 'Maldives',
                    'ML' => 'Mali',
                    'MT' => 'Malta',
                    'MH' => 'Marshall Islands',
                    'MQ' => 'Martinique',
                    'MR' => 'Mauritania',
                    'MU' => 'Mauritius',
                    'YT' => 'Mayotte',
                    'MX' => 'Mexico',
                    'FM' => 'Micronesia, Federated States Of',
                    'MD' => 'Moldova',
                    'MC' => 'Monaco',
                    'MN' => 'Mongolia',
                    'ME' => 'Montenegro',
                    'MS' => 'Montserrat',
                    'MA' => 'Morocco',
                    'MZ' => 'Mozambique',
                    'MM' => 'Myanmar',
                    'NA' => 'Namibia',
                    'NR' => 'Nauru',
                    'NP' => 'Nepal',
                    'NL' => 'Netherlands',
                    'AN' => 'Netherlands Antilles',
                    'NC' => 'New Caledonia',
                    'NZ' => 'New Zealand',
                    'NI' => 'Nicaragua',
                    'NE' => 'Niger',
                    'NG' => 'Nigeria',
                    'NU' => 'Niue',
                    'NF' => 'Norfolk Island',
                    'MP' => 'Northern Mariana Islands',
                    'NO' => 'Norway',
                    'OM' => 'Oman',
                    'PK' => 'Pakistan',
                    'PW' => 'Palau',
                    'PS' => 'Palestinian Territory, Occupied',
                    'PA' => 'Panama',
                    'PG' => 'Papua New Guinea',
                    'PY' => 'Paraguay',
                    'PE' => 'Peru',
                    'PH' => 'Philippines',
                    'PN' => 'Pitcairn',
                    'PL' => 'Poland',
                    'PT' => 'Portugal',
                    'PR' => 'Puerto Rico',
                    'QA' => 'Qatar',
                    'RE' => 'Reunion',
                    'RO' => 'Romania',
                    'RU' => 'Russia',
                    'RW' => 'Rwanda',
                    'BL' => 'Saint Barthelemy',
                    'SH' => 'Saint Helena',
                    'KN' => 'Saint Kitts And Nevis',
                    'LC' => 'Saint Lucia',
                    'MF' => 'Saint Martin',
                    'PM' => 'Saint Pierre And Miquelon',
                    'VC' => 'Saint Vincent And Grenadines',
                    'WS' => 'Samoa',
                    'SM' => 'San Marino',
                    'ST' => 'Sao Tome And Principe',
                    'SA' => 'Saudi Arabia',
                    'SN' => 'Senegal',
                    'RS' => 'Serbia',
                    'SC' => 'Seychelles',
                    'SL' => 'Sierra Leone',
                    'SG' => 'Singapore',
                    'SK' => 'Slovakia',
                    'SI' => 'Slovenia',
                    'SB' => 'Solomon Islands',
                    'SO' => 'Somalia',
                    'ZA' => 'South Africa',
                    'GS' => 'South Georgia And Sandwich Isl.',
					'KR' => 'South Korea',
                    'ES' => 'Spain',
                    'LK' => 'Sri Lanka',
                    'SD' => 'Sudan',
                    'SR' => 'Suriname',
                    'SJ' => 'Svalbard And Jan Mayen',
                    'SZ' => 'Swaziland',
                    'SE' => 'Sweden',
                    'CH' => 'Switzerland',
                    'SY' => 'Syrian Arab Republic',
                    'TW' => 'Taiwan',
                    'TJ' => 'Tajikistan',
                    'TZ' => 'Tanzania',
                    'TH' => 'Thailand',
                    'TL' => 'Timor-Leste',
                    'TG' => 'Togo',
                    'TK' => 'Tokelau',
                    'TO' => 'Tonga',
                    'TT' => 'Trinidad And Tobago',
                    'TN' => 'Tunisia',
                    'TR' => 'Turkey',
                    'TM' => 'Turkmenistan',
                    'TC' => 'Turks And Caicos Islands',
                    'TV' => 'Tuvalu',
                    'UG' => 'Uganda',
                    'UA' => 'Ukraine',
                    'AE' => 'United Arab Emirates',
                    'GB' => 'United Kingdom',
                    'US' => 'United States',
                    'UM' => 'United States Outlying Islands',
                    'UY' => 'Uruguay',
                    'UZ' => 'Uzbekistan',
                    'VU' => 'Vanuatu',
                    'VE' => 'Venezuela',
                    'VN' => 'Viet Nam',
                    'VG' => 'Virgin Islands, British',
                    'VI' => 'Virgin Islands, U.S.',
                    'WF' => 'Wallis And Futuna',
                    'EH' => 'Western Sahara',
                    'YE' => 'Yemen',
                    'ZM' => 'Zambia',
                    'ZW' => 'Zimbabwe',
                );
    $iso_code = array_search(strtolower($country), array_map('strtolower', $countries)); ## easy version
    return $iso_code;
}
if (!function_exists('cftable')) {

    function cftable($atts = array()) {
        ob_start();
        if (empty($atts)) {
            wp_redirect(home_url());
            die();
        }
        $post_id = trim($atts['tid']);
        $total_rows = trim($atts['total'])>0?trim($atts['total']):"all";
        $type = trim($atts['type']);
        $disc = trim($atts['disc']);
		$terms= trim($atts['terms']);
        $post = get_post($post_id);
        $cftable_random_id = uniqid();
if (function_exists( 'is_amp_endpoint' ) && is_amp_endpoint()) { // check AMP
//Render the simple HTML table without CSS. 1-Female // 2-Male
		if ($type=='f'){
?>
                <table id="cftabletbl">
                     <tr class="cfhead">
                            <td>Rank</th>
                            <td>Country</th>
                            <td>Name</th>
                            <td>Points</th>
                        </tr>
                    <?php $rows = get_cftable_array($post_id,'female',$total_rows);
                    if(!empty($rows)){
                        $i=1;
                        foreach ($rows as $row) { 
                            $country = str_replace("_"," ",$row['country']);
                            $country = ucwords($country);
                            $country_code = countryCode_from_countryName($country);
                            $country_code = strtolower($country_code);
                            $flag = "<div style='width:50px;'><img src='".plugin_dir_url(__FILE__)."flags/svg/".$country_code.".svg' style='width:50px;' /></div>";
                    ?>
                        <tr>
                            <td><?=$i++;?></td>
                            <td><?=$flag;?></td>
                            <td><?=$row['athlete_name'];?></td>
                            <td><?=floor($row['points']);?></td>
                        </tr>
                        <?php }
                    }else{ ?>
                        <tr><td colspan="4"><center>No record found!</center></td></tr>
                    <?php }?>
                </table>
<?php			
		}else if($type=='m'){
?>
                <table id="cftabletbl">
                     <tr class="cfhead">
                            <td>Rank</th>
                            <td>Country</th>
                            <td>Name</th>
                            <td>Points</th>
                        </tr>
                    <?php $rows = get_cftable_array($post_id,'male',$total_rows);
                    if(!empty($rows)){
                        $i=1;
                        foreach ($rows as $row) { 
                            $country = str_replace("_"," ",$row['country']);
                            $country = ucwords($country);
                            $country_code = countryCode_from_countryName($country);
                            $country_code = strtolower($country_code);
                            $flag = "<div style='width:50px;'><img src='".plugin_dir_url(__FILE__)."flags/svg/".$country_code.".svg' style='width:50px;' /></div>";
                    ?>
                        <tr>
                            <td><?=$i++;?></td>
                            <td><?=$flag;?></td>
                            <td><?=$row['athlete_name'];?></td>
                            <td><?=floor($row['points']);?></td>
                        </tr>
                        <?php }
                    }else{ ?>
                        <tr><td colspan="4"><center>No record found!</center></td></tr>
                    <?php }?>
                </table>
<?php			
		}else{
?>
                <h3>Women's Leaderboard</h3>
                <table id="cftabletbl">
                        <tr class="cfhead">
                            <td>Rank</th>
                            <td>Country</th>
                            <td>Name</th>
                            <td>Points</th>
                        </tr>
                    <?php $rows = get_cftable_array($post_id,'female',$total_rows);
                    if(!empty($rows)){
                        $i=1;
                        foreach ($rows as $row) { 
                            $country = str_replace("_"," ",$row['country']);
                            $country = ucwords($country);
                            $country_code = countryCode_from_countryName($country);
                            $country_code = strtolower($country_code);
                            $flag = "<div style='width:50px;'><img src='".plugin_dir_url(__FILE__)."flags/svg/".$country_code.".svg' style='width:50px;' /></div>";
                    ?>
                        <tr>
                            <td><?=$i++;?></td>
                            <td><?=$flag;?></td>
                            <td><?=$row['athlete_name'];?></td>
                            <td><?=floor($row['points']);?></td>
                        </tr>
                        <?php }
                    }else{ ?>
                        <tr><td colspan="4"><center>No record found!</center></td></tr>
                    <?php }?>
                </table>
<hr/>
	<h3>Men's Leaderboard</h3>
                <table id="cftabletbl">
                    <tr class="cfhead">
                            <td>Rank</th>
                            <td>Country</th>
                            <td>Name</th>
                            <td>Points</th>
                        </tr>
                    <?php $rows = get_cftable_array($post_id,'male',$total_rows);
                    if(!empty($rows)){
                        $i=1;
                        foreach ($rows as $row) { 
                            $country = str_replace("_"," ",$row['country']);
                            $country = ucwords($country);
                            $country_code = countryCode_from_countryName($country);
                            $country_code = strtolower($country_code);
                            $flag = "<div style='width:50px;'><img src='".plugin_dir_url(__FILE__)."flags/svg/".$country_code.".svg' style='width:50px;' /></div>";
                    ?>
                        <tr>
                            <td><?=$i++;?></td>
                            <td><?=$flag;?></td>
                            <td><?=$row['athlete_name'];?></td>
                            <td><?=floor($row['points']);?></td>
                        </tr>
                        <?php }
                    }else{ ?>
                        <tr><td colspan="4"><center>No record found!</center></td></tr>
                    <?php }?>
                </table>
	
<?php
		}
}else{		
        if ($post->post_type == "cftable" && !is_admin()) { 
            
            ?>
            <style>
                .search-input-select{background: white;color: black;    height: 35px;
    margin: 0px;
    padding: 5px;font-size:15px;}
                .cftablewrap{}
				.cftablewrap .filter_option{padding: 0 0 5px 0; float:left;}
                .cftablewrap.filter{padding-bottom: 5px; padding-top: 0px;}
                .col-sm{float:left;margin-right:10px;}
                .clearfix{clear:both;}
                #cftabletbl-<?=$cftable_random_id;?>{width:100%}
				/*.single-post .cftablewrap {}*/ 
				/*table*/
#cftabletbl-<?=$cftable_random_id;?> {
    border: solid 1px #2c2c2c;
    border-collapse: collapse;
    border-spacing: 0;
    font: normal 13px Arial, sans-serif;
}
#cftabletbl-<?=$cftable_random_id;?> thead th {
    background-color: #2c2c2c;
    border: solid 1px #2c2c2c;
    color: #fff;
    padding: 10px;
	   text-align:center;

   
}
#cftabletbl-<?=$cftable_random_id;?> tbody td {
    border: solid 1px #ccc;
    color: #333;
    padding: 6px;
	    text-align:center;

}
#cftabletbl-<?=$cftable_random_id;?> td:nth-child(1) {width:10%;}
#cftabletbl-<?=$cftable_random_id;?> td:nth-child(2) {width:20%;}
#cftabletbl-<?=$cftable_random_id;?> td:nth-child(3) {width:50%; text-align:left;    
}
#cftabletbl-<?=$cftable_random_id;?> td:nth-child(4) {width:20%;}
#cftabletbl-<?=$cftable_random_id;?> tr:nth-child(even){
  background-color: #f7f7f7;

}
/*end*/
                span.flag-icon {font-size: 40px;}
                @media only screen and (max-width: 767px) {
                    .cftable_wapper .filter_text {
                        text-align: center;
                        margin-bottom: 15px;
                    } 
                    .filter_option{
                        margin: 0 auto;
                        display: table;
                    }
                    .filter_option .col-sm {
                        float: left;
                        text-align: left;
                        margin-right: 5px;
                        margin-bottom: 2px;
                    }
                    .filter_option .search-input-select {
                        background: white;
                        color: black;
                        max-width: 300px;
                        width: 100%;
                    }
                    .cftable_wapper hr{
                        margin-top: 20px;
                    }
                    table {
                        border-collapse: collapse;
                        border-spacing: 0;
                        width: 100%;
                        border: 1px solid #ddd;
                    }

                }
            </style>
<?php if ($type=='f'){?>
<div class="cftablewrap cftable_wapper  filter cftableBody-<?=$post_id;?>">
                <table id="cftabletbl-<?=$cftable_random_id;?>">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Country</th>
                            <th>Name</th>
                            <th>Points</th>
                        </tr>
                    </thead>

                    <tbody id="cftableBody-<?=$cftable_random_id;?>">
                    <?php $rows = get_cftable_array($post_id,'female',$total_rows);
                    if(!empty($rows)){
                        $i=1;
                        foreach ($rows as $row) { 
                            $country = str_replace("_"," ",$row['country']);
                            $country = ucwords($country);
                            $country_code = countryCode_from_countryName($country);
                            $country_code = strtolower($country_code);
                            $flag = "<img src='".plugin_dir_url(__FILE__)."flags/svg/".$country_code.".svg' style='width:50px;' />";
                    ?>
                        <tr>
                            <td><?=$i++;?></td>
                            <td><?=$flag;?></td>
                            <td><?=$row['athlete_name'];?></td>
                            <td><?=floor($row['points']);?></td>
                        </tr>
                        <?php }
                    }else{ ?>
                        <tr><td colspan="4"><center>No record found!</center></td></tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
<?php }else if($type=='m'){ ?>
	<div class="cftablewrap cftable_wapper  filter cftableBody-<?=$post_id;?>">
                <table id="cftabletbl-<?=$cftable_random_id;?>">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Country</th>
                            <th>Name</th>
                            <th>Points</th>
                        </tr>
                    </thead>

                    <tbody id="cftableBody-<?=$cftable_random_id;?>">
                    <?php $rows = get_cftable_array($post_id,'male',$total_rows);
                    if(!empty($rows)){
                        $i=1;
                        foreach ($rows as $row) { 
                            $country = str_replace("_"," ",$row['country']);
                            $country = ucwords($country);
                            $country_code = countryCode_from_countryName($country);
                            $country_code = strtolower($country_code);
                            $flag = "<img src='".plugin_dir_url(__FILE__)."flags/svg/".$country_code.".svg' style='width:50px;' />";
                    ?>
                        <tr>
                            <td><?=$i++;?></td>
                            <td><?=$flag;?></td>
                            <td><?=$row['athlete_name'];?></td>
                            <td><?=floor($row['points']);?></td>
                        </tr>
                        <?php }
                    }else{ ?>
                        <tr><td colspan="4"><center>No record found!</center></td></tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
<?php }else{ ?>            
            <div class="cftablewrap cftable_wapper  filter cftableBody-<?=$post_id;?>">
                <div class="filter_option">
                    <div class="col-sm">
                        <select data-column="1" name="gender" id="gender-<?=$cftable_random_id;?>" class="search-input-select" onchange="get_cftable_<?=$cftable_random_id;?>();"> 
                            <option value="female">Women</option> 
                            <option value="male">Men</option> 
                        </select> 
                    </div>
                    <?php
                   /* $terms = get_terms([
                        'taxonomy' => 'cftag',
                        'hide_empty' => false,
						'include' => $post_id,
                    ]);*/
					$terms = wp_get_post_terms( $post_id, 'cftag' ); 

					
                    ?>
                    <div class="col-sm">
                        <select data-column="2" name="events" id="events-<?=$cftable_random_id;?>" class="search-input-select" onchange="get_cftable_<?=$cftable_random_id;?>();"> 
                            <option value="">Overall</option> 
                            <?php
                            foreach($terms as $term){ ?>
                                <option value="<?=$term->term_id;?>"><?=$term->name;?></option> 
                           <?php }
                            ?>
                        </select> 
                    </div>
                    <div class="clearfix"></div>
                </div>
                <table id="cftabletbl-<?=$cftable_random_id;?>">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Country</th>
                            <th>Name</th>
                            <th>Points</th>
                        </tr>
                    </thead>

                    <tbody id="cftableBody-<?=$cftable_random_id;?>">
                    <?php $rows = get_cftable_array($post_id,'female',$total_rows);
                    if(!empty($rows)){
                        $i=1;
                        foreach ($rows as $row) { 
                            $country = str_replace("_"," ",$row['country']);
                            $country = ucwords($country);
                            $country_code = countryCode_from_countryName($country);
                            $country_code = strtolower($country_code);
                            $flag = "<img src='".plugin_dir_url(__FILE__)."flags/svg/".$country_code.".svg' style='width:50px;' />";
                    ?>
                        <tr>
                            <td><?=$i++;?></td>
                            <td><?=$flag;?></td>
                            <td><?=$row['athlete_name'];?></td>
                            <td><?=floor($row['points']);?></td>
                        </tr>
                        <?php }
                    }else{ ?>
                        <tr><td colspan="4"><center>No record found!</center></td></tr>
                    <?php }?>
                    </tbody>
                </table>
                <?php if ($disc!=""){?>
                <span class="tlab_txt"><em><?php echo $disc;?></em></span>
                <?php }?>
            </div>
            <script>
                function get_cftable_<?=$cftable_random_id;?>(){
                    var gndr = document.getElementById("gender-<?=$cftable_random_id;?>").value;
                    var evnt = document.getElementById("events-<?=$cftable_random_id;?>").value;
                    var cftable_rows = '<?=$total_rows;?>';
                    var xhttp = new XMLHttpRequest();
                      xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            var response = this.responseText;
                            var lastChar = response[response.length -1];
                            if(lastChar==0){
                                response = response.substring(0,response.length - 1);
                            }
                            var data = response.split("^|^");
                            if(data[0].trim()=="success"){
                                document.getElementById("cftableBody-<?=$cftable_random_id;?>").innerHTML=data[1];
                            }else{
                                document.getElementById("cftableBody-<?=$cftable_random_id;?>").innerHTML='<tr><td colspan="4"><center>No record found!</center></td></tr>';
                                return false;
                            }
                        }
                      };
                      xhttp.open("POST", "<?php echo admin_url( 'admin-ajax.php' ); ?>", true);
                      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                      xhttp.send('gender=' + gndr+'&evnt='+evnt+'&total='+cftable_rows+'&pid=<?= $post_id; ?>&action=get_cftable_list');
                }
                
            </script>
            <?php
}
          //  $post->post_title = "";
        }
       
    }//AMP end
	 return ob_get_clean();	
}
}
add_shortcode('cftable', 'cftable');

function wpb_after_post_content($content) {
    global $post;
    if ($post->post_type == "cftable" && !is_admin() && is_single()) {
        $content .= do_shortcode('[cftable tid=' . $post->ID . ']'); 
    }
    return $content;
}

add_filter( "the_content", "wpb_after_post_content" );

function get_cftable_array($postId,$gender='female',$total_rows="all",$term=""){
    $rows = array();
    if( have_rows($gender, $postId) ){
        while( have_rows($gender, $postId) ) { 
            the_row();
            $inner_data = array();
            $country = get_sub_field('country', $postId);
            $athlete_name = get_sub_field('athlete_name', $postId);
            $points = get_sub_field('points', $postId);
            $event = get_sub_field('event', $postId);
            
            if($term!=""){
                if($term==$event){
                    $inner_data['points'] = $points;
                    $inner_data['athlete_name'] = $athlete_name;
                    $inner_data['country'] = $country;
                    $data[] = $inner_data;
                } 
                
            }else{
                $inner_data['points'] = $points;
                $inner_data['athlete_name'] = $athlete_name;
                $inner_data['country'] = $country;
                $data[] = $inner_data;
            }
            
        }
    }


    $myarray = array();
    $arr = $data;
    foreach($arr as $k => $v) { 
        $new_arr[$v['country'].$v['athlete_name']][]=$v; 
    } 
    $myarray = array();
    foreach($new_arr as $key => $value){
        $myarray[] = $value;
    }
    $sumArray = array();
    
    foreach ($myarray as $k=>$subArray) {
        $innerArr = array();

        $points = 0;
        foreach ($subArray as $id=>$value) {
            $innArr = array();
            $innArr['points'] = 0;
            if(count($value)>1){
                //echo $value['points']."<br>";
                $points .= $value['points'];
                $innArr['points'] .=   $value['points'];
                $innArr['country'] = $value['country'];
                $innArr['athlete_name'] = $value['athlete_name'];
            }
        }
        if(isset($subArray['country'])){
            $innerArr['points'] =   $subArray['points'];
            $innerArr['country'] = $subArray['country'];
            $innerArr['athlete_name'] = $subArray['athlete_name'];
        }else{
            $innerArr['points'] =   $points;
            $innerArr['country'] = $innArr['country'];
            $innerArr['athlete_name'] = $innArr['athlete_name'];
        }
        $rows[] = $innerArr;
    }
   // echo "<pre>"; print_r(array_reverse($rows)); echo "</pre>";
    $newrows = $rows;
    //asort($newrows);
    rsort($newrows);	
    if($total_rows!="all"){
        $newrows =array_slice($newrows, 0, $total_rows, true);
    }
//    echo "<pre>"; print_r($newrows);exit;
    
     return $newrows;
}
function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
    $sort_col = array();
    foreach ($arr as $key=> $row) {
        $sort_col[$key] = $row[$col];
    }

    array_multisort($sort_col, $dir, $arr);
}

function get_cftable_list(){
    global $wpdb,$post;
    $requestData = $_REQUEST;
    $postId = trim($_POST['pid']);
    $gender = trim($_POST['gender']);
    $term = trim($_POST['evnt']);
    $total_rows = trim($_POST['total']);
    $rows = get_cftable_array($postId,$gender,$total_rows,$term);
    
//    echo "<pre>";print_r($dataa);die();
    $tbody = '';
    if(!empty($rows)){
        $i=1;
        foreach ($rows as $row) {  // preparing an array
            $country = str_replace("_"," ",$row['country']);
            $country = ucwords($country);
            $country_code = countryCode_from_countryName($country);
            $country_code = strtolower($country_code);
            $flag = "<img src='".plugin_dir_url(__FILE__)."flags/svg/".$country_code.".svg' style='width:50px;' />";
            $tbody .='<tr>
                        <td>'.$i++.'</td>
                        <td>'.$flag.'</td>
                        <td>'.$row['athlete_name'].'</td>
                        <td>'.floor($row['points']).'</td>
                    </tr>';
        }
    }else{
        $tbody .='<tr><td colspan="4"><center>No record found!</center></td></tr>';
    }

    echo "success^|^".$tbody;  // send data as json format
    die();
}
add_action('wp_ajax_get_cftable_list', 'get_cftable_list');
add_action('wp_ajax_nopriv_get_cftable_list', 'get_cftable_list');

////////////////////////// Code end by jitendra kachhadiya on 09 Sep 2020