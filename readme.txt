=== Currently Reading ===
Contributors: eroux
Tags: books, read, reading, admin, administration, jadb
Requires at least: 2.8
Tested up to: 3.0.4
Stable tag: 3.3

Displays a cover image of a book with a link to Google Books based on a supplied ISBN-10 or ISBN-13.

== Description ==
Supplying an [ISBN](http://en.wikipedia.org/wiki/International_Standard_Book_Number) (and, optionally, a Title) will display a cover image of the relevant book with a link to that book's page on [Google Books](http://http://books.google.com/).

Using the Widget you can choose whether to:

* Suppress the List Marker (selected by default, uses internal CSS)

as well as

1. Decide whether you would like to use a Title
1. Define the ISBN-10 or ISBN-13 of the book.

== Installation ==

**Install**

1. Unzip the `currently-reading.zip` file. 
1. Upload `currently-reading.php` to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Use the "Currently Reading" widget.

**Upgrade**

1. Follow your normal installtion procedure
1. Open each Widget's control panel and re-save

== Frequently Asked Questions ==

== Screenshots ==

1. The Configuration of a "Currently Reading" section, with the "UL" marker suppressed.
2. Multiple Widgets, the first marking them as "Recently Read".
3. The previous configuration as rendered by Chrome.

== Changelog ==

= 1.0 =

* Initial Public Release

= 2.0 =

* Fixed a potentially embarassing issue with generated HTML

= 3.0 =

* Release number re-alignment with internal Hg repo

= 3.1 =

* Added the ability to have drop-shadows around the front-cover images of the books

= 3.2 =

* Improved the book spacing a bit in the internal CSS

= 3.3 =

* Moved to a '&lt;div&gt;' based layout instead of using Lists (Kudos to James Sumners for the suggestion)

