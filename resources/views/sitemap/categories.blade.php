<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($categories as $item)
        <url>
            <loc>{{ route('category.single', [$item->slug, $item->id]) }}</loc>
            <lastmod>{{ $item->created_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>
        </url>
    @endforeach
</urlset>