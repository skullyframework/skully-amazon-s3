<?php
/**
 * Created by Trio Digital Agency.
 * Date: 2/26/15
 * Time: 3:12 PM
 */

namespace SkullyAwsS3\Skully\Models\Traits;
use Aws\S3\S3Client;
use Skully\App\Helpers\FileHelper;
use SkullyAwsS3\Helpers\S3Helpers;

/**
 * Class HasImages
 * @package SkullyAwsS3\Skully\Models\Traits\HasImages
 * Trait used for models having a field "images" which is a json text containing list of images.
 * Field name must be named as exactly "images".
 * If you need to use different field name, override the methods you need.
 * This trait is required so images can be uploaded with Skully Admin.
 * Use this instead of Skully\App\Models\Traits\HasImages to allow for uploading to Amazon S3.
 */
Trait HasImages {
    use \Skully\App\Models\Traits\HasImages {
        afterDestroy as parentAfterDestroy;
    }

    function afterDestroy($oldMe){
        $this->parentAfterDestroy($oldMe);
        $oldId = $this->bean->old("id");
        $classname = $this->classname();

        $imagePath = S3Helpers::key($this->app->config('publicDir'), 'images/'.$classname.'/' . $oldId . '/');
        $this->S3DeleteDir($imagePath);

    }

    /**
     *   This function will delete a directory.  It first needs to look up all objects with the specified directory
     *   and then delete the objects.
     */
    function S3DeleteDir($dir){
        //the $dir is the path to the directory including the directory

        // the directories need to have a / at the end.
        // Clear it just in case it may or may not be there and then add it back in.
        $dir = rtrim($dir, "/");
        $dir = ltrim($dir, "/");
        $dir = $dir . "/";

        $amazonS3Config = $this->app->config('amazonS3');
        $client = S3Client::factory($amazonS3Config['settings']);

        // Get list of directories
        $response = $client->listObjects(array(
            'Bucket' => $amazonS3Config['bucket'],
            'Prefix' => $dir
        ));

//        $this->app->getLogger()->log('list of directories: ' . print_r($response['Contents'], true));

        // Delete each
        foreach($response['Contents'] as $file){
            $client->deleteObject(array(
                'Bucket' => $amazonS3Config['bucket'],
                'Key'    => $file['Key']
            ));
//            $this->app->getLogger()->log('delete ' . $file['Key']);
        }

        return true;

    }
}