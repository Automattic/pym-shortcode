# Pym shortcode

## Sample usage:

```
[pym src="http://blog.apps.npr.org/pym.js/examples/table/child.html"]

```

## All options:

```
[pym src="" pymsrc="" pymoptions=""]
```

`src` is the URL of the page that is to be embedded.

`pymsrc` is optional; only set this if you need to specify a different source than the default. The default pym source is `js/pym.src` in this plugin.

`pymoptions` is optional; this should be a javascript object without the surrounding `{}`, and is given in the event that options need to be passed to the `pymParent`. NPR gives [this example](http://blog.apps.npr.org/pym.js/#examples) javascript:

```js
pym.Parent('example', 'child.html', { xdomain: '*\.npr\.org' });
```

To do the same thing with this Pym shortcode, you would write:

```
[pym src="child.html" pymoptions=" xdomain: '*\.npr\.org' "]
```
