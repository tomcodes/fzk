<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import NavBar from '@/components/NavBar.vue';
import FrazalakonCard from '@/components/FrazalakonCard.vue';
import FzkPagination from '@/components/FzkPagination.vue';
import type { PaginatedData } from '@/components/FzkPagination.vue';

const props = defineProps<{
    frazalakons: PaginatedData;
}>();

function goToPage(page: number) {
    router.get('/admin/pending', { page }, { preserveState: true, preserveScroll: false });
}
</script>

<template>
    <Head title="Dernières fzk" />
    <div class="min-h-screen bg-background text-foreground">
        <NavBar />

        <main class="mx-auto max-w-3xl px-4 py-8">
            <h1 class="mb-6 text-xl font-semibold">
                Dernières fzk non publiées ({{ frazalakons.total }})
            </h1>

            <div class="space-y-4">
                <Link
                    v-for="fzk in frazalakons.data"
                    :key="fzk.id"
                    :href="`/${fzk.slug}`"
                    class="block"
                >
                    <div class="rounded-lg border border-dashed border-primary/50 p-4 transition-colors hover:border-primary hover:bg-primary/15">
                        <FrazalakonCard :frazalakon="fzk" />
                    </div>
                </Link>
            </div>

            <p
                v-if="frazalakons.data.length === 0"
                class="py-12 text-center text-muted-foreground"
            >
                Aucune frazalakon en attente.
            </p>

            <FzkPagination :paginated="frazalakons" @navigate="goToPage" />
        </main>
    </div>
</template>
