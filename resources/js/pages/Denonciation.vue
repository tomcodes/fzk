<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { Card, CardContent } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import NavBar from '@/components/NavBar.vue';

const form = useForm({
    body: '',
    who: '',
    towho: '',
    context: '',
    where: '',
});

function submit() {
    form.post('/denonciation', {
        onSuccess: () => form.reset(),
    });
}
</script>

<template>
    <Head title="Dénonciation anonyme — Frazalakon" />
    <div class="min-h-screen bg-background text-foreground">
        <NavBar />

        <main class="mx-auto max-w-3xl px-4 py-8">
            <h2 class="mb-6 text-xl font-semibold">Dénonciation anonyme</h2>

            <Card>
                <CardContent class="pt-6">
                    <form class="space-y-4" @submit.prevent="submit">
                        <div>
                            <label
                                for="body"
                                class="mb-1 block text-sm font-medium"
                            >
                                La frazalakon *
                            </label>
                            <textarea
                                id="body"
                                v-model="form.body"
                                rows="4"
                                class="flex w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                                placeholder="La citation..."
                            />
                            <p
                                v-if="form.errors.body"
                                class="mt-1 text-sm text-destructive"
                            >
                                {{ form.errors.body }}
                            </p>
                        </div>

                        <div>
                            <label
                                for="who"
                                class="mb-1 block text-sm font-medium"
                            >
                                Qui a dit ça ? *
                            </label>
                            <Input
                                id="who"
                                v-model="form.who"
                                placeholder="Prénom, surnom..."
                            />
                            <p
                                v-if="form.errors.who"
                                class="mt-1 text-sm text-destructive"
                            >
                                {{ form.errors.who }}
                            </p>
                        </div>

                        <div>
                            <label
                                for="towho"
                                class="mb-1 block text-sm font-medium"
                            >
                                À qui ?
                            </label>
                            <Input
                                id="towho"
                                v-model="form.towho"
                                placeholder="Destinataire (optionnel)"
                            />
                        </div>

                        <div>
                            <label
                                for="context"
                                class="mb-1 block text-sm font-medium"
                            >
                                Contexte
                            </label>
                            <Input
                                id="context"
                                v-model="form.context"
                                placeholder="Dans quel contexte ? (optionnel)"
                            />
                        </div>

                        <div>
                            <label
                                for="where"
                                class="mb-1 block text-sm font-medium"
                            >
                                Où ?
                            </label>
                            <Input
                                id="where"
                                v-model="form.where"
                                placeholder="Lieu (optionnel)"
                            />
                        </div>

                        <Button
                            type="submit"
                            :disabled="form.processing"
                        >
                            Dénoncer
                        </Button>
                    </form>
                </CardContent>
            </Card>
        </main>
    </div>
</template>
