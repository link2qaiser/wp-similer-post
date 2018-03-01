<?php
   /*
   Plugin Name: Similer Post
   Plugin URI: http://dixeam.com
   Description: Wordpress plugin that show the same category post anywhere by short code
   Version: .1
   Author: Dixeam Developer- Qaiser
   Author URI: http://dixeam.com
   License: GPL2
   */
if (is_admin() ) {
   
}
if (!is_admin() && !is_home()) {
   function apply_head_css(){
   ?>
   <link rel="stylesheet" href="<?php echo  plugin_dir_url( __FILE__ ); ?>assets/owl.carousel.css">
    
   <?php
   }
   function apply_js(){
   ?>
    <script src="<?php echo  plugin_dir_url( __FILE__ ); ?>assets/owl.carousel.min.js"></script>
    <script type="text/javascript">

      
    </script>
   <?php
   }

   add_action('wp_head', 'apply_head_css');
   add_action('wp_footer', 'apply_js');
   function show_carousol( $atts ){
      $html .=  '';
      global $post;
      $postcat = get_the_category( $post->ID );
      if(isset($postcat[0])) {
      //echo get_the_category( $post->ID );
         $related = new WP_Query(
             array(
                 'category__in'   => $postcat[0]->term_id,
                 'posts_per_page' => $atts['posts'],
                 'post__not_in'   => array( $post->ID )
             )
         );
         if( $related->have_posts() ) { 
            
            $html .= '<h3 class="owl-themeheading"><span>Related List</span></h3><div class="owl-carousel owl-theme">';
             while( $related->have_posts() ) { 
                 $related->the_post(); 
                 $th = get_the_post_thumbnail(get_the_ID(), array( 324, 235 ));
                 $html .= '<div class="item"><a href="'.get_permalink().'">'.$th.'</a><a href="'.get_permalink().'"><h3>'.get_the_title().'</h3></a></div>';
                 /*whatever you want to output*/
             }
             $html .= '</div><br style="clear:both;">';
             
             wp_reset_postdata();
         }
      }
      return  $html;
    
   }
   add_shortcode( 'simcarousol', 'show_carousol' );
}
