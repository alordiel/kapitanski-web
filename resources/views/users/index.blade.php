<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('All users') }}
            </h2>
            <a
                href="/admin/users/create"
                class="flex items-center justify-between rounded bg-primary px-6 pb-2 pt-2.5 text-base font-bold text-white transition duration-150 ease-in-out hover:bg-primary-600  focus:bg-primary-600  focus:outline-none focus:ring-0 active:bg-primary-700 ">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024" class="h-6 pr-2"
                     xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M854.6 288.6L639.4 73.4c-6-6-14.1-9.4-22.6-9.4H192c-17.7 0-32 14.3-32 32v832c0 17.7 14.3 32 32 32h640c17.7 0 32-14.3 32-32V311.3c0-8.5-3.4-16.7-9.4-22.7zM790.2 326H602V137.8L790.2 326zm1.8 562H232V136h302v216a42 42 0 0 0 42 42h216v494zM544 472c0-4.4-3.6-8-8-8h-48c-4.4 0-8 3.6-8 8v108H372c-4.4 0-8 3.6-8 8v48c0 4.4 3.6 8 8 8h108v108c0 4.4 3.6 8 8 8h48c4.4 0 8-3.6 8-8V644h108c4.4 0 8-3.6 8-8v-48c0-4.4-3.6-8-8-8H544V472z"></path>
                </svg>
                Add new
            </a>
        </div>
    </x-slot>
</x-app-layout>
