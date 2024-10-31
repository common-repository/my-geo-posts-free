=== My Geo Posts Free ===
Contributors: mindstien
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=admin%40mindstien%2ecom&item_name=Wordpress%20Plugin%20Donation&item_number=Support%20Open%20Source&no_shipping=0&no_note=1&tax=0&currency_code=USD&lc=US&bn=PP%2dDonationsBF&charset=UTF%2d8
Tags: geoplugin, ipinfodb, geo, geo location, geo tagging, visitor location, user location, maxmind
Requires at least: 3.0
Tested up to: 4.0
Stable tag: 1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Geo Target your wordpress site with geo data from ipinfodb or geoplugin like visitor's city, country...

== Description ==

My Geo Posts Free plugin uses IpInfoDb and/or geoPlugin's service to get geolocation data of visitor's ip address. It save location data in visitors browser cookies to save number of api calls.

= How to use My GEO Post Free Plugin ? =

Use following shortcodes almost anywhere in WordPress, ie. Title/Content of WordPress post/page/widget etc.. Within a title or within a content itself, just copy paste following shortcodes.

* `[mygeo_city]`   // to display City name
* `[mygeo_country_code]` // to display Country Code
* `[mygeo_country_name]` // to display Country Name
* `[mygeo_region]`  // to display state / region name
* `[mygeo_latitude]`  // to display latitude of the visitors location
* `[mygeo_longitude]` // to display longitude of the visitors location
* `[mygeo_postal_code]` // to display postal code if available

You can also add default value when geo data is not available i.e.

* `[mygeo_city default='Your City']` 

To directly display data using PHP code in template files itself, you can use following php code by replacing SHORTCODE with any of the above code.

`<?php echo do_shortcode('SHORTCODE'); ?>`

Hire plugin author for your [Wordpress Development](http://www.freelancer.com/u/mindstiente.html).

Visit official website for this plugin at [Mindstien Technologies](http://www.mindstien.com).

== Installation ==

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Use following shortcodes almost anywhere in WordPress, ie. Title/Content of WordPress post/page/widget etc.. Within a title or within a content itself, just copy paste following shortcodes.

* `[mygeo_city]`   // to display City name
* `[mygeo_country_code]` // to display Country Code
* `[mygeo_country_name]` // to display Country Name
* `[mygeo_region]`  // to display state / region name
* `[mygeo_latitude]`  // to display latitude of the visitors location
* `[mygeo_longitude]` // to display longitude of the visitors location
* `[mygeo_postal_code]` // to display postal code if available

To directly display data using PHP code in template files itself, you can use following php code by replacing SHORTCODE with any of the above code.

`<?php echo do_shortcode('SHORTCODE'); ?>`


== Frequently asked questions ==

= How accurate the location data are ? =

The accuracy of geo location data purely depends on the geoip service providers, i.e. IpInfoDb and GeoPlugin

== Changelog ==

1.2: Option of default value in shortcode is added.
1.1: Plugin updated to use geodata from ipinfodb and geoplugin services.
1.0: New plugin launched.
