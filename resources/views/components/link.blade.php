@php
    $attribute_strings = [];
    if (!isset($attributes)) {
        $attributes = collect([]);
    }
    $attributes = $attributes->merge(["class" => "font-medium text-blue-600 dark:text-blue-500 hover:underline cursor-pointer"]);
    $default_class = explode(' ', 'font-medium text-blue-600 dark:text-blue-500 hover:underline cursor-pointer');
    foreach ($attributes as $key => $attribute) {
        if ($key == 'class') {
            $attribute = join(' ', array_merge($default_class, explode(' ', $attribute)));
        }
        array_push($attribute_strings, "$key='$attribute'");
    }
    $attribute_strings = join(' ', $attribute_strings);
@endphp
<a {!! $attribute_strings !!}>{{ $label }}</a>
