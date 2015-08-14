<?php
/*
Plugin Name: Custom Category Widget
Plugin URI: http://srsujon.com/widgets/custom-cateogry-widget
Description: This is a plugin which will give you facilities for showing your categories at the sidebars of your theme
Author: Saidur Rahman Sujon
Version: 1.0
Author URI: http://srsujon.com
*/        

class sr_custom_category_widget extends WP_Widget {

    // constructor
    function sr_custom_category_widget() {
       parent::WP_Widget(false, $name = __('Custom Category Widget', 'wp_widget_plugin') );
       add_action( 'wp_head', array( $this, 'sr_custom_categories_css' ) );
    }

    // widget form creation
    function form($instance) {    
    // Check values
        if( $instance) {
             $title = esc_attr($instance['title']);
             $catids = esc_attr($instance['catids']);
             $textarea = esc_textarea($instance['textarea']);
        } else {
             $title = '';
             $text = '';
             $textarea = '';
        }
?>

<p>
<label for="<?php echo $this->get_field_name('title'); ?>"><?php _e('Title', 'wp_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_name('catids'); ?>"><?php _e('Insert Your Category Ids Semparated by comma (,)', 'wp_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('catids'); ?>" name="<?php echo $this->get_field_name('catids'); ?>" type="text" value="<?php echo $catids;  ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_name('textarea'); ?>"><?php _e('Custom CSS for Categories:', 'wp_widget_plugin'); ?></label>
<textarea class="widefat" id="<?php echo $this->get_field_id('textarea'); ?>" name="<?php echo $this->get_field_name('textarea'); ?>"><?php if(empty($textarea)){echo " ul.sr_categories{list-style-type:none;}";} else{echo $textarea; } ?></textarea>
</p>
<?php

    }

    //frontend css. which will set the design in the header
    
    function sr_custom_categories_css() {

          echo "<style>";
          
          $options =  get_option('widget_sr_custom_category_widget');
           foreach ($options as $content) {
                echo  $content1=stripslashes($content['textarea']);
           }
           
          echo "</style>";

       } 
    
   
    // widget update
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
          // Fields
          $instance['title'] = strip_tags($new_instance['title']);
          $instance['catids'] = strip_tags($new_instance['catids']);
          $instance['textarea'] = strip_tags($new_instance['textarea']);
          return $instance;
    }


    
    // widget display
    function widget($args, $instance) {
       extract( $args );
       // these are the widget options
       $title = apply_filters('widget_title', $instance['title']);
       $catids = $instance['catids'];  
       $textarea = $instance['textarea'];
       
       echo $before_widget;
       // Display the widget
       echo '<div class="widget-text wp_widget_plugin_box">';

   // Check if title is set
   if ( $title ) {
      echo $before_title . $title . $after_title;
   }
   
      if( $catids ) {

        $sr_category_ids = explode(",", $catids);
        
        $sr_category_ids_lenght = count($sr_category_ids);
        
        echo "<ul class='sr_categories'> "; 
        
        for($i=0;$i<$sr_category_ids_lenght;$i++){
            
        ?>

            <li><a href="<?php echo get_category_link( $sr_category_ids[$i] ); ?>" title="<?php echo get_cat_name($sr_category_ids[$i]); ?>">
            <?php echo get_cat_name($sr_category_ids[$i]); ?></a> </li>    
           
        <?php 
        }
        
        echo "</ul>" ; 
        

   } 
   // Check if textarea is set

   echo '</div>';           
   echo $after_widget;
    }
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("sr_custom_category_widget");'));        


