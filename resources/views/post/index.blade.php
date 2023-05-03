<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Posts') }}
            </h2>
        </div>
    </x-slot>

    @if(count($posts) > 0)
        <h1>List of Posts</h1>
        <ul class="list-of-posts">
            @foreach($posts as $post)
                <li>
                    <span class="post-name">
                        <a href="/posts/{{$post->slug}}" title="View">{{$post->title}} </a>
                    </span><br>
                    <span class="price">{{$post->created_on}}</span>
                    <span>{{$post->excerpt}}</span>
                </li>
            @endforeach
        </ul>
    @else
        <h3>No posts were found</h3>
    @endif
</x-app-layout>
