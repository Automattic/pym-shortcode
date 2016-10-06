## Notes for Plugin maintainers

`js/pym.js` in this plugin should be kept up-to-date with the current version of https://pym.nprapps.org/pym.v1.min.js.

To update:

- save https://pym.nprapps.org/pym.v1.min.js as `js/pym.js` in this plugin.
- update this plugin's version number to the pym version number

NPR Visuals Team's [stated intention](https://github.com/nprapps/pym.js/tree/master#versioning) is that versions of Pym will be backwards-compatible for `0.x` and `0.0.x` releases, so we can copy those in directly. When a `x.0.0` release comes around, we'll need to figure out a plan for that.
