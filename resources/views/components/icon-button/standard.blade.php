<a {{  $attributes->class(['group relative h-10 w-10 overflow-hidden rounded-full text-m3-surface-on-variant dark:text-m3-surface-on-variant p-2']) }}>
    <div
        class="absolute inset-0 h-full w-full rounded-full bg-m3-primary dark:bg-m3-primary-dark bg-opacity-0 dark:bg-opacity-0 transition-colors duration-200 group-hover:bg-opacity-[0.08] group-focus:bg-opacity-[0.12] dark:group-hover:bg-opacity-[0.08] dark:group-focus:bg-opacity-[0.12]">
    </div>
    {{ $slot }}
</a>
