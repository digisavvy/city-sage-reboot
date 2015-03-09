<?php
/**
 * some_like_it_neat functions and definitions
 *
 * @package some_like_it_neat
 */

if ( ! function_exists( 'some_like_it_neat_setup' ) ) :
	/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
	function some_like_it_neat_setup()
	{

		/**
	 * Set the content width based on the theme's design and stylesheet.
	 */
		if ( ! isset( $content_width ) ) {
			$content_width = 640; /* pixels */
		}

		/*
        * Make theme available for translation.
        * Translations can be filed in the /languages/ directory.
        * If you're building a theme based on some_like_it_neat, use a find and replace
        * to change 'some-like-it-neat' to the name of your theme in all the template files
        */
		load_theme_textdomain( 'some-like-it-neat', get_template_directory() . '/library/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
        * Enable Custom Header Support
        *
        * @link http://codex.wordpress.org/Custom_Headers
        */
		$args = array(
			'width'         => 960,
			'height'        => 560,
			'default-image' => get_template_directory_uri() . '/assets/img/header.png',
		);
		add_theme_support( 'custom-header', $args );

		/*
        * Enable support for Post Thumbnails on posts and pages.
        *
        * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
        */
		add_theme_support( 'post-thumbnails' );

		/*
        * Enable title tag support for all posts.
        *
        * @link http://codex.wordpress.org/Title_Tag
        */
		add_theme_support( 'title-tag' );

		/*
        * Add Editor Style for adequate styling in text editor.
        *
        * @link http://codex.wordpress.org/Function_Reference/add_editor_style
        */
		add_editor_style( '/assets/css/style.css' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menu( 'primary-navigation', __( 'Primary Menu', 'some-like-it-neat' ) );

		// Enable support for Post Formats.
		if ( 'yes' === get_theme_mod( 'some-like-it-neat_post_format_support' ) ) {
			add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link', 'status', 'gallery', 'chat', 'audio' ) );
		}

		// Enable Support for Jetpack Infinite Scroll
		if ( 'yes' === get_theme_mod( 'some-like-it-neat_infinite_scroll_support' ) ) {
			$scroll_type = get_theme_mod( 'some-like-it-neat_infinite_scroll_type' );
			add_theme_support( 'infinite-scroll', array(
				'type'				=> $scroll_type,
				'footer_widgets'	=> false,
				'container'			=> 'content',
				'wrapper'			=> true,
				'render'			=> false,
				'posts_per_page' 	=> false,
				'render'			=> 'some_like_it_neat_infinite_scroll_render',
			) );

			function some_like_it_neat_infinite_scroll_render() {
				if ( have_posts() ) : while ( have_posts() ) : the_post();
						get_template_part( 'page-templates/partials/content', get_post_format() );
				endwhile;
				endif;
			}
		}

		// Setup the WordPress core custom background feature.
		add_theme_support(
			'custom-background', apply_filters(
				'some_like_it_neat_custom_background_args', array(
				'default-color' => 'ffffff',
				'default-image' => '',
				)
			)
		);

		/**
	 * Including Theme Hook Alliance (https://github.com/zamoose/themehookalliance).
	 */
		include 'library/vendors/tha-theme-hooks/tha-theme-hooks.php' ;

		/**
	 * WP Customizer
	 */
		include get_template_directory() . '/library/vendors/customizer/customizer.php';

		/**
	 * Implement the Custom Header feature.
	 */
		require get_template_directory() . '/library/vendors/custom-header.php';

		/**
	 * Custom template tags for this theme.
	 */
		include get_template_directory() . '/library/vendors/template-tags.php';

		/**
	 * Custom functions that act independently of the theme templates.
	 */
		include get_template_directory() . '/library/vendors/extras.php';

		/**
	 * Load Jetpack compatibility file.
	 */
		include get_template_directory() . '/library/vendors/jetpack.php';

		/**
	 * Including TGM Plugin Activation
	 */
		include_once get_template_directory() . '/library/vendors/tgm-plugin-activation/recommended-plugins.php' ;

	}
endif; // some_like_it_neat_setup
add_action( 'after_setup_theme', 'some_like_it_neat_setup' );

/**
 * Enqueue scripts and styles.
 */
if ( ! function_exists( 'some_like_it_neat_scripts' ) ) :
	function some_like_it_neat_scripts()
	{

		if ( SCRIPT_DEBUG || WP_DEBUG ) :
			// Vendor Scripts
			wp_enqueue_script( 'modernizr-js', get_stylesheet_directory_uri() . '/assets/js/vendor/modernizr/modernizr.js', array( 'jquery' ), '2.8.2', true );
			// wp_enqueue_script( 'search-overlay', get_stylesheet_directory_uri() . '/assets/js/app/classie.js', array( 'jquery' ), '21.0', false );
			wp_enqueue_script( 'selectivizr-js', get_stylesheet_directory_uri() . '/assets/js/vendor/selectivizr/selectivizr.js', array( 'jquery' ), '1.0.2b', true );
			wp_enqueue_script( 'flexnav-js', get_stylesheet_directory_uri() . '/assets/js/vendor/flexnav/jquery.flexnav.js', array( 'jquery' ), '1.3.3', true );
			wp_enqueue_script( 'hoverintent-js', get_stylesheet_directory_uri() . '/assets/js/vendor/hoverintent/jquery.hoverIntent.js', array( 'jquery' ), '1.0.0', true );

			// Concatonated Scripts
			wp_enqueue_script( 'development-js', get_stylesheet_directory_uri() . '/assets/js/development.js', array( 'jquery' ), '1.0.0', false );

			// Main Style
			wp_enqueue_style( 'some_like_it_neat-style',  get_stylesheet_directory_uri() . '/assets/css/style.css' );

	 else :
			// Vendor Scripts
	 		// wp_enqueue_script( 'search-overlay', get_stylesheet_directory_uri() . '/assets/js/app/classie.js', array( 'jquery' ), '21.0', false );
			wp_enqueue_script( 'modernizr-js', get_stylesheet_directory_uri() . '/assets/js/vendor/modernizr/modernizr.js', array( 'jquery' ), '2.8.2', true );
			wp_enqueue_script( 'selectivizr-js', get_stylesheet_directory_uri() . '/assets/js/vendor/selectivizr/selectivizr.js', array( 'jquery' ), '1.0.2b', true );
			wp_enqueue_script( 'flexnav-js', get_stylesheet_directory_uri() . '/assets/js/vendor/flexnav/jquery.flexnav.js', array( 'jquery' ), '1.3.3', true );
			wp_enqueue_script( 'hoverintent-js', get_stylesheet_directory_uri() . '/assets/js/vendor/hoverintent/jquery.hoverIntent.js', array( 'jquery' ), '1.0.0', true );

			// Concatonated Scripts
			wp_enqueue_script( 'production-js', get_stylesheet_directory_uri() . '/assets/js/production-min.js', array( 'jquery' ), '1.0.0', false );

			// Main Style
			wp_enqueue_style( 'some_like_it_neat-style',  get_stylesheet_directory_uri() . '/assets/css/style-min.css' );

	 endif;

		// Dashicons
		wp_enqueue_style( 'dashicons' );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'some_like_it_neat_scripts' );
endif; // Enqueue Scripts and Styles

/**
 * Title Tag Backward Comaptibility for < 4.1 installs
 */
if ( ! function_exists( '_wp_render_title_tag' ) ) {
	function theme_slug_render_title()
	{
	?>
			<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php

	}
	add_action( 'wp_head', 'theme_slug_render_title' );
}

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function some_like_it_neat_widgets_init()
{
	register_sidebar(
		array(
		'name'          => __( 'Sidebar', 'some-like-it-neat' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'some_like_it_neat_widgets_init' );

/**
 * Initializing Flexnav Menu System
 */
if ( ! function_exists( 'dg_add_flexnav' ) ) :
	function dg_add_flexnav()
	{
	?>
			<script>
				// Init Flexnav Menu
				jQuery(document).ready(function($){
					$(".flexnav").flexNav({
						'animationSpeed' : 250, // default drop animation speed
						'transitionOpacity': true, // default opacity animation
							'buttonSelector': '.menu-button', // default menu button class
							'hoverIntent': true, // use with hoverIntent plugin
							'hoverIntentTimeout': 350, // hoverIntent default timeout
							'calcItemWidths': false // dynamically calcs top level nav item widths
						});
				});
			</script>
			<?php
	}
	add_action( 'wp_footer', 'dg_add_flexnav' );
endif;

/**
 * Custom Hooks and Filters
 */
if ( ! function_exists( 'some_like_it_neat_add_breadcrumbs' ) ) :
	function some_like_it_neat_add_breadcrumbs()
	{
		if ( ! is_front_page() ) {
			if ( function_exists( 'HAG_Breadcrumbs' ) ) { HAG_Breadcrumbs(
				array(
				'prefix'     => __( 'You are here: ', 'some-like-it-neat' ),
				'last_link'  => true,
				'separator'  => '|',
				'excluded_taxonomies' => array(
				'post_format'
				),
				'taxonomy_excluded_terms' => array(
				'category' => array( 'uncategorized' )
				),
				'post_types' => array(
				'gizmo' => array(
				'last_show'          => false,
				'taxonomy_preferred' => 'category',
				),
				'whatzit' => array(
				'separator' => '&raquo;',
				)
				)
				)
			);
			}
		}
	}
	add_action( 'tha_content_top', 'some_like_it_neat_add_breadcrumbs' );
endif;

if ( ! function_exists( 'some_like_it_neat_optional_scripts' ) ) :
	function some_like_it_neat_optional_scripts()
	{
		// Link Color
		if ( '' != get_theme_mod( 'some_like_it_neat_add_link_color' )  ) {
		} ?>
			<style type="text/css">
				a { color: <?php echo get_theme_mod( 'some_like_it_neat_add_link_color' ); ?>; }
			</style>
		<?php
	}
	add_action( 'wp_head', 'some_like_it_neat_optional_scripts' );
endif;

if ( ! function_exists( 'some_like_it_neat_mobile_styles' ) ) :
	function some_like_it_neat_mobile_styles()
	{
		$value = get_theme_mod( 'some_like_it_neat_mobile_hide_arrow' );

		if ( 0 == get_theme_mod( 'some_like_it_neat_mobile_hide_arrow' ) ) { ?>
								<style>
								.menu-button i.navicon {
									display: none;
								}
								</style>
							<?php
		} else {

		}
	}
	add_action( 'wp_head', 'some_like_it_neat_mobile_styles' );
endif;

if ( ! function_exists( 'some_like_it_neat_add_footer_divs' ) ) :
	function some_like_it_neat_add_footer_divs()
	{
	?>

			<div class="footer-left">
				<?php echo esc_attr( get_theme_mod( 'some_like_it_neat_footer_left', __( '&copy; All Rights Reserved', 'some-like-it-neat' ) ) ); ?>

			</div>
			<div class="footer-right">
				<?php echo esc_attr( get_theme_mod( 'some_like_it_neat_footer_right', 'Footer Content Right' ) );  ?>
			</div>
		<?php
	}
	add_action( 'tha_footer_bottom', 'some_like_it_neat_add_footer_divs' );
endif;

add_action( 'tha_head_bottom', 'some_like_it_neat_add_selectivizr' );
function some_like_it_neat_add_selectivizr()
{
	?>
	<!--[if (gte IE 6)&(lte IE 8)]>
  		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/selectivizr/selectivizr-min.js"></script>
  		<noscript><link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/style.css" /></noscript>
	<![endif]-->
<?php
}

// Add Google Fonts
add_action( 'wp_head', 'some_like_it_neat_add_google_fonts' );

function some_like_it_neat_add_google_fonts() {
	echo "<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700|Gentium+Basic:400,700' rel='stylesheet' type='text/css'>";
}

// Search Overlay
add_action( 'tha_body_top', 'search_overlay' );
function search_overlay() { ?>
	<div id="morphsearch" class="morphsearch">
					<form class="morphsearch-form">
						<!-- <input class="morphsearch-input" type="search" placeholder="Search..."> -->
						<div>
							<label class="screen-reader-text" for="s">Search for:</label>
							<input type="text" class="morphsearch-input" placeholder="Search..." value="" name="s" id="s">
							<input type="submit" id="searchsubmit" value="Search">
						</div>
						<button class="morphsearch-submit" type="submit">Search</button>
					</form>
					<div class="morphsearch-content">
						<div class="dummy-column">
							<h2>People</h2>
							<a class="dummy-media-object" href="http://twitter.com/SaraSoueidan">
								<img class="round" src="http://0.gravatar.com/avatar/81b58502541f9445253f30497e53c280?s=50&amp;d=identicon&amp;r=G" alt="Sara Soueidan">
								<h3>Sara Soueidan</h3>
							</a>
							<a class="dummy-media-object" href="http://twitter.com/rachsmithtweets">
								<img class="round" src="http://0.gravatar.com/avatar/48959f453dffdb6236f4b33eb8e9f4b7?s=50&amp;d=identicon&amp;r=G" alt="Rachel Smith">
								<h3>Rachel Smith</h3>
							</a>
							<a class="dummy-media-object" href="http://www.twitter.com/peterfinlan">
								<img class="round" src="http://0.gravatar.com/avatar/06458359cb9e370d7c15bf6329e5facb?s=50&amp;d=identicon&amp;r=G" alt="Peter Finlan">
								<h3>Peter Finlan</h3>
							</a>
							<a class="dummy-media-object" href="http://www.twitter.com/pcridesagain">
								<img class="round" src="http://1.gravatar.com/avatar/db7700c89ae12f7d98827642b30c879f?s=50&amp;d=identicon&amp;r=G" alt="Patrick Cox">
								<h3>Patrick Cox</h3>
							</a>
							<a class="dummy-media-object" href="https://twitter.com/twholman">
								<img class="round" src="http://0.gravatar.com/avatar/cb947f0ebdde8d0f973741b366a51ed6?s=50&amp;d=identicon&amp;r=G" alt="Tim Holman">
								<h3>Tim Holman</h3>
							</a>
							<a class="dummy-media-object" href="https://twitter.com/shaund0na">
								<img class="round" src="http://1.gravatar.com/avatar/9bc7250110c667cd35c0826059b81b75?s=50&amp;d=identicon&amp;r=G" alt="Shaun Dona">
								<h3>Shaun Dona</h3>
							</a>
						</div>
						<div class="dummy-column">
							<h2>Popular</h2>
							<a class="dummy-media-object" href="http://tympanus.net/codrops/2014/08/05/page-preloading-effect/">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/thumbs/PagePreloadingEffect.png" alt="PagePreloadingEffect">
								<h3>Page Preloading Effect</h3>
							</a>
							<a class="dummy-media-object" href="http://tympanus.net/codrops/2014/05/28/arrow-navigation-styles/">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/thumbs/ArrowNavigationStyles.png" alt="ArrowNavigationStyles">
								<h3>Arrow Navigation Styles</h3>
							</a>
							<a class="dummy-media-object" href="http://tympanus.net/codrops/2014/06/19/ideas-for-subtle-hover-effects/">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/thumbs/HoverEffectsIdeasNew.png" alt="HoverEffectsIdeasNew">
								<h3>Ideas for Subtle Hover Effects</h3>
							</a>
							<a class="dummy-media-object" href="http://tympanus.net/codrops/2014/07/14/freebie-halcyon-days-one-page-website-template/">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/thumbs/FreebieHalcyonDays.png" alt="FreebieHalcyonDays">
								<h3>Halcyon Days Template</h3>
							</a>
							<a class="dummy-media-object" href="http://tympanus.net/codrops/2014/05/22/inspiration-for-article-intro-effects/">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/thumbs/ArticleIntroEffects.png" alt="ArticleIntroEffects">
								<h3>Inspiration for Article Intro Effects</h3>
							</a>
							<a class="dummy-media-object" href="http://tympanus.net/codrops/2014/06/26/draggable-dual-view-slideshow/">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/thumbs/DraggableDualViewSlideshow.png" alt="DraggableDualViewSlideshow">
								<h3>Draggable Dual-View Slideshow</h3>
							</a>
						</div>
						<div class="dummy-column">
							<h2>Recent</h2>
							<a class="dummy-media-object" href="http://tympanus.net/codrops/2014/10/07/tooltip-styles-inspiration/">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/thumbs/TooltipStylesInspiration.png" alt="TooltipStylesInspiration">
								<h3>Tooltip Styles Inspiration</h3>
							</a>
							<a class="dummy-media-object" href="http://tympanus.net/codrops/2014/09/23/animated-background-headers/">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/thumbs/AnimatedHeaderBackgrounds.png" alt="AnimatedHeaderBackgrounds">
								<h3>Animated Background Headers</h3>
							</a>
							<a class="dummy-media-object" href="http://tympanus.net/codrops/2014/09/16/off-canvas-menu-effects/">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/thumbs/OffCanvas.png" alt="OffCanvas">
								<h3>Off-Canvas Menu Effects</h3>
							</a>
							<a class="dummy-media-object" href="http://tympanus.net/codrops/2014/09/02/tab-styles-inspiration/">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/thumbs/TabStyles.png" alt="TabStyles">
								<h3>Tab Styles Inspiration</h3>
							</a>
							<a class="dummy-media-object" href="http://tympanus.net/codrops/2014/08/19/making-svgs-responsive-with-css/">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/thumbs/ResponsiveSVGs.png" alt="ResponsiveSVGs">
								<h3>Make SVGs Responsive with CSS</h3>
							</a>
							<a class="dummy-media-object" href="http://tympanus.net/codrops/2014/07/23/notification-styles-inspiration/">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/thumbs/NotificationStyles.png" alt="NotificationStyles">
								<h3>Notification Styles Inspiration</h3>
							</a>
						</div>
					</div><!-- /morphsearch-content -->
					<span class="morphsearch-close"></span>
				</div>
<?php }

add_action( 'wp_footer', 'search_overlay_footer' );

function search_overlay_footer() { ?>
	<script>
		(function() {
			var morphSearch = document.getElementById( 'morphsearch' ),
				input = morphSearch.querySelector( 'input.morphsearch-input' ),
				ctrlClose = morphSearch.querySelector( 'span.morphsearch-close' ),
				isOpen = isAnimating = false,
				// show/hide search area
				toggleSearch = function(evt) {
					// return if open and the input gets focused
					if( evt.type.toLowerCase() === 'focus' && isOpen ) return false;

					var offsets = morphsearch.getBoundingClientRect();
					if( isOpen ) {
						classie.remove( morphSearch, 'open' );

						// trick to hide input text once the search overlay closes
						// todo: hardcoded times, should be done after transition ends
						if( input.value !== '' ) {
							setTimeout(function() {
								classie.add( morphSearch, 'hideInput' );
								setTimeout(function() {
									classie.remove( morphSearch, 'hideInput' );
									input.value = '';
								}, 300 );
							}, 500);
						}

						input.blur();
					}
					else {
						classie.add( morphSearch, 'open' );
					}
					isOpen = !isOpen;
				};

			// events
			input.addEventListener( 'focus', toggleSearch );
			ctrlClose.addEventListener( 'click', toggleSearch );
			// esc key closes search overlay
			// keyboard navigation events
			document.addEventListener( 'keydown', function( ev ) {
				var keyCode = ev.keyCode || ev.which;
				if( keyCode === 27 && isOpen ) {
					toggleSearch(ev);
				}
			} );


			/***** for demo purposes only: don't allow to submit the form *****/
			morphSearch.querySelector( 'button[type="submit"]' ).addEventListener( 'click', function(ev) { ev.preventDefault(); } );
		})();
	</script>
<?php }

// Add Post/Page Navigation
add_action( 'tha_entry_after', 'some_like_it_neat_post_nav' );

function some_like_it_neat_post_nav() {
	if ( is_singular() ) :
		echo get_the_post_navigation();
	endif;
}
