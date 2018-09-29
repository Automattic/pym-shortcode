=== Pym.js Embeds ===
Contributors: innlabs
Donate link: https://inn.org/donate
Tags: shortcode, iframe, javascript, embeds, responsive, pym, NPR
Requires at least: 3.0.1
Requires PHP: 5.3
Tested up to: 4.9.8
Stable tag: 1.3.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A WordPress solution to embed iframes that are responsive horizontally and vertically using the NPR Visuals Team's `Pym.js`.

== Description ==

Pym.js Embeds provides shortcode and Gutenberg block wrappers for embedding responsive iframes using [Pym.js](http://blog.apps.npr.org/pym.js/), developed by the NPR Visuals Team. Embedded content resizes vertically to match its container's width.

== Installation ==

1. In the WordPress Dashboard go to **Plugins**, then click the **Add Plugins** button and search the WordPress Plugins Directory for Pym.js Embeds. Alternatively, you can download the zip file from this Github repo and upload it manually to your WordPress site.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. In **Settings > Pym.js Embed Settings**, decide whether you'd like to change the plugin's behavior to use a non-default source URL for `Pym.js`, and whether you'd like to prevent post authors from setting embed-specific URLs for `Pym.js`
4. Begin embedding content!

== Frequently Asked Questions ==

For answers to frequently asked questions, [see this plugin's documentation on GitHub](https://github.com/INN/pym-shortcode/tree/master/docs).

For support resources, [see this plugin's documentation on GitHub](https://github.com/INN/pym-shortcode/tree/master/docs).

== Screenshots ==

Embeddable table from NPR:

![an embeddable table from NPR](img/responsive-iframe-npr.png)

Pym.js Shortcode in a WordPress post:

![Pym.js Shortcode in a WordPress post](img/pym-shortcode-in-post.png)

Desktop view of the WordPress post with the NPR embed using Pym.js Shortcode:

![Desktop view of the WordPress post with the NPR embed using Pym.js Shortcode](img/pym-example-desktop.png)

Mobile view of the WordPress post with the NPR embed using Pym.js Shortcode:

![Mobile view of the WordPress post with the NPR embed using Pym.js Shortcode](img/pym-example-phone.png)

== Changelog ==

= 1.3.2.1 =

**This is a major update! Please read the release notes.**

Following the practice begun at plugin version 1.1.2 of [having the plugin version number match the version number of the bundled copy of `Pym.js`](https://github.com/INN/pym-shortcode/blob/master/docs/maintainer-notes.md), the first three numbers in this plugin's version do not change with this release because the `Pym.js` version has not changed. We've tacked a `.1` on to the end to denote this release. Please read the release notes and test your site as appropriate before upgrading in production.

We wish to thank all who helped us test [the release candidate](https://github.com/INN/pym-shortcode/releases/tag/v1.3.2.1-rc1) for this version, including Mike Janssen at [Current.org](https://current.org/) and Aly Hurt at NPR's Visuals Team.

New features:

* Plugin renamed from "Pym Shortcode" to "Pym.js Embeds".
* Adds a "Pym.js Embed" block for use in Gutenberg. [PR #34](https://github.com/INN/pym-shortcode/pull/34) for issue [#28](https://github.com/INN/pym-shortcode/issues/28).
	* If a block is created using this plugin and Gutenberg, and Gutenberg is then disabled, the block will show a link to the embedded graphic.
* Through the settings page, you can now serve Pym.js using your newsroom's CDN or NPR's CDN! [PR #45]() for [issue #31](https://github.com/INN/pym-shortcode/issues/31).
* Adds a settings page, available to [those users with the `manage_options` capability](https://codex.wordpress.org/Roles_and_Capabilities#Capability_vs._Role_Table), with the following options:
	* Change the default pymsrc URL. [PR #45](https://github.com/INN/pym-shortcode/pull/45) for [issue #8](https://github.com/INN/pym-shortcode/issues/8).
	* Override block and shortcode pymsrc URLs with the default pymsrc URL. [PR #45](https://github.com/INN/pym-shortcode/pull/45) for [issue #8](https://github.com/INN/pym-shortcode/issues/8).
* Adds an informational page, available to all who can make posts, that lists the plugin's default source URL for `Pym.js`. This is to make the process of building new interactives easier.
* Shortcode now gains an explicit `align=""` parameter, so that WordPress's generated [alignment CSS classes](https://codex.wordpress.org/CSS#WordPress_Generated_Classes) can be used on embeds. By enabling this in the shortcode, the Gutenberg Block also gains support for alignment. [PR #34](https://github.com/INN/pym-shortcode/pull/34). Prior to this release, the alignment classes could be added via the `class=""` parameter.
* Script tags for embeds are no longer output by `the_content()`, instead being output during `wp_footer()` by [closures](https://secure.php.net/manual/en/functions.anonymous.php) hooked on the `'wp_footer'` action. [PR #34](https://github.com/INN/pym-shortcode/pull/34) for issues [#33](https://github.com/INN/pym-shortcode/issues/33) and [#35](https://github.com/INN/pym-shortcode/issues/35).
* The script tag used to run `new pym.Parent` is now configurable. By replacing the [pluggable function](https://codex.wordpress.org/Pluggable_Functions) `pym_shortcode_script_footer_enqueue()` with your own function, you can now use alternate forms of embed code that may be required for PJAX sites or custom versions of Pym.js. This resolves issue [#19](https://github.com/INN/pym-shortcode/issues/19).
* Adds "Requires PHP: 5.3" metadata to the plugin's `readme.txt`, since we're now using PHP namespaces for some code.
* Adds documentation for how to test the plugin:
	* tests to run before enabling the "override pymsrc" option in production
	* tests to run for site compatibility with Gutenberg

Changes:

* The source URL for `pymjs`, known as the pymsrc URL, is now passed through [wp_http_validate_url](https://developer.wordpress.org/reference/functions/wp_http_validate_url/). [PR #45](https://github.com/INN/pym-shortcode/pull/45) for [issue #8](https://github.com/INN/pym-shortcode/issues/8).
* The source URL for `pym.js` is no longer output by `the_content()`, instead being output during `wp_footer` by an action dedicated to the task. If different shortcodes and/or blocks on the page specify different source URLs for Pym.js, all are output (after removing duplicates), but a message is logged in the browser console. If `WP_DEBUG` is set, this message is also logged to the server log, with the post ID specified. [PR #34](https://github.com/INN/pym-shortcode/pull/34) for issues [#33](https://github.com/INN/pym-shortcode/issues/33) and [#35](https://github.com/INN/pym-shortcode/issues/35). See https://github.com/INN/pym-shortcode/tree/master/docs#ive-set-a-different-pymsrc-option-but-now-im-seeing-a-message-in-the-console
* `docs/updating-pym.md` becomes `docs/maintainer-notes.md`
* Script tags for embeds are no longer output by `the_content()`, instead being output during `wp_footer()` by [closures](https://secure.php.net/manual/en/functions.anonymous.php) hooked on the `'wp_footer'` action. [PR #34](https://github.com/INN/pym-shortcode/pull/34) for issues [#33](https://github.com/INN/pym-shortcode/issues/33) and [#35](https://github.com/INN/pym-shortcode/issues/35).

Removed:

* Script tags for embeds are no longer output by `the_content()`, instead being output during `wp_footer()` by [closures](https://secure.php.net/manual/en/functions.anonymous.php) hooked on the `'wp_footer'` action. [PR #34](https://github.com/INN/pym-shortcode/pull/34) for issues [#33](https://github.com/INN/pym-shortcode/issues/33) and [#35](https://github.com/INN/pym-shortcode/issues/35).

= 1.3.2 =

* *RECOMMENDED UPDATE* : Pym.js users, NPR has released an update that closes a potential security hole. We recommend everyone update to 1.3.2.
* Update to Pym.js version 1.3.2: https://github.com/nprapps/pym.js/releases/tag/v1.3.2 (Changelog at https://github.com/nprapps/pym.js/blob/v1.3.2/CHANGELOG)

= 1.3.1 =

* Update to Pym.js version 1.3.1: https://github.com/nprapps/pym.js/releases/tag/v1.3.1 (Changelog at https://github.com/nprapps/pym.js/blob/v1.3.1/CHANGELOG)
* (we skipped pym.js version 1.3.0: https://github.com/nprapps/pym.js/releases/tag/v1.3.0)

= 1.2.2 =

* Update to Pym.js version 1.2.2: https://github.com/nprapps/pym.js/releases/tag/v1.2.2 (Changelog at https://github.com/nprapps/pym.js/blob/master/CHANGELOG )
* (we skipped Pym.js version 1.2.1: https://github.com/nprapps/pym.js/releases/tag/v1.2.1 )
* Add `id=""` attribute to allow setting custom IDs on embeds. [#21](https://github.com/INN/pym-shortcode/issues/21)
* Add `class=""` attribute to allow setting custom classes on embeds. [#22](https://github.com/INN/pym-shortcode/issues/22) and [#23](https://github.com/INN/pym-shortcode/issues/23).
* Add a default class name `pym` to all embed-containing div elements output by this plugin, and a filter 'pym_shortcode_default_class' to allow changing it.

= 1.2.0.2 =

* Fix encoding error on pym.v1.min.js, [thanks to lchheng](https://github.com/INN/pym-shortcode/pull/18)

= 1.2.0.1 =

* Add attribution for lchheng's [pymsrc fix](https://github.com/INN/pym-shortcode/pull/17).

= 1.2.0 =

* Update to Pym.js version 1.2.0: https://github.com/nprapps/pym.js/releases/tag/v1.2.0 (Changelog at https://github.com/nprapps/pym.js/blob/v1.2.0/CHANGELOG )
* Fixes a bug where the `pymsrc` attribute might have been ignored, for real this time. [Thanks, lchheng!](https://github.com/INN/pym-shortcode/pull/17)

= 1.1.2 =

* Update to Pym.js version 1.1.2: https://github.com/nprapps/pym.js/releases/tag/v1.1.2
* Switch the new default url of `Pym.js` in this plugin to `js/pym.v1.min.js`, leaving the existing `js/pym.js` where it is.
* Provide additional notes in [the documentation](https://github.com/INN/pym-shortcode/tree/master/docs) for maintainers on updating `Pym.js` in this plugin
* Fixes a bug where the `pymsrc` attribute might have been ignored
* Fixes and corrections to documentation.

= 1.0 =

* First release of the plugin

== Pym.js Resources from NPR ==

You may also want to look at NPR's Pym.js resources:

* [Pym.js homepage](http://blog.apps.npr.org/pym.js/)
* [Pym.js repo on GutHub/nprapps](https://github.com/nprapps/pym.js/)
