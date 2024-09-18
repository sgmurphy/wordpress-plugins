<?php

namespace WPSocialReviews\App\Services\Platforms;

use WPSocialReviews\App\Models\OptimizeImage;
use WPSocialReviews\App\Services\Platforms\Feeds\CacheHandler;
use WPSocialReviews\App\Services\Platforms\Feeds\Instagram\InstagramFeed;
use WPSocialReviews\App\Services\Platforms\Feeds\Facebook\FacebookFeed;
use WPSocialReviews\App\Services\Platforms\Feeds\Twitter\TwitterFeed;
use WPSocialReviews\App\Services\Platforms\Feeds\Youtube\YoutubeFeed;
use WPSocialReviews\App\Services\Platforms\Feeds\Facebook\Helper as FacebookHelper;
use WPSocialReviews\App\Services\Platforms\Feeds\Instagram\Common;
use WPSocialReviews\App\Services\Helper as GlobalHelper;
use WPSocialReviews\App\Services\Platforms\Feeds\Config;
use WPSocialReviews\Framework\Support\Arr;

class ImageOptimizationHandler
{
    public $doneResizing = [];
    public $availableRecords = null;

    public $platform = '';

    public function __construct($platform)
    {
        $this->platform = $platform;
    }

    public function registerHooks()
    {
        add_action('wp_ajax_wpsr_resize_images', array($this, 'savePhotos'));
        add_action('wp_ajax_nopriv_wpsr_resize_images', array($this, 'savePhotos'));
        add_action('wpsocialreviews/check_instagram_access_token_validity_weekly', array($this, 'checkValidity'));
        add_action('wpsocialreviews/reset_data', array($this, 'resetData'));
    }

    public function savePhotos()
    {
        $id = absint(Arr::get($_REQUEST, 'id', -1));
        $platform = isset($_REQUEST['platform']) ? sanitize_text_field($_REQUEST['platform']) : '';
        $feed_type = isset($_REQUEST['feed_type']) ? sanitize_text_field($_REQUEST['feed_type']) : '';

        if($id > 0 && $this->platform == $platform) {
            $encodedMeta   = get_post_meta($id, '_wpsr_template_config', true);
            $decodedMeta   = json_decode($encodedMeta, true);
            $feed_settings = Arr::get($decodedMeta, 'feed_settings', []);

            $feedConfigs = null;
            if($this->platform == 'instagram'){
                $formattedMeta = Config::formatInstagramConfig($feed_settings, array());
                $feedConfigs = (new InstagramFeed())->getTemplateMeta($formattedMeta);
            }else if($this->platform == 'youtube'){
                $formattedMeta = Config::formatYoutubeConfig($feed_settings, array());
                $feedConfigs = (new YoutubeFeed())->getTemplateMeta($formattedMeta);
            }else if($this->platform == 'facebook_feed'){
                $formattedMeta = Config::formatFacebookConfig($feed_settings, array());
                $feedConfigs = (new FacebookFeed())->getTemplateMeta($formattedMeta, null, $feed_type);
            }else if($this->platform == 'twitter'){
                $formattedMeta = Config::formatTwitterConfig($feed_settings, array());
                $feedConfigs = (new TwitterFeed())->getTemplateMeta($formattedMeta);
            } else if($this->platform == 'tiktok'){
                $formattedMeta =  apply_filters('wpsocialreviews/format_tiktok_config', $feed_settings, []);
                $feedConfigs = apply_filters('wpsocialreviews/get_template_meta', $formattedMeta, []);
            }
            
            $feeds = Arr::get($feedConfigs, 'dynamic.items', []);
            $resizedImages = Arr::get($feedConfigs, 'dynamic.resize_data', []);

            $photo_type = $feed_type ? $feed_type : Arr::get($feed_settings, 'source_settings.feed_type', '');
            $feedIds = [];
            foreach ($feeds as $index => $feed) {
                $max_records = $this->maxRecordsCount();
                if($index > $max_records){
                    continue;
                }

                if($photo_type == 'album_feed'){
                    $photo_feeds = Arr::get($feed, 'photos.data', []);
                    $feedIds = array_merge($feedIds,array_column($photo_feeds , 'id'));
                    foreach ($photo_feeds as $itemFeed) {
                        $itemFeed['page_id'] = Arr::get($feed, 'page_id', '');
                        $itemFeed['media_type'] = 'IMAGE';
                        $itemFeed['default_media'] = Arr::get($feed, 'source', '');
                        $itemFeed['media_url'] = Arr::get($feed, 'source', '');
                        if (in_array(Arr::get($itemFeed, 'id'), $resizedImages)) {
                            $this->doneResizing[] = Arr::get($itemFeed, 'id');
                        } else {
                            if(!$this->maxResizingPerUnitTimePeriod()) {
                                if ($this->isMaxRecordsReached()) {
                                    $this->deleteLeastUsedImages();
                                }
                                $this->processSaveImage($itemFeed);
                            }
                        }
                    }
                } else {
                    $feedIds = array_column($feeds , 'id');
                    $feedId = Arr::get($feed, 'id');
                    if (in_array($feedId, $resizedImages)) {
                        $this->doneResizing[] = Arr::get($feed, 'id');
                    } else {
                        if (!$this->maxResizingPerUnitTimePeriod()) {
                            if ($this->isMaxRecordsReached()) {
                                $this->deleteLeastUsedImages();
                            }
                            $this->processSaveImage($feed);
                        }
                    }
                }
            }

            $header = Arr::get($feedConfigs, 'dynamic.header');
            $accountId = Arr::get($feedConfigs, 'feed_settings.header_settings.account_to_show');

            if ($platform !== 'tiktok' && empty(Arr::get($header, 'user_avatar'))) {
                $accountId = null;
            }

            if ($platform === 'tiktok' && empty(Arr::get($header, 'data.user.avatar_url'))){
                $accountId = null;
            }
            //get all connected ids

            $connected_ids = [];
            $account_ids = [];
            if($this->platform == 'facebook_feed') {
                $connected_ids            = (new FacebookHelper())->getConncetedSourceList();
                $account_ids = Arr::get($feed_settings, 'source_settings.selected_accounts', []);
            }else if($this->platform == 'instagram'){
                $connected_ids            = (new Common())->findConnectedAccounts();
                $account_ids = Arr::get($feed_settings, 'source_settings.account_ids', []);
            } else if($this->platform == 'tiktok'){
                $connected_ids =  apply_filters('wpsocialreviews/get_connected_source_list',[]);
                $account_ids = Arr::get($feed_settings, 'open_id', []);
            }

            $connected_account_list = array_intersect_key($connected_ids, array_flip($account_ids));

            $account_id = null;
            foreach($connected_account_list as $item) {
                if($this->platform == 'facebook_feed'){
                    $account_id = $this->platformHeaderLogo($item, $item['page_id']);
                    $this->platformCoverPhoto($item, $item['page_id']);
                }else if($this->platform == 'instagram'){
                    $account_id = $this->platformHeaderLogo($item, $item['user_id']);
                }else if($this->platform == 'tiktok'){
                    $account_id = $this->platformHeaderLogo($item, $item['open_id']);
                }
            }

            $resizedImages = [
                'images_data' => $feedIds,
                'account_id'  => $account_id
            ];

            $resizedImagesJson = json_encode($resizedImages);
            echo $resizedImagesJson;
        }
    }

    public function platformHeaderLogo($header, $accountId)
    {
        $account_id = $accountId;
        if (empty(Arr::get($header, 'user_avatar')) && $this->platform == 'instagram') {
            $accountId = null;
        }

        if (!empty($accountId) && $this->platform == 'instagram') {
            if ($this->localHeaderExists($accountId, 'avatars')) {
                $accountId = null;
            }
        }

        $globalSettings = $this->getGlobalSettings();
        if (!empty($accountId) || ($this->platform == 'facebook_feed' && !empty($account_id))) {
            $userAvatar = null;
            if($this->platform == 'facebook_feed'){
                $userAvatar = Arr::get($header, 'picture.data.url');
            }elseif($this->platform == 'instagram'){
                $userAvatar = Arr::get($header, 'user_avatar');
            }
            $res = false;
            $isLocalUrl = GlobalHelper::isLocalUrl($userAvatar);
            if(!$isLocalUrl){
                $res = $this->maybeLocalHeader($account_id, $userAvatar, $globalSettings,'avatars');
            }

            if (!$res) {
                return $accountId = null;
            }
        }

        return $accountId;
    }

    public function platformCoverPhoto($header, $accountId)
    {
        if (empty(Arr::get($header, 'cover.source')) && $this->platform == 'facebook_feed') {
            $accountId = null;
        }

        if (!empty($accountId)) {
            if ($this->localHeaderExists($accountId,'covers')) {
                $accountId = null;
            }
        }

        if (!empty($accountId)) {
            $globalSettings = $this->getGlobalSettings();
            $userAvatar = Arr::get($header, 'user_avatar');

            if ($this->platform == 'facebook_feed'){
                $coverPhoto = Arr::get($header, 'cover.source');
                $res = null;
                $isLocalUrl = GlobalHelper::isLocalUrl($coverPhoto);
                if(!$isLocalUrl){
                    $res = $this->maybeLocalHeader($accountId, $coverPhoto, $globalSettings, 'covers');
                }

                if (!$res) {
                    $accountId = null;
                }
            }
            if ($this->platform === 'tiktok') {
                $userAvatar = Arr::get($header, 'data.user.avatar_url');

                $res = $this->maybeLocalHeader($accountId, $userAvatar, $globalSettings, 'avatars');

                if (!$res) {
                    $accountId = null;
                }
            }
        }
    }

    public function processSaveImage($feed)
    {
        $userName = '';
        if($this->platform == 'instagram'){
            $userName = Arr::get($feed, 'username', '');
        }else if($this->platform == 'facebook_feed'){
            $userName = Arr::get($feed, 'page_id', '');
        }else if($this->platform == 'tiktok'){
            $userName = Arr::get($feed, 'user.name', '');
        }
        if($userName) {
            $this->saveImage($feed);
        }
    }

    public function saveImage($feed)
    {
        $imageSizes = ['full'  => 640, 'low'   => 320, 'thumb' => 150];
        $mediaId = Arr::get($feed, 'id', '');
        if($this->platform == 'instagram'){
            $userName = Arr::get($feed, 'username', '');
        }else if($this->platform == 'facebook_feed'){
            $userName = Arr::get($feed, 'page_id', '');
        }else if($this->platform == 'tiktok'){
            $userName = Arr::get($feed, 'user.name', '');
        }
        
        $isImageResized = false;
        $uploadDir = $this->getUploadDir($this->platform) . '/' . $userName;

        $sizes = ['height' => 1, 'width'  => 1];
        foreach ($imageSizes as $suffix => $image_size) {
            $image_source_set    = $this->getMediaSource($feed);
            $fileName = Arr::get($image_source_set, $image_size, $this->getMediaUrl($feed));
            if (!empty($fileName) && !empty($mediaId)) {
                $imageFileName = $mediaId . '_'. $suffix . '.jpg';
                $headers = @get_headers($fileName, 1);
                if (isset($headers['Content-Type'])) {
                    if (!str_contains($headers['Content-Type'], 'image/')) {
                        error_log("Not a regular image");
                    } else {
                        if (!file_exists($uploadDir)) {
                            wp_mkdir_p($uploadDir);
                        }

                        $fullFileName = trailingslashit($uploadDir) . $imageFileName;
                        if (file_exists($fullFileName)) {
                            $isImageResized = true;
                            continue;
                        }
                        $imageEditor = wp_get_image_editor($fileName);
                        if (is_wp_error($imageEditor)) {
                            require_once ABSPATH . 'wp-admin/includes/file.php';

                            $timeoutInSeconds = 5;
                            $temp_file = download_url($fileName, $timeoutInSeconds);
                            $imageEditor = wp_get_image_editor($temp_file);
                        }
                        if (!is_wp_error($imageEditor)) {
                            $imageEditor->set_quality( 80 );
                            $sizes = $imageEditor->get_size();
                            $imageEditor->resize( $image_size, null );
                            $savedImage = $imageEditor->save($fullFileName);
                            if ($savedImage) {
                                $isImageResized = true;
                            }
                        } else {
                            $isImageResized |= $this->download($fileName, $fullFileName, $suffix);
                            $imgSize = @getimagesize($fileName);

                            if ($isImageResized && is_array($imgSize) && $imgSize[0] > 0 && $imgSize[1] > 0) {
                                $sizes = [
                                    'width' => $imgSize[0],
                                    'height' => $imgSize[1],
                                ];
                            }
                        }

                        if (!empty($temp_file)) {
                            @unlink( $temp_file );
                        }
                    }
                }
            }
        }

        $this->updateImageInDb($userName, $mediaId, $isImageResized, $sizes);
    }

    public function resizeImage($imageUrl, $originalImage, $old_size, $image_size)
    {
        try {
            // Get the image resource.
            $image = imagecreatefromjpeg($originalImage);

            // Get the width and height of the original image.
            $originalWidth  = getimagesize($imageUrl)[0];
            $originalHeight = getimagesize($imageUrl)[1];

            // Set the new width and height of the resized image.
            $newWidth = 640; $newHeight = 640;
            switch ($image_size) {
                case 'low':
                    $newWidth = 320;
                    $newHeight = 320;
                    break;
                case 'thumb':
                    $newWidth = 150;
                    $newHeight = 150;
                    break;
            }

            // Create a new image object of the same type as the original image.
            $newImage = imagecreatetruecolor($newWidth, $newHeight);

            // Copy the original image to the new image, resizing it as needed.
            imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

            $tmpImage = $originalImage;
            $tmpImage = str_replace($old_size, $image_size, $tmpImage);

            // Save the resized image to a file.
            imagejpeg($newImage, $tmpImage);

            // Free the memory used by the images.
            imagedestroy($image);
            imagedestroy($newImage);
            return true;
        } catch (\Exception $exception) {
            //$exception->getMessage();
        }

        return false;
    }

    public function download($url = '', $filepath = '', $image_size = '')
    {
        $curl = curl_init($url);

        if (!$curl) {
            //error_log('wpsn was unable to initialize curl. Please check if the curl extension is enabled.');
            return false;
        }

        $file = @fopen($filepath, 'wb');

        if (!$file) {
            //error_log('wpsn was unable to create the file: ' . $filepath);
            return false;
        }

        try {
            curl_setopt($curl, CURLOPT_FILE, $file);
            curl_setopt($curl, CURLOPT_FAILONERROR, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_ENCODING, '');
            curl_setopt($curl, CURLOPT_TIMEOUT, 10);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            if (!empty($_SERVER['HTTP_USER_AGENT'])) {
                curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            }

            $success = curl_exec($curl);

            if (!$success) {
                //error_log('wpsn failed to get the media data from Instagram: ' . curl_error($curl));
                return false;
            }
            
            if($image_size == 'full') {
                $this->resizeImage($url, $filepath, 'full', 'low');
                $this->resizeImage($url, $filepath, 'full', 'thumb');
            }

            else if($image_size == 'low') {
                $this->resizeImage($url, $filepath, 'low', 'full');
                $this->resizeImage($url, $filepath, 'low', 'thumb');
            }

            else if($image_size == 'thumb') {
                $this->resizeImage($url, $filepath, 'thumb', 'low');
                $this->resizeImage($url, $filepath, 'thumb', 'full');
            }

            return true;
        } finally {
            curl_close($curl);
            fclose($file);
        }
    }

    public function updateImageInDb($userName, $mediaId, $isImageResized, $sizes)
    {
        $dateFormat = date('Y-m-d H:i:s');
        $data = [
            'user_name'         => $userName,
            'last_requested'    => $dateFormat,
            'created_at'        => $dateFormat,
            'updated_at'        => $dateFormat,
            'platform'          => $this->platform,
            'media_id'          => $mediaId,
        ];

        $data['images_resized'] = 0;
        if ($isImageResized) {
            $data['images_resized'] = 1;
            $aspectRatio = round($sizes['width'] / $sizes['height'], 2);
            $data['aspect_ratio'] = $aspectRatio;
        }

        $saved = (new OptimizeImage())->updateData($mediaId, $userName, $data);

        if($saved) {
            $this->doneResizing[] = $mediaId;
        }
    }

    public function getMediaSource($post)
    {
        $media_urls   = [];
        if($this->platform == 'facebook_feed'){
            $timeline = Arr::get($post, 'attachments.data.0.media.image.src');
            $videos_image_1 = Arr::get($post, 'format.0.picture');
            $videos_image_2 = Arr::get($post, 'format.1.picture');
            $photos = Arr::get($post, 'images.0.source');
            $albums_image = Arr::get($post, 'cover_photo.source');
            $album_inside_image = Arr::get($post, 'source');
            $image = Arr::get($timeline, 'media.image.src');

            if ($timeline && !$videos_image_1 && !$albums_image) {
                $media_urls['150'] = $timeline;
                $media_urls['320'] = $timeline;
                $media_urls['640'] = $timeline;
            } else if(!$timeline && $videos_image_1) {
                if($videos_image_2) {
                    $videos_image_1 = $videos_image_2;
                } 
                $media_urls['150'] = $videos_image_1;
                $media_urls['320'] = $videos_image_1;
                $media_urls['640'] = $videos_image_1;
            } else if($photos && !$timeline && !$videos_image_1){
                $media_urls['150'] = $photos;
                $media_urls['320'] = $photos;
                $media_urls['640'] = $photos;
            } else if($albums_image && !$timeline && !$videos_image_1){
                $media_urls['150'] = $albums_image;
                $media_urls['320'] = $albums_image;
                $media_urls['640'] = $albums_image;
            }else if($album_inside_image){
                $media_urls['150'] = $album_inside_image;
                $media_urls['320'] = $album_inside_image;
                $media_urls['640'] = $album_inside_image;
            }else{
                $media_urls['150'] = $image;
                $media_urls['320'] = $image;
                $media_urls['640'] = $image;
            }
        }else if($this->platform == 'instagram'){
            $accountType = Arr::get($post, 'images') ? 'personal' : 'business';
            $thumbnail = Arr::get($post, 'images.thumbnail.url');
            $low_resolution = Arr::get($post, 'images.low_resolution.url');
            $standard_resolution = Arr::get($post, 'images.standard_resolution.url');

            if ($accountType === 'personal') {
                $media_urls['150'] = $thumbnail;
                $media_urls['320'] = $low_resolution;
                $media_urls['640'] = $standard_resolution;
            } else {
                $full_size    = $this->getMediaUrl($post);
                $media_urls['150'] = $full_size;
                $media_urls['320'] = $full_size;
                $media_urls['640'] = $full_size;
            }
        }else if($this->platform == 'tiktok'){
            $full_size    = $this->getMediaUrl($post);
            $media_urls['150'] = $full_size;
            $media_urls['320'] = $full_size;
            $media_urls['640'] = $full_size;
        }
        
        return $media_urls;
    }

    public function getMediaUrl($post)
    {
        $media_type = Arr::get($post, 'media_type');
        $default_media = Arr::get($post, 'default_media');
        $media_name = Arr::get($post, 'media_name');
        $photos = Arr::get($post, 'images.0.source');
        $timeline = Arr::get($post, 'attachments.data.0.media.image.src');
        $videos_image = Arr::get($post, 'format.0.picture');
        $album_inside_image = Arr::get($post, 'source');
        $thumbnail_url = Arr::get($post, 'thumbnail_url');

        if($this->platform == 'instagram') {
            if($media_type == 'IMAGE' && !empty($default_media) && $media_name != 'VIDEO') {
                return $default_media;
            }
            if($media_name == 'VIDEO' && !empty($thumbnail_url)) {
                return $thumbnail_url;
            }
        } else if($this->platform == 'facebook_feed') {
            if($media_name == 'VIDEO' && !empty($thumbnail_url)) {
                return $thumbnail_url;
            }
            if($media_type == 'IMAGE' && empty($default_media) && !empty($photos)) {
                return $photos;
            }

            if($media_type == 'IMAGE' && empty($default_media) && !empty($album_inside_image)) {
                return $album_inside_image;
            }
    
            // if($media_type == 'IMAGE' && empty($default_media) && !empty(Arr::get($post, 'feed.format.0.picture'))){
            //     return Arr::get($post, 'feed.format.0.picture');
            // }
    
            if($media_type == 'IMAGE' && empty($default_media) && !empty($videos_image)){
                return $videos_image;
            }

            if($media_type == 'IMAGE' && !empty($default_media) && !empty($timeline)){
                return $timeline;
            }
        } else if($this->platform == 'tiktok') {
            return Arr::get($post, 'media.preview_image_url');
        }
    }

    public function checkValidity($account)
    {
       $error_status = Arr::get($account, 'status');
       $has_app_permission_error = Arr::get($account, 'has_app_permission_error', false);
       if($error_status === 'error' && $has_app_permission_error){
           (new PlatformData($this->platform))->handleAppPermissionError();
       }
    }

    public function cleanData($account)
    {
        $userName   = Arr::get($account, 'username');
        $userId   = Arr::get($account, 'user_id');
        $image_id = '';
        if($this->platform == 'instagram'){
            $image_id = Arr::get($account, 'user_id');
        }elseif($this->platform == 'facebook_feed'){
            $image_id = Arr::get($account, 'page_id');
        } elseif ($this->platform == 'tiktok') {
            $userName = Arr::get($account, 'display_name');
            $image_id = $userName;
        }

        $cacheHandler = new CacheHandler($this->platform);
        if(!empty($userName)) {
            (new OptimizeImage())->deleteMediaByUserName($userName);
            $uploadDir = $this->getUploadDir($this->platform) . '/' . $userName;
            $this->deleteDirectory($uploadDir, $image_id);
            $cacheHandler->clearCacheByAccount($userId);
        }
    }

    public function resetData($platform)
    {
        $connectedAccounts = [];
        if($platform == 'instagram'){
            $connectedIds      = get_option('wpsr_'.$platform.'_verification_configs', []);
            $connectedAccounts  = Arr::get($connectedIds, 'connected_accounts', []);

        } elseif($platform == 'facebook_feed') {
            $connectedIds = get_option('wpsr_facebook_feed_connected_sources_config', []);
            $connectedAccounts = Arr::get($connectedIds, 'sources', []);
        } elseif ($platform == 'tiktok') {
            $connectedIds = get_option('wpsr_tiktok_connected_sources_config', []);
            $connectedAccounts = Arr::get($connectedIds, 'sources', []);
        }

        delete_option('wpsr_'.$platform.'_local_avatars');
        delete_option('wpsr_'.$platform.'_local_covers');

        foreach($connectedAccounts as $account) {
            $userName = '';
            $image_id = '';
            if($platform == 'instagram'){
                $userName   = Arr::get($account, 'username');
                $image_id = Arr::get($account, 'user_id');
            }elseif($platform == 'facebook_feed'){
                $userName   = Arr::get($account, 'page_id');
                $image_id = $userName;
            } elseif ($platform == 'tiktok') {
                $userName = Arr::get($account, 'display_name');
                $image_id = $userName;
            }
            if (!empty($account)) {
                (new OptimizeImage())->deleteMediaByUserName($userName);
                $uploadDir = $this->getUploadDir($platform) . '/' . $userName;
                $this->deleteDirectory($uploadDir, $image_id);
            }
        }
    }

    public function deleteDirectory($dir, $image_id)
    {
        if (!is_dir($dir)) {
            return false;
        }

        $this->deleteDirectoryContents($dir);
        $this->deleteImagesOutside($dir, $image_id);

        return true;
    }

    private function deleteDirectoryContents($dir)
    {
        foreach (glob($dir . '/*') as $item) {
            is_dir($item) ? $this->deleteDirectoryContents($item) : unlink($item);
            @rmdir($item);
        }
        rmdir($dir);  
    }

    private function deleteImagesOutside($dir, $image_id)
    {
        $parentDir = dirname(rtrim($dir, '/')) . '/';

        foreach (glob($parentDir . '*') as $item) {
            if (is_dir($item)) {
                continue;
            }

            $filename = pathinfo($item, PATHINFO_FILENAME);
            if (str_starts_with($filename, $image_id)) {
                unlink($item);
            }
        }
    }

    public function getResizeNeededImageLists($feeds, $feed_settings)
    {
        $ids = array_column($feeds , 'id');
        if($this->platform == 'instagram'){
            $userNames = array_column($feeds , 'username');
        }else if($this->platform == 'facebook_feed'){
            $photo_type = Arr::get($feed_settings, 'source_settings.feed_type', '');
            $userNames = array_column($feeds , 'page_id');
            if($photo_type == 'album_feed'){
                $ids = [];
                foreach ($feeds as $item) {
                    if (isset($item['photos']['data'])) {
                        $photoIds = array_column($item['photos']['data'], 'id');
                        $ids = array_merge($ids,$photoIds);
                    }
                }
            }
        } else if($this->platform === 'tiktok'){
            $userNames = [];
            foreach ($feeds as $item) {
                $userNames[] = Arr::get($item, 'user.name');
            }
        }
        $resized_images = (new OptimizeImage())->getMediaIds($ids, $userNames);
        return array_unique($resized_images);
    }

    public function getUploadDir($platform)
    {
        $errorManager = new PlatformErrorManager();
        $upload     = wp_upload_dir();
        $uploadDir = trailingslashit($upload['basedir']) . trailingslashit(WPSOCIALREVIEWS_UPLOAD_DIR_NAME) . $platform;
        if (!file_exists($uploadDir)) {
            $created = wp_mkdir_p($uploadDir);
            if($created){
                $errorManager->removeErrors('upload_dir');
            } else {
                $error = __( 'There was an error creating the folder for storing resized '.$platform.' images.', 'wp-social-reviews' );
                $errorManager->addError('upload_dir', $error);
            }
        } else {
            $errorManager->removeErrors('upload_dir');
        }

        return $uploadDir;
    }

    public function getUploadUrl()
    {
        $upload     = wp_upload_dir();
        return trailingslashit($upload['baseurl']) . trailingslashit(WPSOCIALREVIEWS_UPLOAD_DIR_NAME) . $this->platform;
    }

    public function getGlobalSettings()
    {
        $globalSettings = get_option('wpsr_'.$this->platform.'_global_settings');
        return Arr::get($globalSettings, 'global_settings', []);
    }

    public function formattedData($header,$headerMeta)
    {
        $covers = null;
        $avatar = '';
        if ($this->platform == 'facebook_feed'){
            if($headerMeta == 'avatars'){
                $avatar = Arr::get($header, 'picture.data.url');
            } else {
                $covers = Arr::get($header, 'cover.source');
            }
        }elseif($this->platform == 'instagram'){
            $avatar = Arr::get($header, 'user_avatar');
        } elseif ($this->platform == 'tiktok') {
            $header['account_id'] = Arr::get($header, 'data.user.display_name');
            $avatar = Arr::get($header, 'data.user.avatar_url');
        }

        $accountId = Arr::get($header, 'account_id');
        if($accountId < 0){
            $accountId = Arr::get($header, 'account_id');
        }

        $globalSettings = $this->getGlobalSettings();
        $isLocalHeaderExists = $this->localHeaderExists($accountId,$headerMeta);

        if(!empty($accountId) && !$isLocalHeaderExists && Arr::get($globalSettings, 'optimized_images') === 'false') {
            return $header;
        }else if($isLocalHeaderExists && Arr::get($globalSettings, 'optimized_images') !== 'false'){
            $this->platformHeaderLogo($header, $accountId);
            if($this->platform == 'facebook_feed') {
                $this->platformCoverPhoto($header, $accountId);
            }
        }
        if(!empty($avatar) && !empty($accountId) && $headerMeta == 'avatars') {
            $isLocalUrl = GlobalHelper::isLocalUrl($avatar);
            $header['local_avatar'] = !$isLocalUrl ? $this->maybeLocalHeader($accountId, $avatar, $globalSettings,$headerMeta) : false;
        }
        if(!empty($covers) && !empty($accountId) && $headerMeta == 'covers') {
            $isLocalUrl = GlobalHelper::isLocalUrl($covers);
            $header['local_cover'] = !$isLocalUrl ? $this->maybeLocalHeader($accountId, $covers, $globalSettings,$headerMeta) : false;
        }

        return $header;
    }

    public function maybeLocalHeader($userId, $profilePicture, $globalSettings,$headerMeta)
    {
        if ($this->localHeaderExists($userId,$headerMeta)) {
            return $this->getLocalHeaderUrl($userId,$headerMeta);
        }
        if($this->platform == 'facebook_feed' && $headerMeta == 'covers'){
            $checkLocalImage = get_option('wpsr_'.$this->platform.'_local_covers');
        }else{
            $checkLocalImage = get_option('wpsr_'.$this->platform.'_local_avatars');
        }

        if ($this->shouldCreateLocalHeader($userId, $globalSettings,$headerMeta) && (empty($checkLocalImage) || !isset($checkLocalImage[$userId]) || !$checkLocalImage[$userId])) {
            $created = $this->createLocalHeader($userId, $profilePicture,$headerMeta);

            $this->updateLocalHeaderStatus($userId, $created,$headerMeta);

            if ($created) {
                return $this->getLocalHeaderUrl($userId,$headerMeta);
            }
        }

        return false;
    }

    public function localHeaderExists($userId, $headerMeta)
    {
        $avatars = get_option('wpsr_'.$this->platform.'_local_'.$headerMeta, array());
        return !empty(Arr::get($avatars, $userId));
    }

    public function getLocalHeaderUrl($userId, $headerMeta = '')
    {
        if($this->platform == 'facebook_feed' && $headerMeta == 'covers') {
            return $this->getUploadUrl() . '/' . $userId . '_cover.jpg';
        }

        $checkLocalAvatar = get_option('wpsr_'.$this->platform.'_local_avatars');
        if (isset($checkLocalAvatar[$userId])) {
            return $checkLocalAvatar[$userId] ? ($this->getUploadUrl() . '/' . $userId . '.jpg') : '';
        } else {
            return '';
        }
    }

    public function shouldCreateLocalHeader($userId, $globalSettings, $headerMeta = '')
    {
        if (Arr::get($globalSettings, 'optimized_images') === 'true' || Arr::get($globalSettings, 'global_settings.optimized_images') === 'true') {
            $avatars = get_option('wpsr_'.$this->platform.'_local_'.$headerMeta, array());
            return empty(Arr::get($avatars, $userId));
        }
        return false;
    }

    public function updateLocalHeaderStatus($userId, $status, $headerMeta = '')
    {
        $avatars = get_option('wpsr_'.$this->platform.'_local_'.$headerMeta, array());
        if(!empty($userId)) {
            $avatars[$userId] = $status;
            update_option('wpsr_'.$this->platform.'_local_'.$headerMeta, $avatars);
        }
    }

    public function createLocalHeader($userName, $fileName,$headerMeta)
    {
        if (empty($fileName)) {
            return false;
        }

        $imageEditor   = wp_get_image_editor($fileName);
        if(is_wp_error($imageEditor)) {
            if (!function_exists('download_url' )) {
                include_once ABSPATH . 'wp-admin/includes/file.php';
            }

            $timeoutInSeconds = 5;
            $temp_file = download_url($fileName, $timeoutInSeconds);
            $imageEditor = wp_get_image_editor($temp_file);
            if (!empty($temp_file)) {
                @unlink($temp_file);
            }
        }
        if($headerMeta == 'avatars'){
            $fullFileName = $this->getUploadDir($this->platform) . '/' . $userName . '.jpg';
        }else{
            $fullFileName = $this->getUploadDir($this->platform) . '/' . $userName . '_cover.jpg';
        }

        if (!is_wp_error($imageEditor)) {
            $resize = $headerMeta == 'avatars' ? 150 : 600;
            $imageEditor->set_quality(80);
            $imageEditor->resize($resize, null);
            $saved_image = $imageEditor->save($fullFileName);
            if ($saved_image) {
                return true;
            }
        }

        return $this->download($fileName, $fullFileName);
    }

    public function deleteLeastUsedImages()
    {
        $limit = ($this->availableRecords  && $this->availableRecords > 1) ? $this->availableRecords : 1;
        $oldPosts = (new OptimizeImage())->getOldPosts($limit, $this->platform);

        $upload_dir = $this->getUploadDir($this->platform);
        $imageSizes = ['thumb', 'low', 'full'];
        foreach ($oldPosts as $post) {
            $userName = Arr::get($post, 'user_name');
            foreach ($imageSizes as $size) {
                $file_name = $upload_dir .  '/'. $userName . '/' . Arr::get($post, 'media_id') . '_' . $size . '.jpg';
                if (is_file($file_name)) {
                    unlink($file_name);
                }
            }

            $mediaId = Arr::get($post, 'media_id');
            if(!empty($mediaId)) {
                (new OptimizeImage())->deleteMedia($mediaId, $userName);
            }
        }
    }

    protected function maxRecordsCount()
    {
        $maxRecordsMap = [
            'instagram' => WPSOCIALREVIEWS_INSTAGRAM_MAX_RECORDS,
            'facebook_feed' => WPSOCIALREVIEWS_FACEBOOK_FEED_MAX_RECORDS,
            'tiktok' => WPSOCIALREVIEWS_TIKTOK_MAX_RECORDS,
        ];

        return $maxRecordsMap[$this->platform] ?? 0;
    }

    public function isMaxRecordsReached()
    {
        $totalRecords = OptimizeImage::where('platform', $this->platform)->count();
        $max_records = $this->maxRecordsCount();

        if ($totalRecords > $max_records) {
            $this->availableRecords = (int) $totalRecords - $max_records;
            return true;
        }
        return false;
    }

    public function updateLastRequestedTime($ids)
    {
        if (count($ids) === 0) {
            return;
        }

        if($this->shouldUpdateLastRequestedTime()) {
            (new OptimizeImage())->updateLastRequestedTime($ids);
        }
    }

    public function maxResizingPerUnitTimePeriod()
    {
        $fifteenMinutesAgo = date('Y-m-d H:i:s', time() - 15 * 60);
        $totalRecords = OptimizeImage::where('created_at', '>', $fifteenMinutesAgo)->count();

        return ($totalRecords > 100);
    }

    public function shouldUpdateLastRequestedTime()
    {
        return (rand(1, 20) === 20);
    }
}