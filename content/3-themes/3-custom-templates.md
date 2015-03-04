title: Custom Templates
----
# Custom Templates

To use a custom template for a page you need to add the `template` attribute to the page.
For example the page info section might look like:

    title: Custom Templates
    template: custom
    ----
    # Custom Templates
    ...

This would then use the `custom.html` template instead of `page.html` template in the active theme.

## Contact Example

Let's use an example to better demonstrate the use of custom templates. Say we want a contact page that makes use of
some custom attributes. The page might look like:

    title: Contact
    template: contact
    contact_methods:
        - Email: mailto:hi@example.com
        - Twitter: http://twitter.com/gilbitron
    ----
    # Contact

    Please contact me using the links below:

The our `contact.html` template might look like:

    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <title>{{ info.title }} - My Site</title>
    </head>
    <body>
        {{ content|raw }}

        <ul class="contact-methods">
            {% for contact_method in info.contact_methods %}
                {% for name, link in contact_method %}
                    <li><a href="{{ link }}">{{ name }}</a></li>
                {% endfor %}
            {% endfor %}
        </ul>
    </body>
    </html>