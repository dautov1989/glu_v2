{{-- Analytics Component --}}
@props([
    'yandexMetrikaId' => config('services.yandex_metrika.id'),
    'googleAnalyticsId' => config('services.google_analytics.id'),
])

@if($yandexMetrikaId)
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function(m,e,t,r,i,k,a){
        m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();
        for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
        k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)
    })(window, document,'script','https://mc.yandex.ru/metrika/tag.js?id={{ $yandexMetrikaId }}', 'ym');

    ym({{ $yandexMetrikaId }}, 'init', {
        ssr: true,
        webvisor: true,
        clickmap: true,
        ecommerce: "dataLayer",
        accurateTrackBounce: true,
        trackLinks: true
    });
</script>
<noscript>
    <div>
        <img src="https://mc.yandex.ru/watch/{{ $yandexMetrikaId }}" 
             style="position:absolute; left:-9999px;" 
             alt="" />
    </div>
</noscript>
<!-- /Yandex.Metrika counter -->
@endif

@if($googleAnalyticsId)
<!-- Google Analytics 4 -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $googleAnalyticsId }}"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '{{ $googleAnalyticsId }}', {
        'send_page_view': true,
        'anonymize_ip': true
    });
</script>
<!-- /Google Analytics 4 -->
@endif
