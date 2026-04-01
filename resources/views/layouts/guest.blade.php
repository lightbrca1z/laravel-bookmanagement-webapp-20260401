<!DOCTYPE html>
<html lang="ja" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ログイン') — BookManager</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-100 via-indigo-50/60 to-violet-100/80 font-sans text-slate-800 antialiased">
    <div class="flex min-h-screen flex-col">
        <header class="shrink-0 border-b border-white/20 bg-white/70 px-4 py-5 shadow-lg shadow-indigo-950/5 backdrop-blur-xl sm:px-8 sm:py-6">
            <div class="mx-auto flex max-w-6xl items-center justify-center gap-3 sm:justify-start">
                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-600 to-violet-600 text-white shadow-lg shadow-indigo-500/30 ring-1 ring-white/20">
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M8 7h8M8 11h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </span>
                <div class="text-center sm:text-left">
                    <p class="text-xs font-medium uppercase tracking-widest text-indigo-600/90">Library</p>
                    <p class="text-lg font-bold tracking-tight text-slate-900">BookManager</p>
                </div>
            </div>
        </header>
        <main class="flex w-full flex-1 flex-col items-center justify-center px-4 py-10 sm:px-6 sm:py-14">
            @yield('content')
        </main>
    </div>
</body>
</html>
