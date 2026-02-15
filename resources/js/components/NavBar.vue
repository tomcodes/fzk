<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { dashboard, login, register } from '@/routes';

defineProps<{
    canRegister?: boolean;
}>();
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
            <nav class="flex items-center gap-3">
                <Link
                    href="/"
                    class="text-sm text-muted-foreground hover:text-foreground"
                    :class="{
                        'text-foreground font-medium':
                            $page.url === '/' ||
                            $page.url.startsWith('/?'),
                    }"
                >
                    Accueil
                </Link>
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
                    class="text-sm text-muted-foreground hover:text-foreground"
                    :class="{
                        'text-foreground font-medium':
                            $page.url.startsWith('/denonciation'),
                    }"
                >
                    Dénonciation anonyme
                </Link>
                <span class="mx-1 text-border">|</span>
                <Link
                    v-if="$page.props.auth.user"
                    :href="dashboard()"
                    class="text-sm text-muted-foreground hover:text-foreground"
                >
                    Tableau de bord
                </Link>
                <template v-else>
                    <Link
                        :href="login()"
                        class="text-sm text-muted-foreground hover:text-foreground"
                    >
                        Connexion
                    </Link>
                    <Link
                        v-if="canRegister"
                        :href="register()"
                        class="text-sm text-muted-foreground hover:text-foreground"
                    >
                        Inscription
                    </Link>
                </template>
            </nav>
        </div>
    </header>
</template>
