<script lang="ts">
    import * as Dialog from '@/components/ui/dialog/index';
    import { Button, buttonVariants } from '@/components/ui/button/index';
    import { Plus } from 'lucide-svelte';
    import { Form, page } from '@inertiajs/svelte';
    import { Input } from '@/components/ui/input/index';
    import { Label } from '@/components/ui/label/index';
    import { toast } from 'svelte-sonner';
    let errors = $derived($page.props.errors ?? {});
    let open = $state(false);
</script>

<Dialog.Root bind:open>
    <Dialog.Trigger class={buttonVariants({ variant: 'default' })}>
        Add Subject <Plus />
    </Dialog.Trigger>

    <Dialog.Content class="sm:max-w-106.25">
        <Form
            preserveScroll
            method="post"
            action="/subjects"
            onSuccess={() => {
                open = false;
                toast.success('Subject added successfully.');
            }}
            class="contents"
        >
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
