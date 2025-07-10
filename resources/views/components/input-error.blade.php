@foreach ($messages ?? [] as $message)
    <div {{ $attributes }} style="color:red;">{{ $message }}</div>
@endforeach
