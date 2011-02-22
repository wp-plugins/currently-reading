<?php
/*
    Plugin Name: Currently Reading
    Plugin URI: http://www.damn.org.za/blog/currentlyreading
    Description: Display a Currently Reading widget using an image from (and linking to) the Google Books Website
    Author: Eugéne Roux
    Version: 3.3
    Author URI: http://damn.org.za/
 */

//
//  CurrentlyReading Class
//
class CurrentlyReading extends WP_Widget {
    /** constructor */
    function CurrentlyReading() {
        $widget_ops = array( 'classname' => 'widget_reading', 'description' => __( 'Display a Currently Reading widget using an image from (and linking to) the Google Books website' ), 'internalcss' => true );
        $this->WP_Widget( 'reading', __( 'Reading', 'reading_widget' ), $widget_ops );
        $this->widget_defaults = array(
            'internalcss' => true,
            'boxshadow' => true,
        );
    }

    //
    //  @see WP_Widget::widget
    //
    function widget($args, $instance) {		
        $args = wp_parse_args( $args, $this->widget_defaults );
        extract( $args );
		//$widget_options = wp_parse_args( $instance, $this->widget_defaults );

        $title = apply_filters('widget_title', $instance['title']);
        $internalcss = $instance["internalcss"] ? true : false;
        $boxshadow = $instance["boxshadow"] ? true : false;

        if ($instance['isbn'] != "") {      // No point in a "Currently Reading" if you aren't, is there?

            echo $before_widget;

            if ( $title )
                echo $before_title . $title . $after_title; // This way we get to choose a "No Title" scenario...

            $spacechars = array(' ', '-', '_');
            $myisbn = str_replace($spacechars, "", $instance['isbn']);

            print("\n\t<!-- ISBN: " . $instance['isbn'] . " -->\n");

            print("\t\t<div");
            if ( $internalcss ) {
                print(" style='margin: 1em; padding: 2ex;'");
            }
            print( " class='currentlyreading' id='currenlyreading-ISBN" . $myisbn . "'>\n");

            print( "\t\t\t<a href='http://books.google.com/books?vid=ISBN$myisbn'>");
            print( "<img class='currentlyreading' id='currenlyreading-ISBN" . $myisbn . "-img' " );
            if ( $boxshadow ) {
                print( "style='-moz-box-shadow: #CCC 5px 5px 5px; -webkit-box-shadow: #CCC 5px 5px 5px; " );
                print( "-khtml-box-shadow: #CCC 5px 5px 5px; box-shadow: #CCC 5px 5px 5px;' " );
            }
            print( "src='http://books.google.com/books?vid=ISBN$myisbn&printsec=frontcover&img=1&zoom=1' ");
            print( "alt='ISBN: " . $instance['isbn'] . "' title='ISBN: " . $instance['isbn'] . "'/></a>\n");
            print( "\t\t</div>\n");

            echo $after_widget;
        }
    }

    //
    //  @see WP_Widget::update
    //
    function update($new_instance, $old_instance) {				
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['isbn'] = strip_tags( $new_instance['isbn'] );
        $instance['internalcss'] = $new_instance['internalcss'] ? 1 : 0;
        $instance['boxshadow'] = $new_instance['boxshadow'] ? 1 : 0;
        return $instance;
    }

    //
    //  @see WP_Widget::form
    //
    function form( $instance ) {
        $instance = wp_parse_args( $instance, $this->widget_defaults );
        extract( $instance );

        $title = esc_attr( $instance['title'] );
        $isbn = esc_attr( $instance['isbn'] );
        $internalcss = $instance['internalcss'] ? "checked='checked'" : "";
        $boxshadow = $instance['boxshadow'] ? "checked='checked'" : "";

        print( "\t<p>\n\t\t<label for='" . $this->get_field_id("title") . "'>" ); _e( "Title:" ); 
        print( "\n\t\t\t<input class='widefat' id='" . $this->get_field_id('title') . "' name='" );
        print( $this->get_field_name('title') . "' type='text' value='" . $title );
        print( "' />\n\t\t</label>\n\t\t<em>Leave blank for no title</em>\n\t</p>\n" );

        print( "\t<p>\n\t\t<label for='" . $this->get_field_id("isbn") . "'>" ); _e( "ISBN:" );
        print( "\n\t\t\t<input class='widefat' id='" . $this->get_field_id("isbn") . "' name='" );
        print( $this->get_field_name("isbn") . "' type='text' value='" . $isbn . "' />\n\t\t</label>\n\t</p>\n" );

        print( "\t<p>\n" );
        print( "\t\t<input class='checkbox' type='checkbox' " . $internalcss );
        print( " id='" . $this->get_field_id("internalcss") . "' name='" . $this->get_field_name("internalcss") . "'/>\n" );
        print( "\t\t<label for='" . $this->get_field_id("internalcss") . "'>" ); _e( "Pad the Image" );
        print( "\n\t\t<br />\n" );
        print( "\t\t<input class='checkbox' type='checkbox' " . $boxshadow );
        print( " id='" . $this->get_field_id("boxshadow") . "' name='" . $this->get_field_name("boxshadow") . "'/>\n" );
        print( "\t\t<label for='" . $this->get_field_id("boxshadow") . "'>" ); _e( "Display a Box-Shadow" );
        print( "</label>\n\t</p>\n" );

    }
}

//
//  register CurrentlyReading widget
//
add_action('widgets_init', create_function('', 'return register_widget( "CurrentlyReading" );'));

