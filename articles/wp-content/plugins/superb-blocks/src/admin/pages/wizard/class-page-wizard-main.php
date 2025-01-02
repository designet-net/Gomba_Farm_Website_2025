<?php

namespace SuperbAddons\Admin\Pages\Wizard;

use SuperbAddons\Admin\Controllers\Wizard\WizardController;
use SuperbAddons\Gutenberg\Controllers\GutenbergController;

defined('ABSPATH') || exit();

class PageWizardMainPage
{
    public function __construct()
    {
        if (!GutenbergController::is_block_theme()) {
            new PageWizardIncompatiblePage();
            return;
        }

        if (WizardController::IsCompleteScreen()) {
            new PageWizardCompletePage();
            return;
        }

        if (WizardController::IsWizardStages()) {
            new PageWizardStagesPage();
            return;
        }

        new PageWizardIntroPage();
    }
}
