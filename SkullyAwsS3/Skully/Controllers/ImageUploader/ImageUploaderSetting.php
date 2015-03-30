<?php
/**
 * Created by Trio Digital Agency.
 * Date: 2/26/15
 * Time: 3:12 PM
 */

namespace SkullyAwsS3\Skully\Controllers\ImageUploader;
use Aws\S3\S3Client;
use Skully\App\Helpers\FileHelper;
use SkullyAwsS3\Helpers\S3Helpers;

/**
 * Class ImageUploaderSetting
 * @package SkullyAwsS3\Skully\Controllers\ImageUploader
 * Use this instead of SkullyAdmin\Controllers\ImageUploaderSetting to allow for uploading to Amazon S3.
 */

Trait ImageUploaderSetting {
    use \SkullyAdmin\Controllers\ImageUploader\ImageUploaderSetting {
        processTempImage as parentProcessTempImage;
    }
    use ImageUploader;

    function processTempImage($tmp, $options, $oldFile = '') {
        return $this->S3ProcessTempImage($tmp, $options, $oldFile);
    }

    function processDestroyImage($instance, $imageSetting, $imageField, $position) {
        $this->S3ProcessDestroyImage($instance, $imageSetting, $imageField, $position);
    }
} 