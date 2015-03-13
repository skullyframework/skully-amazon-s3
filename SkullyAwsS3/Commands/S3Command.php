<?php
/**
 * Created by Trio Digital Agency.
 * Date: 2/28/15
 * Time: 9:54 PM
 */

namespace SkullyAwsS3\Skully\Commands;


use Skully\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class S3Command extends Command {
    public function s3cmdPath()
    {
        return realpath(__DIR__.DIRECTORY_SEPARATOR."s3cmd-1.5.2".DIRECTORY_SEPARATOR.'s3cmd');
    }
    protected function configure()
    {
        $this->setName("skully:s3")
            ->setDescription("S3 commands")
            ->setDefinition(array(
                new InputArgument('mainCommand', InputArgument::REQUIRED, 'Command to run.'),
            ))
            ->addOption('python-command', 'p', InputOption::VALUE_REQUIRED, 'python')
            ->setHelp(<<<EOT
This console app will help you manage your Amazon S3 repository for use with Skully framework.

It uses s3cmd application located in {$path}

To use:

<info>./console skully:s3sync</info>
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $argv = $input->getArguments();
        $mainCommand = $argv['mainCommand'];
        $commands = explode(' ', $mainCommand);
        $command = $commands[0];
        $gitdir = $this->gitDirPath();
        $remotegitname = $this->remoteGitDirName();

        $force = $input->getOption('force');

        $status = null;

        switch ($command) {
            case 'git':
                unset($commands[0]);
                $commands = array_values($commands);
                $command = implode(' ', $commands);
                switch ($commands[0]) {
                    case 'add':
                        // Remove files under directory "App".
                        $cmd = $this->gitCommand($command);
                        echo $cmd."\n";
                        shell_exec($cmd);
                        $cmd = $this->gitCommand('reset -- ' . $this->app->getTheme()->getAppPath());
                        echo $cmd."\n";
                        shell_exec($cmd);
                        break;
                    case 'push':
                    case 'pull':
                        // Change command to jgit push.
                        $cmd = $this->jgitCommand($command);
                        echo $cmd."\n";
                        shell_exec($cmd);
                        break;
                    default:
                        $cmd = $this->gitCommand($command);
                        echo $cmd."\n";
                        shell_exec($cmd);
                        break;
                }
                break;
            case 'setup:git':
                if (file_exists($gitdir)) {
                    echo "Warning: Git directory $gitdir already exists, delete it and setup a new one? (Y/N): ";
                    if ($force) {
                        echo "Y";
                        unlink($gitdir);
                    }
                    else {
                        $handle = fopen ("php://stdin","r");
                        $line = fgets($handle);
                        if(strtoupper(trim($line)) == 'Y'){
                            unlink($gitdir);
                        }
                        else {
                            echo "\nCommand cancelled.";
                            return "Command cancelled.";
                        }
                    }
                }

                $initCommand = 'git --git-dir="'.$gitdir.'" init';
                echo "$initCommand\n";
                shell_exec($initCommand);
                $s3Config = $this->app->config('amazonS3');
                print_r($s3Config);
                $s3ConfigFile = $this->app->config('basePath').'.s3conf';
                $s3ConfigText = 'accesskey: '. $s3Config['settings']['key'] . "\n" .
                'secretkey: ' . $s3Config['settings']['secret'] . "\n" .
                'acl: public';
                file_put_contents($s3ConfigFile, $s3ConfigText);
                $addRemoteCommand = 'git --git-dir="'.$gitdir.'" remote add origin amazon-s3://.s3conf@'.$s3Config['bucket'].'/'.$remotegitname;
                echo $addRemoteCommand."\n";
                shell_exec($addRemoteCommand);
                break;
        }
        return $status;
    }

    public function gitCommand($command)
    {
        return 'git --git-dir="'.$this->gitDirPath().'" --work-tree="'.$this->workTreePath().'" '. $command;
    }

    public function jgitCommand($command)
    {
        return $this->jgitPath() . ' --git-dir="'.$this->gitDirPath().'" '. $command;
    }

    public function gitDirName()
    {
        return self::__DEFAULT_GIT_DIR_NAME;
    }

    public function remoteGitDirName()
    {
        return self::__DEFAULT_REMOTE_GIT_DIR_NAME;
    }

    public function gitDirPath()
    {
        return $this->app->config('basePath') . $this->gitDirName();
    }

    public function workTreePath()
    {
        if (substr($this->app->config('basePath'), -1,1) == DIRECTORY_SEPARATOR) {
            return substr($this->app->config('basePath'), 0, strlen($this->app->config('basePath'))-1);
        }
        else {
            return $this->app->config('basePath');
        }
    }

    public function jgitPath()
    {
        return realpath(__DIR__.DIRECTORY_SEPARATOR.'jgit.sh');
    }
} 