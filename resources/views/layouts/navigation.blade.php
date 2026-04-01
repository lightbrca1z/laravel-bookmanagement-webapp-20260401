<!DOCTYPE html>
<html lang="ja" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', '書籍管理') — BookManager</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-full bg-gradient-to-br from-slate-100 via-indigo-50/60 to-violet-100/80 font-sans text-slate-800 antialiased">
    <header class="sticky top-0 z-50 border-b border-white/20 bg-white/70 shadow-lg shadow-indigo-950/5 backdrop-blur-xl">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-4 py-3.5 sm:px-6 lg:px-8">
            <a
                href="{{ route('books.index') }}"
                class="group flex shrink-0 items-center gap-3 rounded-2xl bg-gradient-to-br from-indigo-600 to-violet-600 px-4 py-2.5 text-white shadow-lg shadow-indigo-500/30 ring-1 ring-white/20 transition duration-200 hover:shadow-xl hover:shadow-indigo-500/35 hover:brightness-105"
                aria-label="書籍一覧へ"
            >
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/15 ring-1 ring-white/25">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M8 7h8M8 11h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </span>
                <span class="flex flex-col leading-tight">
                    <span class="text-xs font-medium uppercase tracking-widest text-indigo-100/90">Library</span>
                    <span class="text-base font-bold tracking-tight">BookManager</span>
                </span>
            </a>
            <nav class="flex flex-wrap items-center justify-end gap-1.5 sm:gap-2" aria-label="メインメニュー">
                @auth
                    <span class="hidden text-sm text-slate-500 sm:inline">
                        <span class="font-medium text-slate-700">{{ auth()->user()->userid ?? auth()->user()->name }}</span>
                    </span>
                    <a
                        href="{{ route('books.index') }}"
                        class="rounded-xl px-4 py-2.5 text-sm font-medium text-slate-600 transition-all duration-200 hover:bg-slate-100/90 hover:text-slate-900"
                    >
                        ホーム
                    </a>
                    <a
                        href="{{ route('books.index') }}"
                        class="rounded-xl px-4 py-2.5 text-sm font-semibold text-indigo-700 transition-all duration-200 hover:bg-indigo-50 hover:text-indigo-800"
                    >
                        書籍一覧
                    </a>
                    <a
                        href="{{ route('books.create') }}"
                        class="inline-flex items-center rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md shadow-indigo-500/25 ring-1 ring-white/10 transition-all duration-200 hover:brightness-110 hover:shadow-lg hover:shadow-indigo-500/30"
                    >
                        ＋ 書籍登録
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button
                            type="submit"
                            class="rounded-xl border border-slate-200/90 bg-white/80 px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
                        >
                            ログアウト
                        </button>
                    </form>
                @endauth
            </nav>
        </div>
    </header>
    <main class="mx-auto max-w-5xl px-4 py-8 sm:px-6 sm:py-10 lg:px-8">
        @yield('content')
    </main>
    @stack('scripts')
</body>
</html>
