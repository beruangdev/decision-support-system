@props(['disabled' => false, 'labelText' => '', 'labelClass' => '', 'message' => ''])

<div class="wrapper-input-floating-label">
    <div class="relative">
        <input type="text" {{ $attributes->merge(['class' => 'block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 appearance-none dark:text-white focus:outline-none focus:ring-0 peer']) }}
            placeholder=" " value="" />
        <label
            class="absolute text-sm duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1 {{ $labelClass }}">
            {{ $labelText }}
        </label>
    </div>
    <p class="mt-1 text-xs text-red-600 dark:text-red-400 input-floating-label-error-message">
    </p>
</div>
