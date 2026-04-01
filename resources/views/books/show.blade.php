@extends('layouts.navigation')

@section('title', '書籍詳細')

@section('content')
    <div class="mb-8">
        <p class="mb-1 text-sm font-semibold uppercase tracking-wider text-indigo-600/90">Detail</p>
        <h1 class="bg-gradient-to-r from-slate-900 via-indigo-900 to-violet-900 bg-clip-text text-3xl font-bold tracking-tight text-transparent sm:text-4xl">
            書籍詳細
        </h1>
    </div>

    <div class="rounded-3xl border border-white/60 bg-white/90 p-6 shadow-xl shadow-slate-200/50 ring-1 ring-slate-900/5 backdrop-blur-sm sm:p-8">
        @if (session('success'))
            <div class="mb-8 flex items-start gap-3 rounded-2xl border border-emerald-200/80 bg-gradient-to-r from-emerald-50 to-teal-50/80 px-5 py-4 text-emerald-900 shadow-sm ring-1 ring-emerald-500/10">
                <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-500 text-white shadow-sm">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </span>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <dl class="grid gap-4 sm:grid-cols-2">
            <div class="rounded-2xl border border-slate-100 bg-gradient-to-br from-slate-50/80 to-indigo-50/30 p-5 ring-1 ring-slate-900/5">
                <dt class="text-xs font-bold uppercase tracking-wider text-indigo-600/80">ID</dt>
                <dd class="mt-2 text-2xl font-bold tabular-nums text-slate-900">{{ $book->id }}</dd>
            </div>
            <div class="rounded-2xl border border-slate-100 bg-gradient-to-br from-slate-50/80 to-violet-50/30 p-5 ring-1 ring-slate-900/5 sm:col-span-2">
                <dt class="text-xs font-bold uppercase tracking-wider text-violet-600/80">タイトル</dt>
                <dd class="mt-2 text-lg font-semibold leading-snug text-slate-900">{{ $book->title }}</dd>
            </div>
            <div class="rounded-2xl border border-slate-100 bg-white p-5 ring-1 ring-slate-900/5">
                <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">著者名</dt>
                <dd class="mt-2 font-medium text-slate-900">{{ $book->author ?? '—' }}</dd>
            </div>
            <div class="rounded-2xl border border-slate-100 bg-white p-5 ring-1 ring-slate-900/5">
                <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">ISBN</dt>
                <dd class="mt-2 font-mono text-sm font-semibold tracking-wide text-slate-800">{{ $book->isbn ?? '—' }}</dd>
            </div>
            <div class="rounded-2xl border border-slate-100 bg-white p-5 ring-1 ring-slate-900/5">
                <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">カテゴリ</dt>
                <dd class="mt-2">
                    <span class="inline-flex rounded-full bg-violet-100 px-3 py-1.5 text-sm font-semibold text-violet-800 ring-1 ring-violet-200/60">
                        {{ $book->category?->title ?? '—' }}
                    </span>
                </dd>
            </div>
            <div class="rounded-2xl border border-slate-100 bg-white p-5 ring-1 ring-slate-900/5">
                <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">価格</dt>
                <dd class="mt-2 text-xl font-bold tabular-nums text-indigo-900">¥{{ number_format($book->price) }}</dd>
            </div>
            <div class="rounded-2xl border border-slate-100 bg-slate-50/50 p-5 ring-1 ring-slate-900/5">
                <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">出版日</dt>
                <dd class="mt-2 font-mono text-sm text-slate-700">{{ $book->published_at?->format('Y-m-d') ?? '—' }}</dd>
            </div>
            <div class="rounded-2xl border border-slate-100 bg-slate-50/50 p-5 ring-1 ring-slate-900/5 sm:col-span-2">
                <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">説明文</dt>
                <dd class="mt-2 whitespace-pre-wrap text-sm leading-relaxed text-slate-700">{{ $book->description ? $book->description : '—' }}</dd>
            </div>
            <div class="rounded-2xl border border-slate-100 bg-slate-50/50 p-5 ring-1 ring-slate-900/5">
                <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">登録日時</dt>
                <dd class="mt-2 font-mono text-sm text-slate-700">{{ $book->created_at?->format('Y-m-d H:i') }}</dd>
            </div>
            <div class="rounded-2xl border border-slate-100 bg-slate-50/50 p-5 ring-1 ring-slate-900/5">
                <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">更新日時</dt>
                <dd class="mt-2 font-mono text-sm text-slate-700">{{ $book->updated_at?->format('Y-m-d H:i') }}</dd>
            </div>
        </dl>

        <div class="mt-8 flex flex-wrap items-center gap-3 border-t border-slate-100 pt-8">
            <a
                href="{{ route('books.edit', $book) }}"
                class="inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-indigo-600 to-violet-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/30 transition hover:brightness-110"
            >
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                編集画面へ
            </a>
            <form class="inline" action="{{ route('books.destroy', $book) }}" method="POST" onsubmit="return confirm('この書籍を削除しますか？');">
                @csrf
                @method('DELETE')
                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-2xl border border-rose-200 bg-rose-50 px-6 py-3 text-sm font-semibold text-rose-700 transition hover:bg-rose-100"
                >
                    削除
                </button>
            </form>
            <a href="{{ route('books.index') }}" class="inline-flex items-center rounded-2xl px-5 py-3 text-sm font-semibold text-indigo-700 transition hover:bg-indigo-50">
                ← 一覧へ戻る
            </a>
        </div>
    </div>
@endsection
