# Pym Shortcode

Pym Shortcode will responsively resize an iframe's height depending on the width of its container. The plugin uses [Pym.js](http://blog.apps.npr.org/pym.js/), developed by the [NPR Visuals Team](http://blog.apps.npr.org/), to allow embedded content in WordPress posts and pages using a simple shortcode. Using `pym.js`, it bypasses the usual cross-domain issues.

## Plugin Installation

1. In the WordPress Dashboard go to **Plugins**, then click the **Add Plugins** button and search the WordPress Plugins Directory for Pym Shortcode. Alternatively, you can download the zip file from this Github repo and upload it manually to your WordPress site.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Nothing to configure, just begin using Pym Shortcode!

## Using Pym Shortcode

In a WordPress post or page use Pym Shortcode like this:

`[pym src="http://blog.apps.npr.org/pym.js/examples/table/child.html"]`

Example in a post:

![Pym Shortcode in a WordPress post](img/pym-shortcode-in-post.png)

Desktop view of the WordPress post with the NPR embed using Pym Shortcode:

![Desktop view of the WordPress post with the NPR embed using Pym Shortcode](img/pym-example-desktop.png)

Mobile view of the WordPress post with the NPR embed using Pym Shortcode:

![Mobile view of the WordPress post with the NPR embed using Pym Shortcode](img/pym-example-phone.png)

## Options

```
[pym src="" pymsrc="" pymoptions=""]
```

`src` is the URL of the page that is to be embedded.

`pymsrc` is optional; only set this if you need to specify a different source for Pym.js than the default. The default pym source is `js/pym.src` in this plugin.

`pymoptions` is optional; this should be a javascript object without the surrounding `{}`, and is given in the event that options need to be passed to the `pymParent`. NPR gives [this example](http://blog.apps.npr.org/pym.js/#examples) javascript:

```js
pym.Parent('example', 'child.html', { xdomain: '*\.npr\.org' });
```

## Frequently Asked Questions

### Why would I want to use Pym in the first place?

Using iframes in a responsive page can be frustrating. It’s easy enough to make an iframe’s width span 100% of its container, but sizing its height is tricky — especially if the content of the iframe changes height depending on page width (for example, because of text wrapping or media queries) or events within the iframe.

### Why is a WordPress plugin needed to use Pym.js?

Normally WordPress strips out JavaScript inserted in posts and pages, so the native Pym.js code won't work. Pym Shortcode simply provides a wrapper around Pym.js so you can embed anything you'd use Pym.js for by using WordPress shortcode. 

### When would I use a Pym solution versus embed code without using Pym?

If you're embedding a YouTube video or a SoundCloud audio player, you don't need Pym.js and in fact you would not want to use it. To make these commodity types of embeds responsive, you may need to add CSS rules depending on your theme. They won't be resized by Pym Shortcode.

You would want to use Pym for other types of iframe content including tables, charts, and interactive elements. For example, news organizations often create data-driven visualizations that are hosted in another application and need to be iframed into their CMS. 

For Pym Shortcode to work, `pym.js` code must be on the "Child Page" which is the source of the content embedded in the shortcode. You can use Pym Shortcode to embed content from any page that is so enabled.

### Is Pym.js or this plugin dependent on jQuery or any other library?

Nope, all the required JavaScript is self-contained in `pym.js`. The shortcode will enqueue `pym.js` when necessary. You will need to include `pym.js` on the embedded page, however.

### Why would I want to change the pym.js source URL?

There are several reasons why you might want to change the version of Pym used to embed a webpage. For example:

- The embedded page uses an older version of Pym
- The embedded page is loaded over HTTPS, so Pym must be loaded over HTTPS to communicate with the child
- The embedded page uses a modified version of Pym

In any of these cases, set the new version of Pym using the `pymsrc` option in the shortcode:

```
[pym src="http://blog.apps.npr.org/pym.js/examples/table/child.html" pymsrc="https://cdnjs.cloudflare.com/ajax/libs/pym/0.4.5/pym.min.js" pymoptions=""]
```

### How do I serve pym.js if the embedded page uses HTTPS and my site does not?

If the embedded page's domain has an SSL certificate and is loaded over HTTPS, and if your site is loaded over plain HTTP, then the Pym script on your page will not be able to talk to the Pym script in the embedded page. This can be fixed by making sure your site loads over HTTPS, or by specifying an alternate source for your Pym script.

The default pym source is `js/pym.src` in this plugin, served by whatever protocol your site is using. You can change the source by using the `pymsrc` parameter in the shortcode, for example an HTTPS-using CDN source like `https://cdnjs.cloudflare.com/ajax/libs/pym/0.4.5/pym.min.js`:

```
[pym src="https://blog.apps.npr.org/pym.js/examples/table/child.html" pymsrc="https://cdnjs.cloudflare.com/ajax/libs/pym/0.4.5/pym.min.js" pymoptions=""]
```

### How do I know if there's an HTTPS problem with a given embedded iframe?

If the embed isn't resizing correctly (especially vertically), the `pym.js` script may not be loading correctly.

You can determine if the embed is being served by `https` by opening the embed in new tab and looking at the protocol it's using. To open the embed in a new tab, try right-clicking on the embed and choosing "Open frame in new tab" or a similar option.

You can also check by opening your browser's developer tools and looking in the console for errors.

## Other Pym Resources

You may also want to look at NPR's Pym.js resources, especially if you're interesting in building Pym-compatible embeds:

* [Pym.js homepage](http://blog.apps.npr.org/pym.js/)
* [Pym.js repo on GutHub/nprapps](https://github.com/nprapps/pym.js/)
