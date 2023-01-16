<template>
    <div class="alert-container">
        <transition name="slide-fade">
            <div class="alert" v-if="message"
                 :class="{ 'alert-danger': message.type === 'error','alert-success': message.type === 'success','alert-warning': message.type==='warning', 'alert-info' : (!message.type || message.type === 'info')}">
                <div class="alert-content">
                    <p>{{ message.text }}</p>
                </div>
                <button @click.prevent="message = null" class="alert-close">
                    ×
                </button>
            </div>
        </transition>
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
        let timer;
        bus.$on('flash-message', (message) => {
            clearTimeout(timer);

            this.message = message;

            timer = setTimeout(() => {
                this.message = null;
            }, 5000);
        });
    }

};
</script>

<style scoped>
.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: all 0.4s;
}

.slide-fade-enter,
.slide-fade-leave-to {
    transform: translateX(400px);
    opacity: 0;
}

.alert-container{
    min-width: 400px;
    position: fixed;
    top: 10px;
    right: 10px;
}

.alert {
    display: flex;
    align-items: center;
    padding: 0.55rem 0.65rem 0.55rem 0.75rem;
    border-radius: .5rem;
    justify-content: space-between;
    margin-bottom: 2rem;
    box-shadow: 0px 3.2px 13.8px rgba(0, 0, 0, 0.02),
    0 7.6px 33.3px rgba(0, 0, 0, 0.028),
    0px 14.4px 62.6px rgba(0, 0, 0, 0.035),
    0px 25.7px 111.7px rgba(0, 0, 0, 0.042),
    0px 48px 208.9px rgba(0, 0, 0, 0.05),
    0px 115px 500px rgba(0, 0, 0, 0.07);
    color: #fff;
}

.alert-content {
    display: flex;
    align-items: center;
}

.alert-close {
    background-color: transparent;
    border: none;
    outline: none;
    transition: all 0.2s ease-in-out;
    padding: 0.75rem;
    border-radius: 0.5rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.alert-close:hover {
    background-color: #FFF;
}

.alert-success {
    background-color: rgba(62, 189, 97, 0.6);
    border: 2px solid #3EBD61;
}

.alert-info {
    background-color: rgba(0, 108, 227, 0.6);
    border: 2px solid #006CE3;
}

.alert-warning {
    background-color: rgba(239, 148, 0, 0.6);
    border: 2px solid #EF9400;
}

.alert-danger {
    background-color: rgba(236, 77, 43, 0.6);
    border: 2px solid #EF9400;
}
</style>
