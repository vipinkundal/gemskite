<script setup>
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <div>
        <div>
            <Link href="/">
                <!-- <BreezeApplicationLogo/> -->
            </Link>
        </div>

        <div>
            <slot />
        </div>
    </div>
</template>
