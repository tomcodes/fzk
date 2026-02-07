<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
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
    frazalakons: Frazalakon[];
}>();

function toggleLike(e: Event, fzk: Frazalakon) {
    e.preventDefault();
    e.stopPropagation();
    router.post(`/${fzk.slug}/like`, {}, { preserveScroll: true });
}
</script>

<template>
    <Head title="Top 47 — Frazalakon" />
    <div class="min-h-screen bg-background text-foreground">
        <NavBar />

        <main class="mx-auto max-w-3xl px-4 py-8">
            <h2 class="mb-6 text-xl font-semibold">Top 47</h2>

            <div class="space-y-4">
                <Link
                    v-for="(fzk, index) in frazalakons"
                    :key="fzk.id"
                    :href="`/${fzk.slug}`"
                    class="block"
                >
                    <Card
                        class="transition-colors hover:border-primary/30 hover:bg-accent/50"
                    >
                        <CardContent class="pt-6">
                            <div class="mb-3 flex items-start gap-3">
                                <span
                                    class="mt-0.5 text-lg font-bold text-muted-foreground"
                                >
                                    #{{ index + 1 }}
                                </span>
                                <blockquote
                                    class="whitespace-pre-line text-base leading-relaxed"
                                >
                                    {{ fzk.body }}
                                </blockquote>
                            </div>
                            <div
                                class="space-y-1 text-sm text-muted-foreground"
                            >
                                <p class="font-medium text-foreground">
                                    &mdash; {{ fzk.who }}
                                </p>
                                <p v-if="fzk.towho">
                                    To {{ fzk.towho }}
                                </p>
                                <p v-if="fzk.where">
                                    {{ fzk.where }}
                                </p>
                                <p v-if="fzk.context" class="italic">
                                    {{ fzk.context }}
                                </p>
                                <p v-if="fzk.author">
                                    Added by {{ fzk.author }}
                                </p>
                            </div>
                            <div class="mt-3 flex items-center gap-1.5">
                                <button
                                    v-if="$page.props.auth.user"
                                    class="flex items-center gap-1 text-sm text-muted-foreground transition-colors hover:text-destructive"
                                    :class="{ 'text-destructive': fzk.is_liked }"
                                    @click="toggleLike($event, fzk)"
                                >
                                    <Heart
                                        class="h-4 w-4"
                                        :fill="fzk.is_liked ? 'currentColor' : 'none'"
                                    />
                                    {{ fzk.heart_count }}
                                </button>
                                <span
                                    v-else
                                    class="flex items-center gap-1 text-sm text-muted-foreground"
                                >
                                    <Heart class="h-4 w-4" />
                                    {{ fzk.heart_count }}
                                </span>
                            </div>
                        </CardContent>
                    </Card>
                </Link>
            </div>

            <p
                v-if="frazalakons.length === 0"
                class="py-12 text-center text-muted-foreground"
            >
                No frazalakons yet.
            </p>
        </main>
    </div>
</template>
