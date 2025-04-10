const info = Vue.createApp({
    data() {
        return {
            currentComponent: '',
            isPasswordFormVisible: false,
            orderSuccessful: false
        }
    },
    methods: {
        showComponent(component) {
            this.currentComponent = component;
            this.isPasswordFormVisible = false; // Hide password form if any other component is selected
        },
        showPasswordForm() {
            this.currentComponent = ''; // Reset current component
            this.isPasswordFormVisible = true;
        },
        closeAccountPopup() {
            this.currentComponent = '';
        },
        closePasswordPopup() {
            this.isPasswordFormVisible = false;
        }
    }
});
info.mount('#info');