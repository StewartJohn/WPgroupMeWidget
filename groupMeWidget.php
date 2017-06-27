<?php
/**
 * Plugin Name: Group Me Widget
 * Plugin URI: https://github.com/StewartJohn/WPgroupMeWidget/
 * Description: Adds a widget to the site that displays the latest posts from a GroupMe account
 * Version: 0.1
 * Author: John Stewart
 * Author URI: https://johnastewart.org
 * License: GPL2
*/

/*   2017 John  (email : johnstewart@ou.edu)
 
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.
 
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
 
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* Start Adding Functions Below this Line */

// Register and load the widget
function groupMeWidget_load_widget() {
	register_widget( 'groupMe_widget' );
}
add_action( 'widgets_init', 'groupMeWidget_load_widget' );

// Creating the widget 
class groupMe_widget extends WP_Widget {

function __construct() {
parent::__construct(

// Base ID of your widget
'groupMe_widget', 

// Widget name will appear in UI
__('GroupMe Widget', 'groupMe_widget_domain'), 

// Widget description
array( 'description' => __( 'Sample widget based on WPBeginner Tutorial', 'groupMe_widget_domain' ), ) 
);
}

// Creating widget front-end

public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );

// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];

// This is where you run the code and display the output

$response = wp_remote_get( 'http://status.reclaimhosting.com/api/v1/components' ); //use HTTP GET to retrieve server status information from the API
echo "<img width='40px' height='40px' src='http://icons.iconarchive.com/icons/chrisbanks2/cold-fusion-hd/128/GroupMe-icon.png'><br />";
if( is_array($response) ) {
    $body = $response['body']; // use the content
    $a = json_decode($body, true); //parse the json from the HTTP GET
    $serverName1 = $a[data][7][name]; //Set a variable called serverName1 equal to the name attribute for the 7th item in the Server List
    $status1 = $a[data][7][status_name]; //Set a variable called status1 equal to the status_name attribute for the 7th item in the Server List
    $serverName2 = $a[data][15][name]; //Set a variable called serverName2 equal to the name attribute for the 15th item in the Server List
    $status2 = $a[data][15][status_name]; //Set a variable called status2 equal to the status_name attribute for the 15th item in the Server List
if( $status1=="Operational") {
    echo $serverName1, ": ", $status1, " ", "<img src='https://create.ou.edu/wp-content/uploads/2016/02/2000px-MW-Icon-CheckMark.svg_-e1456421962246.png'>", "<br />"; //Print the information for the first server to the screen
    } else {
    echo $serverName1, ": ", $status1, " ", "<img src='https://create.ou.edu/wp-content/uploads/2016/02/420px-X_mark.svg_-4-e1456422394441.png'>", "<br />"; //Print the information for the first server to the screen
    }
if( $status2=="Operational") {
    echo $serverName2, ": ", $status2, " ", "<img src='https://create.ou.edu/wp-content/uploads/2016/02/2000px-MW-Icon-CheckMark.svg_-e1456421962246.png'>"; //Print the information for the second server to the screen
    } else {
    echo $serverName2, ": ", $status2, " ", "<img src='https://create.ou.edu/wp-content/uploads/2016/02/420px-X_mark.svg_-4-e1456422394441.png'>"; //Print the information for the second server to the screen
    }
} else {
echo "Error communicating with GroupMe API";
}
	
//echo __( 'Hello, World!', 'groupMe_widget_domain' );
echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'New title', 'groupMe_widget_domain' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}
} // Class wpb_widget ends here

/* Stop Adding Functions Below this Line */
?>
