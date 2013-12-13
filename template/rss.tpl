{$xml_header}
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
   <channel>
      <atom:link href="{$info.url}/?feed=rss" rel="self" type="application/rss+xml" />
	   <title>{$info.title}</title>
      <link>{$info.url}</link>
      <description>{$info.description}</description>
      <language>en-us</language>
      <pubDate>Wed, 02 Oct 2002 08:00:00 EST</pubDate>
      <lastBuildDate>Wed, 02 Oct 2002 08:00:00 EST</lastBuildDate>
      <generator>SmartStrap</generator>
      {foreach from=$files key=file item=content}
         {if $content.link ne '/404' and $content.link ne '/index' and $content.link ne '/archive'}
            <item>
               <title>{$content.title}</title>
               <link>{$info.url}{$content.link}</link>
               <description>{$content.content}</description>
               <pubDate>{$content.date|date_format:"%a, %d %b %Y %H:%M:%S %z"}</pubDate>
               <guid>{$info.url}{$content.link}</guid>
            </item>
         {/if}
      {/foreach}
   </channel>
</rss>