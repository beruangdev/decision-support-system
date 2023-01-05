import './bootstrap';

window.ASEET_PATH = "/public"
if (window.location.hostname == "localhost") window.ASEET_PATH = ""

import "./scripts"
import "./vendor"
import "./algorithms"

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
