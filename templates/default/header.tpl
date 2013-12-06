<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>{$info.dom_title}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{$info.description}">
    <link href="{$info.baseurl}?feed=atom" type="application/atom+xml" rel="alternate" title="{$info.dom_title} ATOM Feed">
    <link href="{$info.baseurl}?feed=rss"  type="application/rss+xml"  rel="alternate" title="{$info.dom_title} RSS Feed" />

    <!-- Le styles -->
    <link href="{$info.baseurl}/template/css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
      .mini-layout-body {
        margin: 0 auto;
        width: 620px;
      }
    </style>
    <link href="{$info.baseurl}/template/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{$info.baseurl}/template/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{$info.baseurl}/template/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{$info.baseurl}/template/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="{$info.baseurl}/template/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="{$info.baseurl}/template/ico/favicon.png">
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="{$info.base_url}">{$info.site_title}</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              {foreach $menus as $menu}
              <li class="{$menu.class}"><a href="{$menu.link}">{$menu.name}</a></li>
              {/foreach}
            </ul>
            <form class="navbar-search pull-right" method="get" action="http://www.google.com/search">
              <input type="text" class="search-query" placeholder="Search" name="q">
              <input type="checkbox" name="sitesearch" value="{$info.baseurl}/template" checked="checked" style="display:none;">
            </form>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>