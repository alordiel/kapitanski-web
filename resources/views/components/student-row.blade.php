@props(['index', 'name' => '', 'email' => '', 'errorEmail' => '', 'errorName' => ''])
@php
    $index++;
    $nameID = "name-" . $index;
    $nameErrorID = 'name-error-' . $index;
    $emailID = "email-" . $index;
    $emailErrorID = 'email-error-' . $index;
    $showDelete = $index !== 1;
@endphp
<div class="flex flex-wrap mb-4 items-center" data-number="{{$index}}">
    <div class="mr-5">
        <x-input-label for="{{$nameID}}" :value="__('Full name')"/>
        <x-text-input
            class="w-60 lg:w-72 xl:w-80"
            id="{{$nameID}}"
            name="{{$nameID}}"
            type="text"
            required
            value="{{$name}}"
        />
        <p class="text-sm text-red-600 dark:text-red-400 space-y-1" id="{{$emailErrorID}}">
            {{$errorName}}
        </p>
    </div>
    <div>
        <x-input-label for="{{$emailID}}" :value="__('Email')"/>
        <x-text-input
            class="w-60 lg:w-72 xl:w-80"
            id="{{$emailID}}"
            name="{{$emailID}}"
            type="email"
            value="{{$email}}"
            required
        />
        <p class="text-sm text-red-600 dark:text-red-400 space-y-1" id="{{$nameErrorID}}">
            {{$errorEmail}}
        </p>
    </div>
    @if($showDelete)
        <button
            class="remove-row rounded-full border-2 border-red-500 text-red-500 block w-7 h-7 ml-5 mt-4 flex items-center justify-center"
            type="button"
            onclick="this.parentElement.remove()"
        >
            X
        </button>
    @endif
</div>
