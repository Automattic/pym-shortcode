=== Pym Shortcode ===
Contributors: inn_nerds
Donate link: https://inn.org/donate
Tags: pym,javascript,embeds,responsive
Requires at least: 3.0.1
Tested up to: 4.5.2
Stable tag: v0.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A WordPress solution to embed iframes responsive horizontally and vertically using the NPR Visuals Team's pym.js in shortcode.

== Description ==

Pym Shortcode will resize an iframe responsively depending on the height of its content and the width of its container. The plugin uses [Pym.js](http://blog.apps.npr.org/pym.js/), developed by the NPR Visuals Team, to allow embedded content in WordPress posts and pages using a simple shortcode. 

== Installation ==

1. In the WordPress Dashboard go to **Plugins**, then click the **Add Plugins** button and search the WordPress Plugins Directory for Pym Shortcode. Alternatively, you can download the zip file from this Github repo and upload it manually to your WordPress site.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Nothing to configure, just begin using Pym Shortcode!

== Frequently Asked Questions ==

= Why would I want to use Pym in the first place? =

Using iframes in a responsive page can be frustrating. It’s easy enough to make an iframe’s width span 100% of its container, but sizing its height is tricky — especially if the content of the iframe changes height depending on page width (for example, because of text wrapping or media queries) or events within the iframe.

= Why is a WordPress plugin needed to use Pym.js? =

Normally WordPress strips out JavaScript inserted in posts and pages, so the native Pym.js code won't work. Pym Shortcode simply provides a wrapper around Pym.js so you can embed anything you'd use Pym.js for by using WordPress shortcode. 

= Is Pym.js or this plugin dependent on jQuery or any other library? =

Nope.

= How do you serve pym.js if the embedded page's domain has an SSL cert (and can/will be served over HTTPS) but the parent page's domain does not have an SSL certificate? =

The default pym source is js/pym.src in this plugin, but you can optionally change the source by using the `pymsrc` parameter in the shortcode, for example a CDN source for Pym.js like `https://cdnjs.cloudflare.com/ajax/libs/pym/0.4.5/pym.min.js`

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

= 1.0 =

* First release of the plugin

== Upgrade Notice == 

No updates at this time.

== Pym Resources from NPR ==

You may also want to look at NPR's Pym.js resources:

* [Pym.js homepage](http://blog.apps.npr.org/pym.js/)
* [Pym.js repo on GutHub/nprapps](https://github.com/nprapps/pym.js/)
