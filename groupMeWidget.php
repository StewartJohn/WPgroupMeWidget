<?php
/*
Plugin Name: Group Me Widget
Description: Adds a widget to the site that displays the latest posts from a GroupMe account
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
echo __( 'Hello, World!', 'groupMe_widget_domain' );
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
