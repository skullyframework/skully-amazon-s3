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
    const __DEFAULT_GIT_DIR_NAME = '.git-s3';
    const __DEFAULT_REMOTE_GIT_DIR_NAME = 'public.git';
    protected function configure()
    {
        $this->setName("skully:s3")
            ->setDescription("Run S3 related commands.")
            ->setDefinition(array(
                new InputArgument('mainCommand', InputArgument::REQUIRED, 'Command to run. When contain spaces, enclose with double-quotes e.g. "git add --all".'),
            ))
            ->addOption('force',
                'f', InputOption::VALUE_OPTIONAL,
                'When set, no need to wait for user\'s inputs e.g. before deleting existing git directory.',
                false)
            ->setHelp(<<<EOT
This console app will help you manage your Amazon S3 repository for use with Skully framework.

Usage examples (include the double quotes):

<info>./console skully:s3 setup</info>
<info>./console skully:s3 "git <git-command>"</info>

Example of git commands (include the double quotes):
<info>./console skully:s3 "git add --all"</info>
<info>./console skully:s3 "git commit -a -m \"Info about this commit\""</info>

Pull / push from s3 repository (include the double quotes):
<info>./console skully:s3 "git pull origin master"</info>
<info>./console skully:s3 "git push origin master"</info>

Skully S3 uses JGit in combination with Jgit to push to amazon S3 repository, so any JGit command should work:
<info>./console skully:s3 "jgit status"</info>
Or git commands specific for public directories:
<info>./console skully:s3 "git status"</info>

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
            case 'setup':
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
                $s3ConfigFile = $this->app->config('basePath').'config'.DIRECTORY_SEPARATOR.'AmazonS3'.DIRECTORY_SEPARATOR.'.s3conf';
                $s3ConfigText = 'accesskey: '. $s3Config['setting']['key'] . "\n" .
                'secretkey: ' . $s3Config['setting']['secret'] . "\n" .
                'acl: public';
                file_put_contents($s3ConfigFile, $s3ConfigText);
                $addRemoteCommand = 'git --git-dir="'.$gitdir.'" remote add origin amazon-s3://"'.$s3ConfigFile.'"@'.$s3Config['bucket'].'/'.$remotegitname;
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