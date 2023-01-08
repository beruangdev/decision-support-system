import './bootstrap';
const is_production = import.meta.env.PROD

window.ASEET_PATH = "/public"
const hostname = window.location.hostname
if (hostname == "localhost" || hostname.startsWith("192.168")) window.ASEET_PATH = ""
// if (!is_production) window.ASEET_PATH = ""
// window.ASEET_PATH = ""

import "./scripts"
import "./vendor"
import "./algorithms"

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// console.log("window.meta", import.meta.env);
