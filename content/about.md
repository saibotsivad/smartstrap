title: About

---

This is a core set of files and functions to make it easy to make
one-off type websites that look great, and are maintainable.

In other words, if you want something as a baseline for that
company who wants the 4-page setup, or you need something for
that web comic you are setting up.

It's written in PHP, because even though [PHP sucks][phpsucks]
it is still one of the most widely used on things like shared
hosts and so on. Some day I'm going to rewrite this for people
using something cool like [node.js][nodejs] but for
now I want something I can use with very little effort, and
that will work on the majority of servers *that people use*.
(Hint: Most people's shared host space doesn't allow things
like Node, for technical reasons.)

Basic Technology
----------------

This thing uses:

* [Smarty][smarty] for templating.
* [Michel Fortin's][fortin] extended implementation of [Markdown](markdown).
* [Twitter Bootstrap][bootstrap] for the core template, but it's easy to change.

Check out the [how-to](howto) for instructions.



[phpsucks]: http://webonastick.com/php.html "PHP Sucks"
[nodejs]: http://nodejs.org/ "Node.js home"
[smarty]: http://www.smarty.net/ "Smarty templating engine"
[fortin]: http://michelf.ca/projects/php-markdown/ "Michel Fortin's PHP implementation of Markdown"
[markdown]: http://daringfireball.net/projects/markdown/ "Markdown home"
[bootstrap]: http://twitter.github.com/bootstrap/ "Twitter Bootstrap"