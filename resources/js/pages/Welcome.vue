<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { useDebounceFn } from '@vueuse/core';
import { Input } from '@/components/ui/input';
import {
    Pagination,
    PaginationContent,
    PaginationEllipsis,
    PaginationFirst,
    PaginationItem,
    PaginationLast,
    PaginationNext,
    PaginationPrevious,
} from '@/components/ui/pagination';
import { Button } from '@/components/ui/button';
import { Search } from 'lucide-vue-next';
import NavBar from '@/components/NavBar.vue';
import FrazalakonCard from '@/components/FrazalakonCard.vue';
import type { Frazalakon } from '@/components/FrazalakonCard.vue';

interface PaginatedData {
    data: Frazalakon[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    next_page_url: string | null;
    prev_page_url: string | null;
}

const props = withDefaults(
    defineProps<{
        canRegister: boolean;
        frazalakons: PaginatedData;
        search: string;
    }>(),
    {
        canRegister: true,
        search: '',
    },
);

const searchQuery = ref(props.search);

const performSearch = useDebounceFn(() => {
    router.get(
        '/',
        { search: searchQuery.value || undefined },
        { preserveState: true, preserveScroll: false },
    );
}, 300);

watch(searchQuery, performSearch);

function goToPage(page: number) {
    router.get(
        '/',
        { page, search: searchQuery.value || undefined },
        { preserveState: true, preserveScroll: false },
    );
}
</script>

<template>
    <Head title="Frazalakon" />
    <div class="min-h-screen bg-background text-foreground">
        <NavBar :can-register="canRegister" />

        <main class="mx-auto max-w-3xl px-4 py-8">
            <div class="relative mb-6">
                <Search
                    class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground"
                />
                <Input
                    v-model="searchQuery"
                    type="search"
                    placeholder="Rechercher..."
                    class="pl-9"
                />
            </div>

            <div class="space-y-4">
                <Link
                    v-for="fzk in frazalakons.data"
                    :key="fzk.id"
                    :href="`/${fzk.slug}`"
                    class="block"
                >
                    <div class="rounded-lg border border-border p-4 transition-colors hover:border-primary/30 hover:bg-accent/50">
                        <FrazalakonCard :frazalakon="fzk" />
                    </div>
                </Link>
            </div>

            <p
                v-if="frazalakons.data.length === 0"
                class="py-12 text-center text-muted-foreground"
            >
                Aucun frazalakon pour le moment.
            </p>

            <Pagination
                v-if="frazalakons.last_page > 1"
                v-slot="{ page }"
                :items-per-page="frazalakons.per_page"
                :total="frazalakons.total"
                :default-page="frazalakons.current_page"
                class="mt-8"
                @update:page="goToPage"
            >
                <PaginationContent v-slot="{ items }">
                    <PaginationFirst @click="goToPage(1)" />
                    <PaginationPrevious
                        @click="
                            goToPage(
                                Math.max(frazalakons.current_page - 1, 1),
                            )
                        "
                    />

                    <template v-for="(item, index) in items" :key="index">
                        <PaginationItem
                            v-if="item.type === 'page'"
                            :value="item.value"
                            as-child
                        >
                            <Button
                                :variant="
                                    item.value === frazalakons.current_page
                                        ? 'default'
                                        : 'outline'
                                "
                                class="h-9 w-9 p-0"
                                @click="goToPage(item.value)"
                            >
                                {{ item.value }}
                            </Button>
                        </PaginationItem>
                        <PaginationEllipsis
                            v-else
                            :key="item.type"
                            :index="index"
                        />
                    </template>

                    <PaginationNext
                        @click="
                            goToPage(
                                Math.min(
                                    frazalakons.current_page + 1,
                                    frazalakons.last_page,
                                ),
                            )
                        "
                    />
                    <PaginationLast
                        @click="goToPage(frazalakons.last_page)"
                    />
                </PaginationContent>
            </Pagination>
        </main>
    </div>
</template>
