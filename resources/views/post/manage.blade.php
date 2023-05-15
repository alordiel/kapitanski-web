<x-app-layout>
    <x-slot name="header">
        <x-subheader title="All posts" url="{{route('post.admin.create')}}" icon="add" button-text="Add new"/>
    </x-slot>

    @if(session()->has('message'))
        <x-success-message message="{{session('message')}}"/>
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
                    <h3><a href="{{route('post',['post' => $post])}}" title="View">{{$post->title}} </a></h3>
                    <span>{{$post->created_on}}</span>
                    <div class="line-actions">
                        <x-edit-entry url="{{route('post.admin.edit',['post' => $post])}}" title="Edit post"/>
                        <x-delete-entry url="{{route('post.admin.destroy',['post' => $post])}}"
                                        button-title="Delete post" entry="post"/>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <h3>No posts were found</h3>
    @endif
</x-app-layout>
