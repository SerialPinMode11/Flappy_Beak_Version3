@once
@push('styles')
<style>
    .auth-duck-tracks svg {
        width: 100%;
        height: 100%;
        display: block;
    }
    .auth-duck-tracks .duck-print {
        transform-origin: center;
        transform-box: fill-box;
        animation: auth-duck-step 5.5s ease-in-out infinite;
    }
    .auth-duck-tracks .duck-print--alt {
        animation-duration: 6.2s;
        animation-delay: -1.4s;
    }
    .auth-duck-tracks .duck-print image {
        opacity: 1;
    }
    .auth-duck-tracks .duck-print--alt image {
        filter: sepia(0.2) hue-rotate(8deg) saturate(0.95);
    }
    @keyframes auth-duck-step {
        0%, 100% { opacity: 0.32; transform: scale(1); }
        50% { opacity: 0.72; transform: scale(1.04); }
    }
    @media (prefers-reduced-motion: reduce) {
        .auth-duck-tracks .duck-print {
            animation: none;
            opacity: 0.48;
        }
    }
</style>
@endpush
@endonce

@php
    $duckFootprintsSrc = asset('images/duck-footprints.png');
    /** Source PNG is 512×512; size in SVG viewBox units */
    $dfSize = 76;
    $dfHalf = $dfSize / 2;
@endphp

<div class="auth-duck-tracks absolute inset-0 pointer-events-none z-[1] overflow-hidden" aria-hidden="true">
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 900 700" preserveAspectRatio="xMidYMid slice" class="min-h-full min-w-full">
        @foreach ([
            ['t' => 'translate(80 60) rotate(35)', 'd' => '0s', 'alt' => false],
            ['t' => 'translate(130 120) rotate(38)', 'd' => '-0.6s', 'alt' => true],
            ['t' => 'translate(175 185) rotate(32)', 'd' => '-1.2s', 'alt' => false],
            ['t' => 'translate(225 255) rotate(36)', 'd' => '-1.8s', 'alt' => true],
            ['t' => 'translate(275 330) rotate(34)', 'd' => '-2.4s', 'alt' => false],
            ['t' => 'translate(325 405) rotate(37)', 'd' => '-3s', 'alt' => true],
            ['t' => 'translate(375 485) rotate(33)', 'd' => '-3.6s', 'alt' => false],
            ['t' => 'translate(780 90) rotate(-38)', 'd' => '-0.4s', 'alt' => true],
            ['t' => 'translate(720 165) rotate(-35)', 'd' => '-1s', 'alt' => false],
            ['t' => 'translate(665 245) rotate(-40)', 'd' => '-1.6s', 'alt' => true],
            ['t' => 'translate(615 325) rotate(-36)', 'd' => '-2.2s', 'alt' => false],
            ['t' => 'translate(565 410) rotate(-39)', 'd' => '-2.8s', 'alt' => true],
            ['t' => 'translate(515 495) rotate(-37)', 'd' => '-3.4s', 'alt' => false],
            ['t' => 'translate(420 140) rotate(8) scale(0.88)', 'd' => '-1.5s', 'alt' => false],
            ['t' => 'translate(460 520) rotate(-5) scale(0.82)', 'd' => '-2.2s', 'alt' => true],
        ] as $step)
            <g transform="{{ $step['t'] }}">
                <g class="duck-print{{ $step['alt'] ? ' duck-print--alt' : '' }}" style="animation-delay: {{ $step['d'] }};">
                    <image
                        href="{{ $duckFootprintsSrc }}"
                        xlink:href="{{ $duckFootprintsSrc }}"
                        x="{{ -$dfHalf }}"
                        y="{{ -$dfHalf }}"
                        width="{{ $dfSize }}"
                        height="{{ $dfSize }}"
                        preserveAspectRatio="xMidYMid meet"
                    />
                </g>
            </g>
        @endforeach
    </svg>
</div>
