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

You could then simply do `./console skully:s3 git (add / commit / push)` to send the files to your server, along with other git commands.

### Installation of console application

First, you need to make sure JDK (Java Development Kit) is installed. JDK is used by [jgit.sh](https://github.com/eclipse/jgit), the application we use to manage git repository in Amazon S3.

#### JDK Installation for Windows / Mac OS X:

Review installation from http://www.oracle.com/technetwork/java/javase/downloads/index.html

#### JDK Installation for Linux with Apt-Get:

```
sudo apt-get install default-jre
sudo apt-get install default-jdk
```

### Usage of console application

Following commands are to be executed from your project's main directory via terminal:

**Setup your local git repository**

You'd only need to do this once in **each of your development machine**, so if you work on two computers for one project, you need to do this in both of your computers:

```
./console skully:s3 setup
```

**Add, commit, and push the files you created in your public directory**

Do this anytime you make an update to your public directory.

```
./console skully:s3 git add --all
./console skully:s3 git commit -a -m "Note about the update."
./console skully:s3 git push origin master
```

**Pull updates from your S3 repository**

Do this anytime you need to get latest update from your repository.

```
./console skully:s3 git pull origin master
```

## Example

There is a sample application in `Tests/TestApp/app`. To set this up (do the following in your terminal):
1. Clone this repository into your web server ```git clone https://github.com/skullyframework/skully-amazon-s3 ```.
2. Create a database named `skully_admin` and `skully_admin_test`.
3. Browse to the test app ```cd Tests/app```.
4. Run db migration ```./console skully:schema db:migration```.
5. Browse to your app
