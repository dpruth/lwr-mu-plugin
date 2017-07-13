# LWR's Must-Use Plugin

Used by Lutheran World Relief's website, [lwr.org](https://lwr.org)

This plugin is loaded before any other plugins, and defines particular functions for LWR's use. 

See [Must Use Plugins](https://codex.wordpress.org/Must_Use_Plugins) in the Wordpress Codex for more information.

##Primary Functions

###lwr-custom-meta
* Adds metadata, such as OpenGraph tags, to the `<head>` of the website
* Adds Google, Twitter, Facebook, and MailChimp tags and pixels for goal tracking

###lwr-custom-admin
* Adds a few small options in the Wordpress Admin (wp-admin)
* DEPRECATED: used to include "Alert" options and "Homepage" options, which have since been replaced by Advanced Custom Fields

##lwr-custom-posttypes
* Defines [Custom Post Types](https://premium.wpmudev.org/blog/create-wordpress-custom-post-types/) for lwr.org
  * Press Releases
  * Projects
  * Ingatherings
  * Staff Members
  * Videos
  
##lwr-custom-taxonomies
* Defines [Custom Taxonomies](https://premium.wpmudev.org/blog/creating-custom-taxonomies-wordpress/) for lwr.org
  * Countries
  * Sectors
  * Cross-Cutting Themes
  * Partners
  * Department (Staff)
  * Office (Staff)
  * Season (Ingatherings)
  
 ##lwr-custom-csv
 * Adds custom columns to the CSV export
