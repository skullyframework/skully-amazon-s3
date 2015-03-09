<?php
/**
 * Created by Trio Digital Agency.
 * Date: 2/27/15
 * Time: 4:33 PM
 */
require_once(realpath(__DIR__.'/../AdminTestCase.php'));

use \Skully\Console\Console;
use \Skully\App\Helpers\FileHelper;
use \SkullyAwsS3\Skully\Commands\S3Command;

class S3ConsoleTest extends \Tests\AdminTestCase {
    public function testSetup()
    {
        $app = __setupApp();
        $console = new Console($app, true);
        $console->addCommands($app->config('additionalCommands'));

        $gitpath = realpath(__DIR__.'/../app/.git-s3');
        echo $gitpath;
        shell_exec('rm -rf ' . $gitpath);
        $this->assertFalse(file_exists($gitpath));
        $commands = $console->getCommands();
        function className($item) {
            return get_class($item);
        }
        print_r(array_map('className', $commands));
        $output = $console->run("skully:s3 setup -f");
        echo $output->fetch();
        FileHelper::removeFolder($gitpath);
        $this->assertFalse(file_exists($gitpath));
    }

    public function xtestGitCommand()
    {
        $app = __setupApp();
        $command = new S3Command($app, 'skully:s3');
        $expected = 'git --git-dir="'.$app->config('basePath').'.git-s3" --work-tree="'.$app->config('basePath').'" add --all';
        $this->assertEquals($expected, $command->gitCommand('add --all'));

        $expected = 'git --git-dir="'.$app->config('basePath').'.git-s3" --work-tree="'.$app->config('basePath').'" commit -a -m "hello there"';
        $this->assertEquals($expected, $command->gitCommand('commit -a -m "hello there"'));
    }

    public function xtestJGitCommand()
    {
        $app = __setupApp();
        $command = new S3Command($app, 'skully:s3');
        $expected = $command->jgitPath().' --git-dir="'.$app->config('basePath').'.git-s3" push origin master';
        $this->assertEquals($expected, $command->jgitCommand('push origin master'));

        $expected = $command->jgitPath().' --git-dir="'.$app->config('basePath').'.git-s3" pull origin master';
        $this->assertEquals($expected, $command->jgitCommand('pull origin master'));
    }

    public function testCreateNewFile()
    {
        $app = __setupApp();
        $console = new Console($app, true);
        $console->addCommands($app->config('additionalCommands'));

        file_put_contents($app->getTheme()->getBasePath().'test.txt', "test stuff");
        file_put_contents($app->getTheme()->getAppPath().'appfile.txt', "I shall not pass");
        $output = $console->run("skully:s3 \"git add --all\"");
        echo $output->fetch();
        $output = $console->run('skully:s3 "git commit -a -m \"Test commit\""');
        echo $output->fetch();
        $output = $console->run('skully:s3 "git push origin master"');
        echo $output->fetch();

        /**
         * @var SkullyAwsS3\S3Client $s3client
         * @var SkullyAwsS3\S3ApplicationTrait $app
         */
        $s3client = $app->getS3Client();

        $this->assertTrue($s3client->isObject('text.txt'));
        $this->assertFalse($s3client->isObject('TestApp/appfile.txt'));


        // Check if files within App directory were not pushed to repository.
    }

    public function testUpdateFile()
    {

    }

    public function testDeleteFile()
    {

    }
}
 