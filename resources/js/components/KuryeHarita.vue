<template>
    <div class="p-4">
        <h2>📡 WebSocket Bağlantısı</h2>
        <p v-if="message">🟢 Gelen Mesaj: {{ message }}</p>
    </div>
</template>

<script>
export default {
    data() {
        return {
            message: null,
        };
    },
    mounted() {
        window.Echo.channel('test-channel')
            .listen('TestEvent', (e) => {
                console.log("📥 Gelen Veri:", e);
                this.message = e.message;
            });
    }
}
</script>
