title: How To
date: 2013-03-05
excerpt: Some extra information on how to use smarkdown.

---

Folder Structure
----------------

At the root you have four basic folders:

* `/app` holds the functions that run the site
* `/libs` holds PHP libraries, aka Smarty and Markdown
* `/public` holds the linkable files, aka JavaScript, CSS, etc. and the actual content files

Inside these folders you have the following:

* `/app/control` the *control* functions that run the site
* `/app/templates` the Smarty templates that create the *display*
* `/libs/markdown` the Markdown to HTML library
* `/libs/smarty` the current version of Smarty
* `/public/css` the CSS used by the template
* `/public/ico` the favicon and other icons used by various mobile devices
* `/public/img` this should be any images used *by the template*
* `/public/js` the JavaScript used by the template
* `/public/content` the content, aka, markdown and images

How to Use
----------

Look inside `/app/control/info.php` for where to change or set variables, you
can access those variable from anywhere in the code, but you can't modify them
during runtime, so they are basically static globals.

If you are putting this app inside a subfolder, aka `site.com/test` you will
need to change the `.htaccess` file `RewriteBase` to be the folder, e.g. `RewriteBase /test/`

Inside `/app/control/menu.php` is the logic you should use to define the menu
items inside the template. Check it out in the code, and have a look at
the [demo][demo] to see it in action.



[demo]: http://smarkdown.tobiaslabs.com "Demo of this site in use"