<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $linktree->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="text-white min-h-screen flex justify-center" style="background-color: {{ $linktree->bg_color ?? '#1f2937' }}; @if($linktree->bg_image) background-image: url('{{ asset('storage/' . $linktree->bg_image) }}'); background-size: cover; background-position: center; @endif">

    @if($linktree->bg_image)
        <div class="absolute inset-0 bg-black/30"></div>
    @endif

    <div class="relative z-10 w-full max-w-md p-6 flex flex-col items-center pt-16 space-y-6">
        
        <div class="w-24 h-24 bg-gradient-to-tr from-indigo-500 to-purple-500 rounded-full flex items-center justify-center text-3xl font-bold shadow-2xl">
            {{ substr($linktree->title, 0, 1) }}
        </div>

        <div class="text-center space-y-2">
            <h1 class="text-2xl font-bold" style="color: {{ $linktree->text_color ?? '#ffffff' }};">{{ $linktree->title }}</h1>
            <p class="text-sm" style="color: {{ $linktree->text_color ?? '#ffffff' }}; opacity: 0.8;">{{ $linktree->description ?? 'Meus links importantes' }}</p>
        </div>

        <div class="w-full space-y-3">
            @forelse($linktree->dados as $link)
                <a href="{{ $link->url_link }}" target="_blank" rel="noopener noreferrer"
                   class="relative flex items-center justify-center p-3 px-14 rounded-2xl hover:scale-105 transition-transform shadow-lg cursor-pointer font-semibold min-h-[60px]"
                   style="background-color: {{ $link->button_color ?? '#ffffff' }}; color: {{ isLightColor($link->button_color ?? '#ffffff') ? '#000000' : '#ffffff' }};">
                    
                    @if($link->icon)
                        <div class="absolute left-3 w-10 h-10 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                             <img src="{{ asset('storage/' . $link->icon) }}" alt="{{ $link->name_link }}" class="w-full h-full object-cover">
                        </div>
                    @endif
                    
                    <span class="text-center w-full break-words leading-tight">{{ $link->name_link }}</span>
                </a>
            @empty
                <div class="text-center py-8" style="color: {{ $linktree->text_color ?? '#ffffff' }}; opacity: 0.6;">
                    <p class="text-sm">Nenhum link adicionado ainda</p>
                </div>
            @endforelse
        </div>

        <div class="mt-auto pt-10 text-[10px] font-bold uppercase tracking-widest" style="color: {{ $linktree->text_color ?? '#ffffff' }}; opacity: 0.4;">
            Feito com LinkNext
        </div>
    </div>

</body>
</html>

@php
function isLightColor($color) {
    $hex = str_replace('#', '', $color);
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    $brightness = ($r * 299 + $g * 587 + $b * 114) / 1000;
    return $brightness > 128;
}
@endphp