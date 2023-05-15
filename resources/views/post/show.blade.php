<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-between">
            {{$post->title}}
            <span>
                 @role('super-admin')
                        <x-edit-entry url="{{route('post.admin.edit',['post' => $post])}}" title="Edit post"/>
                        <x-delete-entry url="{{route('post.admin.destroy',['post' => $post])}}"
                                        button-title="Delete post" entry="post"/>
                @endrole
            </span>
        </h2>
    </x-slot>
    <div>
        {!!  $post->content !!}
    </div>
</x-app-layout>
