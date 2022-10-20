<template>
    <div>
        <template>
            <div class="text-center">
                <v-progress-circular
                indeterminate
                color="primary"
                ></v-progress-circular>
                <v-progress-circular
                indeterminate
                color="error"
                ></v-progress-circular>
                <v-progress-circular
                indeterminate
                color="info"
                ></v-progress-circular>
                <v-progress-circular
                indeterminate
                color="warning"
                ></v-progress-circular>
            </div>
        </template>
    </div>
</template>
<style scoped>
.v-progress-circular {
  margin: 1rem;
}
</style>