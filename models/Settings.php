<?php

namespace Weglot\TranslatePlugin\Models;

use Model;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'weglot_translate';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';
}