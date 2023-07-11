<a {{  $attributes->class(['group relative h-10 w-10 overflow-hidden rounded-full text-neutralVariant-30 dark:text-neutralVariant-80 p-2']) }}>
    <div
        class="absolute inset-0 h-full w-full rounded-full bg-primary-40 dark:bg-primary-80 bg-opacity-0 dark:bg-opacity-0 transition-colors duration-200 group-hover:bg-opacity-[0.08] group-focus:bg-opacity-[0.12] dark:group-hover:bg-opacity-[0.08] dark:group-focus:bg-opacity-[0.12]">
    </div>
    {{ $slot }}
</a>
