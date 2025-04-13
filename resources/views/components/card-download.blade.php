@props(['title' => 'TITLE FILE', 'typeFile' => 'PDF', 'color' => 'var(--accent-primary)', 'url' => ''])

<div class="card" style="border-left: 3px solid {{ $color }}; background: #F2F2F2; min-height: 175px; min-width: 250px; max-width: 300px; margin-right: 5px; margin-left: 5px;">
    <div class="card-header bg-transparent">
        <div>
            <div class="float-left">
                <button class="btn btn-sm" style="border: 1px solid {{ $color }}; background: white;">
                    <i class="fas fa-file-alt" style="color: {{ $color }}; font-size: 25px;"></i>
                </button>
            </div>
            <div class="float-right">
                <span style="background: #2D3748; font-size: 14px; color: white; font-weight: 700; padding: 5px;">{{ $typeFile }}</span>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-lg-9">
                <h4>
                    {{ $title }}
                </h4>
            </div>
            <div class="col-lg-3">
                @if ($url != '')
                    <a href="{{ $url }}" target="_blank">
                        <i class="fas fa-download" style="font-size: 25px; color: {{ $color }};"></i>
                    </a>
                @else
                    tidak ada file
                @endif
            </div>
        </div>
    </div>

    {{-- <div class='card-footer'>
    </div> --}}
</div>
