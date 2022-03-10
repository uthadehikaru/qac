<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route(Auth::user()->is_member?'member.dashboard':'admin.dashboard')" :active="request()->is('*dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @can('is-admin')
                    <x-nav-link :href="route('admin.members.index')" :active="request()->is('admin/members*')">
                        {{ __('Members') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.courses.index')" :active="request()->is('admin/courses*')">
                        {{ __('Courses') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.testimonials.index')" :active="request()->is('admin/testimonials*')">
                        {{ __('Testimonials') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.certificates.index')" :active="request()->is('admin/certificates*')">
                        {{ __('Certificates') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.events.index')" :active="request()->is('admin/events*')">
                        {{ __('Events') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.quiz.index')" :active="request()->is('admin/quiz*')">
                        {{ __('Quizzes') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.systems.index')" :active="request()->is('admin/systems*')">
                        {{ __('Settings') }}
                    </x-nav-link>
                    @elsecan('is-member')
                    <x-nav-link :href="route('member.profile')" :active="request()->is('member/profile')">
                        {{ __('Profile') }}
                    </x-nav-link>
                    <x-nav-link :href="route('member.password')" :active="request()->is('member/password')">
                        {{ __('Ubah Password') }}
                    </x-nav-link>
                    @endcan
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-nav-link :href="route('notifications')" class="mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                {{ Auth::user()->unreadNotifications()->count() }}
                </x-nav-link>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Logout') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route(Auth::user()->is_member?'member.dashboard':'admin.dashboard')" :active="request()->is('*dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @can('is-admin')
            <x-responsive-nav-link :href="route('admin.members.index')" :active="request()->is('admin/members*')">
                {{ __('Members') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.courses.index')" :active="request()->is('admin/courses*')">
                {{ __('Courses') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.testimonials.index')" :active="request()->is('admin/testimonials*')">
                        {{ __('Testimonials') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.certificates.index')" :active="request()->is('admin/certificates*')">
                        {{ __('Certificates') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.events.index')" :active="request()->is('admin/events*')">
                {{ __('Events') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.quiz.index')" :active="request()->is('admin/quiz*')">
                {{ __('Quizzes') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.systems.index')" :active="request()->is('admin/systems*')">
                {{ __('Settings') }}
            </x-responsive-nav-link>
            @elsecan('is-member')
            <x-responsive-nav-link :href="route('member.profile')" :active="request()->is('member/profile')">
                {{ __('Profile') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('member.password')" :active="request()->is('member/password')">
                {{ __('Ubah Password') }}
            </x-responsive-nav-link>
            @endcan
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                <div class="flex-shrink-0">
                    <svg class="h-10 w-10 fill-current text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>

                <div class="ml-3">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Logout') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
