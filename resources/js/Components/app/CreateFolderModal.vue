<template>
    <Modal :show="modelValue" @show="onShow" max-width="sm">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">Create New Folder</h2>
            <div class="mt-6">
                <InputLabel
                    for="folderName"
                    value="Folder Name"
                    class="sr-only"
                />
                <TextInput
                    type="text"
                    ref="folderNameInput"
                    id="folderName"
                    v-model="form.name"
                    class="mt-1 block w-full"
                    :class="
                        form.errors.name
                            ? 'border-red-500 focus:border-red-500 focus:red-ring-500'
                            : ''
                    "
                    placeholder="Folder Name"
                    @keyup.enter="createFolder"
                />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                <PrimaryButton
                    class="ml-3"
                    :class="{ 'opacity-25': form.processing }"
                    @click="createFolder"
                    :disable="form.processing"
                    >Submit</PrimaryButton
                >
            </div>
        </div>
    </Modal>
</template>

<script setup>
// Imports
import { nextTick, ref } from "vue";
import Modal from "../Modal.vue";
import TextInput from "../TextInput.vue";

import { useForm } from "@inertiajs/vue3";
import SecondaryButton from "../SecondaryButton.vue";
import InputError from "../InputError.vue";
import InputLabel from "../InputLabel.vue";
import PrimaryButton from "../PrimaryButton.vue";

// Uses
const form = useForm({
    name: "",
});

// Refs
const folderNameInput = ref(null);

// Props & Emit
const { modelValue } = defineProps({
    modelValue: Boolean,
});

const emit = defineEmits(["update:modelValue"]);

// Computed

// Methods
function onShow() {
    nextTick(() => folderNameInput.value.focus());
}

function createFolder() {
    console.log("Create folder");
    form.post(route("folder.create"), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            form.reset();
            // Show success notifications
        },
        onError: () => folderNameInput.value.focus(),
    });
}

function closeModal() {
    emit("update:modelValue");
    form.clearErrors();
    form.reset();
}

// Hooks
</script>

<style scoped></style>
