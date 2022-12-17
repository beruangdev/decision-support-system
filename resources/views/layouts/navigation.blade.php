<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                {{-- <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div> --}}

                <div class="flex space-x-2 sm:space-x-8 ml-3 sm:ml-10 items-center">
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-1 sm:px-2 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div class="mr-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                                    </svg>
                                </div>
                                <div>Project</div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('project.index')">
                                {{ __('All Project') }}
                            </x-dropdown-link>

                            <x-dropdown-link x-on:click.prevent="$dispatch('open-modal', 'modal-add-project')">
                                {{ __('Add Project') }}
                            </x-dropdown-link>

                        </x-slot>
                    </x-dropdown>
                </div>
                <div class="flex space-x-2 sm:space-x-8 items-center">
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-1 sm:px-2 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div class="mr-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                                    </svg>
                                </div>
                                <div>Alternative</div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('All Alternative') }}
                            </x-dropdown-link>
                            <x-dropdown-link x-on:click.prevent="$dispatch('open-modal', 'modal-add-alternative')">
                                {{ __('Add Alternative') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>



            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Project') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Alternative') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>


{{-- Modal ADD Project --}}
<x-modal name="modal-add-project" focusable>
    <form method="post" action="{{ route('project.store') }}" class="p-6">
        @csrf

        <h2 class="text-lg font-medium text-gray-900 flex">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 10.5v6m3-3H9m4.06-7.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
            </svg>


            {{ __('Add New Project') }}
        </h2>

        <div class="mt-6">
            <x-input-label for="project-name" value="Name" class="sr-only" />
            <x-text-input id="project-name" name="name" type="text" class="mt-1 block w-full" placeholder="Name" />
        </div>
        <div class="mt-2">
            <x-textarea name="description" id="project-description" class="w-full" placeholder="Project description..."></x-textarea>
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-secondary-button class="ml-3 bg-gray-700 text-white hover:bg-gray-900" type="submit">
                {{ __('Submit') }}
            </x-secondary-button>
        </div>
    </form>
</x-modal>
{{-- Modal ADD Project END --}}

{{-- Modal ADD Alternative --}}
<x-modal name="modal-add-alternative" focusable>
    <form method="post" action="{{ route('alternative.store') }}" class="p-6 form-add-alternative" x-data="storeAltenative($el)" x-init="initStoreAltenative" @submit.prevent="submitStoreAltenative">
        @csrf

        <h2 class="text-lg font-medium text-gray-900 flex flex-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
            </svg>
            {{ __('Add New Alternative') }}
        </h2>

        <div class="mt-6">
            <template x-if="body.name.error">
                <label for="alternative-name">
                    <p class="-mb-[0.8rem] px-2 py-1 bg-white relative ml-2 w-fit text-sm text-red-500 leading-3" x-text="body.name.message"></p>
                </label>
            </template>
            <x-text-input id="alternative-name" name="name" type="text" placeholder="Name" class="mt-1 block w-full" />
        </div>
        <div class="mt-2">
            <template x-if="body.nik.error">
                <label for="alternative-nik">
                    <p class="-mb-[0.8rem] px-2 py-1 bg-white relative ml-2 w-fit  text-sm text-red-500 leading-3" x-text="body.nik.message"></p>
                </label>
            </template>
            <x-text-input id="alternative-nik" name="nik" type="text" placeholder="Nomor Induk Kependudukan (NIK)" class="mt-1 block w-full" />
        </div>
        <div class="mt-2">
            <template x-if="body.nkk.error">
                <label for="alternative-nkk">
                    <p class="-mb-[0.8rem] px-2 py-1 bg-white relative ml-2 w-fit  text-sm text-red-500 leading-3" x-text="body.nkk.message"></p>
                </label>
            </template>
            <x-text-input id="alternative-nkk" name="nkk" type="text" class="mt-1 block w-full" placeholder="Nomor Kartu Keluarga" />
        </div>
        <div class="mt-2">
            <template x-if="body.address.error">
                <label for="alternative-address">
                    <p class="-mb-[0.8rem] px-2 py-1 bg-white relative ml-2 w-fit  text-sm text-red-500 leading-3" x-text="body.address.message"></p>
                </label>
            </template>
            <x-text-input id="alternative-address" name="address" type="text" class="mt-1 block w-full" placeholder="Address" />
        </div>
        <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-2">
            <div>
                <template x-if="body.phone.error">
                    <label for="alternative-phone">
                        <p class="-mb-[0.8rem] px-2 py-1 bg-white relative ml-2 w-fit  text-sm text-red-500 leading-3" x-text="body.phone.message"></p>
                    </label>
                </template>
                <x-text-input id="alternative-phone" name="phone" type="text" class="mt-1 block w-full" placeholder="Phone" />
            </div>

            <div>
                <template x-if="body.salary.error">
                    <label for="alternative-salary">
                        <p class="-mb-[0.8rem] px-2 py-1 bg-white relative ml-2 w-fit  text-sm text-red-500 leading-3" x-text="body.salary.message"></p>
                    </label>
                </template>
                <x-text-input id="alternative-salary" name="salary" type="text" class="mt-1 block w-full" placeholder="Salary" />
            </div>
        </div>



        <div class="mt-3 flex flex-wrap items-center">
            <label for="project-province" class="basis-full md:basis-3/12">Province</label>
            <div class="basis-full md:basis-9/12">
                <template x-if="body.province.error">
                    <label for="alternative-province" class="relative z-10 -mb-[0.8rem] px-2 py-1 bg-white ml-2 w-fit">
                        <p class="text-sm text-red-500 leading-3" x-text="body.province.message"></p>
                    </label>
                </template>
                <select name="province" id="project-province" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" disabled>
                    <option value="">-</option>
                </select>
            </div>
        </div>
        <div class="mt-3 flex flex-wrap items-center">
            <label for="project-kabupaten" class="basis-full md:basis-3/12">Kabupaten</label>
            <div class="basis-full md:basis-9/12">
                <template x-if="body.kabupaten.error">
                    <div class="relative z-10 -mb-[0.8rem] px-2 py-1 bg-white ml-2 w-fit">
                        <p class="text-sm text-red-500 leading-3" x-text="body.kabupaten.message"></p>
                    </div>
                </template>
                <select name="kabupaten" id="project-kabupaten" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" disabled>
                    <option value="">-</option>
                </select>
            </div>
        </div>
        <div class="mt-3 flex flex-wrap items-center">
            <label for="project-kecamatan" class="basis-full md:basis-3/12">Kecamatan</label>
            <div class="basis-full md:basis-9/12">
                <template x-if="body.kecamatan.error">
                    <div class="relative z-10 -mb-[0.8rem] px-2 py-1 bg-white ml-2 w-fit">
                        <p class="text-sm text-red-500 leading-3" x-text="body.kecamatan.message"></p>
                    </div>
                </template>
                <select name="kecamatan" id="project-kecamatan" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" disabled>
                    <option value="">-</option>
                </select>
            </div>
        </div>
        <div class="mt-3 flex flex-wrap items-center">
            <label for="project-village" class="basis-full md:basis-3/12">Desa</label>
            <div class="basis-full md:basis-9/12">
                <template x-if="body.village.error">
                    <div class="relative z-10 -mb-[0.8rem] px-2 py-1 bg-white ml-2 w-fit">
                        <p class="text-sm text-red-500 leading-3" x-text="body.village.message"></p>
                    </div>
                </template>
                <select name="village" id="project-village" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" disabled>
                    <option value="">-</option>
                </select>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-secondary-button class="ml-3 bg-gray-700 text-white hover:bg-gray-900" type="submit">
                {{ __('Submit') }}
            </x-secondary-button>
        </div>
    </form>
</x-modal>
{{-- Modal ADD Alternative END --}}
