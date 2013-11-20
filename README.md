smarkdown
=========

This is a core set of files and functions to make it easy to make
one-off type websites that look great, and are maintainable.

In other words, if you want something as a baseline for that
company who wants the 4-page setup, or you need something for
that web comic you are setting up.

It's written in PHP, because even though [PHP sucks][phpsucks]
it is still one of the most widely used on things like shared
hosts and so on, making it a very *usable* language.

Folder Structure
----------------

At the root you have two folders, the `lib` and `site` folders.

lib
---

* `/lib/smarty` : [Smarty][smarty] for templating.
* `/lib/markdown` : [Michel Fortin's][fortin] extended implementation of [Markdown][markdown].
* `/lib/smartstrap` : [This][smartstrap], the smartstrap functions

site
----

* `/site/content` : The content is markdown files with metadata, and any embedded images
* `/site/template` : The template files (tpl, css, js, etc.) for the site

How to Use
----------

The basic idea is this: point your Apache configured domain to `/site` and
all that is inside there is now public.

Look inside `/site/index.php` for the configuration details like site title, folder
paths, etc. You can access those variable from anywhere in the code, they are
basically static globals.

Put the page text and metadata as markdown files inside `/site/content`, and any images
specific to those pages as well.

If you don't like the default template, just go inside `/site/template` and change it.

Menu Bar
--------

You'll notice that inside the `index.php` configuration is an array of markdown files, and
those happen to be the ones that show up in the menu bar. Well that's the basic idea.

If you put a markdown file name in the menu array, it'll show up automagically, and inside
the template you'll get a `menu.class` variable, which will include `active` if you are on
that page.

[phpsucks]: http://webonastick.com/php.html "PHP Sucks"
[smarty]: http://www.smarty.net/ "Smarty templating engine"
[fortin]: http://michelf.ca/projects/php-markdown/ "Michel Fortin's PHP implementation of Markdown"
[markdown]: http://daringfireball.net/projects/markdown/ "Markdown home"
[demo]: http://smarkdown.tobiaslabs.com "Demo of this site in use"