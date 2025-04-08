<?php
$thisfile = basename(__FILE__, ".php");
register_plugin(
    $thisfile,
    '🍪 Cookie Monster',
    '1.0',
    'Multicolor',
    'https://www.gofundme.com/f/support-the-getsimple-ce-cms-project',
    'Advanced cookieconsent plugin with GDPR options, styles and categories.',
    'settings',
    'cookieMonster_admin'
);

add_action('theme-footer', 'cookieMonster_load_scripts');

add_action('plugins-sidebar', 'createSideMenu', [
    $thisfile,
    '
Cookie Monster Settings 🍪',
    ' cookieMonster_admin'
]);

function cookieMonster_load_scripts()
{
    global $SITEURL;
    $plugin_dir = $SITEURL . 'plugins/cookieMonster/';

    echo '<link rel="stylesheet" href="' . $plugin_dir . 'cookieconsent.css">';
    echo '<script src="' . $plugin_dir . 'cookieconsent.min.js"></script>';

    $settings_file = GSDATAOTHERPATH . 'cookieMonster_settings.json';
    $settings = file_exists($settings_file) ? json_decode(file_get_contents($settings_file), true) : [];

    if (empty($settings)) {
        $settings = [
            'layout' => 'box',
            'position' => 'bottom',
            'language' => 'en',
            'style' => 'light',
            'categories' => [
                'analytics' => true,
                'marketing' => true,
                'preferences' => true,
                'social' => true
            ],
            'cookieExpires' => 365,
            'cookieDomain' => '',
            'text' => [
                'consentTitle' => 'Consent to cookies',
                'consentDescription' => 'We use cookies to improve your experience. Customize your preferences below.'
            ],
            'categoryDescriptions' => [
                'necessary' => 'These cookies are required for the website to function.',
                'analytics' => 'They help us analyze site traffic.',
                'marketing' => 'Used to personalize advertising.',
                'preferences' => 'They remember your settings.',
                'social' => 'Social media integration.'
            ],
            'customCookies' => [
                'necessary' => '',
                'analytics' => '',
                'marketing' => '',
                'preferences' => '',
                'social' => ''
            ]
        ];
    }

    $default_cookie_categories = [
        'necessary' => ['PHPSESSID', 'session_', '_csrf'],
        'analytics' => ['_ga', '_gid', '_gat'],
        'marketing' => ['_fbp', 'fr', 'tr'],
        'preferences' => ['lang', 'theme', 'settings'],
        'social' => ['_tw', '_li', '_pin']
    ];

    $cookie_categories = $default_cookie_categories;
    foreach (['necessary', 'analytics', 'marketing', 'preferences', 'social'] as $category) {
        if (!empty($settings['customCookies'][$category])) {
            $custom = array_filter(array_map('trim', explode(',', $settings['customCookies'][$category])));
            $cookie_categories[$category] = array_merge($default_cookie_categories[$category], $custom);
        }
    }

    $detected_cookies = [];
    foreach ($_COOKIE as $name => $value) {
        foreach ($cookie_categories as $category => $patterns) {
            foreach ($patterns as $pattern) {
                if (strpos($name, $pattern) !== false) {
                    $detected_cookies[$category][] = $name;
                    break;
                }
            }
        }
    }

    ?>
    <style>
        #cc-main {
            font-family: Arial, sans-serif;
        }

        <?php if ($settings['style'] === 'light'): ?>


        <?php elseif ($settings['style'] === 'light-funky'): ?>

            #cc-main {
                color-scheme: light;

                --cc-bg: #f9faff;
                --cc-primary-color: #112954;
                --cc-secondary-color: #112954;

                --cc-btn-primary-bg: #3859d0;
                --cc-btn-primary-color: var(--cc-bg);
                --cc-btn-primary-hover-bg: #213657;
                --cc-btn-primary-hover-color: #fff;

                --cc-btn-secondary-bg: #dfe7f9;
                --cc-btn-secondary-color: var(--cc-secondary-color);
                --cc-btn-secondary-hover-bg: #c6d1ea;
                --cc-btn-secondary-hover-color: #000;

                --cc-cookie-category-block-bg: #ebeff9;
                --cc-cookie-category-block-border: #ebeff9;
                --cc-cookie-category-block-hover-bg: #dbe5f9;
                --cc-cookie-category-block-hover-border: #dbe5f9;
                --cc-cookie-category-expanded-block-hover-bg: #ebeff9;
                --cc-cookie-category-expanded-block-bg: #ebeff9;

                --cc-overlay-bg: rgba(219, 232, 255, 0.85) !important;

                --cc-toggle-readonly-bg: #cbd8f1;
                --cc-toggle-on-knob-bg: var(--cc-bg);
                --cc-toggle-off-bg: #8fa8d6;
                --cc-toggle-readonly-knob-bg: var(--cc-bg);

                --cc-separator-border-color: #f1f3f5;

                --cc-footer-border-color: #f1f3f5;
                --cc-footer-bg: var(--cc-bg);

                --cc-btn-border-radius: 1rem .6rem 1.3rem .5rem / .5rem 1rem;
                --cc-modal-border-radius: var(--cc-btn-border-radius);
                --cc-pm-toggle-border-radius: var(--cc-btn-border-radius);
            }

            #cc-main .toggle__icon:after {
                border-radius: var(--cc-btn-border-radius);
            }

            #cc-main .cm__btn--close {
                border-radius: var(--cc-btn-border-radius);
                border-top-left-radius: 0;
                border-top-right-radius: 0;
            }

        <?php endif; ?>

        <?php if ($settings['style'] === 'dark'): ?>
            #cc-main {
                --cc-bg: #000;
                --cc-primary-color: rgb(239, 244, 246);
                --cc-secondary-color: #b1bdc3;

                --cc-btn-primary-bg: #ffffff;
                --cc-btn-primary-color: #000;
                --cc-btn-primary-hover-bg: #ccd4d8;
                --cc-btn-primary-hover-color: #000;

                --cc-btn-secondary-bg: rgba(255, 255, 255, 0.039);
                --cc-btn-secondary-color: var(--cc-primary-color);
                --cc-btn-secondary-border-color: #252729;
                --cc-btn-secondary-hover-bg: #252729;
                --cc-btn-secondary-hover-color: #fff;
                --cc-btn-secondary-hover-border-color: #252729;

                --cc-cookie-category-block-bg: #101111;
                --cc-cookie-category-block-border: #1d1e1f;
                --cc-cookie-category-block-hover-bg: #151516;
                --cc-cookie-category-block-hover-border: #1d1e1f;
                --cc-cookie-category-expanded-block-hover-bg: #1d1e1f;
                --cc-cookie-category-expanded-block-bg: #101111;
                --cc-toggle-readonly-bg: #2f3132;
                --cc-overlay-bg: rgba(0, 0, 0, 0.9) !important;

                --cc-toggle-on-knob-bg: var(--cc-bg);
                --cc-toggle-readonly-knob-bg: var(--cc-cookie-category-block-bg);

                --cc-separator-border-color: #252729;

                --cc-footer-border-color: #212529;
                --cc-footer-bg: #000;
            }

        <?php endif; ?>



        <?php if ($settings['style'] === 'dark-turquoise'): ?>
            #cc-main {
                color-scheme: dark;

                --cc-bg: #161a1c;
                --cc-primary-color: rgb(239, 244, 246);
                --cc-secondary-color: #b1bdc3;

                --cc-btn-primary-bg: #60fed2;
                --cc-btn-primary-color: #000;
                --cc-btn-primary-hover-bg: #4dd4ae;
                --cc-btn-primary-hover-color: #000;

                --cc-btn-secondary-bg: #242c31;
                --cc-btn-secondary-color: var(--cc-primary-color);
                --cc-btn-secondary-hover-bg: #d4dae0;
                --cc-btn-secondary-hover-color: #000;

                --cc-cookie-category-block-bg: #1e2428;
                --cc-cookie-category-block-border: #1e2428;
                --cc-cookie-category-block-hover-bg: #242c31;
                --cc-cookie-category-block-hover-border: #242c31;
                --cc-cookie-category-expanded-block-hover-bg: #242c31;
                --cc-cookie-category-expanded-block-bg: #1e2428;
                --cc-toggle-readonly-bg: #343e45;
                --cc-overlay-bg: rgba(4, 6, 8, .85) !important;

                --cc-toggle-on-knob-bg: var(--cc-bg);
                --cc-toggle-readonly-knob-bg: var(--cc-cookie-category-block-bg);

                --cc-separator-border-color: #222a30;

                --cc-footer-border-color: #212529;
                --cc-footer-bg: #0f1112;
            }

        <?php endif; ?>
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            console.log('DOM passed through, I initialize CookieConsent');
            const settings = <?php echo json_encode($settings); ?>;
            const detectedCookies = <?php echo json_encode($detected_cookies); ?>;

            try {
                window.CookieConsent.run({
                    guiOptions: {
                        consentModal: {
                            layout: settings.layout || 'box',
                            position: settings.position || 'bottom'
                        },
                        preferencesModal: {
                            layout: settings.layout || 'box'
                        }
                    },
                    categories: {
                        necessary: {
                            enabled: true,
                            readOnly: true,
                            cookies: detectedCookies.necessary || []
                        },
                        analytics: {
                            enabled: settings.categories?.analytics || false,
                            cookies: detectedCookies.analytics || []
                        },
                        marketing: {
                            enabled: settings.categories?.marketing || false,
                            cookies: detectedCookies.marketing || []
                        },
                        preferences: {
                            enabled: settings.categories?.preferences || false,
                            cookies: detectedCookies.preferences || []
                        },
                        social: {
                            enabled: settings.categories?.social || false,
                            cookies: detectedCookies.social || []
                        }
                    },
                    language: {

                        default: settings.language || 'en',
                        translations: {
                            pl: {
                                consentModal: {
                                    title: settings.text?.consentTitle || 'Zgoda na ciasteczka',
                                    description: settings.text?.consentDescription || 'Używamy ciasteczek, aby poprawić Twoje doświadczenie. Dostosuj swoje preferencje poniżej.',
                                    acceptAllBtn: 'Akceptuj wszystkie',
                                    acceptNecessaryBtn: 'Akceptuj niezbędne',
                                    showPreferencesBtn: 'Pokaż opcje'
                                },
                                preferencesModal: {
                                    title: 'Ustawienia ciasteczek',
                                    acceptAllBtn: 'Akceptuj wszystkie',
                                    acceptNecessaryBtn: 'Akceptuj niezbędne',
                                    savePreferencesBtn: 'Zapisz preferencje',
                                    sections: [
                                        {
                                            title: 'Niezbędne',
                                            description: settings.categoryDescriptions?.necessary || 'Te ciasteczka są wymagane do działania strony.',
                                            linkedCategory: 'necessary',
                                            toggle: {
                                                value: 'necessary',
                                                enabled: true,
                                                readonly: true
                                            },
                                            cookieTable: {
                                                headers: ['Nazwa', 'Opis'],
                                                body: (detectedCookies.necessary || []).map(name => [name, 'Ciasteczko niezbędne'])
                                            }
                                        },
                                        {
                                            title: 'Analityczne',
                                            description: settings.categoryDescriptions?.analytics || 'Pomagają nam analizować ruch na stronie.',
                                            linkedCategory: 'analytics',
                                            toggle: {
                                                value: 'analytics',
                                                enabled: settings.categories?.analytics || false,
                                                readonly: false
                                            },
                                            cookieTable: {
                                                headers: ['Nazwa', 'Opis'],
                                                body: (detectedCookies.analytics || []).map(name => [name, 'Ciasteczko analityczne'])
                                            }
                                        },
                                        {
                                            title: 'Marketingowe',
                                            description: settings.categoryDescriptions?.marketing || 'Używane do personalizacji reklam.',
                                            linkedCategory: 'marketing',
                                            toggle: {
                                                value: 'marketing',
                                                enabled: settings.categories?.marketing || false,
                                                readonly: false
                                            },
                                            cookieTable: {
                                                headers: ['Nazwa', 'Opis'],
                                                body: (detectedCookies.marketing || []).map(name => [name, 'Ciasteczko marketingowe'])
                                            }
                                        },
                                        {
                                            title: 'Preferencje',
                                            description: settings.categoryDescriptions?.preferences || 'Zapamiętują Twoje ustawienia.',
                                            linkedCategory: 'preferences',
                                            toggle: {
                                                value: 'preferences',
                                                enabled: settings.categories?.preferences || false,
                                                readonly: false
                                            },
                                            cookieTable: {
                                                headers: ['Nazwa', 'Opis'],
                                                body: (detectedCookies.preferences || []).map(name => [name, 'Ciasteczko preferencji'])
                                            }
                                        },
                                        {
                                            title: 'Społecznościowe',
                                            description: settings.categoryDescriptions?.social || 'Integracja z mediami społecznościowymi.',
                                            linkedCategory: 'social',
                                            toggle: {
                                                value: 'social',
                                                enabled: settings.categories?.social || false,
                                                readonly: false
                                            },
                                            cookieTable: {
                                                headers: ['Nazwa', 'Opis'],
                                                body: (detectedCookies.social || []).map(name => [name, 'Ciasteczko społecznościowe'])
                                            }
                                        }
                                    ]
                                }
                            },
                            en: {
                                consentModal: {
                                    title: settings.text?.consentTitle || 'Cookie Consent',
                                    description: settings.text?.consentDescription || 'We use cookies to enhance your experience. Customize your preferences below.',
                                    acceptAllBtn: 'Accept All',
                                    acceptNecessaryBtn: 'Accept Necessary',
                                    showPreferencesBtn: 'Show Options'
                                },
                                preferencesModal: {
                                    title: 'Cookie Settings',
                                    acceptAllBtn: 'Accept All',
                                    acceptNecessaryBtn: 'Accept Necessary',
                                    savePreferencesBtn: 'Save Preferences',
                                    sections: [
                                        {
                                            title: 'Necessary',
                                            description: settings.categoryDescriptions?.necessary || 'These cookies are required for the website to function.',
                                            linkedCategory: 'necessary',
                                            toggle: {
                                                value: 'necessary',
                                                enabled: true,
                                                readonly: true
                                            },
                                            cookieTable: {
                                                headers: ['Name', 'Description'],
                                                body: (detectedCookies.necessary || []).map(name => [name, 'Necessary Cookie'])
                                            }
                                        },
                                        {
                                            title: 'Analytics',
                                            description: settings.categoryDescriptions?.analytics || 'Help us analyze website traffic.',
                                            linkedCategory: 'analytics',
                                            toggle: {
                                                value: 'analytics',
                                                enabled: settings.categories?.analytics || false,
                                                readonly: false
                                            },
                                            cookieTable: {
                                                headers: ['Name', 'Description'],
                                                body: (detectedCookies.analytics || []).map(name => [name, 'Analytics Cookie'])
                                            }
                                        },
                                        {
                                            title: 'Marketing',
                                            description: settings.categoryDescriptions?.marketing || 'Used to personalize advertisements.',
                                            linkedCategory: 'marketing',
                                            toggle: {
                                                value: 'marketing',
                                                enabled: settings.categories?.marketing || false,
                                                readonly: false
                                            },
                                            cookieTable: {
                                                headers: ['Name', 'Description'],
                                                body: (detectedCookies.marketing || []).map(name => [name, 'Marketing Cookie'])
                                            }
                                        },
                                        {
                                            title: 'Preferences',
                                            description: settings.categoryDescriptions?.preferences || 'Remember your settings.',
                                            linkedCategory: 'preferences',
                                            toggle: {
                                                value: 'preferences',
                                                enabled: settings.categories?.preferences || false,
                                                readonly: false
                                            },
                                            cookieTable: {
                                                headers: ['Name', 'Description'],
                                                body: (detectedCookies.preferences || []).map(name => [name, 'Preference Cookie'])
                                            }
                                        },
                                        {
                                            title: 'Social Media',
                                            description: settings.categoryDescriptions?.social || 'Integration with social media.',
                                            linkedCategory: 'social',
                                            toggle: {
                                                value: 'social',
                                                enabled: settings.categories?.social || false,
                                                readonly: false
                                            },
                                            cookieTable: {
                                                headers: ['Name', 'Description'],
                                                body: (detectedCookies.social || []).map(name => [name, 'Social Media Cookie'])
                                            }
                                        }
                                    ]
                                }
                            },
                            es: {
                                consentModal: {
                                    title: settings.text?.consentTitle || 'Consentimiento de cookies',
                                    description: settings.text?.consentDescription || 'Usamos cookies para mejorar tu experiencia. Personaliza tus preferencias a continuación.',
                                    acceptAllBtn: 'Aceptar todas',
                                    acceptNecessaryBtn: 'Aceptar necesarias',
                                    showPreferencesBtn: 'Mostrar opciones'
                                },
                                preferencesModal: {
                                    title: 'Configuración de cookies',
                                    acceptAllBtn: 'Aceptar todas',
                                    acceptNecessaryBtn: 'Aceptar necesarias',
                                    savePreferencesBtn: 'Guardar preferencias',
                                    sections: [
                                        {
                                            title: 'Necesarias',
                                            description: settings.categoryDescriptions?.necessary || 'Estas cookies son requeridas para que el sitio web funcione.',
                                            linkedCategory: 'necessary',
                                            toggle: {
                                                value: 'necessary',
                                                enabled: true,
                                                readonly: true
                                            },
                                            cookieTable: {
                                                headers: ['Nombre', 'Descripción'],
                                                body: (detectedCookies.necessary || []).map(name => [name, 'Cookie necesaria'])
                                            }
                                        },
                                        {
                                            title: 'Analíticas',
                                            description: settings.categoryDescriptions?.analytics || 'Nos ayudan a analizar el tráfico del sitio web.',
                                            linkedCategory: 'analytics',
                                            toggle: {
                                                value: 'analytics',
                                                enabled: settings.categories?.analytics || false,
                                                readonly: false
                                            },
                                            cookieTable: {
                                                headers: ['Nombre', 'Descripción'],
                                                body: (detectedCookies.analytics || []).map(name => [name, 'Cookie analítica'])
                                            }
                                        },
                                        {
                                            title: 'Marketing',
                                            description: settings.categoryDescriptions?.marketing || 'Utilizadas para personalizar anuncios.',
                                            linkedCategory: 'marketing',
                                            toggle: {
                                                value: 'marketing',
                                                enabled: settings.categories?.marketing || false,
                                                readonly: false
                                            },
                                            cookieTable: {
                                                headers: ['Nombre', 'Descripción'],
                                                body: (detectedCookies.marketing || []).map(name => [name, 'Cookie de marketing'])
                                            }
                                        },
                                        {
                                            title: 'Preferencias',
                                            description: settings.categoryDescriptions?.preferences || 'Recuerdan tus configuraciones.',
                                            linkedCategory: 'preferences',
                                            toggle: {
                                                value: 'preferences',
                                                enabled: settings.categories?.preferences || false,
                                                readonly: false
                                            },
                                            cookieTable: {
                                                headers: ['Nombre', 'Descripción'],
                                                body: (detectedCookies.preferences || []).map(name => [name, 'Cookie de preferencias'])
                                            }
                                        },
                                        {
                                            title: 'Redes Sociales',
                                            description: settings.categoryDescriptions?.social || 'Integración con redes sociales.',
                                            linkedCategory: 'social',
                                            toggle: {
                                                value: 'social',
                                                enabled: settings.categories?.social || false,
                                                readonly: false
                                            },
                                            cookieTable: {
                                                headers: ['Nombre', 'Descripción'],
                                                body: (detectedCookies.social || []).map(name => [name, 'Cookie de redes sociales'])
                                            }
                                        }
                                    ]
                                }
                            },
                            de: {
                                consentModal: {
                                    title: settings.text?.consentTitle || 'Zustimmung zu Cookies',
                                    description: settings.text?.consentDescription || 'Wir verwenden Cookies, um Ihr Erlebnis zu verbessern. Passen Sie Ihre Präferenzen unten an.',
                                    acceptAllBtn: 'Alle akzeptieren',
                                    acceptNecessaryBtn: 'Nur notwendige akzeptieren',
                                    showPreferencesBtn: 'Optionen anzeigen'
                                },
                                preferencesModal: {
                                    title: 'Cookie-Einstellungen',
                                    acceptAllBtn: 'Alle akzeptieren',
                                    acceptNecessaryBtn: 'Nur notwendige akzeptieren',
                                    savePreferencesBtn: 'Präferenzen speichern',
                                    sections: [
                                        {
                                            title: 'Notwendig',
                                            description: settings.categoryDescriptions?.necessary || 'Diese Cookies sind für die Funktion der Website erforderlich.',
                                            linkedCategory: 'necessary',
                                            toggle: {
                                                value: 'necessary',
                                                enabled: true,
                                                readonly: true
                                            },
                                            cookieTable: {
                                                headers: ['Name', 'Beschreibung'],
                                                body: (detectedCookies.necessary || []).map(name => [name, 'Notwendiger Cookie'])
                                            }
                                        },
                                        {
                                            title: 'Analytisch',
                                            description: settings.categoryDescriptions?.analytics || 'Helfen uns, den Website-Verkehr zu analysieren.',
                                            linkedCategory: 'analytics',
                                            toggle: {
                                                value: 'analytics',
                                                enabled: settings.categories?.analytics || false,
                                                readonly: false
                                            },
                                            cookieTable: {
                                                headers: ['Name', 'Beschreibung'],
                                                body: (detectedCookies.analytics || []).map(name => [name, 'Analytischer Cookie'])
                                            }
                                        },
                                        {
                                            title: 'Marketing',
                                            description: settings.categoryDescriptions?.marketing || 'Wird zur Personalisierung von Werbung verwendet.',
                                            linkedCategory: 'marketing',
                                            toggle: {
                                                value: 'marketing',
                                                enabled: settings.categories?.marketing || false,
                                                readonly: false
                                            },
                                            cookieTable: {
                                                headers: ['Name', 'Beschreibung'],
                                                body: (detectedCookies.marketing || []).map(name => [name, 'Marketing-Cookie'])
                                            }
                                        },
                                        {
                                            title: 'Präferenzen',
                                            description: settings.categoryDescriptions?.preferences || 'Speichern Ihre Einstellungen.',
                                            linkedCategory: 'preferences',
                                            toggle: {
                                                value: 'preferences',
                                                enabled: settings.categories?.preferences || false,
                                                readonly: false
                                            },
                                            cookieTable: {
                                                headers: ['Name', 'Beschreibung'],
                                                body: (detectedCookies.preferences || []).map(name => [name, 'Präferenz-Cookie'])
                                            }
                                        },
                                        {
                                            title: 'Soziale Medien',
                                            description: settings.categoryDescriptions?.social || 'Integration mit sozialen Medien.',
                                            linkedCategory: 'social',
                                            toggle: {
                                                value: 'social',
                                                enabled: settings.categories?.social || false,
                                                readonly: false
                                            },
                                            cookieTable: {
                                                headers: ['Name', 'Beschreibung'],
                                                body: (detectedCookies.social || []).map(name => [name, 'Sozialer Medien-Cookie'])
                                            }
                                        }
                                    ]
                                }
                            }
                        }
                    },
                    cookie: {
                        expiresAfterDays: settings.cookieExpires || 365,
                        domain: settings.cookieDomain || window.location.hostname,
                        path: '/',
                        sameSite: 'Lax'
                    },
                    page_scripts: true,
                    onAccept: function ({ acceptedCategories }) {
                        console.log('Zgoda zaakceptowana:', acceptedCategories);
                        if (acceptedCategories.includes('analytics') && typeof gtag !== 'undefined') {
                            gtag('consent', 'update', { 'analytics_storage': 'granted' });
                        } else if (typeof gtag !== 'undefined') {
                            gtag('consent', 'update', { 'analytics_storage': 'denied' });
                        }
                        if (acceptedCategories.includes('marketing') && typeof gtag !== 'undefined') {
                            gtag('consent', 'update', { 'ad_storage': 'granted' });
                        } else if (typeof gtag !== 'undefined') {
                            gtag('consent', 'update', { 'ad_storage': 'denied' });
                        }
                    },
                    onChange: function ({ changedCategories }) {
                        console.log('Zmienione kategorie:', changedCategories);
                        location.reload();
                    }
                });
                console.log('CookieConsent initiated successfully');
            } catch (error) {
                console.error('Błąd inicjalizacji CookieConsent:', error);
            }
        });
    </script>
    <?php
}



function cookieMonster_admin()
{
    global $SITEURL;

    if (isset($_POST['submit'])) {
        $settings = [
            'layout' => $_POST['layout'],
            'position' => $_POST['position'],
            'language' => $_POST['language'],
            'style' => $_POST['style'],
            'categories' => [
                'analytics' => isset($_POST['categories_analytics']),
                'marketing' => isset($_POST['categories_marketing']),
                'preferences' => isset($_POST['categories_preferences']),
                'social' => isset($_POST['categories_social'])
            ],
            'cookieExpires' => (int) $_POST['cookie_expires'],
            'cookieDomain' => $_POST['cookie_domain'],
            'text' => [
                'consentTitle' => $_POST['consent_title'],
                'consentDescription' => $_POST['consent_description']
            ],
            'categoryDescriptions' => [
                'necessary' => $_POST['desc_necessary'],
                'analytics' => $_POST['desc_analytics'],
                'marketing' => $_POST['desc_marketing'],
                'preferences' => $_POST['desc_preferences'],
                'social' => $_POST['desc_social']
            ],
            'customCookies' => [
                'necessary' => $_POST['custom_cookies_necessary'],
                'analytics' => $_POST['custom_cookies_analytics'],
                'marketing' => $_POST['custom_cookies_marketing'],
                'preferences' => $_POST['custom_cookies_preferences'],
                'social' => $_POST['custom_cookies_social']
            ]
        ];
        file_put_contents(GSDATAOTHERPATH . 'cookieMonster_settings.json', json_encode($settings));
        echo '<div class="updated">Settings saved!</div>';
    }

    $settings_file = GSDATAOTHERPATH . 'cookieMonster_settings.json';
    $settings = file_exists($settings_file) ? json_decode(file_get_contents($settings_file), true) : [];

    $default_cookie_categories = [
        'necessary' => ['PHPSESSID', 'session_', '_csrf'],
        'analytics' => ['_ga', '_gid', '_gat'],
        'marketing' => ['_fbp', 'fr', 'tr'],
        'preferences' => ['lang', 'theme', 'settings'],
        'social' => ['_tw', '_li', '_pin']
    ];

    $current_cookies = array_keys($_COOKIE);
    $current_cookies_list = !empty($current_cookies) ? implode(', ', $current_cookies) : 'No cookies detected';

    ?>

    <style>
        .cookieMonster :is(input,
            textarea, select) {
            border: solid 1px #ddd !important;
            padding: 10px !important;
            width: 100%;
        }

        .cookieMonster label {
            margin: 10px 0;
        }

        .cookieMonster textarea {
            height: 200px;
        }

        .cookieMonster [type="submit"] {
            background: #000;
            color: #fff;
            margin: 10px 0;
        }

        .cookieMonster [type="checkbox"] {
            all: revert;
        }
    </style>
    <h3>
        🍪 Cookie Monster Settings</h3>
    <hr>
    <form method="post" action="" class="cookieMonster">
        <h3>Layout and position</h3>
        <label>Style:</label>
        <select name="layout">
            <option value="box" <?php if (@$settings['layout'] == 'box')
                echo 'selected'; ?>>Box</option>
            <option value="cloud" <?php if (@$settings['layout'] == 'cloud')
                echo 'selected'; ?>>Cloud</option>
            <option value="bar" <?php if (@$settings['layout'] == 'bar')
                echo 'selected'; ?>>Bar</option>
        </select><br>

        <label>Position:</label>
        <select name="position">
            <option value="bottom" <?php if (@$settings['position'] == 'bottom')
                echo 'selected'; ?>>Lower</option>
            <option value="top" <?php if (@$settings['position'] == 'top')
                echo 'selected'; ?>>Upper</option>
            <option value="left" <?php if (@$settings['position'] == 'left')
                echo 'selected'; ?>>Left</option>
            <option value="right" <?php if (@$settings['position'] == 'right')
                echo 'selected'; ?>>Right</option>
        </select><br>
        <hr>
        <h3>Style</h3>
        <label>Banner Style:</label>
        <select name="style">
            <option value="light" <?php if (@$settings['style'] == 'light')
                echo 'selected'; ?>>Light</option>
            <option value="light-funky" <?php if (@$settings['style'] == 'light-funky')
                echo 'selected'; ?>>Light Funky
            </option>
            <option value="dark" <?php if (@$settings['style'] == 'dark')
                echo 'selected'; ?>>Dark</option>

<option value="dark-turquoise" <?php if (@$settings['style'] == 'dark-turquoise')
                echo 'selected'; ?>>Dark Turquoise</option>

        </select><br>
        <hr>
        <h3>Language</h3>
        <label>Default language:</label>
        <select name="language">
            <option value="en" <?php if (@$settings['language'] == 'en')
                echo 'selected'; ?>>English</option>
            <option value="pl" <?php if (@$settings['language'] == 'pl')
                echo 'selected'; ?>>Polish</option>
            <option value="es" <?php if (@$settings['language'] == 'es')
                echo 'selected'; ?>>Spanish</option>
            <option value="de" <?php if (@$settings['language'] == 'de')
                echo 'selected'; ?>>German</option>
        </select><br>
        <hr>
        <h3>Content</h3>
        <label>Banner title: </label>
        <input type="text" name="consent_title"
            value="<?php echo @$settings['text']['consentTitle'] ?: 'Consent to cookies'; ?>"><br>
        <label>Banner description:</label>
        <textarea name="consent_description"><?php echo @$settings['text']['consentDescription'] ?: 'We use cookies to improve your experience. Customize your preferences below.
'; ?></textarea><br>
        <hr>
        <h3>Cookie categories</h3>
        <label><input type="checkbox" name="categories_analytics" <?php if (@$settings['categories']['analytics'])
            echo 'checked'; ?>>Analytical</label><br>
        <label><input type="checkbox" name="categories_marketing" <?php if (@$settings['categories']['marketing'])
            echo 'checked'; ?>>Marketing</label><br>
        <label><input type="checkbox" name="categories_preferences" <?php if (@$settings['categories']['preferences'])
            echo 'checked'; ?>> Preferences</label><br>
        <label><input type="checkbox" name="categories_social" <?php if (@$settings['categories']['social'])
            echo 'checked'; ?>> Social</label><br>
        <hr>
        <h3>Opisy kategorii</h3>
        <label>Description for "Required":</label>
        <textarea
            name="desc_necessary"><?php echo @$settings['categoryDescriptions']['necessary'] ?: 'These cookies are required for the website to function..'; ?></textarea><br>
        <label>Description for "Analytical":</label>
        <textarea
            name="desc_analytics"><?php echo @$settings['categoryDescriptions']['analytics'] ?: 'Help us analyze site traffic.'; ?></textarea><br>
        <label>Description for "Marketing":</label>
        <textarea
            name="desc_marketing"><?php echo @$settings['categoryDescriptions']['marketing'] ?: 'Used to personalize advertising.'; ?></textarea><br>
        <label>Description for "Preferences":</label>
        <textarea
            name="desc_preferences"><?php echo @$settings['categoryDescriptions']['preferences'] ?: 'They remember your settings.'; ?></textarea><br>
        <label>Description for "Social": </label>
        <textarea
            name="desc_social"><?php echo @$settings['categoryDescriptions']['social'] ?: 'Social media integration.'; ?></textarea><br>
        <hr>
        <h3>Custom cookie names</h3>
        <p>
            Enter cookie names separated by commas (e.g. cookie1, cookie2). Default cookies are automatically
            included.</p>
        <strong>Cookies currently used on the website: </strong>


        <div style="background:#fafafa;border:solid 1px #ddd;padding:10px;margin-bottom:20px;">
            <?php echo htmlspecialchars($current_cookies_list); ?>
        </div>
        <label>Essential (default: <?php echo implode(', ', $default_cookie_categories['necessary']); ?>):</label>
        <input type="text" name="custom_cookies_necessary" value="<?php echo @$settings['customCookies']['necessary']; ?>"
            placeholder="np. auth_token, cart_id"><br>
        <label>Analytical (default: <?php echo implode(', ', $default_cookie_categories['analytics']); ?>):</label>
        <input type="text" name="custom_cookies_analytics" value="<?php echo @$settings['customCookies']['analytics']; ?>"
            placeholder="np. custom_ga"><br>
        <label>Marketing (default: <?php echo implode(', ', $default_cookie_categories['marketing']); ?>):</label>
        <input type="text" name="custom_cookies_marketing" value="<?php echo @$settings['customCookies']['marketing']; ?>"
            placeholder="np. ad_custom"><br>
        <label>Preferences (default: <?php echo implode(', ', $default_cookie_categories['preferences']); ?>):</label>
        <input type="text" name="custom_cookies_preferences"
            value="<?php echo @$settings['customCookies']['preferences']; ?>" placeholder="np. user_prefs"><br>
        <label>Social (default: <?php echo implode(', ', $default_cookie_categories['social']); ?>):</label>
        <input type="text" name="custom_cookies_social" value="<?php echo @$settings['customCookies']['social']; ?>"
            placeholder="np. fb_custom"><br>

        <h3>Cookie settings </h3>
        <label>Expiration time (days):
        </label>
        <input type="number" name="cookie_expires" value="<?php echo @$settings['cookieExpires'] ?: 365; ?>" min="1"><br>
        <label>Cookie domain: </label>
        <input type="text" name="cookie_domain" value="<?php echo @$settings['cookieDomain'] ?: ''; ?>"
            placeholder="np. example.com"><br>

        <hr>
        <hr>
        <h3>Option to correct settings
        </h3>
        If you want to give the user the option to fix the settings and reopen the modal, paste this code into your template

        <code style="background:#fafafa;border:solid 1px #ddd;width:100%;display:block;padding:10px;margin:10px 0;">
        &lt;a href="#" data-cc="show-preferencesModal" onclick="event.preventDefault()">Cookie Preferences&lt;/a>
        </code>

        <input type="submit" name="submit" value="Save Settings">
    </form>

    <div id="paypal" style="padding-top:10px">
        <style>
            .donateButton {
                box-shadow: inset 0px 1px 0px 0px #fff6af;
                background: linear-gradient(to bottom, #ffec64 5%, #ffab23 100%);
                background-color: #ffec64;
                border-radius: 6px;
                border: 1px solid #ffaa22;
                display: inline-block;
                cursor: pointer;
                color: #333333;
                font-family: Arial;
                font-size: 15px;
                font-weight: bold;
                padding: 6px 24px;
                text-decoration: none;
                text-shadow: 0px 1px 0px #ffee66;
            }

            .donateButton:hover {
                background: linear-gradient(to bottom, #ffab23 5%, #ffec64 100%);
                background-color: #ffab23;
            }

            .donateButton:active {
                position: relative;
                top: 1px;
            }
        </style>




        <p><a href="https://getsimple-ce.ovh/donate" target="_blank" class="donateButton">Buy Us A Coffee <svg
                    xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path fill="currentColor" fill-opacity="0"
                        d="M17 14v4c0 1.66 -1.34 3 -3 3h-6c-1.66 0 -3 -1.34 -3 -3v-4Z">
                        <animate fill="freeze" attributeName="fill-opacity" begin="0.8s" dur="0.5s" values="0;1"></animate>
                    </path>
                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                        <path stroke-dasharray="48" stroke-dashoffset="48"
                            d="M17 9v9c0 1.66 -1.34 3 -3 3h-6c-1.66 0 -3 -1.34 -3 -3v-9Z">
                            <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.6s" values="48;0"></animate>
                        </path>
                        <path stroke-dasharray="14" stroke-dashoffset="14"
                            d="M17 9h3c0.55 0 1 0.45 1 1v3c0 0.55 -0.45 1 -1 1h-3">
                            <animate fill="freeze" attributeName="stroke-dashoffset" begin="0.6s" dur="0.2s" values="14;0">
                            </animate>
                        </path>
                        <mask id="lineMdCoffeeHalfEmptyFilledLoop0">
                            <path stroke="#fff"
                                d="M8 0c0 2-2 2-2 4s2 2 2 4-2 2-2 4 2 2 2 4M12 0c0 2-2 2-2 4s2 2 2 4-2 2-2 4 2 2 2 4M16 0c0 2-2 2-2 4s2 2 2 4-2 2-2 4 2 2 2 4">
                                <animateMotion calcMode="linear" dur="3s" path="M0 0v-8" repeatCount="indefinite">
                                </animateMotion>
                            </path>
                        </mask>
                        <rect width="24" height="0" y="7" fill="currentColor" mask="url(#lineMdCoffeeHalfEmptyFilledLoop0)">
                            <animate fill="freeze" attributeName="y" begin="0.8s" dur="0.6s" values="7;2"></animate>
                            <animate fill="freeze" attributeName="height" begin="0.8s" dur="0.6s" values="0;5"></animate>
                        </rect>
                    </g>
                </svg></a></p>
    </div>
    <?php
}


?>