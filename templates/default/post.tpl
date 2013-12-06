{include file="header.tpl"}
    <div class="container">
      <div class="mini-layout-body">

        <h1>{$title}{$date}</h1>
        {if isset($excerpt)}<p>{$excerpt}</p>{/if}

        {$content}

      </div>
    </div>
{include file="footer.tpl"}