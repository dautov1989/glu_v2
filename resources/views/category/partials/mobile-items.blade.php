@foreach($bentoData['all'] as $post)
    <x-bento-card :post="$post" size="mobile" :badge="$post->bentoBadge" :gradient="$post->bentoGradient"
        :icon="$post->bentoIcon" />
@endforeach