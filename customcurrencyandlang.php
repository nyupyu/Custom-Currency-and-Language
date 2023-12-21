<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class customcurrencyandlang extends Module
{
    public function __construct()
    {
        $this->name = 'customcurrencyandlang';
        $this->tab = 'front_office_features';
        $this->version = '0.0.2';
        $this->author = 'nyupyu';

        parent::__construct();

        $this->displayName = $this->l('Custom Currency and Language');
        $this->description = $this->l('Module to set default currency and language on the front end.');
    }

    public function install()
    {
        if (parent::install()) {
            $availableLanguages = array('pl', 'en');
            $defaultLanguage = 'en';
            $browserLanguage = $this->getBrowserLanguage($availableLanguages, $defaultLanguage);

            Configuration::updateValue('PS_LANG_DEFAULT', 1);

            Configuration::updateValue('PS_ADMIN_LANGUAGE', 1);
     
            Configuration::updateValue('PS_CURRENCY_DEFAULT', 1);
            
            Configuration::updateValue('PS_ADMIN_CURRENCY', 2);

            return true;
        }

        return false;
    }

    public function getBrowserLanguage($available, $default)
    {
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
            if (empty($available)) {
                return empty($langs) ? $default : $langs[0];
            }

            foreach ($langs as $lang) {
                $lang = substr($lang, 0, 2);
                if (in_array($lang, $available)) {
                    return $lang;
                }
            }
        }
        return $default;
    }
}
