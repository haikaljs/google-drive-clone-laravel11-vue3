<template>
    <div class="h-screen bg-white flex w-full gap-4">
        <Navigation />
        <main class="flex flex-col flex-1 px-4 overflow-hidden">
            <div class="flex items-center justify-between w-full">
                <SearchForm />
                <UserSettingsDropdown />
            </div>
            <div class="flex flex-1 flex-col overflow-hidden">
                <slot />
            </div>
        </main>
    </div>
</template>

<script setup>
import { ref } from "vue";

import Navigation from "@/Components/app/Navigation.vue";
import SearchForm from "@/Components/app/SearchForm.vue";
import UserSettingsDropdown from "@/Components/app/UserSettingsDropdown.vue";
</script>
