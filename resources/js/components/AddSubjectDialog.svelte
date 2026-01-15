<script lang="ts">
    import * as Dialog from '@/components/ui/dialog/index';
    import { Button, buttonVariants } from '@/components/ui/button/index';
    import { Plus } from 'lucide-svelte';
    import { Form, page } from '@inertiajs/svelte';
    import { Input } from '@/components/ui/input/index';
    import { Label } from '@/components/ui/label/index';
    let errors = $derived($page.props.errors ?? {});
    let flash = $derived($page.props.flash ?? {});
    let open = $state(false);
</script>

{#if flash?.success}
    <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
        {flash.success}
    </div>
{/if}

<Dialog.Root bind:open>
    <Dialog.Trigger class={buttonVariants({ variant: 'default' })}>
        Add Subject <Plus />
    </Dialog.Trigger>

    <Dialog.Content class="sm:max-w-106.25">
        <Form method="post" action="/subjects" onSuccess={() => (open = false)} class="contents">
            <Dialog.Header>
                <Dialog.Title>Add Subject</Dialog.Title>
                <Dialog.Description>Add a new subject.</Dialog.Description>
            </Dialog.Header>

            <div class="grid gap-4">
                <div class="grid gap-3">
                    <Label for="name">Subject Name</Label>
                    <Input id="name" name="name" placeholder="e.g. Mathematics" class={errors?.name ? 'border-destructive' : ''} />
                    {#if errors?.name}
                        <p class="text-destructive text-sm">{errors.name}</p>
                    {/if}
                </div>
            </div>

            <div class="grid gap-4">
                <div class="grid gap-3">
                    <Label for="description">Subject Description</Label>
                    <Input
                        id="description"
                        name="description"
                        placeholder="e.g. Mathematics for beginners"
                        class={errors?.description ? 'border-destructive' : ''}
                    />
                    {#if errors?.description}
                        <p class="text-destructive text-sm">{errors.description}</p>
                    {/if}
                </div>
            </div>

            <Dialog.Footer>
                <Button type="button" variant="outline" onclick={() => (open = false)}>Cancel</Button>
                <Button type="submit">Save</Button>
            </Dialog.Footer>
        </Form>
    </Dialog.Content>
</Dialog.Root>
