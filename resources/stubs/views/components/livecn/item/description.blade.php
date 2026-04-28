<p
    data-slot="item-description"
    {{ $attributes->class(cn(
        'line-clamp-2 text-left text-sm leading-normal font-normal text-muted-foreground group-data-[size=xs]/item:text-xs [&>a]:underline [&>a]:underline-offset-4 [&>a:hover]:text-primary',
    )) }}
>
    {{ $slot }}
</p>
