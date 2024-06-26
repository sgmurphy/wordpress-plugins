<?php

namespace WPStaging\Framework\Utils;

use WPStaging\Core\WPStaging;
use WPStaging\Backup\Service\Archiver;
use WPStaging\Backup\Service\BackupsFinder;
use WPStaging\Framework\Adapter\Directory;

class Urls
{

    /**
     * Retrieves the URL for a given site where the front end is accessible.
     *
     * Returns the 'home' option with the appropriate protocol. The protocol will be 'https'
     * if is_ssl() evaluates to true; otherwise, it will be the same as the 'home' option.
     * If `$scheme` is 'http' or 'https', is_ssl() is overridden.
     */
    public function getHomeUrl($blog_id = null, $scheme = null)
    {

        if (empty($blog_id) || !is_multisite()) {
            $url = get_option('home');
        } else {
            switch_to_blog($blog_id);
            $url = get_option('home');
            restore_current_blog();
        }

        if (!in_array($scheme, ['http', 'https', 'relative'])) {
            if (is_ssl()) {
                $scheme = 'https';
            } else {
                $scheme = parse_url($url, PHP_URL_SCHEME);
            }
        }

        $url = set_url_scheme($url, $scheme);

        return $url;
    }

    /**
     * Return WordPress home url without scheme e.h. host.com or www.host.com
     * @return string
     */
    public function getHomeUrlWithoutScheme()
    {
        return preg_replace('#^https?://#', '', rtrim($this->getHomeUrl(), '/'));
    }

    /**
     * Retrieves the URL for a given site where the front end is accessible.
     *
     * Returns the 'home' option with the appropriate protocol. The protocol will be 'https'
     * if is_ssl() evaluates to true; otherwise, it will be the same as the 'home' option.
     * If `$scheme` is 'http' or 'https', is_ssl() is overridden.
     */
    public function getSiteUrl($blog_id = null, $scheme = null)
    {

        if (empty($blog_id) || !is_multisite()) {
            $url = get_option('siteurl');
        } else {
            switch_to_blog($blog_id);
            $url = get_option('siteurl');
            restore_current_blog();
        }

        if (!in_array($scheme, ['http', 'https', 'relative'])) {
            if ($this->sslAvailable()) {
                $scheme = 'https';
            } else {
                $scheme = parse_url($url, PHP_URL_SCHEME);
            }
        }

        return set_url_scheme($url, $scheme);
    }

    /**
     * Get raw base URL e.g. https://blog.domain.com or https://domain.com without any subfolder
     * @return string
     */
    public function getBaseUrl()
    {
        $result = parse_url($this->getHomeUrl());
        return $result['scheme'] . "://" . $result['host'];
    }

    /**
     * Return base URL (domain) without scheme e.g. blog.domain.com or domain.com
     * @return string
     */
    public function getBaseUrlWithoutScheme()
    {
        return preg_replace('#^https?://#', '', rtrim($this->getBaseUrl(), '/'));
    }

    /**
     * Get hostname of production site including scheme
     * @return string
     */
    public function getProductionHostname()
    {

        $connection = get_option('wpstg_connection');

        // Get the stored hostname
        if (!empty($connection['prodHostname'])) {
            return $connection['prodHostname'];
        }

        // Default. Try to get the hostname from the main domain (Workaround for WP Staging Pro older < 2.9.1)
        $siteurl = get_site_url();
        $result  = parse_url($siteurl);
        return $result['scheme'] . "://" . $result['host'];
    }

    /**
     * Get url of the uploads directory, e.g. http://example.com/wp-content/uploads
     * @return string
     */
    public function getUploadsUrl()
    {
        $upload_dir = wp_upload_dir(null, false, false);
        return trailingslashit($upload_dir['baseurl']);
    }

    /**
     * Get url of the backup directory, e.g. http://example.com/*
     * @return string
     */
    public function getBackupUrl()
    {
        if (!WPStaging::make(Directory::class)->isBackupPathOutsideAbspath()) {
            return $this->getUploadsUrl() . WPSTG_PLUGIN_DOMAIN . '/' . Archiver::BACKUP_DIR_NAME . '/';
        }

        $backupDirAbsPath        = WPStaging::make(BackupsFinder::class)->getBackupsDirectory();
        $relativePathToBackupDir = str_replace(wp_normalize_path(ABSPATH), "", $backupDirAbsPath);
        $siteurl                 = $this->maybeUseProtocolRelative(get_option('siteurl'));
        return trailingslashit($siteurl) . $relativePathToBackupDir;
    }

    /** @return bool */
    public function sslAvailable()
    {
        // Cloudflare
        if (!empty($_SERVER['HTTP_CF_VISITOR'])) {
            // phpcs:ignore WPStagingCS.Security.SanitizeInput.InputNotSanitized
            $cfo = json_decode($_SERVER['HTTP_CF_VISITOR']);
            if (isset($cfo->scheme) && $cfo->scheme === 'https') {
                return true;
            }
        }

        // Other proxy
        if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            return true;
        }

        return is_ssl();
    }

    /**
     * @param string $url
     * @return string
     */
    public function maybeUseProtocolRelative($url)
    {
        if ($this->sslAvailable() && substr($url, 0, 7) === 'http://') {
            $url = preg_replace('@^http://@', '//', $url);
        }

        return $url;
    }
}
