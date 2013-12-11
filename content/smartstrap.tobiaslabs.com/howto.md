title: How To
date: 2013-03-05
excerpt: Some extra information on how to use smarkdown.

---

Folder Structure
----------------

lib
---

* `/libs/smarty` : [Smarty][smarty] for templating.
* `/libs/markdown` : [Michel Fortin's][fortin] extended implementation of [Markdown][markdown].
* `/libs/smartstrap` : [This][smartstrap], the smartstrap functions

site
----

* `/site/content --> ../content/domain.com` : The content is markdown files with metadata, and any embedded images. Symlinked.
* `/site/template --> ../templates/default` : The template files (tpl, css, js, etc.) for the site. Symlinked.
* `index.php` : The main controller
* `.htaccess` : Handles the prettification of the URLs

How to Use: Simple Method
-------------------------

Suppose you are on your server, and you've got Apache pointing `site.com` to `/usr/www/site.com`

Go to `/usr/www` and `git clone https://github.com/saibotsivad/smartstrap.git`

You've now got SmartStrap checked out, like `/usr/www/smartstrap`

Now simply point Apache to the site folder by symlinking, like this (make sure to delete the folder `/usr/www/site.com` first):

`ln -s /usr/www/smartstrap/site /usr/www/site.com`

Go inside the file `smartstrap-configs.php` and setup your site name and URL.

Start writing! It's all inside `/usr/www/site.com/content`

How to Use: Like a Boss
-----------------------

Suppose you are on your server, and you've got Apache pointing `site.com` to `/usr/www/site.com`

Go to `/usr/www` and `git clone https://github.com/saibotsivad/smartstrap.git`

You've now got SmartStrap checked out, like `/usr/www/smartstrap`

I recommend the following folder structure:
* `/usr/www/smartstrap` : Hold the smartstrap library and controls
* `/usr/www/public/mycontent` : Inside here will be your Markdown files and pictures, probably from a repo
* `/usr/www/public/mytemplate` : This would be a single template, also probably from a repo

If that's your setup, you'll need to symlink the 4 site objects into your Apache site folder, like this:

`ln -s /usr/www/smartstrap/site/index.php /usr/www/site.com/index.php`
`ln -s /usr/www/smartstrap/site/.htaccess /usr/www/site.com/.htaccess`
`ln -s /usr/www/public/mytemplate /usr/www/site.com/template`
`ln -s /usr/www/public/mycontent /usr/www/site.com/content`

Then you should copy the `smartstrap-configs.php` file to `/usr/www/smartstrap-configs.php` which will
let you configure your site. At this point, if you use git to pull down the latest version, there won't
be any merge issues, because you aren't changing anything inside the smartstrap folders!

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