# WPGraphQL Extra Options
This plugin was made to be a helper to the WPGraphQL plugin. Its purpose is to expose more of Wordpress API in a primarily read-only fashion for React/GraphQL or Vue/GraphQL theme development. Currently, toggle debug mode in GraphQL request, it can change of the WPGraphQL endpoint, the load options/settings not loaded through the Settings API to be accessed through GraphQL request, adds the ThemeModType to the schema using the Theme API allows for filtering to provide more specific types and descriptions. 

## Quick Install
Clone repository or zipped master to wordpress plugin directory and activate.

## Usage 
Upon activation navigate to "WPGraphQL Extra Options" under Settings. 

## Custom Options/Settings Usage 
The plugin assumes the option can be retrieved through the `get_option` wordpress function.
Enter desired option in `option_name<->option_type<->option_description(optional)` format. Each option is to be separated by a new line. 

### Options/Settings Example

```
page_on_front<->integer<->id of static page used as homepage
page_for_posts<->integer<->id of page displaying blog posts
```

### GraphQL Request Example
All selected settings will appear under the `allSettings` type in camelCase.

```
{
  allSettings{
    pageOnFront
    pageForPosts
  }
}
```

## ThemeMods Usage
Although some theme mods have pre-defined type and a definition won't be necessary Currently, the ThemeModType and ThemeModSubType only works with the [**next**](https://github.com/kidunot89/wp-graphql/tree/next) & [**feature/callStatic-added-to-Types-class**](https://github.com/kidunot89/wp-graphql/tree/feature/callStatic-added-to-Types-class) branches of my fork of the [**WPGraphQL**](https://github.com/wp-graphql/wp-graphql) repo. There is a pull request made but decision haven't been made on how this is to be implemented in the main plugin.

### Pre-defined Mods
* Nav Menu Locations - returns an array with `name` and `menu`
* Custom Image - returns a `post_object('attachment')`

Similar to Options/Settings filters are separate by new lines.

To exclude: `!mod_name`

To redefine: `mod_name<->type<->description`

Valid types are `integer`, `boolean`, `number`, and `string`. To specific a `description` you must enter a `type`, although `description` is optional. The default type is `string` if the expect output an array it will be json_encoded.

### ThemeMods Exclude Example

```
!nav_menu_locations
custom_logo<->integer<->ID of site custom logo media item
```

### GraphQL Request Example
All loaded theme_mods are location under `themeMods` in camelCase. Also a couple have default definitions that probably better off untouched

```
{
  themeMods {
    customLogo
  }
}
```

### Defaults Query

```
{
  themeMods {
    navMenuLocations(location: "location-name") {
      menuId
      name
      menuItems {
        nodes {
          id
          url
          label
          target
        }
      }
    }
    customLogo {
      sourceUrl
    }
  }
}
```

## TODO

### General
1. Add Testing
2. Add Documentation
3. Polish up user controls.

### ThemeMods
1. More flexibility in Filter Mod.
2. Add mutations