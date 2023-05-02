<div class="flex">
    @auth
        <div class="space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Exams') }}
            </x-nav-link>
        </div>
    @endauth
    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
        <x-nav-link :href="route('contacts')" :active="request()->routeIs('contacts')">
            {{ __('Contacts') }}
        </x-nav-link>
    </div>
    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
        <x-nav-link :href="route('about')" :active="request()->routeIs('about')">
            {{ __('About') }}
        </x-nav-link>
    </div>
</div>
