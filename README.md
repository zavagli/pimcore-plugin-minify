Minify Plugin
=============================

Developer info: [Pimcore at basilicom](http://basilicom.de/en/pimcore)

## Synopsis

This plugin adds two new classes to help with with CSS and Javascript
combination / minification in layouts / templates.

## Installation

Add the "basilicom-pimcore-plugin/minify" requirement to the composer.json 
in the toplevel directory of your pimcore installation:

Example:

    {
        "require": {
            "basilicom-pimcore-plugin/minify": ">=1.0.0"
        }
    }


Or run:

    composer require basilicom-pimcore-plugin/minify

Then enable and install the Minify plugin in Pimcore Extension Manager (Extras > Extensions).

## Integration

Add to your templates:

        <?php
            $js = new \Minify\Js();
            echo $js->add("/website/static/js/jquery.js")
                ->add("/website/static/js/site.js")
                ->get();
        ?>
        
Or for CSS:

        <?php
            $js = new \Minify\Css();
            echo $js->add("/website/static/css/bootstrap.css")
                ->add("/website/static/icons/icons.css")
                ->add("/website/static/css/site.css")
                ->get();
        ?>

## Mode of operation

If Pimcore operates in the DEBUG mode, JS/CSS files are not minified
but individual html includes/tags for the files are generated - with timestamp
based cache busters (``?ts=1486051521``).

In production mode, CSS and JS files are combined, minified, and written
to the ``/website/var/tmp/`` directory as ``plugin_minify_*`` files. Each set
of files gets their own cache file based on the md5 sum of the combined
filenames. For CSS files, relative urls/paths are automatically rewritten.

You can force regeneration of the minified files by adding a ``MINIFY_REFRESH``
request parameter. Example: ``http://localhost/test/?MINIFY_REFRESH``

## Credits

Thanks to Dominik Pfaffenbauer for inspiration by providing a similar
plugin: https://github.com/dpfaffenbauer/pimcore-minify (His one is using SimpleXML
to parse the JS/CSS out of the DOM).

## License

GNU General Public License version 3 (GPLv3)