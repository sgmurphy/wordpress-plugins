<?php
namespace WPUmbrella\Controller\BackupV4;

use WPUmbrella\Core\Models\AbstractController;

class CleanupModule extends AbstractController
{
    public function executePost($params)
    {
        if (!isset($params['filename'])) {
            return $this->returnResponse([
                'success' => false,
                'code' => 'no_filename',
            ]);
        }

        if (!isset($params['requestId'])) {
            return $this->returnResponse([
                'success' => false,
                'code' => 'no_key',
            ]);
        }

        $files = [
            ABSPATH . DIRECTORY_SEPARATOR . $params['filename'],
            ABSPATH . DIRECTORY_SEPARATOR . 'cloner_error_log',
            ABSPATH . DIRECTORY_SEPARATOR . sprintf('%s-dictionnary.php', $params['requestId']),
            ABSPATH . DIRECTORY_SEPARATOR . sprintf('dictionnary.php', $params['requestId']),
        ];

        foreach ($files as $file) {
            if (!file_exists($file)) {
                continue;
            }

            @unlink($file);
        }

        $directories = [
            ABSPATH . DIRECTORY_SEPARATOR . 'umb_database',
            ABSPATH . DIRECTORY_SEPARATOR . 'wp-content' . DIRECTORY_SEPARATOR . 'umb_database',
        ];

        foreach ($directories as $directory) {
            $this->destroyDir($directory);
        }

        return $this->returnResponse([
            'success' => true,
            'code' => 'success',
        ]);
    }

    protected function destroyDir($dir)
    {
        try {
            if (!is_dir($dir) || is_link($dir)) {
                return unlink($dir);
            }

            foreach (scandir($dir) as $file) {
                if ($file == '.' || $file == '..') {
                    continue;
                }
                if (!$this->destroyDir($dir . DIRECTORY_SEPARATOR . $file)) {
                    chmod($dir . DIRECTORY_SEPARATOR . $file, 0777);
                    if (!$this->destroyDir($dir . DIRECTORY_SEPARATOR . $file)) {
                        return false;
                    }
                };
            }
            return rmdir($dir);
        } catch (\Exception $e) {
            return null;
        }
    }
}
