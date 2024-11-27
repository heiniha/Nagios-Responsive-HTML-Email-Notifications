<?php

/**
 * Get configuration from config file.
 *
 * @param String $section The section name to recover configuration property.
 * @param String $property The property name to recover configuration value.
 * 
 * @return type The configuration property value.
 **/
function getConfig($section, $property) {
    $config_file = __DIR__ . '/../config.cfg';
    if (!$settings = parse_ini_file($config_file, TRUE)) {
        echo "Error: cannot open configuration file.<br>";
        die();
    } else {
        $config = $settings[$section][$property];
    }
    return $config;
}

/**
 * Get the Nagios Command URL.
 *
 * @param String $nagiosUrl The Nagios server URL.
 * @param String $cmd_typ The Nagios Command Type.
 * @param String $host The monitored Host name.
 * @param String $service The monitored Service name.
 * 
 * @return String The Nagios Command URL.
 **/
function getCommandUrl($nagiosUrl, $cmdType, $host, $service = null) {
    $queryString = [
        'cmd_typ' => $cmdType,
        'host' => $host
    ];
    if ($service) {
        $queryString['service'] = $service;
    }

    $url = $nagiosUrl. '/cgi-bin/cmd.cgi?' . http_build_query($queryString);
    return $url;
}

/**
 * Get the Nagios Extended Info URL.
 *
 * @param String $nagiosUrl The Nagios server URL.
 * @param String $type The Nagios Extended Info Type.
 * @param String $host The monitored Host name.
 * @param String $service The monitored Service name.
 * 
 * @return String The Nagios Extended Info URL.
 **/
function getExtendedInfoUrl($nagiosUrl, $type, $host, $service = null) {
    $queryString = [
        'type' => $type,
        'host' => $host
    ];
    if ($service) {
        $queryString['service'] = $service;
    }

    $url = $nagiosUrl . '/cgi-bin/extinfo.cgi?' . http_build_query($queryString);
    return $url;
}

/* Arguments from Config File config.cfg */
$f_wordwrap = getConfig('mail', 'wordwrap');
$f_language = getConfig('general', 'language');
$f_company_email = getConfig('general', 'company_email');
$f_company_name = getConfig('general', 'company_name');

/* Load translations */
$lang = $f_language ?? 'en';
if (!file_exists(__DIR__ . '/../locale/' . $lang . '.php')) {
    $lang = 'en';
}
$translations = require __DIR__ . '/../locale/' . $lang . '.php';

/* Set locale */
$locale = match ($lang) {
  'en' => 'en_US',
  'es' => 'es_ES',
  default => 'en_US',
};
setlocale(LC_ALL, $locale);

?>