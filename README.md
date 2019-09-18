# wp-climatestrike

A small WordPress plugin to put your site on [digital climate strike](https://digital.globalclimatestrike.net/) on
Sept. 20th, 2019.

## PSA

There's now an "official" [WP plugin by 'Fight For the Future'](https://wordpress.org/plugins/digital-climate-strike-wp/) with a lot of features, on the official WP-plugins directory.
Since this here is my attempt to "scratch my own itch", you'll probably be better off with the official version.

## Install

Copy the `wp-climatestrike` directory to your `wp-content/plugins` directory.
Copy the file `wp-climatestrike/templates/climatestrike.html` to your current theme directory's root and change it to your liking.
If you're ok with the default file, you won't need to copy it. The plugin will first look in the active theme for a file named `climatestrike.html`,
and will fall back to the file inside the plugin directory.
Activate the plugin through the admin panel.

There is an array "allowed_urls" <del>that's currently hard-coded</del>. If the request uri matches these urls, the content is displayed.
One of these urls is the "privacy policy" page that can be defined in WordPress. The other is hard coded to "/impressum/" currently, since those two
are the legally required pages for sites in Germany. The "/wp-admin/" url is added, too, else even the login to the backend would be "striked".

Changed in v1.2.0: Now the "allowed" URLs can be set via the plugin's settings. The privacy policy page is added as a default, if detected.

## Thanks

The HTML file is a copy of the placeholder.html in [Sebastian Gregers Kirby3 plugin](https://github.com/sebastiangreger/kirby3-climatestrike).

## License

wp-climatestrike is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT). It is provided "as is" with no guarantee. Use it at your own risk and always test it yourself before using it in a production environment.

Copyright © 2019 [Tom Arnold](https://www.webrocker.de)
