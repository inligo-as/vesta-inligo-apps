<?php

Vesta::add_header_menu('Inligo Apps', '/plugin/vesta-inligo-apps/');

if (Vesta::is_plugin_page('vesta-inligo-apps')) {
    Vesta::add_css('/plugin/vesta-inligo-apps/style.css');
}
