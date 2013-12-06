{$xml_header}
<feed xmlns="http://www.w3.org/2005/Atom">
    <title>{$info.site_title}</title>
    <subtitle>{$info.description}</subtitle>
    <link href="{$info.base_url}?feed=atom" rel="self" />
    <link href="{$info.base_url}" />
    <id>urn:uuid:60a76c80-d399-11d9-b91C-0003939e0af6</id>
    <updated>{$latest_date}</updated>
    {foreach from=$content_list item=content}
    <entry>
        <title>{$content.metadata.title}</title>
        <link href="{$content.link}" />
        <link rel="alternate" type="text/html" href="{$content.link}"/>
        <id>urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a</id>
        <updated>{$content.metadata.date}</updated>
        <summary>{$content.html}</summary>
    </entry>
    {/foreach}
</feed>