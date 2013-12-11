<ul class="nav">
  {foreach $menu_list as $menu}
    {if isset($menu.children)}
      <li class="dropdown {$menu.class}" id="uniqueid">
        <a class="dropdown-toggle" data-toggle="dropdown" href="{$menu.link}">{$menu.name}<b class="caret"></b></a>
        <ul class="dropdown-menu">
          {foreach $menu.children as $child}
            <li class="{$child.class}"><a href="{$child.link}">{$child.name}</a></li>
          {/foreach}
        </ul>
      </li>
    {else}
      <li class="{$menu.class}"><a href="{$menu.link}">{$menu.name}</a></li>
    {/if}
  {/foreach}
</ul>