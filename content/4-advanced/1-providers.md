title: Custom Providers
----
# Custom Providers

Baun uses the idea of "providers" to abstract out most of it's implementation. This makes it easy to create
your own custom providers and swap them out via the `providers` setting in `config/app.php`.

## Interfaces

Every provider implements an interface. This is important to maintian proper functionality within Baun.
Every provider must implement the minimum methods defined in each interface. See the
[default Interfaces](https://github.com/BaunCMS/Framework/tree/master/src/Interfaces) for more info.

## Providers

A good place to start when creating a custom provider is to have a look at the
[default Providers](https://github.com/BaunCMS/Framework/tree/master/src/Providers).

As an example let's imagine you wanted to change the template engine from Twig to something else. You would
achieve this by creating your own Template Provider. It might look something like:

    <?php namespace My\CustomProviders;

    use Baun\Interfaces\Theme as ThemeInterface;

    class CustomTheme implements ThemeInterface {

        public function __construct($themes_path)
        {
            //...
        }

        public function render($template, $data = [])
        {
            //...
        }

        public function custom($name, $data)
        {
            //...
        }

    }

You can then package your provider and make sure it is [autoloaded](https://getcomposer.org/doc/01-basic-usage.md#autoloading).

Then all the user needs to do is install your package using [Composer](https://getcomposer.org), and change the line
in their `config/app.php`. For example:

    'providers' => [
        'contentParser' => 'Baun\Providers\ContentParser',
        'router'        => 'Baun\Providers\Router',
        'theme'         => 'My\CustomProvidersCustomTheme'
    ]

## Default Libraries

By default the Baun providers use the following libraries:

Provider | Library
-------- | -------
`contentParser` | [PHP Markdown](https://github.com/michelf/php-markdown)
`router` | [PHRoute](https://github.com/mrjgreen/phroute)
`theme` | [Twig](http://twig.sensiolabs.org)