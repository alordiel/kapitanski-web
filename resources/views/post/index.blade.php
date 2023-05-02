<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage posts') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 dark:text-white">
        @if(session()->has('message'))
            <p style='color:green'>{{session('message')}}</p>
        @endif
        @if(count($posts) > 0)
            <h1>List of Posts</h1>
            <ul class="list-of-posts">
                <li>
                    <span class="post-name"><strong>Title</strong></span>
                    <span class="price"><strong>Created on</strong></span>
                    <span class="line-actions"><strong>Manage</strong></span>
                </li>
                @foreach($posts as $post)
                    <li>
            <span class="post-name">
                <a href="/posts/{{$post->id}}" title="View">{{$post->title}} </a>
            </span>
                        <span class="price">{{$post->created_on}}</span>
                        <div class="line-actions">
                <span class="edit">
                    <a href="/posts/{{$post->id}}/edit" title="edit">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em"
                             width="1em" xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M0 0h24v24H0z"></path><path
                                d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 5.63l-2.34-2.34a.996.996 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83a.996.996 0 000-1.41z"></path></svg>
                    </a>
                </span>
                            <form method="POST" action="/posts/{{$post->id}}">
                                @csrf
                                @method('DELETE')
                                <button class="delete" type="submit">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24"
                                         height="1em"
                                         width="1em" xmlns="http://www.w3.org/2000/svg">
                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                        <path
                                            fill="none" d="M0 0h24v24H0V0z"></path>
                                        <path
                                            d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zm2.46-7.12l1.41-1.41L12 12.59l2.12-2.12 1.41 1.41L13.41 14l2.12 2.12-1.41 1.41L12 15.41l-2.12 2.12-1.41-1.41L10.59 14l-2.13-2.12zM15.5 4l-1-1h-5l-1 1H5v2h14V4z"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <h3>No posts were found</h3>
        @endif
    </div>
</x-app-layout>
