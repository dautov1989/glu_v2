<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>Glucosa - Все о диабете</title>
        <link>{{ url('/') }}</link>
        <description>Полезные статьи о сахарном диабете, советы врачей, новости медицины и практические рекомендации.</description>
        <language>ru-ru</language>
        <lastBuildDate>{{ now()->toRssString() }}</lastBuildDate>
        <atom:link href="{{ url('/feed') }}" rel="self" type="application/rss+xml" />
        
        @foreach($posts as $post)
        <item>
            <title><![CDATA[{{ $post->title }}]]></title>
            <link>{{ route('post.show', $post->slug) }}</link>
            <guid isPermaLink="true">{{ route('post.show', $post->slug) }}</guid>
            <description><![CDATA[{!! $post->excerpt ?? Str::limit(strip_tags($post->content), 200) !!}]]></description>
            <pubDate>{{ $post->published_at->toRssString() }}</pubDate>
            @if($post->image)
            <enclosure url="{{ $post->image }}" type="image/jpeg" />
            @endif
            <category><![CDATA[{{ $post->category->title }}]]></category>
        </item>
        @endforeach
    </channel>
</rss>
