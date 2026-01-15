<script lang="ts">
    import PlaceholderPattern from '@/components/PlaceholderPattern.svelte';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import { type BreadcrumbItem } from '@/types';
    import AddSubjectDialog from '@/components/AddSubjectDialog.svelte';

    interface Props {
        subjects: Array<{
            id: number;
            name: string;
        }>;
    }

    let { subjects }: Props = $props();

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Subjects',
            href: '/subjects',
        },
    ];
</script>

<svelte:head>
    <title>Subjects</title>
</svelte:head>

<AppLayout {breadcrumbs}>
    <div class="space-y-4 px-4 pt-4 overflow-x-auto">
        <div class="flex">
            <AddSubjectDialog />
        </div>
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            {#each subjects as subject (subject.id)}
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern class="absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                </div>
            {/each}
        </div>
    </div>
</AppLayout>
