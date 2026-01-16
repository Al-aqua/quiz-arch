<script lang="ts">
    import AppLayout from '@/layouts/AppLayout.svelte';
    import { type BreadcrumbItem } from '@/types';
    import AddSubjectDialog from '@/components/AddSubjectDialog.svelte';
    import SubjectCard from '@/components/SubjectCard.svelte';

    interface Props {
        subjects: Array<{
            id: number;
            name: string;
            description: string;
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
    <div class="space-y-4 px-4 py-4 overflow-x-auto">
        <div class="flex">
            <AddSubjectDialog />
        </div>
        <SubjectCard {subjects} />
    </div>
</AppLayout>
