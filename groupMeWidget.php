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

$response = wp_remote_get( 'https://api.groupme.com/v3/groups/26254485/messages?token=29FGbqXjZHS5FdXsObHMqgkWT1AFerdbYjMAaxr1' ); //use HTTP GET to retrieve server status information from the API
echo "<img src='http://ouitspecialist.com/wp-content/uploads/2017/07/group_me_icon.png'>", "<br>";
if( is_array($response) ) {
    $body = $response['body']; // use the content
    $a = json_decode($body, true); //parse the json from the HTTP GET
    for($i = 0; $i < 5; $i++) {
        $message_sender = $a['response']['messages'][$i]['name']; //Set a variable called message_sender equal to the name attribute for the ith item in the messages list
        $message_text = $a['response']['messages'][$i]['text']; //Set a variable called message_text equal to the name attribute for the ith item in the messages list
        echo "<p><strong>", $message_sender, "</strong>: ", $message_text, "</p>"; //print the message
    }
} else {
echo "Error communicating with Group Me API";
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
