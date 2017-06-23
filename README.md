# Pym shortcode

## Sample usage:

```
[pym src="http://blog.apps.npr.org/pym.js/examples/table/child.html"]

```

## All options:

```
[pym src="" pymsrc="" pymoptions="" id="" class="" ]
```

`src` is the URL of the page that is to be embedded.

`pymsrc` is optional; only set this if you need to specify a different source than the default. The default pym source is `js/pym.v1.min.js` in this plugin.

`pymoptions` is optional; this should be a javascript object without the surrounding `{}`, and is given in the event that options need to be passed to the `pymParent`. NPR gives [this example](http://blog.apps.npr.org/pym.js/#examples) javascript:

```js
pym.Parent('example', 'child.html', { xdomain: '*\.npr\.org' });
```

To do the same thing with this Pym shortcode, you would write:

```
[pym src="child.html" pymoptions=" xdomain: '\\*\.npr\.org' "]
```

`id` is optional; this should be a valid HTML element ID name. It will be used as the ID of your `pymParent` iframe on the parent page. You would want to use this if, for example, [your embedded page contained navigation to another page, requiring the second page to know the pymParent element ID](https://github.com/INN/pym-shortcode/issues/20).

For example, the shortcode `[pym src="http://blog.apps.npr.org/pym.js/examples/graphic/child.html" id="extremely_specific_id"]` results in the following output:

```html
<div id="extremely_specific_example" class="pym"></div><script src="http://example.org/wp-content/plugins/pym-shortcode/js/pym.v1.min.js"></script><script>var pym_0 = new pym.Parent('extremely_specific_example', 'http://blog.apps.npr.org/pym.js/examples/graphic/child.html', {})</script>
```

`class` is optional; this should be a valid HTML class name. It will be added to the element's default class, `'pym'`. You would want to use this is, for example, you wanted to [use a size-based class name to determine the size of the embed on your site](https://github.com/INN/pym-shortcode/issues/23). The class `'pym'` will always be output on container elements created by the Pym Shortcode. This class was introduced in version 1.2.2.

For example, the shortcode `[pym src="http://blog.apps.npr.org/pym.js/examples/graphic/child.html" class="one two three four float-left mw_50"]` results in the following output:

```html
<div id="pym_0" class="pym one two three four float-left mw_50"></div><script src="http://insideenergy.dev/wp-content/plugins/pym-shortcode/js/pym.v1.min.js"></script><script>var pym_0 = new pym.Parent('pym_0', 'http://blog.apps.npr.org/pym.js/examples/graphic/child.html', {})</script>
```
