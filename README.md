# Cookie Monster Plugin Documentation

## Overview
The Cookie Monster plugin is a powerful and customizable cookie consent solution designed for **GetSimple CE CMS**. It provides an advanced, GDPR-compliant cookie management system that allows website administrators to inform users about cookie usage, categorize cookies, and give visitors control over their preferences. With a variety of styles, layouts, and multilingual support, this plugin is both user-friendly and visually appealing, making it an excellent choice for modern websites.

---

## Features

- **GDPR Compliance**: Offers a cookie consent popup with options to accept all, accept necessary, or customize preferences, ensuring compliance with privacy regulations like GDPR.
- **Customizable Styles**: Choose from multiple themes:
  - Light
  - Light Funky
  - Dark
  - Dark Turquoise
- **Multilingual Support**: Supports English, Polish, Spanish, and German, with customizable text for titles, descriptions, and category details.
- **Cookie Categories**: Organizes cookies into five categories:
  - *Necessary*: Essential cookies for website functionality (read-only).
  - *Analytics*: Cookies for traffic analysis (e.g., Google Analytics).
  - *Marketing*: Cookies for personalized ads.
  - *Preferences*: Cookies to remember user settings.
  - *Social*: Cookies for social media integration.
- **Dynamic Cookie Detection**: Automatically detects and categorizes cookies based on predefined patterns and custom entries.
- **Flexible Layouts**: Offers Box, Cloud, and Bar layouts with position options (Bottom, Top, Left, Right).
- **Admin Interface**: A comprehensive settings page to configure layout, style, language, cookie expiration, domain, and custom cookie names.
- **User Control**: Allows users to revisit and adjust their cookie preferences via a simple button (`data-cc="show-preferencesModal"`).
- **Integration with Analytics**: Updates Google Analytics consent status (`gtag`) based on user preferences.

---

## How It Works

### Initialization
The plugin registers itself with GetSimple CE CMS and hooks into the theme-footer to load necessary CSS and JavaScript files (`cookieconsent.css` and `cookieconsent.min.js`).

### Settings Management
Stores configuration in a JSON file (`cookieMonster_settings.json`) located in the `data/other` directory. Default settings are provided if no file exists.

### Cookie Detection
Scans the `$_COOKIE` array to identify and categorize cookies based on predefined and custom patterns.

### Consent Popup
Displays a consent modal on page load using the CookieConsent library, with options tailored to the configured settings.

### Admin Panel
Adds a "Cookie Monster Settings" menu to the plugins sidebar where administrators can adjust all aspects of the plugin.

### Dynamic Styling
Applies CSS variables to customize the appearance of the consent popup based on the selected style.

---

## Installation

1. Download the Cookie Monster plugin files.
2. Place the plugin folder in the `plugins` directory of your GetSimple CE CMS installation.
3. Ensure `cookieconsent.css` and `cookieconsent.min.js` are included in the `plugins/cookieMonster/` directory.
4. Activate the plugin via the GetSimple CE admin panel.

---

## Configuration

### Access the Settings
Navigate to the "Cookie Monster Settings" page from the plugins sidebar.

### Customize Options:
- Choose a layout and position for the consent popup.
- Select a style that fits your site’s aesthetic.
- Set the default language and customize text for the consent title and description.
- Enable/disable cookie categories and add custom cookie names.
- Define cookie expiration (in days) and domain (optional).

### Save Changes
Click "Save Settings" to apply your configuration.

---

## Usage

- The consent popup appears automatically on page load for new visitors.
- To allow users to revisit their preferences, add this button to your template:

```html
<a href="#" data-cc="show-preferencesModal" onclick="event.preventDefault()">Cookie Preferences</a>
```

- The plugin integrates with Google Analytics (`gtag`) to respect user consent for analytics and marketing cookies.

---

## Why Use Cookie Monster?

- **Ease of Use**: Simple setup with a robust admin interface—no coding required.
- **Compliance Made Simple**: Stay GDPR-compliant with minimal effort.
- **Visual Appeal**: Sleek, modern designs that enhance your website’s professionalism.
- **Flexibility**: Tailor the plugin to your needs with extensive customization options.
- **Community Support**: Created by Multicolor, with a call to support the GetSimple CE CMS project via donations.

---

## Get Started Today!

Enhance your website’s privacy management with Cookie Monster. It’s the perfect blend of functionality, style, and user empowerment. Install it now and give your visitors the transparency they deserve while keeping your site compliant and beautiful. Support the project by buying the developers a coffee at GetSimple CE Donation Page and join the community of satisfied users!

*Happy cookie managing!*

 
