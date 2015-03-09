<?php
/**
 * Created by Trio Digital Agency.
 * Date: 2/26/15
 * Time: 3:12 PM
 */

namespace SkullyAwsS3\Skully\Controllers\ImageUploader;

/**
 * Class ImageUploaderSetting
 * @package SkullyAwsS3\Skully\Controllers\ImageUploader
 */

Trait ImageUploaderSetting {
    use \SkullyAdmin\Controllers\ImageUploader\ImageUploaderSetting {
        processTempImage as parentProcessTempImage;
    }
    use ImageUploader;
} 