<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create new product') }}
        </h2>
    </x-slot>
    <h1>Update: {{$exam->exam_name}}</h1>
    <form action="/exams/{{$exam->id}}" method="POST">
        @csrf
        @method("PUT")
        <p>
            <label for="exam-name">
                Product name <br>
                <input type="text" id="exam-name" name="exam_name" value={{$exam->exam_name}}>
            </label>
            @error('exam_name')
                <br>
                <small style="color:red">{{$message}}</small>
            @enderror

        </p>
        <p>
            <label for="price">
                Price <br>
                <input type="number" min="1.00" placeholder="exam price" id="price" name="price" value={{$exam->price}}>
            </label>
            @error('price')
                <br>
                <small style="color:red">{{$message}}</small>
            @enderror
        </p>
        <button type="submit">Update</button>
    </form>
</x-app-layout>
