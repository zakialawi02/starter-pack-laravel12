@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'focus:ring-primary focus:border-primary block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-dark-primary dark:focus:ring-blue-500']) }}>
