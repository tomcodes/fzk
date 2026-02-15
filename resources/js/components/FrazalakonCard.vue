<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { Heart } from 'lucide-vue-next';

export interface Frazalakon {
    id: number;
    slug: string;
    body: string;
    who: string;
    towho: string | null;
    context: string | null;
    where: string | null;
    when: string;
    author: string | null;
    heart_count: number;
    is_liked: boolean;
}

const props = withDefaults(
    defineProps<{
        frazalakon: Frazalakon;
        large?: boolean;
    }>(),
    {
        large: false,
    },
);

function toggleLike(e: Event) {
    e.preventDefault();
    e.stopPropagation();
    router.post(`/${props.frazalakon.slug}/like`, {}, { preserveScroll: true });
}
</script>

<template>
    <blockquote
        class="whitespace-pre-line leading-relaxed"
        :class="large ? 'mb-6 text-2xl' : 'mb-3 text-xl'"
    >
        {{ frazalakon.body }}
    </blockquote>
    <div class="space-y-1 text-sm text-muted-foreground">
        <p class="font-medium text-foreground">
            &mdash; {{ frazalakon.who }}
        </p>
        <p v-if="frazalakon.towho">
            À {{ frazalakon.towho }}
        </p>
        <p v-if="frazalakon.where">
            {{ frazalakon.where }}
        </p>
        <p v-if="frazalakon.context" class="italic">
            {{ frazalakon.context }}
        </p>
        <p v-if="frazalakon.author" class="text-xs opacity-50">
            Ajouté par {{ frazalakon.author }}
        </p>
        <p v-if="frazalakon.when" class="text-xs">
            {{ new Date(frazalakon.when).toLocaleDateString() }}
        </p>
    </div>
    <div class="flex items-center gap-1.5" :class="large ? 'mt-4' : 'mt-3'">
        <button
            v-if="$page.props.auth.user"
            class="flex items-center gap-1 text-sm transition-colors"
            :class="frazalakon.heart_count > 0 ? 'text-heart' : 'text-muted-foreground'"
            @click="toggleLike($event)"
        >
            <Heart
                class="h-4 w-4"
                :fill="frazalakon.heart_count > 0 ? 'currentColor' : 'none'"
            />
            {{ frazalakon.heart_count }}
        </button>
        <span
            v-else
            class="flex items-center gap-1 text-sm"
            :class="frazalakon.heart_count > 0 ? 'text-heart' : 'text-muted-foreground'"
        >
            <Heart class="h-4 w-4" :fill="frazalakon.heart_count > 0 ? 'currentColor' : 'none'" />
            {{ frazalakon.heart_count }}
        </span>
    </div>
</template>
