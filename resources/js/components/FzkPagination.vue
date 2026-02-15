<script lang="ts">
export interface PaginatedData {
    data: unknown[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
}
</script>

<script setup lang="ts">
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

const props = defineProps<{
    paginated: PaginatedData;
}>();

const emit = defineEmits<{
    navigate: [page: number];
}>();

function goToPage(page: number) {
    emit('navigate', page);
}
</script>

<template>
    <Pagination
        v-if="paginated.last_page > 1"
        v-slot="{ page }"
        :items-per-page="paginated.per_page"
        :total="paginated.total"
        :default-page="paginated.current_page"
        class="mt-8"
        @update:page="goToPage"
    >
        <PaginationContent v-slot="{ items }">
            <PaginationFirst @click="goToPage(1)" />
            <PaginationPrevious
                @click="goToPage(Math.max(paginated.current_page - 1, 1))"
            />

            <template v-for="(item, index) in items" :key="index">
                <PaginationItem
                    v-if="item.type === 'page'"
                    :value="item.value"
                    as-child
                >
                    <Button
                        :variant="item.value === paginated.current_page ? 'default' : 'outline'"
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
                @click="goToPage(Math.min(paginated.current_page + 1, paginated.last_page))"
            />
            <PaginationLast @click="goToPage(paginated.last_page)" />
        </PaginationContent>
    </Pagination>
</template>
