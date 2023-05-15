<x-app-layout>
    <x-slot name="header">
        <x-subheader title="Add user" icon="add" button-text="Add user" url="{{route('user.admin.create')}}"/>
    </x-slot>
    <div>
        @foreach($users as $user)
            <p>
                {{$user->name}} | {{$user->email}} | {{$user->getRoleNames()->first() }} |
                <a href="/admin/users/{{$user->id}}/edit">(edit)</a> | <a href="/admin/users/{{$user->id}}">(view)</a> |
                <x-delete-entry url="{{route('user.admin.destroy',['user' => $user])}}" button-title="Delete user" entry="user" />
            </p>
        @endforeach
    </div>
</x-app-layout>
