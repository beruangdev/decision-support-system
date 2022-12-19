<div class="relative inline-block text-left dropdown-wrapper">
    <div>
        <button type="button"
            class="inline-flex w-full justify-center border border-gray-300 text-sm font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-100 dropdown-button rounded-full bg-gray-700 hover:bg-gray-800 duration-300 text-white p-1"
            id="menu-button" aria-expanded="true" aria-haspopup="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5" stroke-width="2.5">
                <path fill-rule="evenodd" d="M10.5 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm0 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm0 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>
    <div class="dropdown-overlay hidden" style="
    position: fixed;
    width: 100vw;
    height: 100vw;
    background: transparent;
    left: 0;
    bottom: 0;
    z-index: 9;
    "></div>
    <div class="dropdown-menu hidden absolute right-0 z-10 mt-2 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none w-max" role="menu" aria-orientation="vertical"
        aria-labelledby="menu-button" tabindex="-1" style="z-index:10; width: max-content;">
        <div class="py-1" role="none">
            <x-dropdown-link x-on:click.prevent="$dispatch('open-modal', 'modal-edit-project')" data-project="{{ $project }}" class="button-edit-project">
                {{ __('Edit') }}
            </x-dropdown-link>
            <x-dropdown-link href="{{ route('project.destroy', $project->id) }}" class="button-delete-project">
                {{ __('Delete') }}
            </x-dropdown-link>
        </div>
    </div>
</div>
