<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>{$info.title}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{$info.description}">
    <link href="/?feed=rss"  type="application/rss+xml"  rel="alternate" title="{$info.title} RSS Feed" />
    <link rel="shortcut icon" href="/template/favicon.ico">

    <link href="/template/css/bootstrap.css" rel="stylesheet">
    <link href="/template/css/sticky-footer-navbar.css" rel="stylesheet">
    <style>
      .mini-layout-body {
        margin: 0 auto 50px auto;
        width: 620px;
      }
    </style>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>

  <body>

    <div id="wrap">

      <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
          <div class="navbar-header">
            <a class="navbar-brand" href="/">{$info.title}</a>
          </div>
          <div class="collapse navbar-collapse">
            {if isset($info.menu_list)}
            <ul class="nav navbar-nav">
              {foreach from=$info.menu_list key=title item=link}
              <li><a href="{$link}">{$title}</a></li>
              {/foreach}
            </ul>
            {/if}
          </div>
        </div>
      </div>