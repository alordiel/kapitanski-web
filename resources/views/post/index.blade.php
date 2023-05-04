<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Posts') }}
            </h2>
        </div>
    </x-slot>

    @if(count($posts) > 0)
        <div class="grid grid-cols-2 gap-4 max-sm:grid-cols-1 max-sm:gap-1">
            @foreach($posts as $post)
                <div class="px-4 py-2 text-sm dark:text-white rounded-md border-indigo-500 dark:border-sky-500 border-2 border-solid">
                    <h2 class="text-xl font-bold">
                        <a href="/posts/{{$post->slug}}" title="View">{{$post->title}} </a>
                    </h2>
                    <p>{{date('Y-m-d',strtotime($post->created_at))}}</p>
                    <p class="my-6">{{$post->excerpt}}</p>
                    <p class="mb-4">
                        <a class="px-4 py-2 font-semibold text-sm bg-white text-slate-700 dark:bg-slate-700 dark:text-white rounded-md border-indigo-500 border" href="/posts/{{$post->slug}}">{{__('Read more')}}</a>
                    </p>
                </div>
            @endforeach
        </div>
    @else
        <h3>No posts were found</h3>
    @endif
</x-app-layout>
