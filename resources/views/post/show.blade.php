<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{$post->title}}
        </h2>
    </x-slot>
    <div>
        {!!  $post->content !!}
    </div>
</x-app-layout>
