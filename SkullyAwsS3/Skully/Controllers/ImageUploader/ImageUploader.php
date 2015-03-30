<?php
/**
 * Created by Trio Digital Agency.
 * Date: 2/27/15
 * Time: 1:08 AM
 */

namespace SkullyAwsS3\Skully\Controllers\ImageUploader;


use Aws\S3\S3Client;
use Skully\App\Helpers\FileHelper;
use SkullyAwsS3\Helpers\S3Helpers;

/**
 * Class ImageUploader
 * @package SkullyAwsS3\Skully\Controllers\ImageUploader
 */

Trait ImageUploader {
    function S3ProcessTempImage($tmp, $options, $oldFile = '')
    {
        $path = $this->parentProcessTempImage($tmp, $options, $oldFile);
        $key = S3Helpers::key($this->app->config('publicDir'), $path);
        $amazonS3Config = $this->app->config('amazonS3');
        $client = S3Client::factory($amazonS3Config['settings']);
        $abspath = FileHelper::replaceSeparators($this->app->getTheme()->getBasePath().$path);
        $client->putObject(array(
            'Bucket'     => $amazonS3Config['bucket'],
            'Key'        => $key,
            'SourceFile' => $abspath,
            'ACL'        => 'public-read'
        ));

        $client->waitUntil('ObjectExists', array(
            'Bucket' => $amazonS3Config['bucket'],
            'Key'    => $key
        ));

        unlink($abspath);
        return $path;
    }

    public function S3ProcessDestroyImage($instance, $imageSetting, $imageField, $position) {
        if (!$instance->hasError()) {
            try {
                $amazonS3Config = $this->app->config('amazonS3');
                $client = S3Client::factory($amazonS3Config['settings']);

                $imageSettings = $this->getImageSettings();
                if($imageSettings[$imageSetting]["_config"]["multiple"]){
                    $imageValue = $instance->get($imageField);
                    if (!is_array($imageValue)) {
                        $imageValue = UtilitiesHelper::decodeJson($imageValue, true);
                    }
                    $imagesAtPosition = $imageValue[$position];
                    if (!empty($imagesAtPosition)) {
                        if(!empty($imageSettings[$imageSetting]["types"])){ //multiple many types
                            foreach($imagesAtPosition as $key => $image) {
                                $client->deleteObject(array(
                                    'Bucket' => $amazonS3Config['bucket'],
                                    'Key'    => S3Helpers::key($this->app->config('publicDir'), $image)
                                ));
                            }
                        }
                        else{ //multiple single types
                            $client->deleteObject(array(
                                'Bucket' => $amazonS3Config['bucket'],
                                'Key'    => S3Helpers::key($this->app->config('publicDir'), $imagesAtPosition)
                            ));
                        }
                    }
                    unset($imageValue[$position]);
                    $imageValue = array_values($imageValue);
                    $instance->set($imageField, json_encode($imageValue));
                }
                else if(!$imageSettings[$imageSetting]["_config"]["multiple"] && !empty($imageSettings[$imageSetting]["types"])){
                    $imageValue = $instance->get($imageField);
                    if (!is_array($imageValue)) {
                        $imageValue = UtilitiesHelper::decodeJson($imageValue, true);
                    }
                    if(!empty($imageValue) && is_array($imageValue)){
                        foreach($imageValue as $key => $image) {
                            $client->deleteObject(array(
                                'Bucket' => $amazonS3Config['bucket'],
                                'Key'    => S3Helpers::key($this->app->config('publicDir'), $image)
                            ));
                        }
                    }
                    $instance->set($imageField, "");
                }
                R::store($instance);
                echo json_encode(array(
                    'message' => $this->app->getTranslator()->translate('deleted'),
                    'setting' => $imageSetting,
                    'field' => $imageField,
                    'position' => $position
                ));
            }
            catch (\Exception $e) {
                $this->app->getLogger()->log("Cannot delete data : " . $e->getMessage());
            }
        }
    }
} 