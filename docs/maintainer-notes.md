# Notes for Plugin maintainers

## Updating Pym.js

`js/pym.js` is NPR's `dist/pym.v1.js` at a tagged release, plus the local changes marked "pym-shortcode local change" in the file. Its header records the upstream tag and commit.

To update:

1. Download `dist/pym.v1.js` from the new tag in https://github.com/nprapps/pym.js.
2. Re-apply each change marked "pym-shortcode local change" in the current `js/pym.js`. There are two:
	- `Parent`'s `_processMessage` returns unless the message came from the embed's own iframe.
	- The `Parent` constructor builds no iframe when `_isSafeUrl()` rejects the child URL, trimmed of surrounding spaces. `_isSafeUrl()` is upstream's own check.
3. Copy the header comment from the current `js/pym.js` into the new file, below upstream's first (banner) line, then update its tag and commit SHA.
4. Compare the result with upstream: `curl -s https://raw.githubusercontent.com/nprapps/pym.js/<new tag>/dist/pym.v1.js | diff - js/pym.js`. The only differences should be the header comment and the marked changes.
5. Bump the plugin's version and add a changelog entry, as for any release.

NPR Visuals Team's [stated intention](https://github.com/nprapps/pym.js/tree/master#versioning) is that versions of `Pym.js` will be backwards-compatible for `0.x` and `0.0.x` releases, so we can take those in with the local changes re-applied. When a `x.0.0` release comes around, we'll need to figure out a plan for that. See discussion in https://github.com/INN/pym-shortcode/issues/12

## Updating the plugin

Since 2.0.0, the plugin's version number follows the plugin's own changes. It no longer matches the version of the bundled `Pym.js`, which the header of `js/pym.js` records. Releases from 1.1.2 to 1.3.2.4 matched it in the first three numbers.

The plugin's [version history](https://github.com/INN/pym-shortcode/releases) looks like this:

- 0.1: initial release
- 1.1.2
- 1.2.0
- 1.2.0.1: a fix in this plugin
- 1.2.0.2: a fix in this plugin
- 1.3.1
- 1.3.2
- 1.3.2.1: Gutenberg and settings page
- 1.3.2.2: WordPress 5.0 support
- 1.3.2.3: AMP support
- 1.3.2.4: minor bugfix for WP 5.4
- 2.0.0: `pymoptions` limited to known Pym.js options
- 3.0.0: Pym.js loads from the plugin's own `js/pym.js` by default; settings page removed

## Release checklist

See [release-checklist.md](./release-checklist.md) for the full list.

## Testing before release

You should make a copy of this document to keep track of checking off the checkboxes. A Github comment is a fine place to do that, as in https://github.com/INN/pym-shortcode/issues/68#issuecomment-593634311.

See also https://github.com/INN/docs/blob/master/projects/wordpress-plugins/release.sh.md

Run the following tests both with and without [the AMP plugin](https://wordpress.org/plugins/amp/) activated:
- [ ] with
- [ ] without

Plugin settings:

- [ ] Does the settings notice work? With a `pym_embeds` option saved (`wp option update pym_embeds '{"default_pymsrc":"https://pym.nprapps.org/pym.v1.min.js"}' --format=json`), an administrator sees the notice with the saved URL, and its **Dismiss this notice** button deletes the option.
- [ ] Does the plugin info page work? `/wp-admin/tools.php?page=pym-embeds-info`

Shortcode tests:

- [ ] `[pym src="https://blog.apps.npr.org/pym.js/examples/table/child.html"]`
- [ ] `[pym src="https://blog.apps.npr.org/pym.js/examples/table/child.html" pymsrc="https://pym.nprapps.org/pym.v1.min.js"]` (the `pymsrc` value is ignored; the embed loads the plugin's `js/pym.js`)
- [ ] `[pym src="https://blog.apps.npr.org/pym.js/examples/table/child.html" pymoptions=" xdomain: '\\*\.npr\.org' "]`
- [ ] `[pym src="https://blog.apps.npr.org/pym.js/examples/table/child.html" class="one two three four float-left mw_50"]`
- [ ] `[pym src="https://blog.apps.npr.org/pym.js/examples/table/child.html" align=""]`
- [ ] `[pym src="https://blog.apps.npr.org/pym.js/examples/table/child.html" align="none"]`
- [ ] `[pym src="https://blog.apps.npr.org/pym.js/examples/table/child.html" align="left"]`
- [ ] `[pym src="https://blog.apps.npr.org/pym.js/examples/table/child.html" align="center"]`
- [ ] `[pym src="https://blog.apps.npr.org/pym.js/examples/table/child.html" align="right"]`
- [ ] `[pym src="https://blog.apps.npr.org/pym.js/examples/table/child.html" align="wide"]`
- [ ] `[pym src="https://blog.apps.npr.org/pym.js/examples/table/child.html" align="full"]`
- [ ] `[pym src="https://blog.apps.npr.org/pym.js/examples/table/child.html" id="extremely_specific_id"]`
- [ ] `[pym src="https://blog.apps.npr.org/pym.js/examples/table/child.html" pymsrc="https://pym.nprapps.org/pym.v1.min.js" pymoptions=""]` (the `pymsrc` value is ignored; the embed loads the plugin's `js/pym.js`)
- [ ] `[pym src="https://blog.apps.npr.org/pym.js/examples/table/child.html" pymsrc="https://pym.nprapps.org/pym.v1.min.js" pymoptions=""]` (the `pymsrc` value is ignored; the embed loads the plugin's `js/pym.js`)

Gutenberg tests:

- [ ] the block, when inserted, prompts users for a URL
- [ ] the block's alignment, custom classes, custom ID, and other options are respected.
- [ ] the block loads the plugin's js/pym.js
- [ ] on a site with Gutenberg not installed, the plugin functions
- [ ] on a 4.9 site with Gutenberg installed, the plugin functions
- [ ] on a 5.0 site, the plugin functions
