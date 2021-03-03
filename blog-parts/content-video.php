<?php $metas =  get_option( 'pp_blog_meta', array('author','date','com') ); ?>
<div class="isotope-item">
  <article id="post-<?php the_ID(); ?>" <?php post_class('post-container'); ?>>
    <?php if ( ! post_password_required() ) { ?>
    <div class="embed">
      <?php
        $video = get_post_meta($post->ID, '_format_video_embed', true);
        if(wp_oembed_get($video)) { echo wp_oembed_get($video); } else { 
          $allowed_tags = wp_kses_allowed_html( 'post' );
          echo wp_kses($video,$allowed_tags);
        }
      ?>
    </div>
    <?php } ?>
    <section class="post-content">
      <!-- Category -->
        <?php 
        if (is_array($metas) && in_array("cat", $metas) && has_post_thumbnail()) :

          $categories = get_the_category();
          $output = '';

          if ( ! empty( $categories ) ) {?>
            <ul class="post-categories">
              <?php foreach( $categories as $category ) {
                  $output .= '<li><a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( esc_html__( 'View all posts in %s', 'listeo' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a> </li>';
              }
              echo wp_kses_post($output); //XSS ok, escaped above?>
              </ul>
          <?php }

        endif;
        ?>
      <div class="meta-tags">
        <?php listeo_posted_on(); ?>
      </div>
      
      <a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
      <p><?php 
      $limit_words = 20;
      $excerpt = get_the_excerpt();
      echo listeo_string_limit_words($excerpt,$limit_words)?></p>

    </section>

  </article>
</div>