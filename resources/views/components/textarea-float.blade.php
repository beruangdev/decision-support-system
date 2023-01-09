@props(['disabled' => false, 'labelText' => '', 'labelClass' => '', 'message' => '', 'rows' => '4'])

<div class="wrapper-input-floating-label h-full">
    <div class="relative  h-full">
        <textarea placeholder=" " cols="30" rows="{{ $rows }}"
            {{ $attributes->merge(['class' => 'block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer']) }}>{{ $slot }}</textarea>
        <label for="floating_outlined"
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-840 px-2 peer-focus:px-2 peer-focus:text-blue-600 dark:peer-focus:text-gray-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-6 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1 {{ $labelClass }}">{{ $labelText }}</label>

    </div>
    <p class="mt-1 text-xs text-red-600 dark:text-red-400 input-floating-label-error-message">
    </p>
</div>
