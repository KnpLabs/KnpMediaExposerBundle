KnpMediaExposerBundle
=====================

The KnpMediaExposerBundle provides a simple integration of the [MediaExposer][media-exposer]
library for your Symfony project.

The MediaExposer Library
------------------------

The [MediaExposer][media-exposer] library allows you to easily expose you
medias to the users of your application by computing their urls or paths.

You can find more informations on the [official page][media-exposer].

Installation
------------

The bundle depends on the [MediaExposer][media-exposer] library, so you
need to copy it under the `vendor/media-exposer` directory of your Symfony
project.

### Grab the sources

#### Using the `deps` file

You can add the following lines to your `deps` file:

```ini
[media-exposer]
    git=http://github.com/knplabs/MediaExposer.git

[KnpMediaExposerBundle]
    git=http://github.com/knplabs/KnpMediaExposerBundle.git
    target=/bundles/Knp/Bundle/MediaExposerBundle
```

And run the command:

```bash
./bin/vendors install
```

#### Using git submodules

You can run the following git commands to add both library and bundle as
submodules:

```bash
git submodule add https://github.com/knplabs/MediaExposer.git vendor/media-exposer
git submodule add https://github.com/knplabs/KnpMediaExposerBundle.git vendor/bundle/Knp/Bundle/MediaExposerBundle
```

### Update your autoloader & kernel

Once you have copied the sources in your project, you must update your
autoloader:

```php
<?php // app/autoload.php

$loader->registerNamespaces(array(
    // ... other namespaces
    'Knp\\Bundle'   => __DIR__.'/vendor/bundles',
    'MediaExposer'  => __DIR__.'/vendor/media-exposer/src'
));
```
Finally, register the bundle to your kernel:

```php
<?php // app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ... the other bundles
        new Knp\Bundle\MediaExposerBundle\KnpMediaExposerBundle()
    );
}
```

You can now proceed to the configuration.

Configuration
-------------

To "absolutify" urls, the media exposer needs a base url that will be prepended
to the relatives sources. By default, the host of the request will be used,
but you can also specify it in your configuration:

```yaml
# app/config/config.yml

knp_media_exposer:
    base_url:   'http://the-base.url'
```

Registering Resolvers
---------------------

After the installation & configuration, the media exposer is almost ready
for use. But there is still one step: registering your resolvers.

With this bundle, adding a resolver to the exposer is as simple as registering
a service having the `knp_media_exposer.resolver` tag.

Here is an exemple of resolver service registration in **yml**:

```yaml
services:
    foo.bar_resolver:
        class:  'Foo\BarResolver'
        tags:
            - { name: 'knp_media_exposer.resolver' }
```

An optional `priority` can also be specified:

```yaml
services:
    foo.bar_resolver:
        class:  'Foo\BarResolver'
        tags:
            - { name: 'knp_media_exposer.resolver', priority: 10 }
```

**Note:** Don't forget that the highest priority is the first and the lowest is the last.

Usage
-----

### Twig integration

The bundle registers a Twig extension adding the necessary to use the `Exposer`
in your templates.

#### The `media_has_source` function

The `media_has_source` function indicates whether the resolver can return
a source for the given media:

```twig
{{ media_has_source(picture) }}
```

You can pass a hash of options as second argument:

```twig
{{ media_has_source(picture, {'foo':'bar'}) }}
```

#### The `media_source` function

The `media_source` function returns the source for the given media:

```twig
{{ media_source(picture) }}
```

You can specify an options hash as second argument:

```twig
{{ media_source(picture, {'foo':'bar'}) }}
```

If you want the `Exposer` to generate absolute sources (URLs), you can force
it passing `true` as third argument:

```twig
{{ media_source(picture, {}, true) }}
```

#### The `media_has_path` function

The `media_has_path` function indicates whether the resolver can return
a path for the given media:

```twig
{{ media_has_path(picture) }}
```

An hash of options can be passed as second argument:

```twig
{{ media_has_path(picture, {'foo':'bar'}) }}
```

#### The `media_path` function

The `media_path` function is responsible of returning a path for the given
media:

```twig
{{ media_path(picture) }}
```

You can also specifiy options as second argument:

```twig
{{ media_path(picture, {'foo':'bar'}}
```

### PHP templating integration

The bundle registers an extension for the PHP templating engine. You can
access it using `$view['media_exposer']` in your templates. It only contains
proxy methods for the `Exposer` instances:

 - `->getSource($media [, array $options [, $forceAbsolute]])`
 - `->hasSource($media [, array $options])`
 - `->getPath($media [, array $options])`
 - `->hasPath($media [, array $options])`

[media-exposer]: https://github.com/knplabs/MediaExposer "MediaExposer library on github"
[symfony-standard]: http://github.com/symfony/symfony-standard "Symfony Standard Edition on github"
