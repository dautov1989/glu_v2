{{-- Schema.org Structured Data Component --}}
@props([
    'type' => 'website',
    'data' => [],
])
@php
    $schema = [];

    switch ($type) {
        case 'website':
            $schema = [
                '@context' => 'https://schema.org',
                '@type' => 'WebSite',
                'name' => config('app.name'),
                'url' => url('/'),
                'description' => 'Информационный портал о сахарном диабете и контроле глюкозы',
                'potentialAction' => [
                    '@type' => 'SearchAction',
                    'target' => [
                        '@type' => 'EntryPoint',
                        'urlTemplate' => url('/search?q={search_term_string}')
                    ],
                    'query-input' => 'required name=search_term_string'
                ]
            ];
            break;

        case 'organization':
            $schema = [
                '@context' => 'https://schema.org',
                '@type' => 'Organization',
                'name' => config('app.name'),
                'url' => url('/'),
                'logo' => asset('images/logo.png'),
                'description' => 'Информационный портал о сахарном диабете',
                'sameAs' => [
                    // Добавьте ссылки на соцсети когда будут
                ]
            ];
            break;

        case 'article':
            $schema = [
                '@context' => 'https://schema.org',
                '@type' => 'MedicalWebPage',
                'headline' => $data['title'] ?? '',
                'description' => $data['description'] ?? '',
                'image' => $data['image'] ?? asset('images/og-image.jpg'),
                'datePublished' => $data['published_at'] ?? now()->toIso8601String(),
                'dateModified' => $data['updated_at'] ?? now()->toIso8601String(),
                'author' => [
                    '@type' => 'Organization',
                    'name' => config('app.name')
                ],
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => config('app.name'),
                    'logo' => [
                        '@type' => 'ImageObject',
                        'url' => asset('images/logo.png')
                    ]
                ],
                'mainEntityOfPage' => [
                    '@type' => 'WebPage',
                    '@id' => $data['url'] ?? url()->current()
                ],
                'about' => [
                    '@type' => 'MedicalCondition',
                    'name' => 'Сахарный диабет'
                ],
                'audience' => [
                    '@type' => 'PatientsAudience',
                    'audienceType' => 'Пациенты с диабетом'
                ]
            ];
            break;

        case 'breadcrumb':
            $items = $data['items'] ?? [];
            $listItems = [];

            foreach ($items as $index => $item) {
                $listItems[] = [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'name' => $item['name'],
                    'item' => $item['url'] ?? null
                ];
            }

            $schema = [
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                'itemListElement' => $listItems
            ];
            break;
    }

    // Merge with custom data if provided
    if (!empty($data) && $type !== 'breadcrumb') {
        $schema = array_merge($schema, $data);
    }
@endphp

<script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
