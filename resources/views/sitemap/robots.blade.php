User-agent: *
Allow: /

# Disallow admin and private areas
Disallow: /admin/
Disallow: /settings/
Disallow: /dashboard/
Disallow: /login
Disallow: /register
Disallow: /password/

# Allow important directories
Allow: /images/
Allow: /css/
Allow: /js/

# Sitemap location
Sitemap: {{ url('/sitemap.xml') }}

# Crawl delay (optional, in seconds)
Crawl-delay: 1