<div class="flex">
    @auth
        <div class="space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <x-nav-link :href="route('posts')" :active="request()->routeIs('posts')">
                {{ __('Blog') }}
            </x-nav-link>
        </div>
        <div class="space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <x-nav-link :href="route('my-exam')" :active="request()->routeIs('dashboard')">
                {{ __('Exams') }}
            </x-nav-link>
        </div>
        @role('member')
        <div class="space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <x-nav-link :href="route('buy')" :active="request()->routeIs('buy')">
                {{ __('Exams') }}
            </x-nav-link>
        </div>
        @endrole
    @endauth
    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
        <x-nav-link :href="route('buy')" :active="request()->routeIs('buy')">
            {{ __('Buy') }}
        </x-nav-link>
    </div>
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
