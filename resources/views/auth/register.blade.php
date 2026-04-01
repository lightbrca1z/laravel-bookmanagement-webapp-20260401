@extends('layouts.guest')

@section('title', '会員登録')

@section('content')
    <div class="w-full max-w-md shrink-0">
        <div class="rounded-3xl border border-slate-200/80 bg-white p-8 shadow-xl shadow-slate-200/40 ring-1 ring-slate-900/5 sm:p-9">
            <h1 class="text-center text-2xl font-bold tracking-tight text-slate-900">会員登録</h1>
            <p class="mt-2 text-center text-sm leading-relaxed text-slate-600">
                アカウントを作成して書籍を管理できます。
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

            <form method="POST" action="{{ route('register.store') }}" class="mt-8 space-y-5">
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
                        placeholder="半角英数字・_・-（例: my_user）"
                    >
                    <p class="text-[11px] text-slate-500">ログイン時に使います。重複できません。</p>
                </div>
                <div class="space-y-1.5">
                    <label for="name" class="block text-xs font-bold uppercase tracking-wide text-slate-500">お名前</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autocomplete="name"
                        class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30"
                    >
                </div>
                <div class="space-y-1.5">
                    <label for="email" class="block text-xs font-bold uppercase tracking-wide text-slate-500">メールアドレス</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30"
                    >
                </div>
                <div class="space-y-1.5">
                    <label for="password" class="block text-xs font-bold uppercase tracking-wide text-slate-500">パスワード</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30"
                    >
                    <p class="text-[11px] text-slate-500">8文字以上で入力してください。</p>
                </div>
                <div class="space-y-1.5">
                    <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wide text-slate-500">パスワード（確認）</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30"
                    >
                </div>
                <button
                    type="submit"
                    class="flex w-full items-center justify-center rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 py-3 text-sm font-semibold text-white shadow-md shadow-indigo-500/25 ring-1 ring-white/10 transition hover:brightness-110 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2"
                >
                    登録する
                </button>
            </form>

            <p class="mt-8 text-center text-sm text-slate-600">
                すでにアカウントをお持ちですか？
                <a href="{{ route('login') }}" class="font-semibold text-indigo-600 underline-offset-2 hover:text-indigo-800 hover:underline">ログイン</a>
            </p>
        </div>
    </div>
@endsection
