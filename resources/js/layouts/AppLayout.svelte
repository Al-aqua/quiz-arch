<script lang="ts">
    import { router } from '@inertiajs/svelte';
    import { onDestroy, onMount } from 'svelte';
    import type { Snippet } from 'svelte';
    import { toast } from 'svelte-sonner';
    import { Toaster } from '@/components/ui/sonner/index';
    import AppLayout from '@/layouts/app/AppHeaderLayout.svelte';
    import type { BreadcrumbItem } from '@/types';

    let removeListener: (() => void) | undefined;

    onMount(() => {
        removeListener = router.on('flash', (event) => {
            if (event.detail.flash.success) {
                toast.success(event.detail.flash.success.toString());
            } else if (event.detail.flash.error) {
                toast.error(event.detail.flash.error.toString());
            }
        });
    });
    onDestroy(() => {
        if (removeListener) {
            removeListener();
        }
    });

    let {
        breadcrumbs = [],
        children,
    }: {
        breadcrumbs?: BreadcrumbItem[];
        children?: Snippet;
    } = $props();
</script>

<Toaster />
<AppLayout {breadcrumbs}>
    {@render children?.()}
</AppLayout>
