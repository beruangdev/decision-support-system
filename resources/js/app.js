import './bootstrap';

import "./scripts/helper"
import "./scripts/dark-mode"
import "./scripts/dropdown"

import "./scripts/alternative/alternative-create"
import "./scripts/alternative/alternative-edit"
import "./scripts/alternative/alternative-delete"

import "./scripts/project/project-create"
import "./scripts/project/project-edit"
import "./scripts/project/project-delete"

import "./scripts/project-method/project-method-create"

import "./vendor/flowbite/dropdown"

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
