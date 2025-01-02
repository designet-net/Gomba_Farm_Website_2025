<?php

namespace SuperbAddons\Data\Utils;

defined('ABSPATH') || exit();

class CacheTypes
{
    const ELEMENTOR = 'elementor';
    const GUTENBERG = 'gutenberg';
}

class CacheOptions
{
    const SERVICE_VERSION = 'service_version';
}

class ElementorCache
{
    const SECTIONS = 'elementor_section_cache';
}

class GutenbergCache
{
    const PATTERNS = 'gutenberg_pattern_cache';
    const PAGES = 'gutenberg_page_cache';
}
