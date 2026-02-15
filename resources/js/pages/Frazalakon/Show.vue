<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import NavBar from '@/components/NavBar.vue';
import FrazalakonCard from '@/components/FrazalakonCard.vue';
import type { Frazalakon } from '@/components/FrazalakonCard.vue';

defineProps<{
    frazalakon: Frazalakon;
}>();
</script>

<template>
    <Head :title="`${frazalakon.who} — Frazalakon`" />
    <div class="min-h-screen bg-background text-foreground">
        <NavBar />

        <main class="mx-auto max-w-3xl px-4 py-8">
            <div class="rounded-lg border border-border p-4">
                <FrazalakonCard :frazalakon="frazalakon" large />
            </div>
        </main>
    </div>
</template>
