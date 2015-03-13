# skully-amazon-s3
Skully Framework integration with Amazon S3. Features:

1. Conversion of all important public urls to their respective Amazon S3 paths.
2. If you have Skully Admin installed - Automatically send all uploaded images to your S3 repository after they resize completed.
3. Console application to git manage your public directory in Amazon.

## Main Module

The main module allows your app to convert all public urls into amazon S3 repository paths, and send images uploaded in admin to your S3 repository.

### Installation of main module

Include this into your composer:

```
"require": {
    "skullyframework/skully-amazon-s3": "0.1.*"
}
```

Then do `composer update`.

Update your Application and Config classes by use-ing `S3ApplicationTrait` and `S3ConfigTrait` in them. Follow the code from `/vendor/skullyframework/skully-amazon-s3/Tests/app/TestApp` on how to do this.

### Usage of main module

Add the following code to your config file (yourapp/config/config.common.php or yourapp/config/config.unique.php):

```
    // Copy credentials.csv from AmazonS3 website into directory "config/AmazonS3/"
    $csv = file_get_contents(realpath(__DIR__.'/AmazonS3/credentials.csv'));
    $csv_r = explode("\n", $csv);
    $s3Config = explode(',', trim($csv_r[1]));
    $s3Config[0] = str_replace('"', '', $s3Config[0]);

    $config->setProtectedFromArray(array(
        'amazonS3' => array(
            'enabled' => true,
            'bucket' => 'skully-admin',
            'region' => 's3-ap-southeast-1',
            'settings' => array(
                'profile'=> $s3Config[0],
                'key'    => $s3Config[1],
                'secret' => $s3Config[2],
            )
        )
    ));
```

**Use your Amazon credentials in your app**:

Copy the directory `yourapp/vendor/skully-amazon-s3/Tests/app/config/AmazonS3` and add the following to your `yourapp/.gitignore` file:
```
config/AmazonS3/*
!config/AmazonS3/README.txt
.git-s3
.s3conf
```

Login to your Amazon S3 account, then download your access credentials. It is usually named `credentials.csv`. Copy this file to `yourapp/config/amazonS3` directory so it can be used by your config file.

And in your Skully Admin controllers, change them to extend from `SkullyAwsS3\Controllers\ImageUploader\ImageUploaderCRUD` or `SkullyAwsS3\Controllers\ImageUploader\ImageUploaderSetting` or `SkullyAwsS3\Controllers\ImageUploader\ImageUploader` instead. To see this, see example code at `/vendor/skully-amazon-s3/Tests/app/TestApp/Controllers/Admin/CRUDImagesController.php`.

**Done!**

At this stage both feature #1 and #2 mentioned earlier should have implemented within your app.

## Console Application

You can actually start working with Amazon S3 now by manually sending all your files in public directory to your Amazon S3 repository, except for public/[template]/App directory. If you need a better workflow, though (and you should!), you can install the **Console Application** for this module, which basically allows you to treat your Amazon S3 repository as Git repository.

You could then simply do `./console skully:s3 sync` to synchronise the files to your server.

This console app uses s3cmd application, so you may also use any of its commands by calling `./console skully:s3 "s3cmd [arguments]"`.

s3cmd references:

1. Simple commands: [http://s3tools.org/s3cmd-howto](http://s3tools.org/s3cmd-howto)
2. Advanced commands: [http://s3tools.org/s3cmd-sync](http://s3tools.org/s3cmd-sync)

### Installation of console application

S3cmd used by this module requires Python 2.6 (or newer). S3cmd is not compatible with Python 3.x.

### Usage of console application

Simply run this command to synchronise with server:

```
./console skully:s3 sync
```

## Example

There is a sample application in `Tests/TestApp/app`. To set this up (do the following in your terminal):
1. Clone this repository into your web server ```git clone https://github.com/skullyframework/skully-amazon-s3 ```.
2. Create a database named `skully_admin` and `skully_admin_test`.
3. Browse to the test app ```cd Tests/app```.
4. Run db migration ```./console skully:schema db:migration```.
5. Browse to your app
