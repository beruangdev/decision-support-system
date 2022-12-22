<div class="relative">
    <button id="dropdownMenuIconButton" data-dropdown-placement="left-start" data-dropdown-toggle="dropdownDots"
        class="flowbite-dropdown inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
        type="button">
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
        </svg>
    </button>

    <!-- Dropdown menu -->
    <div id="dropdownDots" class="hidden z-10 w-44 bg-white  rounded divide-y divide-gray-100 shadow dark:bg-gray-840 dark:divide-gray-600">
        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton"> 
            <li>
                <x-dropdown-link x-on:click.prevent="$dispatch('open-modal', 'modal-edit-project')" data-project="{{ $project }}" class="button-edit-project">
                    {{ __('Edit') }}
                </x-dropdown-link>
            </li>
            <li>
                <x-dropdown-link href="{{ route('project.destroy', $project->id) }}" class="button-delete-project">
                    {{ __('Delete') }}
                </x-dropdown-link>
            </li>
        </ul>
    </div>
</div>
