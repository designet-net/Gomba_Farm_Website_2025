<?php

namespace SuperbAddons\Data\Controllers;

defined('ABSPATH') || exit();

use SuperbAddons\Config\Config;
use SuperbAddons\Data\Utils\KeyType;
use SuperbAddons\Data\Utils\OptionException;

class OptionController
{
    private $current_keydomain_option = false;

    public function __construct()
    {
    }

    /* Domains */
    public function GetPreferredDomain($refresh = false)
    {
        $current_option = self::GetKeyDomainOption($refresh);
        return Config::API_DOMAINS[$current_option[KeyDomainOptionKey::DOMAIN]];
    }

    public function UpdateAPIDomain($domain)
    {
        $domain = absint($domain);
        if ($domain < 0 || $domain >= count(Config::API_DOMAINS)) {
            throw new OptionException(__("Invalid Domain Key. Option could not be updated.", "superb-blocks"));
        }
        $current_option = self::GetKeyDomainOption(true);
        $current_option[KeyDomainOptionKey::DOMAIN] = $domain;
        return update_option(Option::KEY_DOMAIN, $current_option);
    }
    /* */

    /* Keys */
    public function GetKey()
    {
        $current_option = self::GetKeyDomainOption();
        return $current_option[KeyDomainOptionKey::KEY];
    }

    public function GetStamp()
    {
        $current_option = self::GetKeyDomainOption();
        return $current_option[KeyDomainOptionKey::STAMP];
    }

    public function GetKeyType()
    {
        $current_option = self::GetKeyDomainOption();
        return $current_option[KeyDomainOptionKey::KEYTYPE];
    }

    public function KeyIsActive()
    {
        $current_option = self::GetKeyDomainOption();
        return $current_option[KeyDomainOptionKey::KEYACTIVE];
    }

    public function KeyIsExpired()
    {
        $current_option = self::GetKeyDomainOption();
        return $current_option[KeyDomainOptionKey::KEYEXPIRED];
    }

    public function KeyIsExceeded()
    {
        $current_option = self::GetKeyDomainOption();
        return isset($current_option[KeyDomainOptionKey::KEYEXCEEDED]) ? $current_option[KeyDomainOptionKey::KEYEXCEEDED] : false;
    }

    public function KeyIsVerified()
    {
        $current_option = self::GetKeyDomainOption();
        if (!isset($current_option[KeyDomainOptionKey::STAMP]) || !isset($current_option[KeyDomainOptionKey::VERIFIED])) {
            return false;
        }
        return !!$current_option[KeyDomainOptionKey::STAMP] && $current_option[KeyDomainOptionKey::VERIFIED];
    }

    public function SetKeyVerificationFailed()
    {
        $current_option = self::GetKeyDomainOption();
        $current_option[KeyDomainOptionKey::VERIFIED] = false;
        return update_option(Option::KEY_DOMAIN, $current_option);
    }

    public function HasRegisteredKey()
    {
        $current_option = self::GetKeyDomainOption();
        return !!$current_option[KeyDomainOptionKey::KEY];
    }

    public function HasPremiumKey()
    {
        $current_option = self::GetKeyDomainOption();
        return !!$current_option[KeyDomainOptionKey::KEY] && $current_option[KeyDomainOptionKey::KEYTYPE] === KeyType::PREMIUM;
    }

    public function HasStandardKey()
    {
        $current_option = self::GetKeyDomainOption();
        return !!$current_option[KeyDomainOptionKey::KEY] && $current_option[KeyDomainOptionKey::KEYTYPE] === KeyType::STANDARD;
    }

    public function UpdateKey($key, $stamp)
    {
        if (strlen($key) !== 23) {
            throw new OptionException(__("Invalid License Key. Option could not be updated.", "superb-blocks"));
        }
        $current_option = self::GetKeyDomainOption(true);
        $current_option[KeyDomainOptionKey::KEY] = $key;
        if ($stamp > 0) {
            $current_option[KeyDomainOptionKey::STAMP] = $stamp;
        }
        $current_option[KeyDomainOptionKey::VERIFIED] = true;
        return update_option(Option::KEY_DOMAIN, $current_option);
    }

    public function UpdateKeyType($keytype, $active, $expired, $exceeded)
    {
        $current_option = self::GetKeyDomainOption(true);
        $current_option[KeyDomainOptionKey::KEYTYPE] = $keytype;
        $current_option[KeyDomainOptionKey::KEYACTIVE] = !!$active;
        $current_option[KeyDomainOptionKey::KEYEXPIRED] = !!$expired;
        $current_option[KeyDomainOptionKey::KEYEXCEEDED] = !!$exceeded;
        return update_option(Option::KEY_DOMAIN, $current_option);
    }

    public function RemoveKey()
    {
        $current_option = self::GetKeyDomainOption(true);
        $current_option[KeyDomainOptionKey::KEY] = false;
        $current_option[KeyDomainOptionKey::KEYTYPE] = KeyType::FREE;
        return update_option(Option::KEY_DOMAIN, $current_option);
    }

    private function GetKeyDomainOption($refresh = false)
    {
        if (!$this->current_keydomain_option || $refresh) {
            $this->current_keydomain_option = get_option(Option::KEY_DOMAIN, array(KeyDomainOptionKey::DOMAIN => 0, KeyDomainOptionKey::KEY => false, KeyDomainOptionKey::KEYTYPE => KeyType::FREE, KeyDomainOptionKey::KEYEXPIRED => false, KeyDomainOptionKey::KEYACTIVE => true, KeyDomainOptionKey::STAMP => false, KeyDomainOptionKey::VERIFIED => false, KeyDomainOptionKey::KEYEXCEEDED => false));
        }
        return $this->current_keydomain_option;
    }

    /* */

    /* Cache */
    public function GetCache($cache_option)
    {
        return get_option($cache_option, false);
    }

    public function SetCache($cache_option, $data)
    {
        if (!$cache_option) {
            return false;
        }
        return update_option(
            $cache_option,
            array(
                'last_update' => time(),
                'data' => $data
            ),
            false
        );
    }

    public function ClearCache($cache_option)
    {
        if (!$cache_option) {
            return false;
        }

        // Return true if cache is already cleared
        if (!$this->GetCache($cache_option)) return true;

        return delete_option($cache_option);
    }

    public static function GetSettings()
    {
        return get_option(Option::SETTINGS, array(SettingsOptionKey::LOGS_ENABLED => true, SettingsOptionKey::LOG_SHARE_ENABLED => false));
    }

    public function SaveSettings($settings)
    {
        return update_option(Option::SETTINGS, $settings);
    }

    public static function GetCompatibilitySettings()
    {
        return get_option(Option::COMPATIBILITY_SETTINGS, array(CompatibilitySettingsOptionKey::SPECTRA_BLOCK_SPACING => true));
    }

    public function SaveCompatibilitySettings($compatibility_settings)
    {
        return update_option(Option::COMPATIBILITY_SETTINGS, $compatibility_settings);
    }

    /* */
}

class Option
{
    const PREFIX = 'superbaddonslibrary_';
    const KEY_DOMAIN = self::PREFIX . 'keydomain';
    const SETTINGS = self::PREFIX . 'settings';
    const COMPATIBILITY_SETTINGS = self::PREFIX . 'compatibilitysettings';
}

class KeyDomainOptionKey
{
    const DOMAIN = 'spbdomain';
    const KEY = 'spbkey';
    const KEYTYPE = 'spbkeytype';
    const KEYACTIVE = 'spbkeyactive';
    const KEYEXPIRED = 'spbkeyexpired';
    const KEYEXCEEDED = 'spbkeyexceeded';
    const STAMP = 'spbkeystamp';
    const VERIFIED = 'spbkeyverified';
}

class SettingsOptionKey
{
    const LOGS_ENABLED = 'spblogsenabled';
    const LOG_SHARE_ENABLED = 'spblogshareenabled';
}

class CompatibilitySettingsOptionKey
{
    const SPECTRA_BLOCK_SPACING = 'spbspectrablockspacing';
}
