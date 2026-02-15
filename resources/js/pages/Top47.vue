<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import NavBar from '@/components/NavBar.vue';
import FrazalakonCard from '@/components/FrazalakonCard.vue';
import type { Frazalakon } from '@/components/FrazalakonCard.vue';

defineProps<{
    frazalakons: Frazalakon[];
}>();
</script>

<template>
    <Head title="Top 47 — Frazalakon" />
    <div class="min-h-screen bg-background text-foreground">
        <NavBar />

        <main class="mx-auto max-w-3xl px-4 py-8">
            <h2 class="mb-6 text-xl font-semibold">Top 47</h2>

            <div class="space-y-4">
                <Link
                    v-for="fzk in frazalakons"
                    :key="fzk.id"
                    :href="`/${fzk.slug}`"
                    class="block"
                >
                    <div class="rounded-lg border border-border p-4 transition-colors hover:border-primary hover:bg-primary/15">
                        <FrazalakonCard :frazalakon="fzk" />
                    </div>
                </Link>
            </div>

            <p
                v-if="frazalakons.length === 0"
                class="py-12 text-center text-muted-foreground"
            >
                Aucun frazalakon pour le moment.
            </p>
        </main>
    </div>
</template>
