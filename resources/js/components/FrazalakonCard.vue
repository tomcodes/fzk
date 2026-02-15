<script lang="ts">
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
    public?: boolean;
}
</script>

<script setup lang="ts">
import { ref, computed } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import { Heart, Pencil, Trash2, CheckCircle } from 'lucide-vue-next';
import { toast } from 'vue-sonner';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogFooter,
} from '@/components/ui/dialog';

const props = withDefaults(
    defineProps<{
        frazalakon: Frazalakon;
        large?: boolean;
    }>(),
    {
        large: false,
    },
);

const showEditModal = ref(false);
const showDeleteModal = ref(false);
const deleteConfirmInput = ref('');

const editForm = useForm({
    body: props.frazalakon.body,
    who: props.frazalakon.who,
    towho: props.frazalakon.towho || '',
    context: props.frazalakon.context || '',
    where: props.frazalakon.where || '',
    when: props.frazalakon.when ? props.frazalakon.when.substring(0, 10) : '',
    public: props.frazalakon.public ?? false,
});

function toggleLike(e: Event) {
    e.preventDefault();
    e.stopPropagation();
    router.post(`/${props.frazalakon.slug}/like`, {}, { preserveScroll: true });
}

function openEdit(e: Event) {
    e.preventDefault();
    e.stopPropagation();
    editForm.body = props.frazalakon.body;
    editForm.who = props.frazalakon.who;
    editForm.towho = props.frazalakon.towho || '';
    editForm.context = props.frazalakon.context || '';
    editForm.where = props.frazalakon.where || '';
    editForm.when = props.frazalakon.when ? props.frazalakon.when.substring(0, 10) : '';
    editForm.public = props.frazalakon.public ?? false;
    showEditModal.value = true;
}

function submitEdit() {
    editForm.put(`/admin/frazalakons/${props.frazalakon.slug}`, {
        preserveScroll: true,
        onSuccess: () => {
            showEditModal.value = false;
            toast.success('Frazalakon modifiée');
        },
    });
}

const showPublishModal = ref(false);

function openPublish(e: Event) {
    e.preventDefault();
    e.stopPropagation();
    showPublishModal.value = true;
}

function confirmPublish() {
    router.post(`/admin/frazalakons/${props.frazalakon.slug}/publish`, {}, {
        preserveScroll: true,
        onSuccess: () => {
            showPublishModal.value = false;
            showEditModal.value = false;
            toast.success('Frazalakon publiée');
        },
    });
}

const deleteConfirmSentence = computed(() =>
    `supprimer ${props.frazalakon.who}`,
);

const canDelete = computed(() =>
    deleteConfirmInput.value.trim().toLowerCase() === deleteConfirmSentence.value.toLowerCase(),
);

function openDelete() {
    deleteConfirmInput.value = '';
    showDeleteModal.value = true;
}

function deleteFzk() {
    if (!canDelete.value) return;
    router.delete(`/admin/frazalakons/${props.frazalakon.slug}`, {
        preserveScroll: true,
        onSuccess: () => {
            showDeleteModal.value = false;
            toast.success('Frazalakon supprimée');
        },
    });
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
    <div class="flex items-center gap-3" :class="large ? 'mt-4' : 'mt-3'">
        <button
            v-if="$page.props.auth.user"
            class="flex items-center gap-1 text-sm transition-colors"
            :class="frazalakon.heart_count > 0 ? 'text-heart' : 'text-muted-foreground'"
            title="J'aime"
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

        <button
            v-if="$page.props.auth.user?.is_admin"
            class="text-muted-foreground transition-colors hover:text-foreground"
            title="Modifier"
            @click="openEdit($event)"
        >
            <Pencil class="h-4 w-4" />
        </button>

        <button
            v-if="$page.props.auth.user?.is_admin && !frazalakon.public"
            class="text-muted-foreground transition-colors hover:text-primary"
            title="Publier"
            @click="openPublish($event)"
        >
            <CheckCircle class="h-4 w-4" />
        </button>

        <button
            v-if="$page.props.auth.user?.is_admin"
            class="text-muted-foreground transition-colors hover:text-destructive"
            title="Supprimer"
            @click="$event.preventDefault(); $event.stopPropagation(); openDelete()"
        >
            <Trash2 class="h-4 w-4" />
        </button>
    </div>

    <Dialog v-model:open="showEditModal">
        <DialogContent class="max-w-lg">
            <DialogHeader>
                <DialogTitle>Modifier la frazalakon</DialogTitle>
            </DialogHeader>
            <form class="space-y-4" @submit.prevent="submitEdit">
                <div>
                    <label class="mb-1 block text-sm font-medium">Citation *</label>
                    <textarea
                        v-model="editForm.body"
                        rows="4"
                        class="flex w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                    />
                    <p v-if="editForm.errors.body" class="mt-1 text-sm text-destructive">{{ editForm.errors.body }}</p>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium">Qui *</label>
                    <Input v-model="editForm.who" />
                    <p v-if="editForm.errors.who" class="mt-1 text-sm text-destructive">{{ editForm.errors.who }}</p>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium">À qui</label>
                    <Input v-model="editForm.towho" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium">Contexte</label>
                    <Input v-model="editForm.context" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium">Où</label>
                    <Input v-model="editForm.where" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium">Date</label>
                    <Input v-model="editForm.when" type="date" />
                </div>
                <div class="flex items-center gap-2">
                    <input
                        id="edit-public"
                        v-model="editForm.public"
                        type="checkbox"
                        class="h-4 w-4 rounded border-input"
                    />
                    <label for="edit-public" class="text-sm font-medium">Publiée</label>
                </div>
                <DialogFooter class="flex items-center gap-2">
                    <Button
                        type="button"
                        variant="destructive"
                        size="sm"
                        title="Supprimer cette frazalakon"
                        @click="showEditModal = false; openDelete()"
                    >
                        <Trash2 class="mr-1 h-4 w-4" />
                        Supprimer
                    </Button>
                    <div class="flex-1" />
                    <Button type="submit" :disabled="editForm.processing" title="Enregistrer les modifications">
                        Enregistrer
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>

    <Dialog v-model:open="showDeleteModal">
        <DialogContent class="max-w-md">
            <DialogHeader>
                <DialogTitle>Supprimer cette frazalakon</DialogTitle>
            </DialogHeader>
            <div class="space-y-4">
                <p class="text-sm text-muted-foreground">
                    Cette action est irréversible. Pour confirmer, tape
                    <strong class="text-foreground">{{ deleteConfirmSentence }}</strong>
                    ci-dessous.
                </p>
                <Input
                    v-model="deleteConfirmInput"
                    :placeholder="deleteConfirmSentence"
                    @keydown.enter.prevent="deleteFzk"
                />
            </div>
            <DialogFooter>
                <Button
                    type="button"
                    variant="outline"
                    title="Annuler"
                    @click="showDeleteModal = false"
                >
                    Annuler
                </Button>
                <Button
                    type="button"
                    variant="destructive"
                    :disabled="!canDelete"
                    title="Confirmer la suppression"
                    @click="deleteFzk"
                >
                    Supprimer définitivement
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>

    <Dialog v-model:open="showPublishModal">
        <DialogContent class="max-w-md">
            <DialogHeader>
                <DialogTitle>Publier cette frazalakon ?</DialogTitle>
            </DialogHeader>
            <blockquote class="whitespace-pre-line border-l-2 border-primary pl-3 text-sm italic">
                {{ frazalakon.body }}
            </blockquote>
            <p class="text-sm text-muted-foreground">
                &mdash; {{ frazalakon.who }}
            </p>
            <DialogFooter>
                <Button
                    type="button"
                    variant="outline"
                    title="Annuler"
                    @click="showPublishModal = false"
                >
                    Annuler
                </Button>
                <Button
                    type="button"
                    title="Confirmer la publication"
                    @click="confirmPublish"
                >
                    Publier
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
