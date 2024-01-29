<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/produk') }}/all</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>https://catalogue.sungky.com/produk/smartwatch</loc>
        <lastmod>2023-08-10T18:36:13+00:00</lastmod>
        <changefreq>weekly</changefreq>
    </url>
    <url>
        <loc>https://catalogue.sungky.com/produk/smartphone</loc>
        <lastmod>2023-08-10T18:36:13+00:00</lastmod>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc>https://catalogue.sungky.com/produk/tas</loc>
        <lastmod>2023-08-10T18:36:13+00:00</lastmod>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc>https://catalogue.sungky.com/produk/sneakers</loc>
        <lastmod>2023-08-10T18:36:13+00:00</lastmod>
        <changefreq>monthly</changefreq>
    </url>
    <?php
    
        $produk = DB::table('barangs')->get();

    ?>
    @foreach ($produk as $item)
        <url>
            <loc>https://catalogue.sungky.com/{{ $item->slug }}</loc>
            <?php
                $originalDate = $item->updated_at;
                $iso8601Date = date('c', strtotime($originalDate));
            ?>
            <lastmod>{{ $iso8601Date }}</lastmod>
        </url>
    @endforeach
</urlset>
