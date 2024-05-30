<section class="vertical-wizard">
    <div class="bs-stepper vertical vertical-wizard-example">
        <div class="bs-stepper-header">
            @foreach($plans as $plan)
                <div class="step @if (Request::segment(3) == $plan['id']) active @endif">
                    <a href="{{ route('course.getContent', ['courseId' => $courseId, 'planId' => $plan['id']]) }}" class="step-trigger">
                        <span class="bs-stepper-box">{{ $loop->iteration }}</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">{{ $plan['title'] }}</span>
                            <span class="bs-stepper-subtitle">{{ $plan['text'] }}</span>
                        </span>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="bs-stepper-content">
            @isset($contents)
                @foreach($contents as $content)
                    <div class="contents active">
                        @include('course.content')
                    </div>
                @endforeach
            @endisset
        </div>
    </div>
</section>
