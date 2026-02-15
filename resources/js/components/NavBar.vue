<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
</script>

<template>
    <header
        class="sticky top-0 z-10 border-b border-border bg-background/95 backdrop-blur"
    >
        <div
            class="mx-auto flex max-w-3xl items-center justify-between px-4 py-3"
        >
            <Link href="/" class="text-lg font-semibold hover:text-primary">
                Frazalakon
            </Link>
            <nav class="flex items-center gap-8">
                <Link
                    href="/top-47"
                    class="text-sm text-muted-foreground hover:text-foreground"
                    :class="{
                        'text-foreground font-medium':
                            $page.url.startsWith('/top-47'),
                    }"
                >
                    Top 47
                </Link>
                <Link
                    href="/random"
                    class="text-sm text-muted-foreground hover:text-foreground"
                >
                    Aléatoire
                </Link>
                <Link
                    href="/denonciation"
                    class="rounded-md bg-primary px-3 py-1.5 text-sm font-medium text-primary-foreground transition-colors hover:bg-primary/80"
                >
                    Dénonciation anonyme
                </Link>
                <template v-if="$page.props.auth.user">
                    <span class="mx-1 text-border">|</span>
                    <Link
                        :href="dashboard()"
                        class="text-sm text-muted-foreground hover:text-foreground"
                    >
                        Tableau de bord
                    </Link>
                </template>
            </nav>
        </div>
    </header>
</template>
