@extends('layouts.navigation')

@section('title', '書籍一覧')

@section('content')
    @php
        $sortLink = function (string $col) use ($sort, $dir) {
            $nextDir = ($sort === $col && $dir === 'asc') ? 'desc' : 'asc';
            if ($sort !== $col) {
                $nextDir = 'asc';
            }

            return request()->fullUrlWithQuery([
                'sort' => $col,
                'dir' => $nextDir,
                'page' => 1,
            ]);
        };
        $sortLabels = [
            'category' => 'カテゴリ',
            'id' => 'ID',
            'title' => 'タイトル',
            'author' => '著者',
            'price' => '価格',
            'published_at' => '発売日',
            'created_at' => '登録日',
        ];
    @endphp
    <div class="mb-6 flex flex-col gap-6 lg:mb-8 lg:flex-row lg:items-start">
        <div class="min-w-0 min-h-0 flex-1">
            <p class="mb-1 text-sm font-semibold uppercase tracking-wider text-indigo-600/90">Catalog</p>
            <h1 class="bg-gradient-to-r from-slate-900 via-indigo-900 to-violet-900 bg-clip-text text-3xl font-bold tracking-tight text-transparent sm:text-4xl">
                書籍一覧
            </h1>
            <p class="mt-2 max-w-xl text-sm text-slate-600">登録済みの書籍を確認・編集できます。</p>
        </div>
        <aside class="ms-auto box-border flex w-full max-w-[280px] shrink-0 flex-col gap-2 lg:w-[280px] lg:max-w-[280px]">
            <a
                href="{{ route('books.create') }}"
                class="flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md shadow-indigo-500/25 ring-1 ring-white/15 transition hover:brightness-110"
            >
                <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                新規登録
            </a>
            <div class="box-border w-full rounded-xl border border-slate-200/90 bg-white/95 p-2.5 shadow-sm ring-1 ring-slate-900/[0.04]">
                <form action="{{ route('books.index') }}" method="GET" class="space-y-2" role="search">
                    <input type="hidden" name="sort" value="{{ $sort }}">
                    <input type="hidden" name="dir" value="{{ $dir }}">
                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                    <label for="book-search-q" class="block text-[10px] font-bold uppercase tracking-wide text-slate-500">検索</label>
                    <div class="flex min-w-0 gap-1.5">
                        <div class="relative min-w-0 flex-1 overflow-hidden">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2 text-slate-400">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </span>
                            <input
                                type="search"
                                id="book-search-q"
                                name="q"
                                value="{{ $searchQuery }}"
                                autocomplete="off"
                                placeholder="キーワード"
                                class="w-full rounded-lg border border-slate-200 bg-slate-50/90 py-2 pl-8 pr-2 text-xs text-slate-800 placeholder:text-slate-400 focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20"
                            >
                        </div>
                        <button
                            type="submit"
                            class="shrink-0 rounded-lg bg-indigo-600 px-3 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-indigo-700"
                        >
                            検索
                        </button>
                    </div>
                    @if ($searchQuery !== '')
                        <a
                            href="{{ route('books.index', array_merge(request()->except(['q', 'page']), ['page' => 1])) }}"
                            class="block text-center text-[11px] font-medium text-slate-500 underline-offset-2 hover:text-indigo-600 hover:underline"
                        >
                            条件をクリア
                        </a>
                    @endif
                </form>
            </div>
        </aside>
    </div>

    <div class="mb-4 flex flex-col gap-3 rounded-2xl border border-slate-200/80 bg-white/70 px-4 py-3 shadow-sm ring-1 ring-slate-900/[0.03] sm:flex-row sm:flex-wrap sm:items-end sm:justify-between">
        <form method="GET" action="{{ route('books.index') }}" class="flex flex-wrap items-end gap-3">
            @if ($searchQuery !== '')
                <input type="hidden" name="q" value="{{ $searchQuery }}">
            @endif
            <div class="flex flex-col gap-1">
                <label for="book-per-page" class="text-[10px] font-bold uppercase tracking-wide text-slate-500">表示件数</label>
                <select
                    id="book-per-page"
                    name="per_page"
                    class="rounded-lg border border-slate-200 bg-white px-2.5 py-2 text-xs font-medium text-slate-800 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20"
                >
                    @foreach ($perPageOptions as $opt)
                        <option value="{{ $opt }}" @selected((int) $perPage === (int) $opt)>{{ $opt }} 件</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col gap-1">
                <label for="book-sort" class="text-[10px] font-bold uppercase tracking-wide text-slate-500">並び替え</label>
                <select
                    id="book-sort"
                    name="sort"
                    class="min-w-[9rem] rounded-lg border border-slate-200 bg-white px-2.5 py-2 text-xs font-medium text-slate-800 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20"
                >
                    @foreach ($sortLabels as $key => $label)
                        <option value="{{ $key }}" @selected($sort === $key)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col gap-1">
                <label for="book-sort-dir" class="text-[10px] font-bold uppercase tracking-wide text-slate-500">順序</label>
                <select
                    id="book-sort-dir"
                    name="dir"
                    class="rounded-lg border border-slate-200 bg-white px-2.5 py-2 text-xs font-medium text-slate-800 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20"
                >
                    <option value="asc" @selected($dir === 'asc')>昇順</option>
                    <option value="desc" @selected($dir === 'desc')>降順</option>
                </select>
            </div>
            <input type="hidden" name="page" value="1">
            <button
                type="submit"
                class="shrink-0 rounded-lg border border-indigo-700/80 bg-indigo-600 px-4 py-2 text-xs font-semibold text-white shadow-sm shadow-indigo-500/20 transition hover:bg-indigo-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2"
            >
                反映
            </button>
        </form>
        <p class="text-sm text-slate-600 sm:text-right">
            @if ($books->total() > 0)
                全 <span class="font-semibold text-slate-800">{{ number_format($books->total()) }}</span> 件中
                <span class="font-semibold text-indigo-700">{{ number_format($books->firstItem()) }}</span>
                〜
                <span class="font-semibold text-indigo-700">{{ number_format($books->lastItem()) }}</span>
                件を表示
                <span class="mt-1 block text-[11px] text-slate-500 sm:mt-0 sm:inline sm:before:content-['_']">
                    （{{ $sortLabels[$sort] ?? $sort }}・{{ $dir === 'asc' ? '昇順' : '降順' }}）
                </span>
            @else
                <span class="font-semibold text-slate-800">0</span> 件
                @if ($searchQuery !== '')
                    <span class="mt-1 block text-[11px] text-slate-500">キーワード「{{ $searchQuery }}」に一致する書籍はありません。</span>
                @endif
            @endif
        </p>
    </div>

    @if (session('success'))
        <div class="mb-6 flex items-start gap-3 rounded-2xl border border-emerald-200/80 bg-gradient-to-r from-emerald-50 to-teal-50/80 px-5 py-4 text-emerald-900 shadow-sm ring-1 ring-emerald-500/10">
            <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-500 text-white shadow-sm">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </span>
            <p class="text-sm font-medium leading-relaxed">{{ session('success') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 flex items-start gap-3 rounded-2xl border border-rose-200/80 bg-gradient-to-r from-rose-50 to-red-50/80 px-5 py-4 text-rose-900 shadow-sm ring-1 ring-rose-500/10">
            <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-rose-500 text-white shadow-sm">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </span>
            <p class="text-sm font-medium leading-relaxed">{{ session('error') }}</p>
        </div>
    @endif

    @if ($books->total() === 0 && $searchQuery === '')
        <div class="rounded-3xl border border-white/60 bg-white/80 p-10 text-center shadow-xl shadow-slate-200/50 ring-1 ring-slate-900/5 backdrop-blur-sm">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-100 to-violet-100 text-indigo-600">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <p class="text-lg font-semibold text-slate-800">まだ書籍が登録されていません</p>
            <p class="mt-2 text-sm text-slate-600">最初の1冊を登録してみましょう。</p>
            <a
                href="{{ route('books.create') }}"
                class="mt-6 inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-indigo-600 to-violet-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/30 transition hover:brightness-110"
            >
                最初の書籍を登録
            </a>
        </div>
    @elseif ($books->total() === 0)
        <div class="rounded-3xl border border-white/60 bg-white/80 p-10 text-center shadow-xl shadow-slate-200/50 ring-1 ring-slate-900/5 backdrop-blur-sm">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-500">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <p class="text-lg font-semibold text-slate-800">検索条件に一致する書籍がありません</p>
            <p class="mt-2 text-sm text-slate-600">別のキーワードを試すか、条件をクリアしてください。</p>
            <a
                href="{{ route('books.index', array_merge(request()->except(['q', 'page']), ['page' => 1])) }}"
                class="mt-6 inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
            >
                一覧をすべて表示
            </a>
        </div>
    @else
        <div class="overflow-hidden rounded-3xl border border-white/60 bg-white/90 shadow-xl shadow-slate-200/50 ring-1 ring-slate-900/5 backdrop-blur-sm">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[720px] text-left text-sm">
                    <thead>
                        <tr class="bg-gradient-to-r from-slate-800 via-indigo-900 to-violet-900 text-white">
                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-indigo-100/90">
                                <a href="{{ $sortLink('id') }}" class="inline-flex items-center gap-1 rounded-md py-0.5 text-indigo-100/90 ring-white/0 transition hover:text-white hover:ring-1 hover:ring-white/25 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/40">
                                    ID
                                    @if ($sort === 'id')
                                        <span class="tabular-nums opacity-90" aria-hidden="true">{{ $dir === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-indigo-100/90">
                                <a href="{{ $sortLink('title') }}" class="inline-flex items-center gap-1 rounded-md py-0.5 text-indigo-100/90 ring-white/0 transition hover:text-white hover:ring-1 hover:ring-white/25 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/40">
                                    タイトル
                                    @if ($sort === 'title')
                                        <span class="tabular-nums opacity-90" aria-hidden="true">{{ $dir === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-indigo-100/90">
                                <a href="{{ $sortLink('author') }}" class="inline-flex items-center gap-1 rounded-md py-0.5 text-indigo-100/90 ring-white/0 transition hover:text-white hover:ring-1 hover:ring-white/25 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/40">
                                    著者
                                    @if ($sort === 'author')
                                        <span class="tabular-nums opacity-90" aria-hidden="true">{{ $dir === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-indigo-100/90">
                                <a href="{{ $sortLink('category') }}" class="inline-flex items-center gap-1 rounded-md py-0.5 text-indigo-100/90 ring-white/0 transition hover:text-white hover:ring-1 hover:ring-white/25 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/40">
                                    カテゴリ
                                    @if ($sort === 'category')
                                        <span class="tabular-nums opacity-90" aria-hidden="true">{{ $dir === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-indigo-100/90">
                                <a href="{{ $sortLink('price') }}" class="inline-flex items-center gap-1 rounded-md py-0.5 text-indigo-100/90 ring-white/0 transition hover:text-white hover:ring-1 hover:ring-white/25 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/40">
                                    価格
                                    @if ($sort === 'price')
                                        <span class="tabular-nums opacity-90" aria-hidden="true">{{ $dir === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-indigo-100/90">操作</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($books as $book)
                            <tr class="transition-colors duration-150 hover:bg-indigo-50/40">
                                <td class="whitespace-nowrap px-5 py-4">
                                    <a href="{{ route('books.show', $book) }}" class="inline-flex h-8 min-w-8 items-center justify-center rounded-lg bg-indigo-100 px-2 text-sm font-bold text-indigo-800 transition hover:bg-indigo-200">
                                        {{ $book->id }}
                                    </a>
                                </td>
                                <td class="px-5 py-4 font-medium text-slate-800">{{ $book->title }}</td>
                                <td class="max-w-[10rem] truncate px-5 py-4 text-slate-600" title="{{ $book->author }}">{{ $book->author ?? '—' }}</td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex rounded-full bg-violet-100 px-3 py-1 text-xs font-semibold text-violet-800 ring-1 ring-violet-200/60">
                                        {{ $book->category?->title ?? '—' }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 font-semibold tabular-nums text-slate-700">
                                    ¥{{ number_format($book->price) }}
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <a
                                            href="{{ route('books.show', $book) }}"
                                            class="inline-flex items-center justify-center rounded-xl bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-700 ring-1 ring-slate-200/80 transition hover:bg-slate-200"
                                        >
                                            詳細
                                        </a>
                                        <a
                                            href="{{ route('books.edit', $book) }}"
                                            class="inline-flex items-center justify-center rounded-xl bg-indigo-50 px-3 py-2 text-xs font-semibold text-indigo-700 ring-1 ring-indigo-200/80 transition hover:bg-indigo-100"
                                        >
                                            編集
                                        </a>
                                        <form class="inline" action="{{ route('books.destroy', $book) }}" method="POST" onsubmit="return confirm('この書籍を削除しますか？');">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="inline-flex items-center justify-center rounded-xl bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-700 ring-1 ring-rose-200/80 transition hover:bg-rose-100"
                                            >
                                                削除
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8 flex justify-center px-2">
            {{ $books->links('pagination::tailwind') }}
        </div>
    @endif
@endsection
