const newsletter = Vue.createApp({
    data() {
        return {
            showContent: {}
        };
    },
    methods: {
        toggleContent(id) {
            this.showContent[id] = !this.showContent[id];
        }
    }
});
newsletter.mount('body');