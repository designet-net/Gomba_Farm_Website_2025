<?php

namespace SuperbAddons\Config;

defined('ABSPATH') || exit();

class Config
{
    // Available service API domains
    const API_DOMAINS = array("https://superbdemo.com/api/wp-json/", "https://superbthemes.com/wp-json/");
}

class Capabilities
{
    const CONTRIBUTOR = 'edit_posts';
    const ADMIN = 'manage_options';
}
