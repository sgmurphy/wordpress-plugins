<?php

namespace SlimStat\Services;

use SlimStat\Utils\InvalidDatabaseException;
use SlimStat\Utils\MaxMindReader;

class GeoIP
{
    /**
     * List Geo ip Library
     *
     * @var array
     */
    public static $library = array(
        'country' => array(
            'source'     => 'https://cdn.jsdelivr.net/npm/geolite2-country/GeoLite2-Country.mmdb.gz',
            'userSource' => 'https://download.maxmind.com/app/geoip_download?edition_id=GeoLite2-Country&license_key=&suffix=tar.gz',
            'file'       => 'GeoLite2-Country',
            'opt'        => 'geoip',
            'cache'      => 31536000 //1 Year
        ),
        'city'    => array(
            'source'     => 'https://cdn.jsdelivr.net/npm/geolite2-city/GeoLite2-City.mmdb.gz',
            'userSource' => 'https://download.maxmind.com/app/geoip_download?edition_id=GeoLite2-City&license_key=&suffix=tar.gz',
            'file'       => 'GeoLite2-City',
            'opt'        => 'geoip_city',
            'cache'      => 6998000 //3 Month
        ),
    );

    /**
     * Geo IP file Extension
     *
     * @var string
     */
    public static $file_extension = 'mmdb';

    /**
     * @param $pack
     * @return string
     */
    public static function get_geo_ip_path($pack)
    {
        return wp_normalize_path(path_join(\wp_slimstat::$upload_dir, self::$library[strtolower($pack)]['file'] . '.' . self::$file_extension));
    }

    /**
     * @return string
     */
    public static function get_pack()
    {
        return \wp_slimstat::$settings['geolocation_country'] == 'on' ? 'country' : 'city';
    }

    /**
     * @return string
     */
    public static function get_database_file($pack = false)
    {
        $geo_pack = ($pack ? $pack : self::get_pack());
        return self::get_geo_ip_path($geo_pack);
    }

    /**
     * @return bool
     */
    public static function database_exists($pack = false)
    {
        $filePath = self::get_database_file($pack);
        if (file_exists($filePath)) {
            return true;
        }

        return false;
    }

    /**
     * @throws InvalidDatabaseException
     */
    public static function loader($ip)
    {
        if (self::database_exists()) {
            try {
                $reader = new MaxMindReader(self::get_database_file());
                return $reader->get(sanitize_text_field($ip));
            } catch (\Exception $e) {
                error_log('Slimstat Error - ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
                return false;
            }
        }

        return false;
    }

    /**
     * @param $pack
     * @return array
     */
    public static function download($pack, $args = [])
    {
        $args = wp_parse_args($args, [
            'update'              => false,
            'enable_maxmind'      => false,
            'maxmind_license_key' => false,
        ]);

        try {
            WP_Filesystem();
            global $wp_filesystem;

            // Create Empty Return Function
            $result["status"] = false;

            // Sanitize Pack name
            $pack = strtolower($pack);

            // Create a variable with the name of the database file to download.
            $DBFile = self::get_geo_ip_path($pack);

            if (!$args['update'] && file_exists($DBFile)) {
                $result["status"] = true;
                return array_merge($result, array("notice" => __('GeoIP Database Already Exists!', 'wp-slimstat')));
            }

            // Load Require Function
            if (!function_exists('download_url')) {
                include(ABSPATH . 'wp-admin/includes/file.php');
            }
            if (!function_exists('wp_generate_password')) {
                include(ABSPATH . 'wp-includes/pluggable.php');
            }

            // Get the upload directory from WordPress.
            $upload_dir = wp_upload_dir();

            // We need the gzopen() function
            if (false === function_exists('gzopen')) {
                return array_merge($result, array("notice" => __('Error: <code>gzopen()</code> Function Not Found!', 'wp-slimstat')));
            }

            // This is the location of the file to download.
            if ($args['enable_maxmind'] == 'on' && $args['maxmind_license_key']) {
                $download_url = add_query_arg(array(
                    'license_key' => $args['maxmind_license_key']
                ), self::$library[$pack]['userSource']);
            } else {
                $download_url = self::$library[$pack]['source'];
            }

            // Check to see if the subdirectory we're going to upload to exists, if not create it.
            if (!file_exists(\wp_slimstat::$upload_dir)) {
                if (!$wp_filesystem->mkdir(\wp_slimstat::$upload_dir, 0755)) {
                    return array_merge($result, array("notice" => sprintf(__('Error Creating GeoIP Database Directory. Ensure Web Server Has Directory Creation Permissions in: %s', 'wp-slimstat'), $upload_dir['basedir'])));
                }
            }

            if (!$wp_filesystem->is_writable(\wp_slimstat::$upload_dir)) {
                return array_merge($result, array("notice" => sprintf(__('Error Setting Permissions for GeoIP Database Directory. Check Write Permissions for Directories in: %s', 'wp-slimstat'), $upload_dir['basedir'])));
            }

            ini_set('max_execution_time', '300');

            // Download the file from MaxMind, this places it in a temporary location.
            $TempFile = download_url($download_url);

            // If we failed, through a message, otherwise proceed.
            if (is_wp_error($TempFile)) {
                return array_merge($result, array("notice" => sprintf(__('Error Downloading GeoIP Database from: %1$s - %2$s', 'wp-slimstat'), $download_url, $TempFile->get_error_message())));
            } else {
                // Open the downloaded file to unzip it.
                $ZipHandle = gzopen($TempFile, 'rb');

                // Create th new file to unzip to.
                $DBfh = fopen($DBFile, 'wb'); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fopen

                // If we failed to open the downloaded file, through an error and remove the temporary file. Otherwise, do the actual unzip.
                if (!$ZipHandle) {
                    wp_delete_file($TempFile);
                    return array_merge($result, array("notice" => sprintf(__('Error Opening Downloaded GeoIP Database for Reading: %s', 'wp-slimstat'), $TempFile)));
                } else {
                    // If we failed to open the new file, throw and error and remove the temporary file. Otherwise, actually do to unzip.
                    if (!$DBfh) {
                        wp_delete_file($TempFile);
                        return array_merge($result, array("notice" => sprintf(__('Error Opening Destination GeoIP Database for Writing: %s', 'wp-slimstat'), $DBFile)));
                    } else {
                        while (($data = gzread($ZipHandle, 4096)) != false) {
                            fwrite($DBfh, $data); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fwrite
                        }

                        // Close the files.
                        gzclose($ZipHandle);
                        fclose($DBfh); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose

                        // Delete the temporary file.
                        wp_delete_file($TempFile);

                        // Display the success message.
                        $result["status"] = true;
                        $result["notice"] = __('GeoIP Database Successfully Updated!', 'wp-slimstat');
                    }
                }
            }

        } catch
        (\Exception $e) {
            $result['notice'] = sprintf(__('Error: %1$s', 'wp-slimstat'), $e->getMessage());
        }

        return $result;
    }

    /**
     * @throws InvalidDatabaseException
     */
    public static function getCountry($ip = false)
    {
        $reader = self::loader($ip);

        $country = false;

        if ($reader) {
            if (!empty($reader['country']['iso_code']) && $reader['country']['iso_code'] != 'xx') {
                $country = $reader['country']['iso_code'];
            }
        }

        return $country;
    }

    /**
     * @throws InvalidDatabaseException
     */
    public static function getCity($ip = false)
    {
        $reader = self::loader($ip);

        $city = false;

        if ($reader) {
            if (!empty($reader['city']['names']['en'])) {
                $city = $reader['city']['names']['en'];
            }

            if (!empty($reader['subdivisions'][0]['iso_code']) && !empty($city)) {
                $city .= ' (' . $reader['subdivisions'][0]['iso_code'] . ')';
            }
        }

        return $city;
    }

    /**
     * @throws InvalidDatabaseException
     */
    public static function getLocation($ip = false)
    {
        $reader = self::loader($ip);

        $location = false;

        if ($reader) {
            if (!empty($reader['location']['latitude']) && !empty($reader['location']['longitude'])) {
                $location = $reader['location']['latitude'] . ',' . $reader['location']['longitude'];
            }
        }

        return $location;
    }
}