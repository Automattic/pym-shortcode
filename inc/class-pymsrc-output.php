<?php
/**
 * Enqueues the one Pym.js script that the embeds on a page need.
 *
 * @package pym-embeds
 */

/**
 * Provide a singleton class to track whether Pym.js is needed on the page, and output it once.
 *
 * Influenced by https://ttmm.io/tech/the-case-for-singletons/
 *
 * @since 1.3.2.1
 */
class Pymsrc_Output{
	/**
	 * @var Pymsrc_Output $instance The singleton of Pymsrc_Output.
	 */
	private static $instance;

	/**
	 * Get the singleton.
	 * @return Pymsrc_Output
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * During construction, register the output function for this post.
	 *
	 * If the Pymsrc_Output class hasn't been used on a post, then
	 * there's no need to register any output.
	 */
	private function __construct() {
		add_action( 'wp_footer', array( $this, 'output' ) );
	}

	/**
	 * Whether this page needs the Pym.js script tag.
	 *
	 * @var bool
	 */
	private $needed = false;

	/**
	 * Mark Pym.js as needed on this page.
	 *
	 * The script is enqueued once, however many embeds the page has.
	 *
	 * @since 1.3.2.1
	 * @since 3.0.0 The argument is ignored; Pym.js always loads from the URL in pym_pymsrc_default_url().
	 * @param string $url Ignored since 3.0.0.
	 */
	public function add( $url = '' ) {
		$this->needed = true;
	}

	/**
	 * Mark Pym.js as not needed on this page.
	 *
	 * Implemented because at some point we'll write tests for this? ¯\_(ツ)_/¯
	 */
	public function reset() {
		$this->needed = false;
	}

	/**
	 * Output the Pym.js script tag, if any embed on the page needs it.
	 *
	 * @uses pym_pymsrc_default_url
	 * @uses pym_pymsrc_local_url
	 * @uses pym_plugin_version
	 */
	public function output() {
		if ( ! $this->needed ) {
			return;
		}

		$url = pym_pymsrc_default_url();
		// The plugin versions its own copy; whoever sets the filter owns that file's versioning.
		$ver = ( pym_pymsrc_local_url() === $url ) ? pym_plugin_version() : null;
		wp_enqueue_script( 'pym-embeds-pymjs', $url, array(), $ver, true );
	}

}
