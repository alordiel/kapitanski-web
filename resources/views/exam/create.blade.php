Creating a new exam
<x-layout>
    <h1>Create new exam</h1>
    <form action="/exams" method="POST">
        @csrf
        <p>
            <label for="exam-name">
                Product name <br>
                <input type="text" id="exam-name" name="exam_name" value={{old("exam_name")}}>
            </label>
            @error('exam_name')
            <br>
            <small style="color:red">{{$message}}</small>
            @enderror

        </p>
        <p>
            <label for="price">
                Price <br>
                <input type="number" min="1.00" placeholder="exam price" id="price" name="price" value={{old("price")}}>
            </label>
            @error('price')
            <br>
            <small style="color:red">{{$message}}</small>
            @enderror
        </p>
        <button type="submit">Create</button>
        <input type="hidden" value="0" name="exam_order">
        <input type="hidden" value="Product description" name="description">
        <input type="hidden" value="1" name="number_of_credits">
    </form>
</x-layout>
