<x-app-layout>
    <x-slot name="header">
        <x-subheader title="{{$user->name}}" icon="all" button-text="All users" url="{{route('user.admin.manage')}}"/>
    </x-slot>
    <div>
        <p>Name: {{$user->name}}</p>
        <p>Email: {{$user->email}}</p>
        <p>Role: {{$user->getRoleNames()->first()}}</p>
        <p>Registered on: {{$user->created_at}}</p>
    </div>
</x-app-layout>
