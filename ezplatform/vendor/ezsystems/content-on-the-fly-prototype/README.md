# content-on-the-fly
Platform UI Content on the Fly feature

## Install

1. From your eZ Platform installation, run composer:

  ```sh
  $ composer require ezsystems/content-on-the-fly-prototype
  ```

2. Enable the bundle by adding:

  ```php
  new EzSystems\EzContentOnTheFlyBundle\EzSystemsEzContentOnTheFlyBundle()
  ```

  to `app/AppKernel.php`.

3. Setup routing by adding bundle configuration to `app/config/routing.yml`:

  ```yml
  _contentOnTheFly:
      resource: "@ContentOnTheFlyBundle/Resources/config/routing.yml"
      prefix:   '%ezpublish_rest.path_prefix%'
  ```

4. Clear cache and setup assets with `$ composer run-script post-update-cmd`

   *(if you use prod env make sure that it is set with `$ export SYMFONY_ENV=prod` first)*.


## Configuration
Example application configuration (`app/config/config.yml`):
```yml
# ...

content_on_the_fly:
    system:
        site:                       # Configuration per SiteAccess
            content:
                article:            # Content identifier
                    location:
                        - 2         # Suggested location(s)
                default:            # Default, in case of unconfigured content identifier
                    location:
                        - 2
                        - 43
```

Default bundle configuration:
```yml
parameters:
    content_on_the_fly.default.content:
        image:
            location:
                - 51    # /Media/Images
        default:
            location:
                - 2     # /Home
                - 43    # /Media
```

## Default location for content type
If suggested locations are provided for a Content Type (or default) the first location in the list will be preselected.

## Preselected content type
To set the Content Type you have to provide the 'contentTypeIdentifier' in the config of the 'contentDiscover' event.
Example:
```javascript
/**
* ...
* @param config.visibleMethod {String} which tab should be open. Default: 'browse', possible values: 'browse', 'search', 'create'
* @param config.contentTypeIdentifier {String} content type identifier. Default: none, example values: 'image', 'blog', 'article', 'blog_post'
*                                     this parameter is limited to the Create tab, config that works across all tabs will be added in the future
*/
app.fire('contentDiscover', {
    config: {
        // ...
        visibleMethod: 'create',
        contentTypeIdentifier: 'image'
    }
});
```
