import "./bootstrap";
import "./sidebar";
import "./datatable";
import "./demo/chart-area-demo";
import "./demo/datatables-demo";
import "./demo/chart-bar-demo";
import "./demo/chart-pie-demo";

import { createApp } from "vue";
import "../css/app.css";

import App from "./App.vue";

createApp(App).mount("#app");
