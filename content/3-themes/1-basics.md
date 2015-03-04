title: Theme Basics
----
# Theme Basics

Be default Baun uses the [Twig](http://twig.sensiolabs.org) template engine to power its themes. Themes are stored
in the `public/themes` folder.

## Active Theme

The currently active theme is set in `config/app.php`:

    'theme' => 'baun',

This means Baun will look for template files in the `public/themes/baun` folder.

## Templates

Themes are made up of several template files. The minimum required templates are:

Template    | Description
----------- | -----------
`page.html` | The default template for all pages
`404.html`  | Shown when no page is found for the current URL

You can also create [custom templates](/themes/custom-templates) if you wish.

## Template Variables

There are certain variables that Baun passes into your templates and can be used as per
[Twig's docs](http://twig.sensiolabs.org/doc/templates.html).

Variable | Description
-------- | -----------
`{{ content|raw }}` | Shows the page content that has been converted from Markdown to HTML. You need to use the `raw` filter as it contains HTML
`{{ info }}` | Contains the attributes from the info section of the page. For example `{{ info.title }}`, `{{ info.description }}` etc.
`{{ baun_nav() }}` | Technically this is a function not a variable. See the [navigation docs](/themes/navigation)

## Layouts

While not required it probably makes sense to make use of Twig's template inheritance.
This means you can create a base template that all other templates can "extend", saving you the hassle of duplicating
lots of HTML. You can create a `layout.html` template which might look like:

    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <title>My Site</title>
    </head>
    <body>
        {% block content %}{% endblock %}
    </body>
    </html>

Then in your other templates you can do the following:

    {% extends "layout.html" %}

    {% block content %}
        {{ content|raw }}
    {% endblock %}

See Twig's [template inheritance docs](http://twig.sensiolabs.org/doc/templates.html#template-inheritance) for more info.