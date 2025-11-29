<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { compile } from '@/routes/index';
import { router } from '@inertiajs/vue3';

const createCompileRequest = async () => {
    router.visit(compile().url);
};
</script>

<template>
    <div class="p-4 m-4 border rounded">
        <p>
            Tekan tombolnya buat kirim request dari server ke OnlineCompiler,
            nanti liat hasilnya di log.
        </p>
        <form
            @submit.prevent="createCompileRequest"
            class="m-8 flex flex-col gap-4"
        >
            <div>
                <Button>Test Webhook</Button>
            </div>
        </form>
    </div>
</template>
