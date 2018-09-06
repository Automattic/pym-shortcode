# Testing advice for upgrading the plugin

We recommend that you perform testing in a copy of your production environment, such as a staging or development server, or a local development environment. You should try to test with as complete a copy as possible, to include themes, plugins, and a copy of the database.

If your live site uses an HTTPS certificate, your testing environment should use an HTTPS certificate. Talk to your hosting provider or consult your local development environment's docs for information about enabling HTTPS.

## Finding posts that use the `[pym]` shortcode

### site search

Depending on what search engine is enabled on your site, you may be able to find pymsrc posts using the search function: `example.org/?s=pymsrc`

### wp-cli

If you have [wp-cli](https://wp-cli.org/) installed in your environment, you can get a list of posts using the `[pym]` shortcode by running a search using [wp post list](https://developer.wordpress.org/cli/commands/post/list/)

```
wp post list --s='[pym'
```
You should see a list of posts and their IDs.

```
+----+------------------------------------------+-------------------+---------------------+-------------+
| ID | post_title                               | post_name         | post_date           | post_status |
+----+------------------------------------------+-------------------+---------------------+-------------+
| 5  | Pym Example: multiple tables and pymsrcs | pym-example-table | 2018-08-22 20:44:23 | publish     |
+----+------------------------------------------+-------------------+---------------------+-------------+
```

To find posts containg shortcode or blocks with a custom pymsrc set:

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

As an example, here's how to use `wp post list` on a Mac to open in a browser every single post containing a pymsrc setting:

```
wp post list --s='pymsrc' --format=ids | tr "[:space:]" "\n" | xargs -I % open http://pym-shortcode.test/?p=%
```

## Testing the pymsrc override

1. Enable the override option in **Settings > Pym.js Embeds Settings > Override pymsrc**
2. Find all posts using the pymsrc option in a shortcode or block, using one of the methods above.
3. For a representative sample of posts, or for all posts if you can, open each post in a browser.
	1. Does the embed load correctly?
	2. Open the browser console. Are there any notices, warnings, or errors?
	3. 

You may want to take the time to edit your embedded pages so that they all use the NPR CDN version of `Pym.js`, or use your newsroom's CDN version of `Pym.js`. You should be using [the most-recent version of `Pym.js`](http://blog.apps.npr.org/pym.js/) in any case.
