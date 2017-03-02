## Notes for Plugin maintainers

`js/pym.v1.min.js` in this plugin should be kept up-to-date with the current version of https://pym.nprapps.org/pym.v1.min.js.

`js/pym.js` is specifically `Pym.js` version 1.1.0, which this plugin was introduced with, before we had solid plans for an update strategy. It will not be updated.

To update:

- save https://pym.nprapps.org/pym.v1.min.js as `js/pym.v1.min.js` in this plugin, or download https://github.com/nprapps/pym.js/blob/master/dist/pym.v1.min.js from the relevant most-recent tagged release.
- update this plugin's version number to the pym version number

NPR Visuals Team's [stated intention](https://github.com/nprapps/pym.js/tree/master#versioning) is that versions of Pym will be backwards-compatible for `0.x` and `0.0.x` releases, so we can copy those in directly. When a `x.0.0` release comes around, we'll need to figure out a plan for that. See discussion in https://github.com/INN/pym-shortcode/issues/12
