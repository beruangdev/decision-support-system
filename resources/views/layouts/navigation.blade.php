<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-300" />
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
                                class="inline-flex items-center px-1 sm:px-2 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white dark:bg-transparent hover:text-gray-700 dark:hover:text-gray-400 focus:outline-none transition ease-in-out duration-150">
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
                                class="inline-flex items-center px-1 sm:px-2 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white dark:bg-transparent hover:text-gray-700 dark:hover:text-gray-400 focus:outline-none transition ease-in-out duration-150">
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
                            <x-dropdown-link :href="route('alternative.index')">
                                {{ __('All Alternative') }}
                            </x-dropdown-link>
                            <x-dropdown-link x-on:click.prevent="$dispatch('open-modal', 'modal-add-alternative')">
                                {{ __('Add Alternative') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            {{-- Right --}}
            <div class="flex flex-wrap items-center">
                <button id="theme-toggle" type="button"
                    class="text-gray-500 dark:text-gray-400 dark:bg-gray-840 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 aspect-square">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                            fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </button>

                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ml-3">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-840 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
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
    <form method="post" action="{{ route('project.store') }}" class="p-6" x-data="createProject($el)" x-init="init" @submit.prevent="submit">
        @csrf

        <h2 class="text-lg font-medium text-gray-900 flex">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 10.5v6m3-3H9m4.06-7.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
            </svg>


            {{ __('Add New Project') }}
        </h2>

        <div class="mb-3 mt-6">
            <div class="wrapper-input-floating-label">
                <div class="relative">
                    <input type="text" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 appearance-none dark:text-white focus:outline-none focus:ring-0 peer" name="name"
                        placeholder=" " :value="body.name.value" x-model="body.name.value" data-required />
                    <label
                        class="absolute text-sm duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                        Name
                    </label>
                </div>
                <p class="mt-1 text-xs text-red-600 dark:text-red-400 input-floating-label-error-message" x-text="body.name.message">
                    <span class="font-medium">Oh, snapp!</span> Some error message.
                </p>
            </div>
        </div>

        <div class="mb-3">
            <div class="wrapper-input-floating-label">
                <div class="relative">
                    <textarea name="description" cols="30" rows="4" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 appearance-none dark:text-white focus:outline-none focus:ring-0 peer"
                        placeholder=" " :value="body.description.value" x-model="body.description.value"></textarea>
                    <label for="outlined_error"
                        class="absolute text-sm duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-5 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                        Description
                    </label>
                </div>
                <p class="mt-1 text-xs text-red-600 dark:text-red-400 input-floating-label-error-message" x-text="body.description.message">
                    <span class="font-medium">Oh, snapp!</span> Some error message.
                </p>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')" class="modal-close">
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
    <form method="post" action="{{ route('alternative.store') }}" class="p-6 form-add-alternative" x-data="createAltenative($el)" x-init="init" @submit.prevent="submit">
        @csrf

        <h2 class="text-lg font-medium text-gray-900 flex flex-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
            </svg>
            {{ __('Add New Alternative') }}
        </h2>
        <div class="alternative-input">

            <div class="mb-3 mt-6">
                <div class="wrapper-input-floating-label">
                    <div class="relative">
                        <input type="text" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 appearance-none dark:text-white focus:outline-none focus:ring-0 peer" name="name"
                            placeholder=" " :value="body.name.value" x-model="body.name.value" data-required />
                        <label
                            class="absolute text-sm duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                            Name
                        </label>
                    </div>
                    <p class="mt-1 text-xs text-red-600 dark:text-red-400 input-floating-label-error-message" x-text="body.name.message">
                        <span class="font-medium">Oh, snapp!</span> Some error message.
                    </p>
                </div>
            </div>


            <div class="mb-3">
                <div class="wrapper-input-floating-label">
                    <div class="relative">
                        <textarea name="description" cols="30" rows="4" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 appearance-none dark:text-white focus:outline-none focus:ring-0 peer"
                            placeholder=" " :value="body.description.value" x-model="body.description.value"></textarea>
                        <label for="outlined_error"
                            class="absolute text-sm duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-5 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                            Description
                        </label>
                    </div>
                    <p class="mt-1 text-xs text-red-600 dark:text-red-400 input-floating-label-error-message" x-text="body.description.message">
                        <span class="font-medium">Oh, snapp!</span> Some error message.
                    </p>
                </div>
            </div>

        </div>


        <div class="mt-4">
            <p class="mb-1">Add Alternative Details (if number just fill numerik value)</p>
            <div class="grid grid-cols-12 gap-2">
                <x-text-input id="alternative-key" name="key" type="text" placeholder="Key" class="col-span-5" />
                <x-text-input id="alternative-value" name="value" type="text" placeholder="Value" class="col-span-5 md:col-span-6" />
                <x-secondary-button class="px-3 py-1 col-span-2 md:col-span-1 flex flex-wrap justify-center items-center bg-gray-600 hover:!bg-gray-700" type="button" @click.prevent="addTaxonomy">
                    <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                    </svg>
                </x-secondary-button>
            </div>
        </div>

        <div class="mt-4 overflow-auto">
            <p class="mb-1">Alternative Details</p>
            <table class="table-fixed w-full border-separate">
                <thead>
                    <tr>
                        <th class="text-sm text-slate-700 text-left pl-3 py-2 border-2 border-slate-400 w-5/12">KEY</th>
                        <th class="text-sm text-slate-700 text-left pl-3 py-2 border-2 border-slate-400 w-5/12 md:w-6/12">VALUE</th>
                        <th class="text-sm text-slate-700 text-left pl-3 py-2 w-2/12 md:w-1/12"></th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(taxonomy, index) in taxonomies" :key="index">
                        <tr>
                            <td class="p-0">
                                <input type="text" :value="taxonomy.key" @keydown="updateTaxonomy(index, 'key', $el.value)" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm w-[-webkit-fill-available]">
                            </td>
                            <td class="p-0">
                                <input type="text" :value="taxonomy.value" @keydown="updateTaxonomy(index, 'value', $el.value)"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm w-[-webkit-fill-available]">
                            </td>
                            {{-- <td x-text="taxonomy.key"></td> --}}
                            {{-- <td x-text="taxonomy.value"></td> --}}
                            <td class="p-0">
                                <div class="flex flex-wrap justify-end items-center">
                                    <x-danger-button @click.prevent="deleteTaxonomy(index)" class="px-2 py-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 9.75L14.25 12m0 0l2.25 2.25M14.25 12l2.25-2.25M14.25 12L12 14.25m-2.58 4.92l-6.375-6.375a1.125 1.125 0 010-1.59L9.42 4.83c.211-.211.498-.33.796-.33H19.5a2.25 2.25 0 012.25 2.25v10.5a2.25 2.25 0 01-2.25 2.25h-9.284c-.298 0-.585-.119-.796-.33z" />
                                        </svg>
                                    </x-danger-button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>


        <div class="mt-6 flex justify-end">
            <x-secondary-button class="modal-close" x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-secondary-button class="ml-3 bg-gray-700 text-white hover:bg-gray-900" type="submit">
                {{ __('Submit') }}
            </x-secondary-button>
        </div>
    </form>
</x-modal>
{{-- Modal ADD Alternative END --}}
