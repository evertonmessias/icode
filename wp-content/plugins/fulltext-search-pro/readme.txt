=== WP FullText Search Pro ===
Contributors: Epsiloncool
Donate link: https://fulltextsearch.org/
Tags: wordpress, search, text-search, indexed search, fulltext search, search algorithm, search in PDF, search in MS Word, search in Excel, search customization, search in docx, google-like search result
Requires at least: 4.6
Tested up to: 5.9.1
Stable tag: trunk
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

This plugin creates a transparent word-based index to speed up the search, add a relevance, include meta fields and attachment's content to search index and even more. No external software/service required.

== Description ==

This plugin creates a special search index for all existing posts (and posts' metadata too) and modify standard Wordpress
search behaviour (using hooks) to use word-based search index for increase search speed, relevance quality, search by posts meta fields and content of
attachment files (for example, PDF).

In opposite to other search plugins, it complements the built-in WP search, rather than completely redefining it. This means that all functions of WP and even 3rd-party plugins will start to use new indexed search without any modifications.

= Documentation =

Please refer [Documentation](https://fulltextsearch.org/documentation/ "WP FullText Search Documentation").

== Installation ==

1. Unpack and upload `fulltext-search-pro` folder with all files to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Press `Rebuild Index` button to initialize index (actually this function will run automatically on first plugin install)

== Frequently Asked Questions ==

= Where can I put some notices, comments or bugreports? =

Do not hesistate to write to us at [Contact Us](https://fulltextsearch.org/contact/ "Contact Us") page.

== Screenshots ==

1. Plugin configuration screen
2. Indexing Engine configuration screen
3. Search tester screen
4. Simple wpfts_post_index filter example

== Changelog ==

= 2.49.192 =
* Improved compatibility with PHP 8.0+
* Added a couple of hooks to better control shortcode extraction

= 2.49.188 =
* Added PRIMARY key to wpftsi_tw table to allow 3rd party backup and migration plugins work stabler

= 2.48.186 =
* Added external link indexing capability

= 2.47.184 =
* Added fail detection to the indexer to prevent stops because of 3rd party plugins' fails

= 2.46.180 =
* Fix: enforce indexer via AJAX in case the server is local with wrong DNS/hosts file or disabled CRON

= 2.46.178 =
* Added a checkbox to switch ON/OFF the search inside WP admin
* Improved indexer execution for hostings where DNS is configured incorrectly and/or native WP cron does not work properly
* Added a fix (optional, with the checkbox switch) for MariaDB issue with new experimental search option
* WPFTS Index Optimizer is switched OFF by default now (you can bring it back using the switch)
* Rebuild Index button from Attachment Edit page now works again
* Optimized IDLE mode for indexer
* Added wpfts_set_pause() method
* Visual issues fixed
* Replaced TRUNCATE with CREATE-RENAME-DROP to avoid system locking

= 2.45.172 =
* Fixed main_search tweaker routine

= 2.45.170 =
* The indexer sequence and algorithm was completely rebuilt
* Pause mode was added to the indexer
* Improved indexer logging
* Added search index status to the Edit Post page
* Added Flare support
* Fixed a bug in autocomplete widget
* Added 'wpfts_is_force' parameter to WP_Query

= 2.44.168 =
* Added shortcode [wpfts_widget] that lets you install search widget to any place of post/page or template

= 2.43.165 =
* Improved input parameter processing to remove dependency with is_main_query() and is_search() for repeated WP_Query calls
* Bugs fixed
* Improved compatibility with 3rd-party themes and plugins

= 2.42.162 =
* Bugs fixed
* The code was cleaned

= 2.42.160 =
* Numerous bugs fixed
* Autocomplete widget styles fixed
* Shortcode content indexing added (with admin option)

= 2.40.151 =
* Word indexer was optimized for low-memory webservers
* Fixed some notices appeared for rare cases
* Added WPFTS_Utils class to improve extended indexing

= 2.40.149 =
* Fixed a typo with short words search within quotes

= 2.40.148 =
* Fixed an issue with 767 bytes in index for the wpftsi_rawcache table (thanks to Paul Taubman!)

= 2.40.146 =
* Added new algorithm that supports phrase search
* Deep search is now faster (no more afraid to use it)
* Character limit (3 chars) was removed
* MyISAM support was dropped
* Faster index rebuilding
* Fixed some UI/UX issues
* Fixed around 15 issues in the code
* Fixed found_posts / max_num_pages issue
* Fixed text typo
* Fixed language domain and code to be compatible with Wordpress Translate service
* Added support for x86 platforms (by x64 software emulation)
* Fixed notices when result is empty (thanks to Mihajlo!)
* Fixed DB collation issues (now WPFTS is using the same collation as Wordpress does)
* Fixed "expected to be a reference, value given" bug, thanks to @gregamer!
* Translation-related fixes
* Fixed an issue with index length on VARCHAR fields
* Confirmed compatibility with Wordpress 5.5
* The notice on the Smart Excerpt Settings page was fixed
* Fixed an issue with AND settings (now works again, [thanks to @clapierre](https://fulltextsearch.org/forum/topic/21/default-search-logic-and-or-broken-since-version-1-28-75/2))
* Fixed 2 other bugs

= 2.39.139 =
* Added WPFTS_Context support
* Added 'sentence' WP_Query() parameter support
* Added timeout for Textmill.io requests
* Fixed wpfts_index_post: now it is called for attachments too

= 2.39.132 =
* Fixed search results URL when using custom widgets
* Small UI fixes

= 2.39.130 =
* Changed UI logic: now tabbed
* Approved compatibility with Wordpress 5.4
* Approved WP_Query integration (fixed a compatibility issue with Avada and maybe other themes)
* Fixed 3 small issues

= 2.37.128 =
* Added native WP request support. No allow_url_fopen=1 required anymore.
* Fixed 2 bugs

= 2.36.125 =
* Fixed Smart Excerpts view algorithm (was buggy when the file content contains tags)
* Added attachment caption and description to the search index
* Attachments content now stored in 'attachments_content' cluster instead of 'post_content' 

= 2.35.120 =
* Added add-ons support
* Refreshed the style
* Fixed 5 compatibility issues
* Added informative message windows

= 2.33.115 =
* Fixed action & filter parameters

= 2.33.112 =
* Fixed bugs 
* Added more action hooks for add-on support

= 2.32.110 =
* Fixed a big bug with taxonomy

= 2.31.108 =
* Added a port for index class
* Fixed 2 issues

= 2.31.105 =
* Improved error logging while using NativePHP
* Fixed 2 bugs

= 2.30.102 =
* Changed backend design completely
* Redone configuration forms
* Added some hooks for further improvements
* Fixed 5 issues and bugs
* Added Live Search support and widget

= 2.29.96 =
* Fixed comma in MySQL query when using some locales

= 2.29.90 =
* Added support of new TextMill.io formats
* Added extended info of license
* Added info of supported mimetypes and file formats
* Added starting Wizard

= 2.28.89 =
* Fixed Smart Excerpts (now works well for any text and any character limits)

= 2.27.85 =
* To be written... still Release Candidate

= 2.26.80 =
* Added mimetype filter for attachment search results
* Fixed 3 small issues

= 2.25.79 =
* Fixed stucking when indexing too large or unsupported files
* Fixed 5 issues

= 2.24.78 =
* Fixed 11 bugs
* Added add-on gateway
* Little speed optimizations

= 2.23.76 =
* Autoupdate functionality was sufficiently improved
* Added some system checks for autoupdater
* Fixed 5 bugs

= 2.22.75 =
* Fixed a bug/conflict with WP Theme Customizer

= 2.21.74 =
* Added DOC, DOCX support (via TextMill.io)
* Added attachment extracted content display (at attachment Post Edit page)

= 2.21.73 =
* Added TextMill.io service support

= 2.20.72 =
* Added Google-like Smart Excerpts

= 2.18.69 =
* Fixed 9 small and tiny issues

= 2.17.68 =
* Added Multisite support

= 2.16.67 =
* Fixed 12 warnings and 25 notices while optimizing plugin for PHP 7.2
* Added support of PHP 7.2

= 2.15.65 =
* Added Main WP Search Tweaks settings

= 2.14.63 =
* Fixed a bug - it was a reason why plugin can't activate correctly on some hostings

= 2.14.62 =
* Added InnoDB support
* Added a switch of MySQL table type (InnoDB/MySQL)
* Fixed a bug with popup message

= 2.12.58 =
* Fixed MySQL queries: search speed sufficiently improved
* Added "Search in attachments" functionality

= 2.11.57 =
* Added "Deeper Search" flag and functionality

= 2.11.56 =
* Added support for internal query filtering
* Added wpfts_search_terms filter
* Added support for include attachments
* Added attachments content caching
* Fixed some indexing speed issues

= 2.10.54 =
* Fixed Readme.txt
* Fixed some tiny bugs

= 2.10.51 =
* Added License key support
* Added autoupdater

= 2.9.47 =
* Added support for plain/text attachments
* Fixed queries to WP multisite support

= 2.8.46 =
* Added 'wpfts_extract_text' function which can be used in user scripts

= 2.7.45 =
* Fixed PDF parser library (used more stable and much faster library)

= 2.6.41 =
* Fixed compatibility with WP 4.8.1
* Fixed indexing speed - increased a bit (code was optimized)

= 2.5.38 =
* Added support for sites with specific DB table names

= 2.4.31 =
* Fixed - Cosmetic changes

= 2.3.22 =
* Fixed - Changed regexp which is splitting texts to words (non-english characters are now supported)
* Added `wpftp_split_to_words` filter which enables you to define your own "text splitting" algorithm

= 1.2.1 =
* Added complex query analyzer (support quotes)
* Fork project to Pro & Free version

= 1.1.7 =
* Added plugin icon
* Fixed description

= 1.1.6 =
* Fixed - Lowered save_post hook priority to index metadata correctly

= 1.1.5 =
* Fixed small bugs
* Fixed - Debug logging removed

= 1.1.4 =
* Added cluster weights capability
* Added - Plugin assigned to GPL license

= 1.0 =
* First Wordpress version

= 0.4 =
* Added automatic indexing
* Fixed over 30 bugs

= 0.1 =
* Initial edition
* Added basic functions

== Upgrade Notice ==

= 1.1.4 =
* Upgrade immediately, because of some security issues found and fixed

= 1.0 =
* First version to be in Wordpress repository, just install it
