smarkdown
=========

This is a core set of files and functions to make it easy to make
one-off type websites that look great, and are maintainable.

In other words, if you want something as a baseline for that
company who wants the 4-page setup, or you need something for
that web comic you are setting up.

It's written in PHP, because even though [PHP sucks](phpsucks)
it is still one of the most widely used on things like shared
hosts and so on. Some day I'm going to rewrite this for people
using something cool like [node.js](nodejs) but for
now I want something I can use with very little effort, and
that will work on the majority of servers *that people use*.
(Hint: Most people's shared host space doesn't allow things
like Node, for technical reasons.)

Basic Technology
----------------

This thing uses:
	* [Smarty](smarty) for templating.
	* [Michel Fortin's](fortin) extended implementation of [Markdown](markdown).
	* [Twitter Bootstrap](bootstrap) for the core template, but it's easy to change.

Folder Structure
----------------

At the root you have four basic folders:
	* `/app` holds the functions that run the site
	* `/content` holds the text content, and is optional
	* `/libs` holds PHP libraries, aka Smarty and Markdown
	* `/public` holds the linkable files, aka JavaScript, CSS, etc.

Inside these folders you have the following:

	* `/app/control` the *control* functions that run the site
	* `/app/templates` the Smarty templates that create the *display*

	* `/libs/markdown` the Markdown to HTML library
	* `/libs/smarty` the current version of Smarty

	* `/public/css` the CSS used by the template
	* `/public/ico` the favicon and other icons used by various mobile devices
	* `/public/img` this should be any images used *by the template*
	* `/public/js` the JavaScript used by the template

How to Use
----------

Look inside `/app/control/info.php` for where to change or set variables, you
can access those variable from anywhere in the code, but you can't modify them
during runtime, so they are basically static globals.

Inside `/app/control/menu.php` is the logic you should use to define the menu
items inside the template. Check it out on the [demo](demo) to see an example.

In fact, you should probably check out that [demo](demo) anyway, it will show
you how easy this is it use!




[phpsucks]: http://webonastick.com/php.html "PHP Sucks"
[nodejs]: http://nodejs.org/ "Node.js home"
[smarty]: http://www.smarty.net/ "Smarty templating engine"
[fortin]: http://michelf.ca/projects/php-markdown/ "Michel Fortin's PHP implementation of Markdown"
[markdown]: http://daringfireball.net/projects/markdown/ "Markdown home"
[bootstrap]: http://twitter.github.com/bootstrap/ "Twitter Bootstrap"
[demo]: http://strapper.tobiaslabs.com "Demo of this site in use: Strapper"