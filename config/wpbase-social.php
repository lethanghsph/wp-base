<?php
/**
 * WPBase social core class.
 *
 * @package WPBase
 */

if ( ! class_exists( 'WPBase_Social' ) ) :
	/**
	 * WPBase_Social class.
	 */
	final class WPBase_Social {
		/**
		 * Singleton reference to singleton instance.
		 *
		 * @var self
		 */
		protected static $instance;

		/**
		 * Gets the instance via lazy initialization.
		 *
		 * @return self
		 */
		public static function get_instance() {
			if ( null === static::$instance ) {
				static::$instance = new static;
			}

			return static::$instance;
		}

		/**
		 * A list of social profile providers.
		 *
		 * @var array
		 */
		public $profile_providers = array();

		/**
		 * A list of social share providers.
		 *
		 * @var array
		 */
		public $share_providers = array();

		/**
		 * Private constructor of class, use static::get_instance() instead of.
		 */
		private function __construct() {
			/**
			 * Social share providers.
			 *
			 * @var array
			 */
			$this->profile_providers = apply_filters( 'wpbase_social_profile_providers', array(
				'facebook'   => esc_html__( 'Facebook', 'wpbase' ),
				'google'     => esc_html__( 'Google plus', 'wpbase' ),
				'twitter'    => esc_html__( 'Twitter', 'wpbase' ),
				'github'     => esc_html__( 'Github', 'wpbase' ),
				'instagram'  => esc_html__( 'Instagram', 'wpbase' ),
				'pinterest'  => esc_html__( 'Pinterest', 'wpbase' ),
				'linkedin'   => esc_html__( 'LinkedIn', 'wpbase' ),
				'skype'      => esc_html__( 'Skype', 'wpbase' ),
				'tumblr'     => esc_html__( 'Tumblr', 'wpbase' ),
				'youtube'    => esc_html__( 'Youtube', 'wpbase' ),
				'vimeo'      => esc_html__( 'Vimeo', 'wpbase' ),
				'flickr'     => esc_html__( 'Flickr', 'wpbase' ),
				'dribbble'   => esc_html__( 'Dribbble', 'wpbase' ),
			) );

			/**
			 * Social share providers.
			 *
			 * @var array
			 */
			$this->share_providers = apply_filters( 'wpbase_social_share_providers', array(
				'facebook'    => array(
					'name' => esc_html__( 'Facebook', 'wpbase' ),
					'link' => 'http://www.facebook.com/sharer.php?u={url}',
				),

				'twitter'     => array(
					'name' => esc_html__( 'Twitter', 'wpbase' ),
					'link' => 'https://twitter.com/share?url={url}&text={title}',
				),

				'google-plus' => array(
					'name' => esc_html__( 'Google Plus', 'wpbase' ),
					'link' => 'https://plus.google.com/share?url={url}',
				),

				'pinterest'   => array(
					'name' => esc_html__( 'Pinterest', 'wpbase' ),
					'link' => 'https://pinterest.com/pin/create/bookmarklet/?url={url}&description={title}',
				),

				'linkedin'    => array(
					'name' => esc_html__( 'LinkedIn', 'wpbase' ),
					'link' => 'http://www.linkedin.com/shareArticle?url={url}&title={title}',
				),

				'digg'        => array(
					'name' => esc_html__( 'Digg', 'wpbase' ),
					'link' => 'http://digg.com/submit?url={url}&title={title}',
				),

				'tumblr'      => array(
					'name' => esc_html__( 'Tumblr', 'wpbase' ),
					'link' => 'https://www.tumblr.com/widgets/share/tool?canonicalUrl={url}&title={title}',
				),

				'reddit'      => array(
					'name' => esc_html__( 'Reddit', 'wpbase' ),
					'link' => 'http://reddit.com/submit?url={url}&title={title}',
				),

				'stumbleupon' => array(
					'name' => esc_html__( 'Stumbleupon', 'wpbase' ),
					'link' => 'http://www.stumbleupon.com/submit?url={url}&title={title}',
				),
			) );

			// Theme Options register.
			add_action( 'skeleton/theme_options/registers', array( $this, 'social_options' ), 9 );
		}

		/**
		 * Add settings to the Theme Options.
		 *
		 * @access private
		 *
		 * @param Awethemes Framework $framework object.
		 */
		public function social_options( $framework ) {
			if ( ! function_exists( 'wpbase_sanitize_value' ) ) {
				require_once get_template_directory() . '/inc/sanitization-callbacks.php';
			}

			$framework->add_panel( 'social', array(
				'title' => esc_html__( 'Social Network', 'wpbase' ),
				'icon' => 'dashicons-share',
				'priority' => 50,
			) );

			$framework->add_section( 'social_general', function( $tab ) {


				$tab->set( array(
					'title' => esc_html__( 'Social General', 'wpbase' ),
					'panel' => 'social',
				) );

				$tab->add_field( array(
					'name' => esc_html__( 'Open link in a new tab', 'wpbase' ),
					'id'   => 'social_blank',
					'type' => 'checkbox',
				) );

			}, 45 );

			$framework->add_section( 'social_share', function( $tab ) {

				$tab->set( array(
					'title' => esc_html__( 'Social Share', 'wpbase' ),
					'panel' => 'social',
				) );

				$tab->add_field(array(
					'id'   => 'wpbase_social_share',
					'name' => esc_html__( 'Social Sharing', 'wpbase' ),
					'type' => 'title',
					'desc'	=> esc_html__( 'Select sharing providers to display.', 'wpbase' ),
				) );

				foreach ( $this->share_providers as $id => $provider ) {
					$id = sprintf( 'wpbase_social_share_%s', sanitize_key( $id ) );

					$tab->add_field( array(
						'name' => sprintf( esc_html__( 'Share on %s', 'wpbase' ), $provider['name'] ),
						'id'   => $id,
						'type' => 'checkbox',
					) );
				}
			}, 50 );

			$framework->add_section( 'social_links', function( $tab ) {

				$tab->set( array(
					'title' => esc_html__( 'Social Follow', 'wpbase' ),
					'panel' => 'social',
				) );

				$tab->add_field( array(
					'id'   => 'wpbase_social_profile',
					'name' => esc_html__( 'Social Links', 'wpbase' ),
					'type' => 'title',
					'desc'	=> esc_html__( 'Edit your social profiles.', 'wpbase' ),
				) );

				foreach ( $this->profile_providers as $id => $name ) {
					$id = sprintf( 'wpbase_social_profile_%1$s', sanitize_key( $id ) );

					$tab->add_field( array(
						'name' => $name,
						'id'   => $id,
						'type' => 'text_url',
					) );
				}
			}, 55 );
		}

		/**
		 * Get user active share.
		 *
		 * @return array
		 */
		public function get_share() {
			$return = array();

			foreach ( $this->share_providers as $key => $value ) {
				$options[ $key ] = 'wpbase_social_share_' . $key;
			}

			foreach ( $options as $id => $active ) {

				$active = WPBase()->options->wpbase_option( $active );

				if ( ! $active || ! isset( $this->share_providers[ $id ] ) ) {
					continue;
				}

				$return[ $id ] = $this->share_providers[ $id ];
				$return[ $id ]['link'] = $this->parse_share_link( $return[ $id ]['link'] );
			}

			return $return;
		}

		/**
		 * Get user active profile.
		 *
		 * @return array
		 */
		public function get_profile() {
			$return = array();

			foreach ( $this->profile_providers as $key => $value ) {
				$options[ $key ] = 'wpbase_social_profile_' . $key;
			}

			foreach ( $options as $id => $link ) {

				$link = WPBase()->options->wpbase_option( $link );

				if ( empty( $link ) || ! isset( $this->profile_providers[ $id ] ) ) {
					continue;
				}

				$return[ $id ] = array(
					'name' => $this->profile_providers[ $id ],
					'link' => $link,
				);
			}

			return $return;
		}

		/**
		 * Parse share raw link with the_post.
		 *
		 * @param  string $link Raw link to parser.
		 * @return string
		 */
		private function parse_share_link( $link ) {
			/*
			if ( ! in_the_loop() ) {
				return '';
			}
			*/

			$link = str_replace( array( '{url}', '{title}' ), array( get_permalink(), get_the_title() ), $link );

			return apply_filters( 'wpbase_social_parse_sharing', $link );
		}
	}
endif;

if ( ! function_exists( 'wpbase_social' ) ) :
	/**
	 * Social core class instance.
	 *
	 * @return WPBase_Social
	 */
	function wpbase_social() {
		return WPBase_Social::get_instance();
	}
endif;

/**
 * Init the social core.
 */
$GLOBALS['WPBase_Social'] = wpbase_social();
