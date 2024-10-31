=== RVM - Responsive Vector Maps ===
Contributors: Enrico Urbinati
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=info%40responsivemapsplugin%2ecom&lc=IT&item_name=responsive%20Vector%20Maps%20Plugin&item_number=rvm%2dplugin%2dwordpress%2drepo&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted
Tags: world map, interactive maps
Requires at least: 4.3
Tested up to: 6.3.2
Stable tag: 6.6.2
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create responsive clickable maps, many customizations possible, toggle elements on the page or display content over the maps, all settings in one page.

== Description ==

Create responsive linkable vector maps in one click, many customizations possible, toggle elements on the page or display content over the maps. All settings in one page !

Vector maps never loose quality when reducing or increasing their sizes. Using RVM you will not need to create static images for area map tags.

You can use maps in sidebars or just in post/page content using shortcodes.


= Features =

* Default maps available for free : Italy and whole World ( with clickable countries ).
* Responsive: Maps will adapt their width to any device
* High quality image
* Cross-browser compatibility
* More then 200  downloadable maps available on [responsivemapsplugin.com](//www.responsivemapsplugin.com/redirect-to-custom-maps-from-wp-plugin-page/)
* Chance to install dynamic maps with all kind of svg ( not only geographical maps ! )
* Mouseover tooltip effect
* Linkable Subdivisions: Customize background colours, links and html popup ( tooltip )
* Subdivisions' actions : show/hide elements on the page and display label content when clicking on subdivisions
* Linkable Markers: Add your linkable markers on most of the maps using latitude and longitude. Chance to have html popup, dimension ( marker radius ) and min/max radius dimension scale
* Pinpoints: Use your favourite images as icons for markers' pinpoints
* Customizable look and feel ( even transparent background )
* Preview functionality: WYSAWYG while creating/editing your map
* Shortcodes: Use generated shortcodes in your posts, pages or sidebars
* Widget: Maps can be used in widget area too
* Zoom capabilities
* Export and Import features: backup and restore markers and subdivision settings in just one click
* Subdivisions' names: get rid of subdivisions' names with just one setting
* Translations : easily input your own translations in subdivisions's popups



== Installation ==

1. Download the zip file from this page
2. Login to your WordPress dashboard
3. Go to Plugins > Add New, under Install Plugins title click on Upload and use the browse button to search the .zip file you have downloaded at point 1
4. Once activated you have a RVM tab on the left hand side
5. Start creating your favourite maps

== Frequently Asked Questions ==

= Can I customize map and canvas colours ? =

Yes, these are possible layout customizations:

1. Canvas colour
2. Map colour
3. Map border colour
4. Add zoom-in/zoom-out buttons
5. Map width ( can use em, %, px etc.. )
6. Region background colour, links and html labels
7. Markers background colour, border colour, links, dimension, html popup message and min/max radius dimension scale
8. Get rid of map padding

= Can I customize map region links ? =

Yes, it's possible to customize links for each region/area displayed in the map. When creating a new map or editing an existing one, you will have chance to
assign url to each area/region of the map. Default areas/regions have just a tooltip mouseover effect displaying area/region name.
Actually is possible to add a custom html tooltip in a secure way.
It's even possible show/hide elements on the page or show content over your maps.

= Which WP version is the plugin compatible with ? =

The plugin will work at its best from WP ver 3.6 onwards.

= I created a new map, but I would like to give specific width just for a specific post, is it possible ? =

Yes, you can create a new map which will adapt to your box container automatically and will be responsive, but you can even use
an additional **width** parameter to the shortcode within a specific post. Your map will have specific width just for that post.


== Screenshots ==

1. RVM once installed into Wordpress
2. **Main settings** : add padding, background and canvas colour and many more
3. **Subdivisions settings** : customise every single area of the map, add link, html popup label, background color and more
4. **Markers section** : add markers pinpoints using latitude and longitude, customise colors, size and borders
5. Use the Preview button to see map before going live
6. Use html popup label to add rich content to your markers and subdivisions
7. Premium maps purchasable on responsivemapsplugin.com

== Changelog ==

= 6.6.2 =
* Fix : Fixed custom markers pinpoint uploaded via Custom Marker Plugin not showing on map

= 6.6.1 =
* Fix : Fixed name of eSwatini into Eswatini ( english requires capital letter ) - ex Swaziland

= 6.6.0 =
* Fix : Fixed name of Swaziland into eSwatini - thanks to Dirk Middeldorf

= 6.5.9 =
* Fix : Avoiding replacing double quotes with single quotes inside the strings for default card container content
* Compatible with Wordpress 5.9.1

= 6.5.8 =
* Fix : Possible to insert some html tags into markers and subdivisions popup label securely
* Compatible with Wordpress 5.9

= 6.5.7 =
* Fix : adjusted escaping function to allow certain html on widgets
* Compatible with Wordpress 5.8.3

= 6.5.6 =
* Fix : fix for security issue
* New Feature: all features can be now previewed ( inlcuding sections and markers )

= 6.4.5 =
* Fix : fix for security issue

= 6.4.4 =
* Fix : fix for security issue

= 6.4.3 =
* Fix : fix for security issue

= 6.4.2 =
* Fix : fix for security issue

= 6.4.1 =
* Fix : compatibility with Php 8

= 6.4.0 =
* Fix : Show custom selector did not work when more then one class was applied to the element

= 6.3.9 =
* Fix : Select map button for older installation method not working

= 6.3.8 =
* Compatible with Wordpress 5.5
* Fix : compatibility with latest jQuery library coming with WP 5.5 - $(...).live is not a function
* Fix : warning for legacy code for compatibility with oldest WP version

= 6.3.6 =
* Fix : solved issue on some mobile devices having problem with scrolling over the map - special thanks to the team of celafaremoitalia.it ( Ciro Vitale, Luigi Bacco, Valerio Di Pasquale e Lorenzo Muccioli) for the insight
* Fix : zoom buttons icons misalignment
* Improvement : removed old unused jvectormap CSS

= 6.2.4 =
* Fix : on maps with numeric subdivisions label popup content was incorrectly displayed when hovering over subdivisions with 'open label content onto default card' action active
* Fix : issue when importing Subdivisions file - action value not taken
* Improvement : cursor change when 'Open label content onto default card' and 'Show custom selector' action active

= 6.1.2 =
* Fix : name for Custom Markers Icon Module plugin

= 6.1.1 =
* New feature : Custom Icon Marker Module now available as a plugin - more secure and reliable system
* Fix : import file path for markers filled input of Custom Markers Icon Module

= 6.0.0 =
* New feature : added chance to get rid of subdivision's names and easily translate them using html popups
* Fix : general css fixes and improvements

= 5.9.8 =
* New feature : added Deutsch and formal Deutsch languages ( thanks to Kolja Spyra )

= 5.9.7 =
* Fix: issue on RVM domain text - missing for some copy tags
* Fix: issue on Marker Module translation - out of domain text translation need to be hardcoded

= 5.9.5 =
* Fix: issue on RVM "Settings for" in rvm_core (tahnks Giulio Alfonso for your effort in this - @senjoralfonso )

= 5.9.4 =
* Fix: issue on RVM global settings impeded to translate copy

= 5.9.3 =
* New feature : introducing translations - starting with the Italian one
* Fix: issue on text domain which impeded RVM to be translated

= 5.8.2 =
* New feature : introduced effect of markers' pinpoints falling down from top of the map ( special thanks to Brendan Carr )

= 5.7.2 =
* Fix : show custom selector action: selectors toggled properly

= 5.7.1 =
* Fix : Warning: call_user_func() expects parameter 1 to be a valid callback...
* Fix : Undefined index: rvm_custom_icon_marker_module_path_verified...

= 5.6.9 =
* Fix :  Undefined index: field_region_onclick_action
* Fix :  label content not opening onto default map card for certain maps
* Fix :  Color picker bar overlapped by subdivisions' name

= 5.6.6 =
* Fix :  Undefined offset: 4 error fixed even for legacy products

= 5.6.5 =
* Fix :  Undefined offset: 4 error fixed

= 5.6.4 =
* New feature : show/hide custom elements on the page and display subdivisions' label content onto map layer
* Improvements : responsive settings dashboard and better UX

= 5.5.3 =
* New feature : Export and import subdivisions of your maps
* New feature : Export and import markers of your maps
* Improvements : minor style update

= 5.3.2 =
* Fix : fix the "warning count() parameter must be an array or an object" issue of PHP ver 7.2

= 5.3.1 =
* Fix : map width and padding accept <10 values
* New feature : customize markers' image for map pinpoints installing the Custom Icon Marker Module
* Improvements : css updates

= 5.1 =
* Fix : when clicking on publish an error message appeared if switched from custom map to default one
* New feature : Internationalization ready. Plugin can now be translated

= 5.0 =
* Update :  jvectormap core lib updated to ver. 2.0.3
* New feature : Map uploader directly into the RVM settings area
* New feature : Map Padding field to set map padding
* New feature : Feature to open link in a new window
* New feature : editor in your map settings page to see it using the "View post" link
* Fixed : small map issue with ajax loaded content
* Fixed : issue for single entries in Map Width field ( i.e.: 5% )
* Fixed : "Unexpected value 0 0 100% 100% parsing viewBox attribute." warning message in console
* Improvements : style update ( i.e.: label background opacity, zoom effect etc... )

= 4.0 =
* Release on October 2015
* Compatible with WP 4.3 ( use construct for widget building )
* Introduce dynamic map paths: now you can use same maps for local and remote webservers
* Enable/disable subdivisions selected status
* New control settings for hover status, hover background opacity and borders width
* Chance to have transparent canvas background ( wow , thnaks Phill )
* Chance to enable the hover over status each single subdivisions
* Improved "Installation" feature for custom maps ( now the entirepath can be placed )
* Subdivision and maps in main settings sorted alphabetically in ascending order ( finally ! )
* Small css layout improvements

= 3.1 =
* Release on June 2015
* Better management of map name when pasted inside the "Install Your Map" field. No more issues with spaces and .zip extensions

= 3.0 =
* Release on June 2015
* Introduced Custom Maps feature: you can now download and install many other maps then defaults from responsivemapsplugin.com site
* Fix links issues with some browsers ( desktop / mobile ) like Chrome, etc...
* Link target not available anymore in order to fix links issues with some browsers ( see upon )
* Chance to get rid of padding ( space around the map ) for any single map
* Created a settings page in order to fix eventual issues created by wp_emoji script with all svg images on front end and in dashboard
* Change name of Regions/Countries tab into Subdivisions for more consistency

= 2.7 =
* Release on April 2015
* Fix regions and markers links with query-strings ( thanks macsag ! )
* Fix p tag not closed in main settings

= 2.6 =
* Release on April 2015
* ( World Map ) Fix on Niger country not picking up customization
* Fix Portugal aspect ratio
* Added rvm-map-container class to map container div ( less conflicts and more consistency )
* Minor css fix ( map container now has min-width: 100% and box-sizing: border-box; )
* Fix typo $map_apsect_ratio into $map_aspect_ratio in rvm_shortcode.php
* Fix issue on single quote, new line and line break in regions and markers
* Changed function esc_url_raw ( for database entries ) into esc_url ( for input field displaying security purpose ) in rvm_region.php

= 2.5.1 =
* Release on December 2014
* Fix on Indonesia not showing region custom color and custom html popup

= 2.5 =
* Release on November 2014
* Added popup to region countries
* Chance to load custom html in region and markers popup label in total security
* Added USA and Belgium maps
* Improved tabs navigation: active tab memory
* General code cleaning
* Fixed minor bugs ( visible just when WP_DEBUG active )

= 2.1 =
* Release on November 2014
* Fixed issue display weird link on blank field in region section

= 2.0 =
* Release on November 2014
* Markers added: use long/lat for markers to display on the map
* Regions/countries colour customizable
* Completely redesigned: tabbed navigation through main settings, regions/countries and markers
* Improved data storing: use of data series for regions/counties codes

= 1.2 =
* Release on 05/09/2014
* Fix Polish map not saving region links
* Added Europe and World map !
* Use of WP default color picker for map setting

= 1.1 =
Fix Sweden map not displaying : release on 28/07/2014

= 1.0 =
First release on 22/07/2014

== Upgrade Notice ==
First release on 22/07/2014


== Arbitrary section ==

ATTENTION: bare in mind that using same identical shortcode ( same post ID ) in more then one position on the same page will result into a layout issue:
in other words if you create a new map you should not use it in more then one position ( post/sidebar ) per page.
That's because the javascript managing map creation fires same ID selector.

Create instead a new one and use it for your purposes.