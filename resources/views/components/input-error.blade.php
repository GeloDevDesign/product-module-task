@props(['messages'])

@if ($messages)
    <ul class="mt-1" style="list-style:none; padding:0;">
        @foreach ((array) $messages as $message)
            <li class="text-danger">{{ $message }}</li>
        @endforeach
    </ul>
@endif
