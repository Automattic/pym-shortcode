# Testing advice for upgrading the plugin

We recommend that you perform testing in a copy of your production environment, such as a staging or development server, or a local development environment. You should try to test with as complete a copy as possible, to include themes, plugins, and a copy of the database.

If your live site uses an HTTPS certificate, your testing environment should use an HTTPS certificate. Talk to your hosting provider or consult your local development environment's docs for information about enabling HTTPS. (If your host doesn't offer HTTPS on your staging site, that's unfortunate, but it's not something that would prevent you from testing this plugin.)

## Finding posts that use the `[pym]` shortcode

### site search

Depending on what search engine is enabled on your site, you may be able to find pymsrc posts using the search function: `example.org/?s=pymsrc`

### wp-cli

If you have [wp-cli](https://wp-cli.org/) installed in your environment, you can get a list of posts using the `[pym]` shortcode by running a search using [wp post list](https://developer.wordpress.org/cli/commands/post/list/):

```
wp post list --s='[pym'
```
Your terminal should return a list of posts and their IDs:

```
+----+------------------------------------------+-------------------+---------------------+-------------+
| ID | post_title                               | post_name         | post_date           | post_status |
+----+------------------------------------------+-------------------+---------------------+-------------+
| 5  | Pym Example: multiple tables and pymsrcs | pym-example-table | 2018-08-22 20:44:23 | publish     |
+----+------------------------------------------+-------------------+---------------------+-------------+
```

To find posts containing shortcode or blocks with a custom pymsrc set:

```
$ wp post list --s='pymsrc'
+----+------------------------------------------+------------------------+---------------------+-------------+
| ID | post_title                               | post_name              | post_date           | post_status |
+----+------------------------------------------+------------------------+---------------------+-------------+
| 5  | Pym Example: multiple tables and pymsrcs | pym-example-table      | 2018-08-22 20:44:23 | publish     |
| 10 | Single pym child block                   | single-pym-child-block | 2018-08-29 22:52:19 | publish     |
+----+------------------------------------------+------------------------+---------------------+-------------+
```

You can change the formatting of the list and the information it contains for each post using the arguments of [wp post list](https://developer.wordpress.org/cli/commands/post/list/).

As an example, here's how to use `wp post list`, on a [local Valet development install running on a Mac](https://github.com/INN/docs/blob/master/projects/largo/site-setup-valet.md), to open in your default web browser every single post containing a pymsrc setting:

```
wp post list --s='pymsrc' --format=ids | tr "[:space:]" "\n" | xargs -I % open http://pym-shortcode.test/?p=%
```

This opened two tabs: one each for post `5` and `10`. Use this with caution if you have a lot of stories with `Pym.js` embeds; you might crash your web browser.

## Checking embeds that set pymsrc after updating to 3.0.0

Since 3.0.0, every embed loads Pym.js from the same URL, and the `pymsrc` value in a shortcode or block is ignored. Check that embeds which set `pymsrc` still work:

1. Find all posts using the pymsrc option in a shortcode or block, using one of the methods above.
2. For a representative sample of posts, or for all posts if you can, open each post in a browser.
	1. Does the embed load correctly?
	2. Does the embed resize to fit its content?
	3. Open the browser console. Are there any notices, warnings, or errors?

If an embed worked with the `pymsrc` it set but not with the plugin's copy, first make sure the embedded page loads a current release of Pym.js. If every embed still needs a different copy, a developer can load a known one, such as an NPR tagged release or a copy the site hosts, with the `pym_shortcode_pymsrc` filter. Reuse a `pymsrc` URL from a post only if the site controls or trusts its host, since the file there can change after you check it. A copy from elsewhere doesn't include the plugin's local changes. See [Changing where Pym.js loads from](./readme.md#changing-where-pymjs-loads-from).

Each embedded page loads its own copy of Pym.js. Keep that copy on [the most-recent version of `Pym.js`](http://blog.apps.npr.org/pym.js/) in any case.

## Testing embed alignment

Version 1.3.2.1 of this plugin introduced [support for WordPress' alignment CSS classes](./readme.md#align-for-wordpress-alignment-support).

For advice on styling the alignment classes, see [the Gutenberg docs](https://wordpress.org/gutenberg/handbook/extensibility/theme-support/#wide-alignments-and-floats).

### Shortcode testing

Test your theme's alignment CSS classes with the following shortcodes:

```
[pym src="https://blog.apps.npr.org/pym.js/examples/table/child.html" align=""]
[pym src="https://blog.apps.npr.org/pym.js/examples/table/child.html" align="none"]
[pym src="https://blog.apps.npr.org/pym.js/examples/table/child.html" align="left"]
[pym src="https://blog.apps.npr.org/pym.js/examples/table/child.html" align="center"]
[pym src="https://blog.apps.npr.org/pym.js/examples/table/child.html" align="right"]
[pym src="https://blog.apps.npr.org/pym.js/examples/table/child.html" align="wide"]
[pym src="https://blog.apps.npr.org/pym.js/examples/table/child.html" align="full"]
```

You'll want to check that the embeds are positioned correctly on the page in all browsers that you support and at all viewport widths.

### Block testing

Test your theme's alignment CSS by creating blocks with each alignment option. Your theme may need to [declare wide alignment](https://wordpress.org/gutenberg/handbook/extensibility/theme-support/#wide-alignment) in order to see the "wide" and "full" options.
