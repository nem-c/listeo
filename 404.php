<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package listeo
 */

get_header();

?>
<!-- Titlebar
================================================== -->
<div class="header-container with-titlebar basic" >

    <div id="titlebar" class="">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <h2><?php esc_html_e( 'Page Not Found', 'listeo' ); ?></h2>
                    
                    <?php if(function_exists('bcn_display')) { ?>
                        <nav id="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
                            <ul>
                                <?php bcn_display_list(); ?>
                            </ul>
                        </nav>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="clearfix"></div>

<div class="container">

	<div class="row">
    	<div class="col-md-12">
    		<section id="not-found" class="center margin-bottom-50">
    			<h2>404 <i class="fa fa-question-circle"></i></h2>
    			<p><?php esc_html_e( 'We&rsquo;re sorry, but the page you were looking for doesn&rsquo;t exist..', 'listeo' ); ?></p>
    			<!-- Search -->
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
                        <div class="main-search-input gray-style margin-top-50 margin-bottom-10">
                            <div class="main-search-input-item">
                                <input type="text"  name="s" placeholder="<?php esc_html_e('What are you looking for?','listeo') ?>" value=""/>
                            </div>

                            <button class="button"><?php esc_html_e('Search','listeo') ?></button>
                        </div>
                        </form>
                    </div>
                </div>
                <!-- Search Section / End -->
    		</section>
    	</div>
	</div>

</div>

<?php
get_footer();