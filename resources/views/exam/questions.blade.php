<x-app-layout>
    <x-slot name="header">
        <x-subheader title="{{$exam->name}}" icon="all" button-text="All exams" url="{{route('exam.admin.manage')}}"/>
    </x-slot>

    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>

    <div id="app">@{{ message }}</div>

    <script>
        const {createApp} = Vue

        createApp({
            data() {
                return {
                    message: 'Hello Vue!'
                }
            }
        }).mount('#app')
    </script>
</x-app-layout>
