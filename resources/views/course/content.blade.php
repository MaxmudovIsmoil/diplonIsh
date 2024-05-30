<div class="content-header">
    <h4 class="text-center text-primary">{{ $content['text'] }}</h4>
    @if($content['url'])
        <div class="video-player">
            <iframe src="{{ $content['url'] }}" allowfullscreen allow="autoplay"></iframe>
        </div>
    @endif

    <p class="text-justify mt-2">{!! $content['text'] !!}</p>

    @if($content['photo'])
        <img src="{{ asset('storage/photos/'.$content['photo']) }}" alt="Photo" width="100%" srcset="">
    @endif
</div>
