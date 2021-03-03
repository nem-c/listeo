<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package listeo
 */

if ( ! function_exists( 'wp_body_open' ) ) {
    function wp_body_open() {
        do_action( 'wp_body_open' );
    }
}


if ( ! function_exists( 'listeo_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function listeo_posted_on() {
	 echo '<ul class="post-meta">';
	if(is_single()) {
	    $metas =  get_option( 'pp_meta_single',array('author','date','tags','com') );
	    if (is_array($metas) && in_array("author", $metas)) {
	        echo '<li itemscope itemtype="http://data-vocabulary.org/Person">';
	        echo esc_html__('By','listeo'). ' <a class="author-link"  href="'.esc_url(get_author_posts_url(get_the_author_meta('ID' ))).'">'; the_author_meta('display_name'); echo'</a>';
	        echo '</li>';
	    }
	    if (is_array($metas) && in_array("date", $metas)) {
		   
		    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
			}

			$time_string = sprintf( $time_string,
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() ),
				esc_attr( get_the_modified_date( 'c' ) ),
				esc_html( get_the_modified_date() )
			);

		    echo '<li>'.$time_string.'</li>';
		    
		}
	    if (is_array($metas) && in_array("cat", $metas) && !has_post_thumbnail() ) {
	      if(has_category()) { echo '<li class="meta-cat" >';  the_category(' '); echo '</li>'; }
	    }
	    if (is_array($metas) && in_array("tags", $metas)) {
	      if(has_tag()) { echo '<li class="meta-tag" >';  the_tags('',' '); echo '</li>'; }
	    }
	    if (is_array($metas) && in_array("com", $metas)) {
	      echo '<li>'; comments_popup_link( esc_html__('With 0 comments','listeo'), esc_html__('With 1 comment','listeo'), esc_html__('With % comments','listeo'), 'comments-link', esc_html__('Comments are off','listeo')); echo '</li>';
	    }
  	} else {
	     $metas =  get_option( 'pp_blog_meta', array('author','date','com') );

	   	if (is_array($metas) && in_array("author", $metas)) {
	      echo '<li class="meta-author" itemscope itemtype="http://data-vocabulary.org/Person">';
	      if (in_array("author", $metas)) {
	        echo esc_html__('By','listeo'). ' <a class="author-link" href="'.esc_url(get_author_posts_url(get_the_author_meta('ID' ))).'">'; the_author_meta('display_name'); echo'</a>';
	      }
	      echo '</li>';
	    }
	    if (is_array($metas) && in_array("date", $metas)) {
		    $time_string = '<time class="meta-date entry-date published updated" datetime="%1$s">%2$s</time>';
			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
			}

			$time_string = sprintf( $time_string,
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() ),
				esc_attr( get_the_modified_date( 'c' ) ),
				esc_html( get_the_modified_date() )
			);

		     echo '<li><a href="'.get_permalink().'">'.$time_string.'</a></li>';
	
		    
		}
	    if (is_array($metas) && in_array("cat", $metas) && !has_post_thumbnail() ) {
	      if(has_category()) { echo '<li class="meta-cat" >';  the_category(' '); echo '</li>'; }
	    }
	    if (is_array($metas) && in_array("tags", $metas)) {
	      if(has_tag()) { echo '<li class="meta-tag" >';  the_tags('',' '); echo '</li>'; }
	    }
	    if (is_array($metas) && in_array("com", $metas)) {
	      echo '<li class="meta-com" >'; comments_popup_link( esc_html__('With 0 comments','listeo'), esc_html__('With 1 comment','listeo'), esc_html__('With % comments','listeo'), 'comments-link', esc_html__('Comments are off','listeo')); echo '</li>';
	    }
  	}
  	 echo '</ul>';

}
endif;

if ( ! function_exists( 'listeo_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function listeo_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'listeo' ) );
		if ( $categories_list && listeo_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'listeo' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'listeo' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'listeo' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		/* translators: %s: post title */
		comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'listeo' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'listeo' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;




if ( ! function_exists( 'listeo_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since astrum 1.0
 */
function listeo_comment( $comment, $args, $depth ) {
  $GLOBALS['comment'] = $comment;
  switch ( $comment->comment_type ) :
    case 'pingback' :
    case 'trackback' :
  ?>
  <li class="post pingback">
    <p><?php esc_html_e( 'Pingback:', 'listeo' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( esc_html__( '(Edit)', 'listeo' ), ' ' ); ?></p>
  <?php
      break;
    default :
      $allowed_tags = wp_kses_allowed_html( 'post' );
  ?>
  <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
       <div id="comment-<?php comment_ID(); ?>" class="comment">
       <div class="avatar"><?php echo get_avatar( $comment, 70 ); ?></div>
       <div class="comment-content"><div class="arrow-comment"></div>
            <div class="comment-by"><?php printf( '<h5>%s</h5>', get_comment_author_link() ); ?>  <span class="date"> <?php printf( esc_html__( '%1$s at %2$s', 'listeo' ), get_comment_date(), get_comment_time() ); ?></span>
               <?php comment_reply_link( array_merge( $args, array( 'reply_text' => wp_kses(__('<i class="fa fa-reply"></i> Reply','listeo'), $allowed_tags ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
            </div>
            <?php comment_text(); ?>

        </div>
        </div>
  <?php
      break;
  endswitch;
}
endif; // ends check for listeo_comment()



if ( ! function_exists( 'listeo_review' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since astrum 1.0
 */
function listeo_review( $comment, $args, $depth ) {
  $GLOBALS['comment'] = $comment;
  switch ( $comment->comment_type ) :
    case 'pingback' :
    case 'trackback' :
  ?>
  <li class="post pingback">
    <p><?php esc_html_e( 'Pingback:', 'listeo' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( esc_html__( '(Edit)', 'listeo' ), ' ' ); ?></p>
  <?php
      break;
    default :
      $allowed_tags = wp_kses_allowed_html( 'post' );
  ?>
  <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
       <div id="comment-<?php comment_ID(); ?>" class="comment">
	       <div class="avatar"><?php echo get_avatar( $comment, 70 ); ?></div>
	       
	       <div class="comment-content"><div class="arrow-comment"></div>
	            <div class="comment-by"><?php printf( '<h5>%s</h5>', get_comment_author_link() ); ?>  <span class="date"> <?php printf( esc_html__( '%1$s at %2$s', 'listeo' ), get_comment_date(), get_comment_time() ); ?></span>
	            	<div class="star-rating" data-rating="<?php echo get_comment_meta( get_comment_ID(), 'listeo-rating', true ); ?>"></div>
			</div>
	              
	            <?php comment_text(); ?>

	            <?php 
	            $photos = get_comment_meta( get_comment_ID(), 'listeo-attachment-id', false );

	            if($photos) : ?>
	            <div class="review-images mfp-gallery-container">
	            	<?php foreach ($photos as $key => $attachment_id) {

	            		$image = wp_get_attachment_image_src( $attachment_id, 'listeo-gallery' );
	            		$image_thumb = wp_get_attachment_image_src( $attachment_id, 'thumbnail' );

	            	 ?>
					<a href="<?php echo esc_attr($image[0]); ?>" class="mfp-gallery"><img src="<?php echo esc_attr($image_thumb[0]); ?>"></a>
					<?php } ?>
				</div>
				<?php endif; ?>
				<a href="#" class="rate-review"><i class="sl sl-icon-like"></i> <?php esc_html_e('Helpful Review','listeo') ?> <span>12</span></a>
	        </div>
        </div>
  <?php
      break;
  endswitch;
}
endif; // ends check for listeo_comment()

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function listeo_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'listeo_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'listeo_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so listeo_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so listeo_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in listeo_categorized_blog.
 */
function listeo_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'listeo_categories' );
}
add_action( 'edit_category', 'listeo_category_transient_flusher' );
add_action( 'save_post',     'listeo_category_transient_flusher' );



/**
 * Limits number of words from string
 *
 * @since listeo 1.0
 */
if ( ! function_exists( 'listeo_string_limit_words' ) ) :
	function listeo_string_limit_words($string, $word_limit) {
	    $words = explode(' ', $string, ($word_limit + 1));
	    if (count($words) > $word_limit) {
	        array_pop($words);
	        //add a ... at last article when more than limit word count
	        return implode(' ', $words) ;
	    } else {
	        //otherwise
	        return implode(' ', $words);
	    }
	}
endif;


function listeo_get_search_header(){

	$output ='';
	$bannerbg = get_option( 'listeo_search_bg');  

	if(!empty($bannerbg)) { 
		$image_id = attachment_url_to_postid( $bannerbg );
		if( isset( $image_id ) ) {
		  $image  = wp_get_attachment_image_src($image_id,'full'); 
		}
		$opacity = get_option('listeo_search_bg_opacity',0.45);
		$color = get_option('listeo_search_color','#36383e');
		$output = 'data-background="'.esc_attr($bannerbg).'" data-img-width="'.esc_attr($image[1]).'" data-img-height="'.esc_attr($image[2]).'" 
		data-diff="300"	data-color="'.esc_attr($color).'" data-color-opacity="'.esc_attr($opacity).'"';
	} 
	return $output;
}



function realteo_fallback_menu(){
    $args = array(
        'sort_column' => 'menu_order, post_title',
        'menu_class'  => 'menu alt2',

        'echo'        => true,
        'show_home'   => false,
        'link_before' => '',
        'link_after'  => '' );
    wp_page_menu($args);
}

function realteo_fallback_top_menu(){
    $args = array(
        'sort_column' => 'menu_order, post_title',
        'menu_class'  => 'options',

        'echo'        => true,
        'show_home'   => false,
        'link_before' => '',
        'link_after'  => '' );
    wp_page_menu($args);
}

function realteo_add_menuclass( $ulclass ) {
  return preg_replace( '/<ul>/', '<ul id="responsive" class="menu">', $ulclass, 1 );
}
add_filter( 'wp_page_menu', 'realteo_add_menuclass' );

function realteo_remove_menucontainer($ulclass) {
	return preg_replace('/<div id="responsive" class="menu">/', ' ', $ulclass, 1);
}
add_filter('wp_page_menu','realteo_remove_menucontainer');
function realteo_remove_menucontainer_end($ulclass) {
	return preg_replace('/<\/div>/', ' ', $ulclass, 1);
}
add_filter('wp_page_menu','realteo_remove_menucontainer_end');




function listeo_author_info_box(  ) {

	global $post;
	$user_description = '';
	// Detect if it is a single post with a post author
	
	if ( is_single() && isset( $post->post_author ) ) {

		$author_details = '';
		$display_name = get_the_author_meta( 'display_name', $post->post_author );
		if ( empty( $display_name ) ) {
			$display_name = get_the_author_meta( 'nickname', $post->post_author );
		}

		$user_description = get_the_author_meta( 'user_description', $post->post_author );

		$user_website = get_the_author_meta('url', $post->post_author);

		$user_posts = get_author_posts_url( get_the_author_meta( 'ID' , $post->post_author));
	 	
	 	if ( ! empty( $user_description ) ){
			$author_details .= get_avatar( get_the_author_meta('user_email') , 90 );
		}
		
		
		$author_details .= 
		'<div class="about-description">';
		if ( ! empty( $display_name ) ) {
			$author_details .= '<h4>' . $display_name . '</h4>';
		}
		$author_details .= '<a href="'. $user_posts .'">'.esc_html__('View all posts by','listeo').' '. $display_name . '</a>';  

		
		$author_details .= '<p>'.nl2br( $user_description ).'</p>';
		
		// Check if author has a website in their profile
	
		// if there is no author website then just close the paragraph
		$author_details .= '</div>';
	

	}
	if(!empty($user_description )) {
		echo '<div class="clearfix"></div><div class="about-author margin-top-20">'.$author_details.'</div><div class="clearfix"></div>';
	} 
}
// Allow HTML in author bio section 




if ( ! function_exists( 'listeo_related_posts' ) ) :
	function listeo_related_posts($post) {
	    $orig_post = $post;
	    global $post;
	    $categories = get_the_category($post->ID);

	    if ($categories) {
	        $category_ids = array();
	        foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
	        $args=array(
	            'category__in' => $category_ids,
	            'post__not_in' => array($post->ID),
	            //'meta_key'    => '_thumbnail_id',
	            'posts_per_page'=> 2, // Number of related posts that will be shown.
	            'ignore_sticky_posts'=>1
	        );
	        $my_query = new wp_query( $args );
	        if( $my_query->have_posts() ) { ?>
	        <h4 class="headline margin-top-25"><?php esc_html_e('Related Posts','listeo'); ?></h4>
			<div class="row listeo-related-posts">
					
	        <?php
	            while( $my_query->have_posts() ) {
	               $my_query->the_post();
	               get_template_part( 'template-parts/related-content', get_post_format() );
	            }
	       ?>
	        </div><!-- Related Posts / End -->
	        <div class="clearfix"></div>
	    <?php 
	    	}
		}
	    $post = $orig_post;
	    wp_reset_query();

	}
endif;

add_filter( 'get_the_archive_title', 'listeo_archive_titles');
function listeo_archive_titles( $title ) {
    if( is_post_type_archive('listing') ) {
        $title = get_option('listeo_properties_archive_title','Listings');
    }
    if( is_tax()){ 
    	$title = single_term_title( '', false );
    }
    if (function_exists('is_shop')) :
        if(is_shop()){
            return preg_replace( '#^[\w\d\s]+:\s*#', '', strip_tags( $title ) );
        }
    else 
        return $title;
    endif;

    return $title;
};

function listeo_set_author_archive_limit( $query ) {
    if ( is_admin() || ! $query->is_main_query() )
        return;

    if ( is_author() ) {
        $per_page = get_option('listeo_author_listings_per_page',3);
        $query->set( 'posts_per_page', $per_page );
        return;
    }
}
add_action( 'pre_get_posts', 'listeo_set_author_archive_limit', 1 );



function listeo_fallback_menu(){
    $args = array(
        'sort_column' => 'menu_order, post_title',
        'menu_class'  => 'menu alt2',
        'include'     => '',
        'exclude'     => '',
        'echo'        => true,
        'show_home'   => false,
        'link_before' => '',
        'link_after'  => '' );
    wp_page_menu($args);
}

function listeo_date_time_wp_format() {
	/**
	 * Add date format into javascript
	 */
	$dateFormat = get_option('date_format');
	$timeFormat = get_option( 'time_format' );
	$dateFromatSeparator = get_option('listeo_date_format_separator','/');
	$rawFormat = $dateFormat;
	$dateFormat = explode( '-', $dateFormat);
	

	preg_match_all( '/[a-zA-Z]+/', $rawFormat, $output );
	
	// F j, Y =  mm/dd/yy 07/01/2020 17:28
	// Y-m-d = yy/mm/dd 2020/07/01 13:13
	// m/d/Y = mm/dd/yy 07/01/2020 13:16
	// d/m/Y = dd/mm/yy = 01/07/2020 14:08
 
	$convertedType = array();
	foreach ($output[0] as $dataType) 

	{

		switch ( strtolower( $dataType) )
		{
			
			case 'j' : $convertedType[] =  'DD'; break;
			case 'js' : $convertedType[] =  'DD'; break;
			case 'd' : $convertedType[] =  'DD'; break;
			case 'm' : $convertedType[] =  'MM'; break;
			case 'n' : $convertedType[] =  'MM'; break;
			case 'f' : $convertedType[] =  'MM'; break;
			case 'y' : $convertedType[] =  'YYYY'; break;
		}

	}
	

	$convertedData['date'] = $convertedType[0] . $dateFromatSeparator . $convertedType[1] . $dateFromatSeparator . $convertedType[2];
	$convertedData['day'] = intval( get_option( 'start_of_week' ) );
	$convertedData['raw'] = $rawFormat;
	$convertedData['time'] = $timeFormat;
	return $convertedData;
}

function listeo_date_time_wp_format_php() {
	/**
	 * Add date format into javascript
	 */
	$dateFormat = get_option('date_format');
	$dateFromatSeparator = get_option('listeo_date_format_separator','/');
	$timeFormat = get_option( 'time_format' );
	$rawFormat = $dateFormat;
	$dateFormat = explode( '-', $dateFormat);

	preg_match_all( '/[a-zA-Z]+/', $rawFormat, $output );

	foreach ($output[0] as $dataType) 

	{

		switch ( strtolower( $dataType) )
		{
			case 'j' : $convertedType[] =  'd'; break;
			case 'y' : $convertedType[] =  'Y'; break;
			case 'd' : $convertedType[] =  'd'; break;
			case 'm' : $convertedType[] =  'm'; break;
			case 'f' : $convertedType[] =  'm'; break;
		}

	}

	$convertedData = $convertedType[0] . $dateFromatSeparator . $convertedType[1] . $dateFromatSeparator . $convertedType[2];
	
	return $convertedData;
}
