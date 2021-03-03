
<!-- Blog Post Item -->
<div class="col-md-6">
  <a href="<?php the_permalink(); ?>" class="blog-compact-item-container">
    <div class="blog-compact-item">
      <?php 
      if ( ! post_password_required() ) { 
          if(has_post_thumbnail()) { 
              the_post_thumbnail('listeo-blog-related-post'); 
          } 
      }?>
      <?php  if(has_category()) { ?><span class="blog-item-tag"><?php  $cats = get_the_category(); echo esc_html($cats[0]->name); ?></span><?php } ?>
      <div class="blog-compact-item-content">
        <ul class="blog-post-tags">
          <li><?php the_date(); ?></li>
        </ul>
        <h3><?php the_title(); ?></h3>
        <p><?php 
            $limit_words = 20;
            $excerpt = get_the_excerpt();
            echo listeo_string_limit_words($excerpt,$limit_words)?></p>
      </div>
    </div>
  </a>
</div>

