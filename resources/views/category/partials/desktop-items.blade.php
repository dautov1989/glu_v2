@foreach($bentoData['all'] as $post)
    @php
        // Если это подгрузка, то Large не будет, будут только Medium и Small.
        // Если вдруг затесался Large (например, логика изменилась), принудительно делаем Medium, чтобы не ломать сетку внизу.
        $size = ($post->bentoSize === 'large') ? 'medium' : $post->bentoSize;
    @endphp
    <x-bento-card :post="$post" :size="$size" :badge="$post->bentoBadge" :gradient="$post->bentoGradient"
        :icon="$post->bentoIcon" />
@endforeach