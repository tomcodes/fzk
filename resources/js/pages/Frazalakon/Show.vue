<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { Card, CardContent } from '@/components/ui/card';
import { Heart } from 'lucide-vue-next';
import NavBar from '@/components/NavBar.vue';

interface Frazalakon {
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

defineProps<{
    frazalakon: Frazalakon;
}>();

function toggleLike(slug: string) {
    router.post(`/${slug}/like`, {}, { preserveScroll: true });
}
</script>

<template>
    <Head :title="`${frazalakon.who} — Frazalakon`" />
    <div class="min-h-screen bg-background text-foreground">
        <NavBar />

        <main class="mx-auto max-w-3xl px-4 py-8">
            <Card>
                <CardContent class="pt-6">
                    <blockquote
                        class="mb-6 whitespace-pre-line text-lg leading-relaxed"
                    >
                        {{ frazalakon.body }}
                    </blockquote>
                    <div class="space-y-1 text-sm text-muted-foreground">
                        <p class="font-medium text-foreground">
                            &mdash; {{ frazalakon.who }}
                        </p>
                        <p v-if="frazalakon.towho">
                            To {{ frazalakon.towho }}
                        </p>
                        <p v-if="frazalakon.where">
                            {{ frazalakon.where }}
                        </p>
                        <p v-if="frazalakon.context" class="italic">
                            {{ frazalakon.context }}
                        </p>
                        <p v-if="frazalakon.author">
                            Added by {{ frazalakon.author }}
                        </p>
                    </div>
                    <div class="mt-4 flex items-center gap-1.5">
                        <button
                            v-if="$page.props.auth.user"
                            class="flex items-center gap-1 text-sm text-muted-foreground transition-colors hover:text-destructive"
                            :class="{
                                'text-destructive': frazalakon.is_liked,
                            }"
                            @click="toggleLike(frazalakon.slug)"
                        >
                            <Heart
                                class="h-4 w-4"
                                :fill="
                                    frazalakon.is_liked
                                        ? 'currentColor'
                                        : 'none'
                                "
                            />
                            {{ frazalakon.heart_count }}
                        </button>
                        <span
                            v-else
                            class="flex items-center gap-1 text-sm text-muted-foreground"
                        >
                            <Heart class="h-4 w-4" />
                            {{ frazalakon.heart_count }}
                        </span>
                    </div>
                </CardContent>
            </Card>
        </main>
    </div>
</template>
