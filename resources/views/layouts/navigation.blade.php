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
                                class="inline-flex items-center px-1 sm:px-2 py-2 border border-transparent dark:border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:bg-transparent hover:text-gray-700 dark:hover:text-gray-400 focus:outline-none transition ease-in-out duration-150">
                                <div class="mr-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                                    </svg>
                                </div>
                                <div class="hidden md-block">Project</div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('project.index')">
                                {{ __('All Project') }}
                            </x-dropdown-link>

                            <x-dropdown-link x-on:click.prevent="$dispatch('open-modal', 'modal-add-project')">
                                {{ __('Add New') }}
                            </x-dropdown-link>

                            @isset($project_id)
                                <x-dropdown-link :href="route('project.attribute', [
                                    'project' => $project_id,
                                ])">
                                    {{ __('Attribute') }}
                                </x-dropdown-link>
                            @endisset

                        </x-slot>
                    </x-dropdown>
                </div>
                @isset($project_id)
                    {{-- Alternative --}}
                    <div class="flex space-x-2 sm:space-x-8 items-center">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-1 sm:px-2 py-2 border border-transparent dark:border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:bg-transparent hover:text-gray-700 dark:hover:text-gray-400 focus:outline-none transition ease-in-out duration-150">
                                    <div class="mr-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                                        </svg>
                                    </div>
                                    <div class="hidden md-block">Alternative</div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('alternative.index', ['project' => $project_id])">
                                    {{ __('All Alternative') }}
                                </x-dropdown-link>
                                <x-dropdown-link x-on:click.prevent="$dispatch('open-modal', 'modal-add-alternative')">
                                    {{ __('Add Alternative') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    {{-- END Alternative --}}

                    {{-- Project Method --}}
                    <div class="flex space-x-2 sm:space-x-8 items-center">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-1 sm:px-2 py-2 border border-transparent dark:border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:bg-transparent hover:text-gray-700 dark:hover:text-gray-400 focus:outline-none transition ease-in-out duration-150">
                                    <div class="mr-1">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1A3.75 3.75 0 0012 18z" />
                                        </svg>

                                    </div>
                                    <div class="hidden md-block">Method</div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('project_method.index', ['project' => $project_id])">
                                    {{ __('All Method') }}
                                </x-dropdown-link>
                                <x-dropdown-link data-modal-toggle="modal-create-project-method">
                                    {{ __('Add Method') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                    {{-- END Project Method --}}
                @endisset
            </div>

            {{-- Right --}}
            <div class="flex flex-wrap items-center">
                <button id="theme-toggle" type="button"
                    class="text-gray-500 dark:text-gray-400 dark:bg-gray-840 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 aspect-square"
                    @click="onClickMode">
                    <div role="status" :class="'hidden'">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="currentColor" />
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentFill" />
                        </svg>
                        <span class="sr-only">Loading...</span>
                    </div>
                    <svg id="theme-toggle-dark-icon" :class="color_theme == 'dark' ? $el.classList.remove('hidden') : 'hidden'" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg id="theme-toggle-light-icon" :class="color_theme == 'light' ? $el.classList.remove('hidden') : 'hidden'" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
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
                                class="inline-flex items-center px-3 py-2 border border-transparent dark:border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-840 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
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
        {{-- <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('project.index')" :active="request()->routeIs('dashboard')">
                {{ __('Project') }}
            </x-responsive-nav-link>

            @isset($project_id)
                <x-responsive-nav-link :href="route('alternative.index', ['project' => $project_id])" :active="request()->routeIs('alternative')">
                    {{ __('Alternative') }}
                </x-responsive-nav-link>
            @endisset
        </div> --}}

        <!-- Responsive Settings Options -->
        <div class="pb-1 border-t border-gray-200">
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
                        class="absolute text-sm duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
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
                        class="absolute text-sm duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-5 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
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

@isset($project_id)
    {{-- Modal ADD Alternative --}}
    <x-modal name="modal-add-alternative" focusable>
        <form method="post" action="{{ route('alternative.store', ['project' => $project_id]) }}" class="p-6 form-add-alternative" x-data="createAltenative($el)" x-init="init" @submit.prevent="submit">
            @csrf

            <h2 class="text-lg mb-4 font-medium text-gray-900 flex flex-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                </svg>
                {{ __('Add New Alternative') }}
            </h2>

            <div x-data="createAlternativeFromFile($el)" action="{{ route('alternative.store', ['project' => $project_id]) }}" x-init="this.init">
                <input class="selection:block mb-2 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                    type="file" multiple @change="onChangeInputFile">
                <div class="flex flex-wrap justify-between mb-2">
                    <p class="block text-sm font-medium text-gray-900 dark:text-white">You can upload alternative table or input form at bottom</p>
                    <p class="text-xs ml-1 text-gray-500 dark:text-gray-300">xlx, xlsx or csv.</p>
                </div>

                <template x-for="(queue, index) in queues" :key="index">
                    <div class="mb-3">
                        <div class="flex flex-wrap gap-3 border rounded-md p-2">
                            <div class="text-xs flex justify-center w-9" x-text="`${limit_progress(queue.progress)}%`">
                            </div>
                            <div class="flex-1 flex items-center">
                                <div class="bg-gray-200 rounded h-2 w-full" role="progressbar" :aria-valuenow="queue.progress" aria-valuemin="0" aria-valuemax="100">
                                    <div class="bg-blue-600 transition-all duration-500 rounded h-2 text-center w-full" :style="`width:${queue.progress}%;`">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <template x-for="(alert, index) in alerts" :key="index">
                    <div>
                        <template x-if="alert.status">
                            <div id="toast-success" class="flex items-center py-3 px-4 w-full text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-840 mb-2" role="alert">
                                <div class="inline-flex flex-shrink-0 justify-center items-center w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="sr-only">Check icon</span>
                                </div>
                                <div class="ml-3 text-sm font-normal" x-text="alert.text"></div>
                                <button type="button" @click="deleteAlert(index)"
                                    class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-840 dark:hover:bg-gray-700"
                                    data-dismiss-target="#toast-success" aria-label="Close">
                                    <span class="sr-only">Close</span>
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                        </template>

                        <template x-if="!alert.status">
                            <div id="toast-danger" class="flex items-center py-3 px-4 w-full text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-840 mb-2" role="alert">
                                <div class="inline-flex flex-shrink-0 justify-center items-center w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="sr-only">Error icon</span>
                                </div>
                                <div class="ml-3 text-sm font-normal" x-text="alert.text"></div>
                                <button type="button" @click="deleteAlert(index)"
                                    class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                                    data-dismiss-target="#toast-danger" aria-label="Close">
                                    <span class="sr-only">Close</span>
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                        </template>

                    </div>
                </template>
            </div>

            <hr class="my-6 border-t-2 border-solid dark:border-gray-600">
            <div class="alternative-input">

                <div class="mb-3 mt-6">
                    <div class="wrapper-input-floating-label">
                        <div class="relative">
                            <input type="text" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent dark:bg-transparent rounded-lg border-1 appearance-none dark:text-white focus:outline-none focus:ring-0 peer"
                                name="name" placeholder=" " :value="body.name.value" x-model="body.name.value" data-required />
                            <label
                                class="absolute text-sm duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
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
                            <input type="text" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent dark:bg-transparent rounded-lg border-1 appearance-none dark:text-white focus:outline-none focus:ring-0 peer"
                                name="uuid" placeholder=" " :value="body.uuid.value" x-model="body.uuid.value" data-required />
                            <label
                                class="absolute text-sm duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                                Unix ID <div class="text-xs inline-block ml-1 leading-[1.1rem]">(such as an identification number)</div>
                            </label>
                        </div>
                        <p class="mt-1 text-xs text-red-600 dark:text-red-400 input-floating-label-error-message" x-text="body.uuid.message">
                            <span class="font-medium">Oh, snapp!</span> Some error message.
                        </p>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="wrapper-input-floating-label">
                        <div class="relative">
                            <textarea name="description" cols="30" rows="4"
                                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent dark:bg-transparent rounded-lg border-1 appearance-none dark:text-white focus:outline-none focus:ring-0 peer" placeholder=" " :value="body.description.value"
                                x-model="body.description.value"></textarea>
                            <label for="outlined_error"
                                class="absolute text-sm duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-5 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
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
                <p class="mb-1">Add Alternative Attributes (if number just fill numerik value)</p>
                <div class="grid grid-cols-12 gap-2">
                    <x-text-input id="alternative-key" name="key" type="text" placeholder="Key" class="col-span-5 dark:bg-transparent" />
                    <x-text-input id="alternative-value" name="value" type="text" placeholder="Value" class="col-span-5 md:col-span-6 dark:bg-transparent" />
                    <x-secondary-button class="px-3 py-1 col-span-2 md:col-span-1 flex flex-wrap justify-center items-center bg-gray-600 hover:!bg-gray-700" type="button" @click.prevent="addAttribute">
                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                        </svg>
                    </x-secondary-button>
                </div>
            </div>

            <div class="mt-4 overflow-auto">
                <p class="mb-1">Alternative Attributes</p>
                <table class="table-fixed w-full border-separate">
                    <thead>
                        <tr>
                            <th class="text-sm text-slate-700 dark:text-gray-300 text-left pl-3 py-2 border-2 border-slate-400 w-5/12">KEY</th>
                            <th class="text-sm text-slate-700 dark:text-gray-300 text-left pl-3 py-2 border-2 border-slate-400 w-5/12 md:w-6/12">VALUE</th>
                            <th class="text-sm text-slate-700 text-left pl-3 py-2 w-2/12 md:w-1/12"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(attribute, index) in attributes" :key="index">
                            <tr>
                                <td class="p-0">
                                    <input type="text" :value="attribute.key" @keydown="updateAttribute(index, 'key', $el.value)"
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm w-[-webkit-fill-available] dark:bg-transparent">
                                </td>
                                <td class="p-0">
                                    <input type="text" :value="attribute.value" @keydown="updateAttribute(index, 'value', $el.value)"
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm w-[-webkit-fill-available] dark:bg-transparent">
                                </td>
                                {{-- <td x-text="attribute.key"></td> --}}
                                {{-- <td x-text="attribute.value"></td> --}}
                                <td class="p-0">
                                    <div class="flex flex-wrap justify-end items-center">
                                        <x-danger-button @click.prevent="deleteAttribute(index)" class="px-2 py-2">
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

    {{-- Modal Create Project Method --}}
    <div id="modal-create-project-method" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full" data-modal-placement="center-center">
        <div class="relative w-full h-full max-w-7xl md:h-auto max-h-[88vh] overflow-y-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                    data-modal-toggle="modal-create-project-method">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h2 class="text-lg font-medium text-gray-900 flex">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 10.5v6m3-3H9m4.06-7.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                        </svg>


                        {{ __('Add Method') }}
                    </h2>

                    <form action="{{ route('project_method.store', ['project' => $project_id]) }}" x-data="createProjectMethod($el)" x-init="this.init" @submit.prevent="submit" data-url_get_default="{{ route('project_method.get_default', ["project" => $project_id]) }}">

                        <div class="container-error text-red-600 my-3">
                            <p class="error-header">&nbsp;</p>
                            <ul class="text-sm pl-4 list-disc">
                            </ul>
                        </div>

                        <div class="container-input-project-method">

                            <div class="mb-2 md:mb-4 grid grid-cols-1 md:grid-cols-12 gap-3">

                                {{-- LEFT --}}
                                <div class="flex flex-wrap flex-col gap-3 md:col-span-4">
                                    {{-- NAME --}}
                                    <div>
                                        <x-input-float value="" label-text="Name" label-class="" name="name" x-model="body.name" />
                                    </div>

                                    {{-- DESCRIPTION --}}
                                    <div>
                                        <x-textarea-float name="description" label-text="Description" rows="4" x-model="body.description">
                                        </x-textarea-float>
                                    </div>

                                    {{-- SELECT METHOD --}}
                                    <div>
                                        <select
                                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            name="method_id" x-model="body.method_id">
                                            <option selected disabled value="">--- Choice method you want to use ----</option>
                                            <template x-for="(method, index) in methods" :key="index">
                                                <option :value="method.id" x-text="method.name"></option>
                                            </template>
                                        </select>
                                    </div>
                                </div>
                                {{-- LEFT END --}}

                                {{-- RIGHT --}}
                                <div class="flex flex-wrap flex-col gap-3 md:col-span-8">

                                    {{-- SELECT CRITERIA --}}
                                    <div class="container-criterias">
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Choice criteria <span class="text-xs">*select at least 3 criteria</span></label>
                                        <div class="grid lg:grid-cols-2 gap-2">

                                            <template x-for="(atk, index) in attribute_keys" :key="index">
                                                <div class="container-criteria-item flex items-center justify-between px-4 py-2 rounded border border-gray-200 dark:border-gray-700">
                                                    <div class="pr-2 flex">
                                                        <input x-bind:id="'checkbox-method-criteria-' + atk.key_slug" type="checkbox" :value="atk.key_slug" name="criterias"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 mt-[0.1rem]"
                                                            @change="updateAlternativeattributeKeys(atk, index)" />
                                                        <label x-bind:for="'checkbox-method-criteria-' + atk.key_slug" class="ml-2 w-full text-sm font-medium text-gray-900 dark:text-gray-300" x-text="atk.key"></label>
                                                    </div>

                                                    <div>
                                                        <select
                                                            class="block w-full py-1 px-2 pr-4 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 min-w-max"
                                                            name="type">
                                                            <option value="cost" selected>Cost</option>
                                                            <option value="benefit">Benefit</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>

                                </div>
                                {{-- RIGHT END --}}

                            </div>
                        </div>

                        <div class="mt-6 mb-6 flex justify-end">
                            <x-secondary-button data-modal-toggle="modal-create-project-method" class="close-modal">
                                {{ __('Cancel') }}
                            </x-secondary-button>

                            <x-secondary-button class="ml-3 bg-gray-700 text-white hover:!bg-gray-900" type="submit">
                                {{ __('Add') }}
                            </x-secondary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Create Project Method END --}}
@endisset

{{-- <script>
    addEventListener('DOMContentLoaded', (event) => {
        console.log("DOMContentLoaded");
        setTimeout(() => {
            console.log("click");
            document.querySelector(`[data-modal-toggle="modal-create-project-method"]`).click()
        }, 1000);
    });
</script> --}}
