{$xml_header}
<rss version="2.0">
   <channel>
	  <title>{$info.site_title}</title>
      <link>{$info.base_url}</link>
      <description>{$info.description}</description>
      <language>en-us</language>
      <pubDate>{$earliest_date}</pubDate>
      <lastBuildDate>{$latest_date}</lastBuildDate>
      <generator>SmartStrap</generator>
      {foreach from=$content_list item=content}
      <item>
         <title>{$content.metadata.title}</title>
         <link>{$content.link}</link>
         <description>{$content.html}</description>
         <pubDate>{$content.metadata.date}</pubDate>
         <guid>{$content.link}</guid>
      </item>
      {/foreach}
   </channel>
</rss>