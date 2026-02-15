<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { User, Settings, LogOut, Clock } from 'lucide-vue-next';
import { toast } from 'vue-sonner';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';

function logout() {
    router.post('/logout', {}, {
        onSuccess: () => {
            toast.success('À bientôt !');
        },
    });
}
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
                <DropdownMenu v-if="$page.props.auth.user">
                    <DropdownMenuTrigger
                        class="flex h-8 w-8 items-center justify-center rounded-full border border-border text-muted-foreground transition-colors hover:border-primary hover:text-foreground"
                        title="Mon compte"
                    >
                        <User class="h-4 w-4" />
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end" class="w-48">
                        <DropdownMenuLabel class="font-normal">
                            <p class="text-sm font-medium">{{ $page.props.auth.user.name }}</p>
                            <p class="text-xs text-muted-foreground">{{ $page.props.auth.user.email }}</p>
                        </DropdownMenuLabel>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem v-if="$page.props.auth.user?.is_admin" as-child>
                            <Link href="/admin/pending" class="flex items-center gap-2">
                                <Clock class="h-4 w-4" />
                                Dernières fzk
                            </Link>
                        </DropdownMenuItem>
                        <DropdownMenuItem as-child>
                            <Link href="/settings/profile" class="flex items-center gap-2">
                                <Settings class="h-4 w-4" />
                                Mon profil
                            </Link>
                        </DropdownMenuItem>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem
                            class="flex items-center gap-2 text-destructive focus:text-destructive"
                            @click="logout"
                        >
                            <LogOut class="h-4 w-4" />
                            Déconnexion
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </nav>
        </div>
    </header>
</template>
