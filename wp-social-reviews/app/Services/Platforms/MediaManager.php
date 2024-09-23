<?php

namespace WPSocialReviews\App\Services\Platforms;

use WPSocialReviews\Framework\Support\Arr;

class MediaManager {
    protected $resized_image_ids = [];
    protected $image_settings = [];
    protected $imageSize = 'full';
    protected $platform = '';

    public function __construct($resizedImages, $imageSettings, $imageSize, $platform)
    {
        $this->resized_image_ids = $resizedImages;
        $this->image_settings = $imageSettings;
        $this->imageSize = $imageSize;
        $this->platform = $platform;
    }

    public function getMediaUri($post)
    {
        $media_id = Arr::get($post, 'id');
        if(Arr::get($this->image_settings, 'optimized_images') === 'true' || Arr::get($this->image_settings, 'has_gdpr') === "true") {
            if(in_array($media_id, $this->resized_image_ids)) {
                return $this->getLocaImageUri($post);
            }
            return ($this->platform == 'instagram' || $this->platform == 'facebook_feed' || $this->platform == 'tiktok') ? $this->getPlaceholderUri() : null;
        }
        return $this->getPlatformRemoteUri($post);
    }

    public function getLocaImageUri($post)
    {
        if($this->platform == 'instagram'){
            $user_name = Arr::get($post, 'username');
        }else if($this->platform == 'facebook_feed'){
            $user_name = Arr::get($post, 'page_id');
        }else if($this->platform === 'tiktok'){
            $user_name = Arr::get($post, 'user.name');
        }
        
        $media_id = Arr::get($post, 'id');
        $upload     = wp_upload_dir();
        $upload_url = trailingslashit($upload['baseurl']) . trailingslashit(WPSOCIALREVIEWS_UPLOAD_DIR_NAME);

        $image_path = $this->platform.'/' .  $user_name . '/' . $media_id . '_' . $this->imageSize . '.jpg';
        $upload_dir = trailingslashit($upload['basedir']) . trailingslashit(WPSOCIALREVIEWS_UPLOAD_DIR_NAME);
        if(file_exists($upload_dir.$image_path)) {
            return $upload_url . $image_path;
        } else {
            return $this->getAnotherSizedImage($upload_dir, $upload_url, $user_name, $media_id);
        }
    }

    public function getImage($upload_dir, $upload_url, $user_name, $media_id, $size)
    {
        $image_path = $this->platform.'/' .  $user_name . '/' . $media_id . '_'. $size .'.jpg';
        if(file_exists($upload_dir.$image_path)) {
            return $upload_url . $image_path;
        }

        return false;
    }

    public function getAnotherSizedImage($upload_dir, $upload_url, $user_name, $media_id)
    {
        if($this->imageSize !== 'thumb') {
            $currentImage = $this->getImage($upload_dir, $upload_url, $user_name, $media_id, 'thumb');
            if($currentImage) {
                return $currentImage;
            }
        }

        if($this->imageSize !== 'low') {
            $currentImage = $this->getImage($upload_dir, $upload_url, $user_name, $media_id, 'low');
            if($currentImage) {
                return $currentImage;
            }
        }

        if($this->imageSize !== 'full') {
            $currentImage = $this->getImage($upload_dir, $upload_url, $user_name, $media_id, 'full');
            if($currentImage) {
                return $currentImage;
            }
        }
    }

    public function getMediaType($post)
    {
        //if gdpr or optimize images are on we have to return IMAGE as video will not be store locally.
        if(Arr::get($this->image_settings, 'optimized_images') === 'true' || Arr::get($this->image_settings, 'has_gdpr') === "true") {
            return 'IMAGE';
        }

        if(Arr::get($post, 'media_type', false) === 'CAROUSEL_ALBUM' && $this->platform == 'instagram') {
            return Arr::get($post, 'children.data.0.media_type');
        }

        return Arr::get($post, 'media_type');
    }

    public function getThumbnailUrl($post)
    {
        if (Arr::get($post, 'media_type', false) === 'CAROUSEL_ALBUM' && $this->platform == 'instagram') {
            return Arr::get($post, 'children.data.0.thumbnail_url');
        }else if($this->platform == 'facebook_feed'){
            return Arr::get($post, 'attachments.data.0.media.image.src');
        }

        return Arr::get($post, 'thumbnail_url');
    }

    public function getPlatformRemoteUri($post)
    {   
        if(Arr::get($post, 'media_type', false) === 'CAROUSEL_ALBUM' && $this->platform == 'instagram') { 
            return Arr::get($post, 'children.data.0.media_url');
        }else if($this->platform == 'facebook_feed'){
            return Arr::get($post, 'attachments.data.0.media.image.src');
        } else if($this->platform == 'tiktok'){
            return Arr::get($post, 'media.preview_image_url');
        }

        return Arr::get($post, 'media_url');
    }

    public function getPlaceholderUri()
    {
        if($this->platform == 'facebook_feed' || $this->platform == 'tiktok'){
            return WPSOCIALREVIEWS_URL.'assets/images/fb-placeholder.png';
        }else{
            return WPSOCIALREVIEWS_URL.'assets/images/ig-placeholder.png';
        }
        
    }

    public function getInstagramRemoteUri($post)
    {
        $media_type = Arr::get($post, 'media_type', '');
        if($media_type === 'CAROUSEL_ALBUM') {
            return Arr::get($post, 'children.data.0.media_url');
        }

        return $media_type === 'VIDEO' && !Arr::get($post, 'media_url') ? Arr::get($post, 'thumbnail_url') : Arr::get($post, 'media_url');
    }
}