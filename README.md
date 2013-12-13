What it is
----------

The content is written in Markdown, a super simple text with
super simple markup. A lot of cool people like it because it's
easy and enjoyable to write in.

The template used is Smarty, mostly because it's a well written
PHP templating engine with some good basic functionality built in.

The included template is the Twitter Bootstrap, because it's well
written and conforms to specs pretty well.

There's a [demo][demo], which was installed the following way:

1. On my server: `git clone https://github.com/saibotsivad/smartstrap.git ~/smartstrap.tobiaslabs.com`
2. ...
3. Profit?

![That's pretty neat](http://smartstrap.tobiaslabs.com/content/thatsprettyneat.jpg "How neat is that?")

Customize
---------

* Change the `$info` variable inside `./index.php` to whatever you want.

These variables are only used in the template, so you really can put anything in there you want.

* Put your own content in the `./content` folder.

Any file with the `.md` extension is [markdown][Markdown]. The extra bits at the top are available
inside the template, so `title: How to Use` is in the template as `{$title}` and shows as `How to Use`.

* Templating uses [smarty][Smarty], and the template files are in `./template`


Be More Awesome
---------------

Host your blog on github, then clone it as the content folder. May have to symlink it, if your
naming is different. Or just fork this and put your content in it, I guess. I'll be using it on
my [labs][research blog] here as soon as I convert all the WordPress to Markdown.

Magic
-----

There's some magic going on to give you a *posts vs pages* thing. You don't have to play along, but
here's how it works:

Links like `site.com/bydate/2013/12/24/christmas-time` will map to `./content/bydate/2013-12-24_christmas-time.md`

All other links will map like `site.com/any/folder/depth` to `./content/any/folder/depth.md`

Right now the list of posts is displayed anywhere by putting the tag `archive_list` in the markdown
file, with anything as the value of the tag (see [here][archive] for an example).


[smarty]: http://www.smarty.net/ "Smarty templating engine"
[fortin]: http://michelf.ca/projects/php-markdown/ "Michel Fortin's PHP implementation of Markdown"
[markdown]: http://daringfireball.net/projects/markdown/ "Markdown home"
[demo]: http://smartstrap.tobiaslabs.com "Demo of this site in use"
[labs]: http://tobiaslabs.com "Tobias Labs"
[here]: https://github.com/saibotsivad/smartstrap/blob/master/content/archive.md "Demo of archive page"
