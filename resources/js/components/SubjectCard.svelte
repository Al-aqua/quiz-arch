<script lang="ts">
    import * as Card from '@/components/ui/card/index';
    import { Button } from '@/components/ui/button/index';

    interface Props {
        subjects: Array<{
            id: number;
            name: string;
            description: string;
        }>;
    }

    let { subjects }: Props = $props();
</script>

<div class="flex w-full flex-col gap-6">
    <div class="grid auto-rows-min gap-4 md:grid-cols-3 lg:grid-cols-4">
        {#each subjects as subject (subject.id)}
            <Card.Root class="hover:shadow-lg transition-shadow">
                <Card.Header>
                    <Card.Title>{subject.name}</Card.Title>
                </Card.Header>
                <Card.Content>
                    <Card.Description>{subject.description}</Card.Description>
                </Card.Content>
                <Card.Footer>
                    <Button variant="default" size="sm">View</Button>
                </Card.Footer>
            </Card.Root>
        {/each}
    </div>
</div>
