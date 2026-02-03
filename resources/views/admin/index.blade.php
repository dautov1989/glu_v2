@extends('layouts.admin')

@section('title', 'Консоль')

@section('content')
    <div class="bg-white shadow-sm border border-gray-200 p-6 rounded-sm">
        <h2 class="text-2xl font-normal text-gray-800 mb-4">Добро пожаловать в админ-панель {{ config('app.name') }}!</h2>
        <p class="text-gray-600 mb-6">Мы подготовили несколько ссылок, чтобы вы могли приступить к работе:</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-lg font-medium text-gray-800 mb-3">Первые шаги</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('admin.comments') }}" class="text-blue-600 hover:underline">Управление
                            комментариями</a></li>
                    <li><a href="{{ route('admin.affiliate-links.index') }}"
                            class="text-blue-600 hover:underline">Партнерские ссылки</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-medium text-gray-800 mb-3">Быстрые действия</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-blue-600 hover:underline">Посмотреть сайт</a></li>
                    <li><a href="{{ route('profile.edit') }}" class="text-blue-600 hover:underline">Настроить профиль</a>
                    </li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-medium text-gray-800 mb-3">Информация</h3>
                <p class="text-sm text-gray-500">Вы вошли как: <strong>{{ auth()->user()->email }}</strong></p>
                <p class="text-sm text-gray-500 mt-1">Статус: <strong>Администратор</strong></p>
            </div>
        </div>
    </div>
@endsection