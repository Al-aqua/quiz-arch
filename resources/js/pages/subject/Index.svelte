<script module lang="ts">
    import { index } from '@/routes/subjects';

    export const layout = {
        breadcrumbs: [
            {
                title: 'Subjects',
                href: index(),
            },
        ],
    };
</script>

<script lang="ts">
    import { Form } from '@inertiajs/svelte';
    import { Book } from 'lucide-svelte';
    import AppHead from '@/components/AppHead.svelte';
    import InputError from '@/components/InputError.svelte';
    import { Button, buttonVariants } from '@/components/ui/button';
    import * as Dialog from '@/components/ui/dialog/index';
    import * as Empty from '@/components/ui/empty/index';
    import { Input } from '@/components/ui/input';
    import * as Item from '@/components/ui/item/index';
    import { Label } from '@/components/ui/label';
    import { Spinner } from '@/components/ui/spinner';
    import type { Subject } from '@/types';
    import { show, store } from '@/routes/subjects';

    interface Props {
        subjects: Array<Subject>;
    }

    let { subjects }: Props = $props();

    let open = $state(false);
</script>

<AppHead title="Subjects" />

<div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
    {#if subjects && subjects.length > 0}
        <div>
            {@render createSubjectDialog()}
        </div>

        <div class="grid gap-4 grid-rows-min md:grid-cols-3">
            {#each subjects as subject (subject.id)}
                <a href={show.url(subject.slug)}>
                    <Item.Root
                        variant="outline"
                        class="shadow hover:shadow-lg hover:border-primary transition-all
                            duration-300 ease-in-out h-32 w-full overflow-hidden"
                    >
                        <Item.Content>
                            <Item.Title class="text-lg font-medium line-clamp-1"
                                >{subject.name}</Item.Title
                            >
                            <Item.Description
                                class="text-sm text-gray-500 line-clamp-2"
                            >
                                {subject.description}
                            </Item.Description>
                        </Item.Content>
                        <Item.Actions />
                    </Item.Root>
                </a>
            {/each}
        </div>
    {:else}
        <Empty.Root>
            <Empty.Header>
                <Empty.Media variant="icon">
                    <Book />
                </Empty.Media>
                <Empty.Title>No Subjects Yet</Empty.Title>
                <Empty.Description
                    >You haven't created any subjects yet. Get started by
                    creating your first subject.</Empty.Description
                >
            </Empty.Header>
            <Empty.Content>
                {@render createSubjectDialog()}
            </Empty.Content>
        </Empty.Root>
    {/if}
</div>

{#snippet createSubjectDialog()}
    <Dialog.Root bind:open>
        <Dialog.Trigger class={buttonVariants({ variant: 'default' })}>
            Create Subject
        </Dialog.Trigger>
        <Dialog.Content class="sm:max-w-106.25">
            <Form
                {...store.form()}
                class="flex flex-col gap-6"
                onSuccess={() => {
                    open = false;
                }}
            >
                {#snippet children({ errors, processing })}
                    <div class="grid gap-6">
                        <Dialog.Header>
                            <Dialog.Title>Create Subject</Dialog.Title>
                            <Dialog.Description
                                >Create a new subject.</Dialog.Description
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
                                />
                                <InputError message={errors.description} />
                            </div>

                            <Button
                                type="submit"
                                class="mt-4 w-full"
                                disabled={processing}
                                data-test="create-subject-button"
                            >
                                {#if processing}<Spinner />{/if}
                                Create Subject
                            </Button>
                        </div>
                    </div>
                {/snippet}
            </Form>
        </Dialog.Content>
    </Dialog.Root>
{/snippet}
