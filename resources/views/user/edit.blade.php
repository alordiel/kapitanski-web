<?php
use Spatie\Permission\Models\Role;
?>
<x-app-layout>
    <x-subheader title="Edit User" url="{{route('user.admin.manage')}}" icon="all" button-text="All users"/>
    <div class="w-1/2">
        <form method="POST" action="{{ route('user.admin.update',['user'=>$user]) }}">
            @csrf
            @method('PUT')
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')"/>
                <x-text-input
                    id="name"
                    class="block mt-1 w-full"
                    type="text"
                    name="name"
                    :value="$user->name"
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
                    name="email"
                    :value="$user->email"
                    required
                    autocomplete="username"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
            </div>

            <div class="mt-4">
                <x-input-label for="role" :value="__('Role')"/>
                <?php $user_role = $user->getRoleNames()->first(); ?>

                <select
                    name="role"
                    id="role"
                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                >
                    @foreach(Role::all()->pluck('name') as $role)
                        <option value="{{$role}}" @selected($role === $user_role)>{{$role}}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('password')" class="mt-2"/>
            </div>

            <x-primary-button class="mt-4 ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </form>
    </div>
</x-app-layout>
