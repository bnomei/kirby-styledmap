# Kirby Styled Google Map

![GitHub release](https://img.shields.io/github/release/bnomei/kirby-styledmap.svg?maxAge=1800) ![License](https://img.shields.io/badge/license-commercial-green.svg) ![Kirby Version](https://img.shields.io/badge/Kirby-2.3%2B-red.svg)

Kirby CMS Tag and Page Method to print a regular or styled google map. 

**NOTE:** This is not a free plugin. In order to use it on a production server, you need to buy a license. For details on Kirby Styledmap's license model, scroll down to the License section of this document.

If you do not need styling but want absolute control over your markers consider using @Fanningerts [free GMaps Plugin](https://github.com/fanningert/kirbycms-extension-gmaps) instead.

## Key Features

- add your styling JSON
- turn on/off google controls
- simple customization using `config` and `snippets`
- add more than one marker
- marker can have custom marker icon image
- marker can have info window (open on click or allready opened)
- marker can open URL on click
- example code shows how to create custom text labels with svg using a route
- works out-of-the box with @AugustMiller [Kirby Map Field Plugin](https://github.com/AugustMiller/kirby-map-field).

![Example](https://github.com/bnomei/kirby-styledmap/blob/master/example.png)

## Requirements

- [**Kirby**](https://getkirby.com/) 2.3+
- [Google Maps API Key](https://console.developers.google.com/)

## Installation

### [Kirby CLI](https://github.com/getkirby/cli)

```
kirby plugin:install bnomei/kirby-styledmap
```

### Git Submodule

```
$ git submodule add https://github.com/bnomei/kirby-styledmap.git site/plugins/kirby-styledmap
```

### Copy and Paste

1. [Download](https://github.com/bnomei/kirby-styledmap/archive/master.zip) the contents of this repository as ZIP-file.
2. Rename the extracted folder to `kirby-styledmap` and copy it into the `site/plugins/` directory in your Kirby project.

## Usage

### API Key

Unless you allready use [Kirby Map Field Plugin](https://github.com/AugustMiller/kirby-map-field) you need to get a [Google Maps API Key](https://console.developers.google.com/) and add it to your `/site/config/config.php` file. Remember to add *restrictions* (like your website as referrer) when creating the API Key. Otherwise your API Key might be abused.

```php
c::set('plugin.styledmap.apikey', 'YOUR_API_KEY_HERE');
```

### Examples Route/Page

This plugin registers a route where you can view some examples and test your API Key.

```
http://YOUR_DOMAIN_HERE/kirby-styledmap-route/examples
```

### Kirby Tag

This plugin registers a Kirby CMS Tag called `styledmap`. It takes a title for the marker and mixed values for location.


Location from URL

```
(styledmap: Lualualei Beach Park location: https://www.google.com/maps/place/Lualualei+Beach+Park/@21.437127,-158.186699,15z)
```

Location from comma-seperated latitude, logitude and zoom

```
(styledmap: Lualualei Beach Park location: 21.437127, -158.186699, 15)
```

Location from name of the Kirby Field used by [Kirby Map Field Plugin](https://github.com/AugustMiller/kirby-map-field)

```
(styledmap: Lualualei Beach Park location: location)
```

You can also add a link...

```
(styledmap: Lualualei Beach Park location: location info: https://www.facebook.com/theukulelehandbook)
```

or text for a popup window

```
(styledmap: Lualualei Beach Park location: location info: Uke in Hawaii)
```


### Styled Map

By providing the `style` parameter with the name of a file or `snippet` you can import custom style defined as JSON. You can [create them yourself](https://developers.google.com/maps/documentation/javascript/styling) or use online editors like [Google Mapstyle](http://mapstyle.withgoogle.com), [Snazzymaps](https://snazzymaps.com) or [Mapstylr](http://www.mapstylr.com).

You need to create a new snippet in `/site/snippets/`. In this example I will use the name `sm-example-style` but you can pick whatever name suits you. Then paste the raw JSON inside your snippet or get it from somewhere else using PHP and echo it.


```
(styledmap: Lualualei Beach Park style: sm-example-style location: 21.437127, -158.186699, 15)
```

Or you can place a file with `.json`-extension inside the content folder of your `$page` and use the filename as a parameter.

```
(styledmap: Lualualei Beach Park style: whatever.json location: 21.437127, -158.186699, 15)
```

### Custom Marker Icon

You can set a default icon for markers in the `site/config/config.php`. Or you can give each additional marker a custom icon using a `snippet` (see below).

```
c::set('plugin.styledmap.jsmarker.icon', '/assets/plugins/kirby-styledmap/sm-example-icon.svg');
```

### Markers

Create a new `snippet` to return a return an encoded json php array. This example uses `sm-example-markers` as filename for the snippet.

```
(styledmap: Lualualei Beach Park markers: sm-example-markers location: 21.437127, -158.186699, 10)
```

To learn how to create your own [take a look at the example](https://github.com/bnomei/kirby-styledmap/blob/master/snippets/sm-example-markers.php) provided.

### Page or Site Method

If you need more control than the Kirby Tag offers the Page or Site Methods registered by this plugin should be used.

```php
// short version
echo $page->styledmap(				// or $site->styledmap(
    'Lualualei Beach Park', 		// title
    '21.437127, -158.186699, 15'	// array, url, location or fieldname
);

// all possible parameters
echo $page->styledmap(				// or $site->styledmap(
    'Lualualei Beach Park', 		// title
    '21.437127, -158.186699, 15',	// array, url, location or fieldname
    [								// optional: data for center marker
        'info' => 'Uke in Hawaii',
        'icon' => '/assets/plugins/kirby-styledmap/sm-example-icon.svg',
    ],
    'sm-example-style', 			// optional: name of style snippet
    'sm-example-markers' 			// optional: name of markers snippet
);

```

## Other Setting

You can set these in your `site/config/config.php`.

### plugin.styledmap.license
- default: ''
- add your license here and the widget reminding you to buy one will disappear from the Panel.

### plugin.styledmap.apikey
- default: `map.key` or ''
- has an automatic fallback to [Kirby Map Field Plugin](https://github.com/AugustMiller/kirby-map-field) so you do not need to set this up twice.

### plugin.styledmap.examples
- default: true
- if disabled not examples and routes will be registered. use this on production server.

### plugin.styledmap.mapid
- default: 'styledmap'
- override this if you want a different id for the html element

### plugin.styledmap.width
- default: `kirbytext.video.width` = 100%
- maps need width to render. set it here.

### plugin.styledmap.height
- default: `kirbytext.video.height` = 500px
- maps need height to render. set it here.

### plugin.styledmap.cssstyle
- default: css width & height
- override this if you are too lazy to enter width and height seperatly or want to add more inline styling

### plugin.styledmap.mapclass
- default: 'styledmap-container'
- change the name of the used class

### plugin.styledmap.jsjson
- default: null
- set default style for all maps created

### plugin.styledmap.jsmaptypeids
- default: 'google.maps.MapTypeId.ROADMAP'
- override this if you want to start with satelite etc

### plugin.styledmap.jsoptions
- default: []
- disable individual or all google map options using this setting.

```php
// disable zoom
c::set('plugin.styledmap.jsoptions', [
  'zoomControl'       => false,
  ]
);
// or disable everything
c::set('plugin.styledmap.jsoptions', [
  'draggable'         => false,
  'fullscreenControl' => false,
  'mapTypeControl'    => false,
  'rotateControl'     => false,
  'scaleControl'      => false,
  'scrollwheel'       => false,
  'streetViewControl' => false,
  'zoomControl'       => false,
  ]
);
```

### plugin.styledmap.jsmarker
- default: 'styledmap-marker'
- Name of snippet that generated the marker code. Only override this if you know what you are doing.

### plugin.styledmap.jsmarker.icon
- default: ''
- will set default icon for markers using a url of an image (even svg). Supports relative paths since its using the [toolkit url()-helper](https://getkirby.com/docs/toolkit/api#url).

### plugin.styledmap.jsmarker.infoOpen
- default: true
- If an info window is defined then it will be opend by default otherwise the marker has to be clicked first.

### plugin.styledmap.jsmarker.infoMaxWidth
- default: 200
- Default max width of the info window in pixels

### plugin.styledmap.defaults.lat
- default: `map.defaults.lat` or '21.437127'

### plugin.styledmap.defaults.lng
- default: `map.defaults.lng` or '-158.186699'

### plugin.styledmap.defaults.zoom
- default: `map.defaults.zoom` or '15'

### plugin.styledmap.defaults.title
- default: ''

## Disclaimer

This plugin is provided "as is" with no guarantee. Use it at your own risk and always test it yourself before using it in a production environment. If you find any issues, please [create a new issue](https://github.com/bnomei/kirby-styledmap/issues/new).

I am in no way affiliated with the google map places referenced in this readme and the examples. I just liked their names.

## License

Kirby Styledmap can be evaluated as long as you want on how many private servers you want. To deploy Kirby Styledmap on any public server, you need to buy a license. You need one unique license per public server (just like Kirby does). See `license.md` for terms and conditions.

[<img src="https://img.shields.io/badge/%E2%80%BA-Buy%20a%20license-green.svg" alt="Buy a license">](https://bnomei.onfastspring.com/kirby-styledmap)

However, even with a valid license code, it is discouraged to use it in any project, that promotes racism, sexism, homophobia, animal abuse or any other form of hate-speech.

## Technical Support

Technical support is provided on GitHub only. No representations or guarantees are made regarding the response time in which support questions are answered. But you can also join the discussions in the [Kirby Forum](https://forum.getkirby.com/search?q=kirby-styledmap).

## Credits

Kirby Styledmap is developed and maintained by Bruno Meilick, a game designer & web developer from Germany.
I want to thank [Fabian Michael](https://github.com/fabianmichael) for inspiring me a great deal and [Julian Kraan](http://juliankraan.com) for telling me about Kirby in the first place.
