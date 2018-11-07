# Notes for Plugin maintainers

### Updating Pym.js

`js/pym.v1.min.js` in this plugin should be kept up-to-date with the current version of https://pym.nprapps.org/pym.v1.min.js.

`js/pym.js` is specifically `Pym.js` version 1.1.0, which this plugin was introduced with, before we had solid plans for an update strategy. It will not be updated.

To update:

- save https://pym.nprapps.org/pym.v1.min.js as `js/pym.v1.min.js` in this plugin, or download https://github.com/nprapps/pym.js/blob/master/dist/pym.v1.min.js from the relevant most-recent tagged release.
- update this plugin's version number to the `Pym.js` version number

NPR Visuals Team's [stated intention](https://github.com/nprapps/pym.js/tree/master#versioning) is that versions of `Pym.js` will be backwards-compatible for `0.x` and `0.0.x` releases, so we can copy those in directly. When a `x.0.0` release comes around, we'll need to figure out a plan for that. See discussion in https://github.com/INN/pym-shortcode/issues/12

### Updating the plugin

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
