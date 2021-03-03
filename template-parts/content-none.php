<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package listeo
 */

?>

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'listeo' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'listeo' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'listeo' ); ?></p>
			<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
                        <div class="main-search-input gray-style margin-top-50 margin-bottom-10">
                            <div class="main-search-input-item">
                                <input type="text"  name="s" placeholder="<?php esc_html_e('What are you looking for?','listeo') ?>" value=""/>
                            </div>

                            <button class="button"><?php esc_html_e('Search','listeo') ?></button>
                        </div>
                        </form>
			<?php
				

		else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'listeo' ); ?></p>
			<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
                        <div class="main-search-input gray-style margin-top-50 margin-bottom-10">
                            <div class="main-search-input-item">
                                <input type="text"  name="s" placeholder="<?php esc_html_e('What are you looking for?','listeo') ?>" value=""/>
                            </div>

                            <button class="button"><?php esc_html_e('Search','listeo') ?></button>
                        </div>
                        </form>
			<?php
				

		endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
