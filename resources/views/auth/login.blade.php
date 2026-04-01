@extends('layouts.guest')

@section('title', 'ログイン')

@section('content')
    <div class="w-full max-w-md shrink-0">
        <div class="rounded-3xl border border-slate-200/80 bg-white p-8 shadow-xl shadow-slate-200/40 ring-1 ring-slate-900/5 sm:p-9">
            <h1 class="text-center text-2xl font-bold tracking-tight text-slate-900">ログイン</h1>
            <p class="mt-2 text-center text-sm leading-relaxed text-slate-600">
                ユーザーIDとパスワードで書籍一覧に入ります。
            </p>

            @if ($errors->any())
                <div class="mt-6 rounded-2xl border border-rose-200/90 bg-rose-50 px-4 py-3 text-sm text-rose-800 shadow-sm" role="alert">
                    <ul class="list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.attempt') }}" class="mt-8 space-y-5">
                @csrf
                <div class="space-y-1.5">
                    <label for="userid" class="block text-xs font-bold uppercase tracking-wide text-slate-500">ユーザーID</label>
                    <input
                        type="text"
                        id="userid"
                        name="userid"
                        value="{{ old('userid') }}"
                        required
                        autocomplete="username"
                        autofocus
                        class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30"
                        placeholder="例: test1"
                    >
                </div>
                <div class="space-y-1.5">
                    <label for="password" class="block text-xs font-bold uppercase tracking-wide text-slate-500">パスワード</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30"
                    >
                </div>
                <label class="flex cursor-pointer items-center gap-2.5 text-sm text-slate-600 select-none">
                    <input
                        type="checkbox"
                        name="remember"
                        value="1"
                        class="size-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500/40"
                    >
                    ログイン状態を保持する
                </label>
                <button
                    type="submit"
                    class="flex w-full items-center justify-center rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 py-3 text-sm font-semibold text-white shadow-md shadow-indigo-500/25 ring-1 ring-white/10 transition hover:brightness-110 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2"
                >
                    ログイン
                </button>
            </form>

            <p class="mt-8 text-center text-sm text-slate-600">
                はじめての方は
                <a href="{{ route('register') }}" class="font-semibold text-indigo-600 underline-offset-2 hover:text-indigo-800 hover:underline">会員登録</a>
            </p>
        </div>

        <p class="mt-6 rounded-2xl border border-slate-200/80 bg-white/80 px-4 py-3 text-center text-xs leading-relaxed text-slate-600 shadow-sm backdrop-blur-sm">
            デモ:
            <span class="font-mono font-semibold text-slate-800">test1</span>
            /
            <span class="font-mono font-semibold text-slate-800">test1234</span>
        </p>
    </div>
@endsection
