{include file="header.tpl"}
<div class="container">
  <div class="mini-layout-body">

  <h1>{$title}</h1>
  <p class="lead">{$date|date_format:"%B %d, %Y"}</p>

  {$content}

  </div>
</div>
{if isset($archive_list)}
  {include file="archive.tpl"}
{/if}
{include file="footer.tpl"}