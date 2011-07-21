KnpMediaExposerBundle
=====================

The KnpMediaExposerBundle provides a simple integration of the [MediaExposer][media-exposer] library for your Symfony project.

The MediaExposer Library
------------------------

The [MediaExposer][media-exposer] library allows you to easily expose you medias to the users of your application by computing their urls or paths.

You can find more informations on the [official page][media-exposer].

Installation
------------

The bundle depends on the [MediaExposer][media-exposer] library, so you need to copy it under the `vendor/media-exposer` directory of your Symfony project.

You also must copy the sources of the bundle itself under the `vendor/bundle/Knp/Bundle/MediaExposerBundle` directory.

**Note:** The specified directories are not mandatory but it is strongly recommended to respect them as they follow the convention of the [Symfony Standard Edition][symfony-standard].

If you are using git, you can add both as submodules of your repository:

    $ git submodule add https://github.com/knplabs/MediaExposer.git vendor/media-exposer
    $ git submodule add https://github.com/knplabs/KnpMediaExposerBundle.git vendor/bundle/Knp/Bundle/MediaExposerBundle

Then, you must register them to the autoloader:

    <?php // app/autoload.php

    $loader->registerNamespaces(array(
        // ... other namespaces
        'Knp\\Bundle'   => __DIR__.'/vendor/bundle',
        MediaExposer'   => __DIR__.'/vendor/media-exposer/src'
    ));

Finally, register the bundle to your kernel:

    <?php // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // ... the other bundles
            new Knp\Bundle\MediaExposerBundle\KnpMediaExposerBundle()
        );
    }

You can now proceed to the configuration.

Configuration
-------------

To "absolutify" urls, the media exposer needs a base url that will be prepended to the relatives sources.
By default, the host of the request will be used, but you can also specify it in your configuration:

    # app/config/config.yml

    knp_media_exposer:
        base_url:   'http://the-base.url'

Registering Resolvers
---------------------

After the installation & configuration, the media exposer is almost ready for use.
But there is still one step: registering your resolvers.

The registration of a resolver is done by defining a service with the "media\_exposer.resolver" tag.
Here is an exemple of resolver service registration in **yml**:

    services:
        foo.bar_resolver:
            class:  'Foo\BarResolver'
            tags:
                - { name: 'knp_media_exposer.resolver' }

An optional `priority` can also be specified:

    services:
        foo.bar_resolver:
            class:  'Foo\BarResolver'
            tags:
                - { name: 'knp_media_exposer.resolver', priority: 10 }

**Note:** Don't forget that the highest priority is the first and the lowest is the last.

Usage
-----

### In a controller

The bundle will add the **media_exposer** service to the container, so you can access it in your controller with the `->get()` method.

    <?php

    class FooController extends Controller
    {
        public function barAction()
        {
            // ...

            $exposer = $this->get('media_exposer');

            $path = $exposer->getPath($media);
            $source = $exposer->getSource($media);
        }
    }

### In a template

The bundle also add an extension to both the Twig & PHP templating engines.

In a Twig template:

    {# using the filters #}
    <img src="{{ article|media_source }}" alt="" />
    <img src="{{ article|media_path }}" alt="" />

    {# using the functions #}
    <img src="{{ media_source(article) }}" alt="" />
    <img src="{{ media_path(article) }}" alt="" />

In a PHP template:

    <img src="<?php echo $view['media_exposer']->getSource($article); ?>" alt="" />
    <img src="<?php echo $view['media_exposer']->getPath($article); ?>" alt="" />

**Note:** The source means a relative or absolute url and the path means a full file path.

[media-exposer]: https://github.com/knplabs/MediaExposer "MediaExposer library on github"
[symfony-standard]: http://github.com/symfony/symfony-standard "Symfony Standard Edition on github"
