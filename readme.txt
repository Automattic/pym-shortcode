=== Pym Shortcode ===
Contributors: inn_nerds
Donate link: https://inn.org/donate
Tags: shortcode, iframe, javascript, embeds, responsive, pym, NPR
Requires at least: 3.0.1
Tested up to: 4.7.3
Stable tag: 1.2.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A WordPress solution to embed iframes that are responsive horizontally and vertically using the NPR Visuals Team's pym.js.

== Description ==

Pym Shortcode will resize an iframe responsively depending on the height of its content and the width of its container. The plugin uses [Pym.js](http://blog.apps.npr.org/pym.js/), developed by the NPR Visuals Team, to allow embedded content in WordPress posts and pages using a simple shortcode.

== Installation ==

1. In the WordPress Dashboard go to **Plugins**, then click the **Add Plugins** button and search the WordPress Plugins Directory for Pym Shortcode. Alternatively, you can download the zip file from this Github repo and upload it manually to your WordPress site.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Nothing to configure, just begin using Pym Shortcode!

== Frequently Asked Questions ==

For answers to frequently asked questions, [see this plugin's documentation on GitHub](https://github.com/INN/pym-shortcode/tree/master/docs)

== Screenshots ==

Embeddable table from NPR:

![an embeddable table from NPR](img/responsive-iframe-npr.png)

Pym Shortcode in a WordPress post:

![Pym Shortcode in a WordPress post](img/pym-shortcode-in-post.png)

Desktop view of the WordPress post with the NPR embed using Pym Shortcode:

![Desktop view of the WordPress post with the NPR embed using Pym Shortcode](img/pym-example-desktop.png)

Mobile view of the WordPress post with the NPR embed using Pym Shortcode:

![Mobile view of the WordPress post with the NPR embed using Pym Shortcode](img/pym-example-phone.png)

== Changelog ==

= 1.2.2 =

* Update to pym.js version 1.2.2: https://github.com/nprapps/pym.js/releases/tag/v1.2.2 (Changelog at https://github.com/nprapps/pym.js/blob/master/CHANGELOG )
* (we skipped pym.js version 1.2.1: https://github.com/nprapps/pym.js/releases/tag/v1.2.1 )
* Add `id=""` attribute to allow setting custom IDs on embeds. [#21](https://github.com/INN/pym-shortcode/issues/21)
* Add `class=""` attribute to allow setting custom classes on embeds. [#22](https://github.com/INN/pym-shortcode/issues/22) and [#23](https://github.com/INN/pym-shortcode/issues/23).
* Add a default class name `pym` to all embeds output by this plugin.

= 1.2.0.2 =

* Fix encoding error on pym.v1.min.js, [thanks to lchheng](https://github.com/INN/pym-shortcode/pull/18)

= 1.2.0.1 =

* Add attribution for lchheng's [pymsrc fix](https://github.com/INN/pym-shortcode/pull/17).

= 1.2.0 =

* Update to pym.js version 1.2.0: https://github.com/nprapps/pym.js/releases/tag/v1.2.0 (Changelog at https://github.com/nprapps/pym.js/blob/v1.2.0/CHANGELOG )
* Fixes a bug where the `pymsrc` attribute might have been ignored, for real this time. [Thanks, lchheng!](https://github.com/INN/pym-shortcode/pull/17)

= 1.1.2 =

* Update to pym.js version 1.1.2: https://github.com/nprapps/pym.js/releases/tag/v1.1.2
* Switch the new default url of `Pym.js` in this plugin to `js/pym.v1.min.js`, leaving the existing `js/pym.js` where it is.
* Provide additional notes in [the documentation](https://github.com/INN/pym-shortcode/tree/master/docs) for maintainers on updating `Pym.js` in this plugin
* Fixes a bug where the `pymsrc` attribute might have been ignored
* Fixes and corrections to documentation.

= 1.0 =

* First release of the plugin

== Upgrade Notice ==

No updates at this time.

== Pym Resources from NPR ==

You may also want to look at NPR's Pym.js resources:

* [Pym.js homepage](http://blog.apps.npr.org/pym.js/)
* [Pym.js repo on GutHub/nprapps](https://github.com/nprapps/pym.js/)
