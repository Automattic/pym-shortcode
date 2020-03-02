# Notes for Plugin maintainers

## Updating Pym.js

`js/pym.v1.min.js` in this plugin should be kept up-to-date with the current version of https://pym.nprapps.org/pym.v1.min.js.

`js/pym.js` is specifically `Pym.js` version 1.1.0, which this plugin was introduced with, before we had solid plans for an update strategy. It will not be updated.

To update:

- save https://pym.nprapps.org/pym.v1.min.js as `js/pym.v1.min.js` in this plugin, or download https://github.com/nprapps/pym.js/blob/master/dist/pym.v1.min.js from the relevant most-recent tagged release.
- update this plugin's version number to the `Pym.js` version number

NPR Visuals Team's [stated intention](https://github.com/nprapps/pym.js/tree/master#versioning) is that versions of `Pym.js` will be backwards-compatible for `0.x` and `0.0.x` releases, so we can copy those in directly. When a `x.0.0` release comes around, we'll need to figure out a plan for that. See discussion in https://github.com/INN/pym-shortcode/issues/12

## Updating the plugin

The plugin's `A.B.C` version number should match the version number of the bundled copy of `Pym.js`. We started doing this in plugin release 1.1.2.

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

## Release checklist

See [release-checklist.md](./release-checklist.md) for the full list.

## Testing before release

You should make a copy of this document to keep track of checking off the checkboxes:

See also https://github.com/INN/docs/blob/master/projects/wordpress-plugins/release.sh.md

Run the following tests both with and without [the AMP plugin](https://wordpress.org/plugins/amp/) activated:
- [ ] with
- [ ] without

Plugin settings:

- [ ] Does the plugin settings page work?

Shortcode tests:

- [ ] `[pym src="https://blog.apps.npr.org/pym.js/examples/table/child.html"]`
- [ ] `[pym src="https://blog.apps.npr.org/pym.js/examples/table/child.html" pymsrc="https://pym.nprapps.org/pym.v1.min.js"]`
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
- [ ] `[pym src="https://blog.apps.npr.org/pym.js/examples/table/child.html" pymsrc="https://pym.nprapps.org/pym.v1.min.js" pymoptions=""]`
- [ ] `[pym src="https://blog.apps.npr.org/pym.js/examples/table/child.html" pymsrc="https://pym.nprapps.org/pym.v1.min.js" pymoptions=""]`

Gutenberg tests:

- [ ] the block, when inserted, prompts users for a URL
- [ ] the block's alignment, custom classes, custom ID, and other options are respected.
- [ ] the block uses the default pymsrc URL if the pymsrc attribute is not set
- [ ] on a site with Gutenberg not installed, the plugin functions
- [ ] on a 4.9 site with Gutenberg installed, the plugin functions
- [ ] on a 5.0 site, the plugin functions
