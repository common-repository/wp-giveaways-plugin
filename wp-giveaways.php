<?php
/*
Plugin Name: WP-Giveaways
Plugin URI: http://www.craftitonline.com
Description: Provide a widget for giveaways
Author: Luis Cordova
Version: 1.0
Author URI: http://www.craftitonline.com/

Please donate to: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=11103035
*/
function giveaways() 
{
	/* 
		here we will embed the functionality to list giveaway category posts 
		giveaway category ID = 17
	*/

	query_posts("posts_per_page=5&cat=17");
	$string1 = '<li class="giveaways"><ul class="giveaways1">';
	if (have_posts()) :
		while (have_posts()) : the_post();
			$customarray = get_post_custom_values('startdate');
			$date1 = $customarray[0];
			$customarray = get_post_custom_values('enddate');
			$date2 = $customarray[0];
			//echo $date1.$date2;
			if (!empty($date1) && !empty($date2)) {
				/* if today falls between date1 and date2 then display */
				if((strtotime("$date1") <= strtotime("now")) && (strtotime("$date2") >= strtotime("now"))) {
					$string1 = $string1.'<li><a href="'.get_permalink() .'">'.get_the_title().'</a></li>';
				}
			}
		endwhile;
	else:
		$string1 = "<p>"._e('Sorry, no posts matched your criteria.')."</p>";
		$string1 = "";
	endif;
	$string1 .= "</ul></li>";
	echo $string1;
}

function widget_myGiveaways($args) {
	extract($args);
?>
  <!--<h2 class="widgettitle"></h2>-->
  <img src="/storage/giveaways.jpg">
  <?php giveaways(); ?>
  <img src="/storage/giveaway-footer.jpg">
<?php
}
function myGiveaways_init()
{
  register_sidebar_widget(__('Giveaways widget'), 'widget_myGiveaways');     
}
add_action("plugins_loaded", "myGiveaways_init");

?>