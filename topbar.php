<?php 
$top_header_status = get_option('listeo_enable_topheader',false); 
if(is_singular()){
	$top_header_page = get_post_meta($post->ID, 'listeo_top_bar', TRUE);
	switch ($top_header_page) {
		case 'on':
		case 'enable':
			$top_header_status = true;
			break;

		case 'disable':
			$top_header_status = false;
			break;
		
		default:
			$top_header_status = get_option('listeo_enable_topheader',false); 
			break;
	}
}

if($top_header_status) : 
	$top_header_phone = get_option('listeo_top_header_phone');
	$top_header_email = get_option('listeo_top_header_email');
	$dropdown_text = get_option('listeo_top_header_dropdown','Dropdown menu');
?>
<div id="top-bar" >
	<div class="container">
		<!-- Left Side Content -->
		<div class="left-side">
			<ul class="top-bar-menu">
				<?php if(!empty($top_header_phone)) : ?><li><i class="fa fa-phone"></i> <?php echo esc_html($top_header_phone); ?></li><?php endif; ?>
				<?php if(!empty($top_header_email)) : ?><li><i class="fa fa-envelope"></i> <a href="mailto:<?php echo esc_html($top_header_email); ?>"><?php echo esc_html($top_header_email); ?></a></li><?php endif; ?>
				<?php if(!empty($dropdown_text)) : ?>
				<li>
					<div class="top-bar-dropdown">
						<span><?php echo esc_html($dropdown_text); ?></span>
						<?php 
						wp_nav_menu( 
							array( 
								'theme_location' => 'topbar', 
								'menu_id' => 'options',
								'menu_class' => 'options',
								'container' => false, 
								'fallback_cb' => 'listeo_fallback_top_menu',
							) ); 
						?>
			
					</div>
				</li>
			<?php endif; ?> 
			</ul>
		</div>
		
		<!-- Social Icons -->
		<!-- Left Side Content -->
		<div class="right-side">

			<?php 
                $headericons = get_option( 'listeo_top_social_icons', array() );
                if ( is_array($headericons) && !empty( $headericons ) ) {
                    echo '<ul class="social-icons">';
                    foreach( $headericons as $icon ) {
                        echo '<li><a class="' . $icon['icon'] . '" title="' . esc_attr($icon['icon']) . '" href="' . esc_url($icon['url']) . '"><i class="icon-' . $icon['icon'] . '"></i></a></li>';
                    }
                    echo '</ul>';
                }
            ?>
		</div>
	</div>
</div>
<?php endif; ?>