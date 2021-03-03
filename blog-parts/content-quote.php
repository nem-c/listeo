<?php 
if ( ! post_password_required() ) { 
  $quote_content = get_post_meta($post->ID, '_format_quote_content', TRUE);
  $quote_source  = get_post_meta($post->ID, '_format_quote_source_url', TRUE);
  $quote_author  = get_post_meta($post->ID, '_format_quote_source_name', TRUE);
if(!empty($quote_content)) {?>
<div class="isotope-item">
  <figure class="post-quote" id="post-<?php the_ID(); ?>">
    <span class="icon"></span>
    <blockquote>
      <?php 
      echo wp_kses($quote_content,array( 'a' => array('href' => array(),'title' => array()),'br' => array(),'em' => array(),'strong' => array(),));
      ?>
      <?php if(!empty($quote_source)) { ?><a href="<?php echo esc_url(get_post_meta($post->ID, '_format_quote_source_url', TRUE)); ?>"> <?php } ?>
        <span>- <?php echo esc_html($quote_author); ?></span>
      <?php if(!empty($quote_source)) { ?></a> <?php } ?>
    </blockquote>
  </figure>
</div>
<?php } 
} ?>