<?php
namespace SkullyAwsS3;


use SkullyAwsS3\Helpers\S3Helpers;

class S3Client{
    /**
     * @var \Aws\S3\S3Client
     */
    protected $client;

    /**
     * @var \Skully\Application
     */
    protected $app;

    public function __construct($s3config, $app) {
        $this->client = \Aws\S3\S3Client::factory($s3config);
        $this->app = $app;
    }

    public function getObject($path)
    {
        $s3config = $this->app->config('amazonS3');
        $result = $this->client->getObject(array(
            'Bucket' => $s3config['bucket'],
            'Key'    => S3Helpers::key($this->app->config('publicDir'), $path)
        ));
        return $result;
    }

    public function isObject($path)
    {
        $object = $this->getObject($path);
        return !empty($object['Body']);
    }
}