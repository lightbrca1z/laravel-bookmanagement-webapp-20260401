@extends('layouts.navigation')

@section('title', '書籍登録')

@section('content')
    <div class="mb-8">
        <p class="mb-1 text-sm font-semibold uppercase tracking-wider text-indigo-600/90">New book</p>
        <h1 class="bg-gradient-to-r from-slate-900 via-indigo-900 to-violet-900 bg-clip-text text-3xl font-bold tracking-tight text-transparent sm:text-4xl">
            書籍登録
        </h1>
        <p class="mt-2 text-sm text-slate-600">必須項目を入力して書籍を追加します。</p>
    </div>

    <div class="rounded-3xl border border-white/60 bg-white/90 p-6 shadow-xl shadow-slate-200/50 ring-1 ring-slate-900/5 backdrop-blur-sm sm:p-8">
        @if ($errors->any())
            <div class="mb-8 rounded-2xl border border-rose-200/80 bg-gradient-to-r from-rose-50 to-red-50/90 px-5 py-4 shadow-sm ring-1 ring-rose-500/10">
                <p class="mb-2 text-sm font-semibold text-rose-900">入力内容を確認してください</p>
                <ul class="list-inside list-disc space-y-1 text-sm text-rose-800">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('books.store') }}" method="POST" class="max-w-2xl space-y-6">
            @csrf
            <div>
                <label for="category_id" class="mb-2 block text-sm font-semibold text-slate-700">カテゴリ <span class="text-rose-600">*</span></label>
                <select
                    id="category_id"
                    name="category_id"
                    required
                    class="w-full rounded-2xl border border-slate-200/90 bg-slate-50/50 px-4 py-3.5 text-slate-800 shadow-inner shadow-slate-900/5 transition focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/15"
                >
                    <option value="">選択してください</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->title }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="title" class="mb-2 block text-sm font-semibold text-slate-700">タイトル <span class="text-rose-600">*</span></label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
                    required
                    maxlength="100"
                    class="w-full rounded-2xl border border-slate-200/90 bg-slate-50/50 px-4 py-3.5 text-slate-800 shadow-inner shadow-slate-900/5 transition placeholder:text-slate-400 focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/15"
                    placeholder="書籍名を入力（100文字以内）"
                >
            </div>
            <div>
                <label for="author" class="mb-2 block text-sm font-semibold text-slate-700">著者名 <span class="text-rose-600">*</span></label>
                <input
                    type="text"
                    id="author"
                    name="author"
                    value="{{ old('author') }}"
                    required
                    maxlength="100"
                    class="w-full rounded-2xl border border-slate-200/90 bg-slate-50/50 px-4 py-3.5 text-slate-800 shadow-inner shadow-slate-900/5 transition placeholder:text-slate-400 focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/15"
                    placeholder="著者名"
                >
            </div>
            <div>
                <label for="isbn" class="mb-2 block text-sm font-semibold text-slate-700">ISBN <span class="text-rose-600">*</span></label>
                <input
                    type="text"
                    id="isbn"
                    name="isbn"
                    value="{{ old('isbn') }}"
                    required
                    maxlength="17"
                    inputmode="numeric"
                    class="w-full max-w-md rounded-2xl border border-slate-200/90 bg-slate-50/50 px-4 py-3.5 font-mono text-slate-800 shadow-inner shadow-slate-900/5 transition placeholder:text-slate-400 focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/15"
                    placeholder="例: 9784003101018 または 4003101018"
                >
                <p class="mt-1.5 text-xs text-slate-500">ISBN-13（13桁）またはISBN-10（10桁・末尾は数字またはX）。ハイフンはあってもなくても構いません。</p>
            </div>
            <div>
                <label for="price" class="mb-2 block text-sm font-semibold text-slate-700">価格（円） <span class="text-rose-600">*</span></label>
                <input
                    type="number"
                    id="price"
                    name="price"
                    value="{{ old('price') }}"
                    required
                    min="0"
                    max="999999"
                    class="w-full max-w-xs rounded-2xl border border-slate-200/90 bg-slate-50/50 px-4 py-3.5 font-semibold tabular-nums text-slate-800 shadow-inner shadow-slate-900/5 transition focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/15"
                >
                <p class="mt-1.5 text-xs text-slate-500">半角数字の整数（円）のみ。</p>
            </div>
            <div>
                <label for="published_at" class="mb-2 block text-sm font-semibold text-slate-700">出版日 <span class="text-rose-600">*</span></label>
                <input
                    type="date"
                    id="published_at"
                    name="published_at"
                    value="{{ old('published_at') }}"
                    required
                    max="{{ now()->format('Y-m-d') }}"
                    class="w-full max-w-xs rounded-2xl border border-slate-200/90 bg-slate-50/50 px-4 py-3.5 font-mono text-slate-800 shadow-inner shadow-slate-900/5 transition focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/15"
                >
            </div>
            <div>
                <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">説明文</label>
                <textarea
                    id="description"
                    name="description"
                    rows="5"
                    maxlength="2000"
                    class="w-full rounded-2xl border border-slate-200/90 bg-slate-50/50 px-4 py-3.5 text-slate-800 shadow-inner shadow-slate-900/5 transition placeholder:text-slate-400 focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/15"
                    placeholder="任意（2000文字以内）"
                >{{ old('description') }}</textarea>
            </div>
            <div class="flex flex-wrap items-center gap-3 border-t border-slate-100 pt-8">
                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-indigo-600 to-violet-600 px-8 py-3.5 text-sm font-semibold text-white shadow-lg shadow-indigo-500/30 ring-1 ring-white/20 transition duration-200 hover:brightness-110 hover:shadow-xl"
                >
                    登録する
                </button>
                <a href="{{ route('books.index') }}" class="inline-flex items-center rounded-2xl px-5 py-3.5 text-sm font-semibold text-indigo-700 transition hover:bg-indigo-50">
                    ← 一覧へ戻る
                </a>
            </div>
        </form>
    </div>
@endsection
