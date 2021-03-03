<?php
/**
 * Template Name: Listeo iCal Output
 */

if( !isset($_GET['calendar'])){
    wp_die('Oooops.. Something went wrong');
}

$decode = hex2bin($_GET['calendar']);
$data_decode = explode('|', $decode);
$listing_id = $data_decode[0];

$slug = get_post_field( 'post_name', $listing_id ); 
$title = get_post_field( 'post_title', $listing_id ); 

header('Content-type: text/calendar; charset=utf-8');
header('Content-Disposition: inline; filename='.$slug.'.ics');

$output  = "BEGIN:VCALENDAR\r\n";
$output .= "PRODID:-//".get_bloginfo( 'name' )."//EN\r\n";
$output .= "X-WR-CALNAME:".$title.esc_html__(' - Bookings','listeo_core', 'listeo')."\r\n";
$output .= "X-ORIGINAL-URL:".get_permalink($listing_id)."\r\n";
	//get default blog timezone and output only if we're not in UTC or with manual offsets

if(get_option('listeo_ical_timezone')){	
	$blog_timezone = wp_timezone();
	if( is_object($blog_timezone)) {
		$blog_timezone_name = $blog_timezone->getName();
	$output .= "TZID:{$blog_timezone_name}\r\n";
	$output .= "X-WR-TIMEZONE:{$blog_timezone_name}\r\n";
	}
}	

$output .= "CALSCALE:GREGORIAN\r\n";
$output .= "VERSION:2.0\r\n";
$output .= listeo_get_ical_events($listing_id);
$output .= "END:VCALENDAR\r\n";

print $output;
exit();