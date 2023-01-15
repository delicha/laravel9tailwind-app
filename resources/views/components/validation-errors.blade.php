@props(['errors'])

@if ($errors->any())
    <div {{ $attributes }}>
        <div class="font-medium text-red-600">
            {{ __('以下の問題が発生しました。') }}
        </div>

        <ul class="mt-3 text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    dd($errors);
@endif

{{-- @props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach

        @if(empty($messages->image))
            <li>画像ファイルがあれば、再度、選択してください。</li>
        @endif
    </ul>
@endif --}}
