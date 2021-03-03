<?php	

$parallax 			= get_post_meta($post->ID, 'listeo_parallax_image', TRUE);
$parallax_color 	= get_post_meta($post->ID, 'listeo_parallax_color', TRUE);
$parallax_opacity 	= get_post_meta($post->ID, 'listeo_parallax_opacity', TRUE);

$title 				= get_the_title($post->ID);
$subtitle 			= get_post_meta($post->ID, 'listeo_subtitle', true); 

$parallax_output  	= '';
$parallax_output .= (!empty($parallax)) ? ' data-background="'.esc_url($parallax).'" ' : '' ;
$parallax_output .= (!empty($parallax_color)) ? ' data-color="'.esc_attr($parallax_color).'" ' : '' ;
$parallax_output .= (!empty($parallax_opacity)) ? ' data-color-opacity="'.esc_attr($parallax_opacity).'" ' : '' ;

?>
<!-- Titlebar
================================================== -->
<div class="parallax titlebar" <?php echo wp_kses_post($parallax_output); //XSS ok, escaped above ?> >

    <div id="titlebar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <h2><?php the_title(); ?></h2>
                    <?php 
                    if(isset($_GET['keyword_search'])) {
                        ?>
                        <span>
                        <?php
                        $count = $GLOBALS['wp_query']->found_posts;
                        printf(
                            _n(  'We\'ve found <em class="count_properties">%s</em> <em class="count_text">listing</em> for you', 'We\'ve found <em class="count_properties">%s</em> <em class="count_text">listings</em> for you' , $count, 'listeo' ), 
                            $count); 
                        ?>
                        </span>
                        <?php
                    } else {
                        if(!empty($subtitle)) : ?><span><?php  echo wp_kses($subtitle,array( 'a' => array('href' => array(),'title' => array()),'br' => array(),'em' => array(),'strong' => array(),)); ?></span><?php endif; 
                    }
                    ?>
                    
                    <!-- Breadcrumbs -->
                    <?php 
                    
                        if(function_exists('bcn_display')) { ?>
                    <nav id="breadcrumbs">
                        <ul>
                            <?php bcn_display_list(); ?>
                        </ul>
                    </nav>
                    <?php }  
                   ?>

                </div>
            </div>
        </div>
    </div>
</div>