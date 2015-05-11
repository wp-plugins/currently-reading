=== Currently Reading ===
Contributors: eroux
Tags: books, read, reading, admin, administration, jadb
Requires at least: 3
Tested up to: 4.2.2
Stable tag: trunk

Displays a cover image of a book with a link to Google Books based on a supplied ISBN-10 or ISBN-13.

== Description ==
Supplying an [ISBN](http://en.wikipedia.org/wiki/International_Standard_Book_Number) (and, optionally, a Title) will display a cover image of the relevant book with a link to that book's page on [Google Books](http://books.google.co.za/) using the Google Books API.

Using the Widget you can choose whether to:

* Pad the Image (selected by default, uses internal CSS)
* Display a Box-Shadow (selected by default, uses internal CSS)
* Choose Alternate Google Country (defaults to "South Africa" since books.google.com seems to give a "500" error and South Africa seems to work just fine for US clients as well)

as well as

* Decide whether you would like to use a Title
* Define the ISBN-10 or ISBN-13 of the book.

== Installation ==

**Manual Install**

1. Unzip the `currently-reading.zip` file.
2. Upload `currently-reading.php` to the `/wp-content/plugins/` directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.
4. Use the "Currently Reading" widget (found under Appearance -> Widgets).

**Automated Install**

1. Go to "Plugins" -> "Add New" in your Control Panel.
2. Search for the keywords "Currently Reading".
3. Click the "Install Now" button on "Currently Reading" by "Eugéne Roux".

**Upgrade**

1. Follow your normal installation procedure
2. Open each Widget's control panel and re-save

**Use the WordPress Plug-in System**

1. Select "Upgrade and Activate"
2. Congratulate yourself on a sterling job.

== Frequently Asked Questions ==

**I Get a '*Warning: file_get_contents ... : failed to open stream: HTTP request failed! HTTP/1.0 403 Forbidden*' Error on My Blog With No Books Displayed. Why Is This Happening?**

Your web-site has been configure not to allow outgoing HTTP requests and you have 'Use Google API' enabled or Google rejected your connection.

If the automated fail-back failed, please de-select the 'Use Google API' option to use the direct connection instead nd report this as a bug.

**I Get a '*No Google Books Entry Found for ISBN:NUMBER*' on My Blog... Why?**

Sometimes Google Books does not return any valid responses on ISBNs. Try the following:

1. See if you can find an alternate ISBN for the book
2. Toggle the "Use Google API" option
3. Find the eBook on Google's Books Web Page and use its ISBN

**I Get an *Image Not Available* Image on My Blog Instead of the Book Cover, and Clicking It Gives Me a Google 404 Error**

You will only see this if you are *not* using the Google Books API or, if you are, it failed back to the previous system for some reason.

Double-check the ISBN you used; it's either wrong or Google does not have an entry for the book referenced.

**Are You Planning to Insert Other Sources Than Google Books to the Currently Reading Widget?**

I'll have a look into supporting Amazon, though they do make you jump through hoops to use their API (which is the reason I settled on using Google Books to start with).

**Is There a Way to Get This Plug-In to Do a Library of All of Your Books Into WordPress?**

It's not currently possible with this plug-in, no.

I'll give it a bit of thought and see if I can extend it to do that; but it will most likely need the creation of an alternate plugin to do that.

This would likely require its own database table to do properly, as well...

== Screenshots ==

1. The Configuration of a "Currently Reading" section, with Padding enabled.
2. Multiple Widgets, the first marking them as "Finished Reading".
3. The previous configuration as rendered by Safari.
4. The difference between Padding and Box-Shadow Enabled and Disabled.
5. Widget Configuration location in the Dashboard's sidebar.

== Changelog ==

= 4.0.3 =

* Allow the centring of the Book Cover within the sidebar (Props Andy Tegala for the suggestion)
* Cache Google Books API call (if successful) for (default) 30 days
* (Semi-)Gently fall back to previous behaviour if Google Books API call fails

= 4.0.2 =

* Allow *not* using the Google Books API in preference to the older -- direct -- connection
* Since I'm probably the only Saffer using this, default to "books.google.com"

= 4.0.1 =

* Display a message (No Google Books Entry Found for ISBN) when Google has no entry for the book in question
* Reduce the width of margins so that the book entries fit better into the sidebar
* Added a screenshot of the Widget Configuration location in the Sidebar (mostly since I keep forgetting where it is)

= 4.0 =

* Use the Google Books API instead of previous deep-linking
* Fix display of ISBN when updating the widget
* Allow the selection of Alternate Google Domains (books.google.com causes issues in some countries)
* Display book's Title instead of ISBN on mouse-over

= 3.4 =

* Minor fixes to ensure WordPress compatibility

= 3.3 =

* Moved to a '&lt;div&gt;' based layout instead of using Lists (Kudos to James Sumners for the suggestion)

= 3.2 =

* Improved the book spacing a bit in the internal CSS

= 3.1 =

* Added the ability to have drop-shadows around the front-cover images of the books

= 3.0 =

* Release number re-alignment with internal Hg repo

= 2.0 =

* Fixed a potentially embarrassing issue with generated HTML

= 1.0 =

* Initial Public Release
