<template>
    <svg :class="sizeClass" v-on="$listeners" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
    </svg>
</template>

<script>
import Sizable from './Sizable';

export default {
    mixins: [Sizable],
};
</script>
