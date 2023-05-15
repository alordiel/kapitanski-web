<?php

use Spatie\Permission\Models\Role;

?>
<x-app-layout>

    <x-subheader title="Add User" url="{{route('user.admin.manage')}}" icon="all" button-text="All users"/>

    <div class="w-1/2">
        <form method="POST" action="{{ route('user.admin.store') }}">
            @csrf
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')"/>
                <x-text-input
                    id="name"
                    class="block mt-1 w-full"
                    type="text"
                    name="name"
                    value="{{old('name')}}"
                    required
                    autofocus
                    autocomplete="name"
                />
                <x-input-error :messages="$errors->get('name')" class="mt-2"/>
            </div>

            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')"/>
                <x-text-input
                    id="email"
                    class="block mt-1 w-full"
                    type="email"
                    value="{{old('email')}}"
                    name="email"
                    required
                    autocomplete="username"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
            </div>

            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')"/>

                <x-text-input id="password" class="block mt-1 w-full"
                              type="text"
                              name="password"
                              required
                              autocomplete="new-password"
                />

                <x-input-error :messages="$errors->get('password')" class="mt-2"/>
            </div>

            <div class="mt-4">
                <x-input-label for="role" :value="__('Role')"/>

                <select
                    name="role"
                    id="role"
                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                >
                    @foreach(Role::all()->pluck('name') as $role)
                        <option value="{{$role}}">{{$role}}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2"/>
            </div>

            <x-primary-button class="mt-4">
                {{ __('Register') }}
            </x-primary-button>
        </form>
    </div>
</x-app-layout>
