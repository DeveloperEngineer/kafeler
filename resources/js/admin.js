import {createApp} from "vue";
import AdminApp from "./AdminApp.vue";
import router from "./router";
import {createPinia} from "pinia";


const app = createApp(AdminApp);
const pinia = createPinia();

app.use(pinia);
app.use(router);
app.mount("#admin");
