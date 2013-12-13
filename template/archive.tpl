<div class="container">
  <div class="mini-layout-body">
    <dl class="dl-horizontal">
      {foreach from=$files item=post}
        {if $post.link ne '/404' and $post.link ne '/index' and $post.link ne '/archive'}
        <dt>{$post.date|date_format:"%Y-%m-%d"}</dt>
        <dd><a href="{$post.link}">{$post.title}</a></dd>
        {/if}
      {/foreach}
    </dl>
  </div>
</div>