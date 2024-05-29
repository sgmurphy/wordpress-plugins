<?php
namespace WPUmbrella\Controller\BackupV4;

use WPUmbrella\Core\Models\AbstractController;

class UploadModule extends AbstractController
{
    protected function withFile()
    {
        if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            return $this->returnResponse([
                'success' => false,
                'code' => 'upload_error',
            ]);
        }

        $filename = basename($_FILES['file']['name']);
        $filename = sanitize_file_name($filename);

        $destination = ABSPATH . $filename;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $destination)) {
            return $this->returnResponse([
                'success' => true,
                'code' => 'upload_success'
            ]);
        }

        return $this->returnResponse([
            'success' => false,
            'code' => 'upload_error'
        ]);
    }

    public function executePost($params)
    {
        if (!empty($_FILES) && isset($_FILES['file'])) {
            return $this->withFile();
        }

        if (!isset($params['file']) || !isset($params['filename'])) {
            return $this->returnResponse([
                'success' => false,
                'code' => 'no_file',
            ]);
        }

        $data = $params['file'];

        $str = base64_decode($params['file']);
        file_put_contents(ABSPATH . DIRECTORY_SEPARATOR . $params['filename'], $str);

        return $this->returnResponse([
            'success' => true,
            'code' => 'upload_success',
        ]);
    }
}
