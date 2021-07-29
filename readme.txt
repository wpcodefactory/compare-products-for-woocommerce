=== Compare Products for WooCommerce ===
Contributors: algoritmika, anbinder, karzin
Tags: woocommerce, compare, compare products, woo commerce
Requires at least: 4.4
Tested up to: 5.8
Stable tag: 2.1.0
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Let your users know which products interest them the most by comparing them.

== Description ==

**Compare Products for WooCommerce** is a plugin where users can compare WooCommerce products in many aspects helping them to find out what they are looking for.

= Main Features =

* Compare your products using a good looking popup or a normal page if you want.
* Display a button to compare your products on product page or product loop.
* Control precisely where your comparison buttons will be displayed.
* Choose what columns will be available on the comparison list, including price, description, stock, dimensions, and any other WooCommerce custom attributes.

= Premium Version =

Do you like the free version of this plugin? Imagine what [Compare Products for WooCommerce Pro](https://wpfactory.com/item/compare-products-woocommerce/) can do for you!

* Choose in real time which comparison list columns will be displayed on front-end.
* Sort products by any field on front-end in real time.
* Customize compare buttons style.

= More =

* We are open to your suggestions and feedback.
* Please visit the [Compare Products for WooCommerce plugin page](https://wpfactory.com/item/compare-products-woocommerce/).
* Thank you for using or trying out one of our plugins!

== Frequently Asked Questions ==

= Are there any widgets available? =

* Yes, **Comparison list link** - Displays a link to the comparison list page or modal.

= Are there shortcodes available? =

* Yes, `[alg_wc_cp_table]` - Displays the comparison list page.

= Are there any ready languages available? =

Yes, for now:

* Portuguese.

= Is there a Pro version? =

Yes, it's located [here](https://wpfactory.com/item/compare-products-woocommerce/ "Compare Products for WooCommerce Pro").

= Can I see what the Pro version is capable of? =

Start by visiting plugin settings at "WooCommerce > Settings > Compare Products".

= How can I contribute? Is there a GitHub repository? =

If you are interested in contributing - head over to the Compare Products for WooCommerce plugin [GitHub repository](https://github.com/algoritmika/compare-products-for-woocommerce "Compare Products for WooCommerce plugin GitHub repository") to find out how you can pitch in.

== Screenshots ==

1. Compare your products using a good looking popup (it's possible to compare all kind of fields, including WooCommerce attributes)
2. Display a button to compare your products on the product page or product loop
3. Control precisely where your comparison buttons will be displayed
4. Choose what columns will be available on the comparison list

== Installation ==

1. Upload the entire plugin folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the "Plugins" menu in WordPress.
3. Start by visiting plugin settings at "WooCommerce > Settings > Compare Products".

== Changelog ==

= 2.1.0 - 29/07/2021 =
* Dev - Plugin is initialized on `plugins_loaded` action now.
* Dev - Admin settings - Comparison List - Empty list text - Input is sanitized now.
* Dev - Admin settings - Descriptions updated.
* Dev - Localisation - `load_plugin_textdomain()` is called on `init` action now.
* Dev - Code refactoring.
* WC tested up to: 5.5.
* Tested up to: 5.8.

= 2.0.1 - 11/11/2019 =
* Dev - Admin settings descriptions updated; typos fixed.
* Dev - Code refactoring.
* WC tested up to: 3.8.

= 2.0.0 - 24/10/2019 =
* Fix - Font Awesome icon fixed. Loading latest Font Awesome v5.11.2 everywhere now.
* Fix - Dynamic attribute fixed in comparison list template.
* Fix - Homepage redirect fixed (when comparing from loop). `query_vars` filter removed.
* Dev - Comparison List - Modal - "Title" and "Subtitle" options added.
* Dev - Comparison List - "Empty list text" option added.
* Dev - Buttons - Default button - "Title" option added.
* Dev - Major code refactoring. Composer removed.
* Dev - Admin settings restyled.
* Dev - Plugin and author URI updated.
* WC tested up to: 3.7.
* Tested up to: 5.2.

= 1.1.5 - 19/04/2017 =
* Make product dimensions compatible with WooCommerce 3.0 and older versions too

= 1.1.4 - 18/04/2017 =
* Support to WooCommerce 3.0
* Improve plugin description
* Add images about the pro version
* Fix link to comparison list on shop page
* Show singular attribute name instead of label on comparison list template
* Change default icon

= 1.1.3 - 20/03/2017 =
* Fix widget label
* Add horizontal overflow on comparison list in case of too many items
* Add new style option regarding comparison list responsiveness
* Loading external scripts through Protocol-relative URL
* Better translation structure for adding and removing items
* Fix comparison list link (it was creating a query string with "wc-ajax=get_refreshed_fragments")
* Improve calling for the woocommerce notice function

= 1.1.2 - 15/03/2017 =
* Fix translation slug (Now it's possible to translate the plugin through translate.wordpress.org)
* Better plugin description
* Fix remove button with wrong product id

= 1.1.1 - 27/02/2017 =
* Better plugin description

= 1.1.0 - 16/02/2017 =
* Add image option on list tab
* Add title option on list tab
* Add product option on column
* Add shortcode to create a comparison list page
* Add option to enable a modal to display the comparison list
* Add option to choose the comparison list page
* Add Widget displaying a link to comparison table
* New query var to open modal (alg_wc_cp_modal=open)

= 1.0.0 - 09/02/2016 =
* Initial Release.

== Upgrade Notice ==

= 1.0.0 =
This is the first release of the plugin.
