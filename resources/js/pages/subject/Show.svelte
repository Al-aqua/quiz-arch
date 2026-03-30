<script module lang="ts">
</script>

<script lang="ts">
    import { Form } from '@inertiajs/svelte';
    import { FileQuestion, SquarePen, Trash } from 'lucide-svelte';
    import AppHead from '@/components/AppHead.svelte';
    import InputError from '@/components/InputError.svelte';
    import { Button, buttonVariants } from '@/components/ui/button';
    import * as Dialog from '@/components/ui/dialog/index';
    import * as Empty from '@/components/ui/empty/index';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import { Spinner } from '@/components/ui/spinner';
    import { index, show, update, destroy } from '@/routes/subjects';
    import type { Subject } from '@/types';

    interface Props {
        subject: Subject;
    }
    let { subject }: Props = $props();

    export const layout = () => ({
        breadcrumbs: [
            {
                title: 'Subjects',
                href: index.url(),
            },
            {
                title: subject.slug,
                href: show.url(subject.slug),
            },
        ],
    });

    let updateFormOpen = $state(false);
    let deleteFormOpen = $state(false);
</script>

<AppHead title={subject.name} />

<div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
    <div
        class="flex w-full border p-4 gap-4 items-center justify-between max-h-32 overflow-hidden"
    >
        <div class="flex flex-col gap-2">
            <h1 class="text-lg font-medium line-clamp-1">{subject.name}</h1>
            <p class="text-sm text-gray-500 line-clamp-2">
                {subject.description}
            </p>
        </div>
        <div class="flex gap-4">
            {@render editSubjectDialog()}
            {@render deleteSubjectDialog()}
        </div>
    </div>

    <Empty.Root>
        <Empty.Header>
            <Empty.Media variant="icon">
                <FileQuestion />
            </Empty.Media>
            <Empty.Title>No Questions Yet</Empty.Title>
            <Empty.Description
                >You haven't created any questions yet. Get started by creating
                your first question.</Empty.Description
            >
        </Empty.Header>
        <Empty.Content>
            <Button class="mt-4 w-full" data-test="create-subject-button">
                Create your first question
            </Button>
        </Empty.Content>
    </Empty.Root>
</div>

{#snippet editSubjectDialog()}
    <Dialog.Root bind:open={updateFormOpen}>
        <Dialog.Trigger class={buttonVariants({ variant: 'secondary' })}>
            Edit<SquarePen size="1.25rem" /> <span class="sr-only">Edit</span>
        </Dialog.Trigger>
        <Dialog.Content class="sm:max-w-106.25">
            <Form
                {...update.form(subject.slug)}
                class="flex flex-col gap-6"
                onSuccess={() => {
                    updateFormOpen = false;
                }}
            >
                {#snippet children({ errors, processing })}
                    <div class="grid gap-6">
                        <Dialog.Header>
                            <Dialog.Title>Edit Subject</Dialog.Title>
                            <Dialog.Description
                                >Edit your subject.</Dialog.Description
                            >
                        </Dialog.Header>
                        <div class="grid gap-2">
                            <Label for="name">Subject Name</Label>
                            <Input
                                id="name"
                                type="text"
                                name="name"
                                autocomplete="name"
                                placeholder="Programming 101"
                                value={subject.name}
                            />
                            <InputError message={errors.name} />
                        </div>
                        <div class="grid gap-6">
                            <div class="grid gap-2">
                                <Label for="description"
                                    >Subject Description</Label
                                >
                                <Input
                                    id="description"
                                    type="text"
                                    name="description"
                                    autocomplete="description"
                                    placeholder="Subject Description"
                                    value={subject.description}
                                />
                                <InputError message={errors.description} />
                            </div>

                            <Button
                                type="submit"
                                class="mt-4 w-full"
                                disabled={processing}
                                data-test="edit-subject-button"
                            >
                                {#if processing}<Spinner />{/if}
                                Edit Subject
                            </Button>
                        </div>
                    </div>
                {/snippet}
            </Form>
        </Dialog.Content>
    </Dialog.Root>
{/snippet}

{#snippet deleteSubjectDialog()}
    <Dialog.Root bind:open={deleteFormOpen}>
        <Dialog.Trigger class={buttonVariants({ variant: 'destructive' })}>
            Delete<Trash size="1.25rem" /> <span class="sr-only">Delete</span>
        </Dialog.Trigger>
        <Dialog.Content class="sm:max-w-106.25">
            <Form
                {...destroy.form(subject)}
                class="flex flex-col gap-6"
                onSuccess={() => {
                    updateFormOpen = false;
                }}
            >
                {#snippet children({ processing })}
                    <div class="grid gap-6">
                        <Dialog.Header>
                            <Dialog.Title>Delete Subject</Dialog.Title>
                            <Dialog.Description>
                                Are you sure you want to delete this subject?
                            </Dialog.Description>
                        </Dialog.Header>

                        <Button
                            type="submit"
                            class="mt-4 w-full"
                            disabled={processing}
                            data-test="edit-subject-button"
                            variant="destructive"
                        >
                            {#if processing}<Spinner />{/if}
                            Delete Subject
                        </Button>
                    </div>
                {/snippet}
            </Form>
        </Dialog.Content>
    </Dialog.Root>
{/snippet}
