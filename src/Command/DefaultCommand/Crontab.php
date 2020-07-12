<?php


namespace EasySwoole\EasySwoole\Command\DefaultCommand;


use EasySwoole\Bridge\Package;
use EasySwoole\Command\AbstractInterface\CommandHelpInterface;
use EasySwoole\Command\Result;
use EasySwoole\EasySwoole\Command\AbstractCommand;
use EasySwoole\Utility\ArrayToTextTable;

class Crontab extends AbstractCommand
{
    public function commandName(): string
    {
        return 'crontab';
    }

    public function help(CommandHelpInterface $commandHelp): CommandHelpInterface
    {
        $commandHelp->addCommand('show','show crontab');
        $commandHelp->addCommand('stop','stop crontab');
        $commandHelp->addCommand('resume','resume crontab');
        $commandHelp->addCommand('run','run crontab');
        return $commandHelp;
    }

    protected function stop($args)
    {
        $taskName = array_shift($args);
        return $this->bridgeCall(function (Package $package) {
            $data = $package->getMsg();
            return $data . PHP_EOL . $this->show()->getMsg();
        }, 'stop', ['taskName' => $taskName]);
    }


    protected function resume($args)
    {
        $taskName = array_shift($args);
        return $this->bridgeCall(function (Package $package) {
            $data = $package->getMsg();
            return $data . PHP_EOL . $this->show()->getMsg();
        }, 'resume', ['taskName' => $taskName]);
    }

    protected function run($args)
    {
        $taskName = array_shift($args);
        return $this->bridgeCall(function (Package $package) {
            $data = $package->getMsg();
            return $data . PHP_EOL . $this->show()->getMsg();
        }, 'run', ['taskName' => $taskName]);
    }

    protected function show()
    {
        return $this->bridgeCall(function (Package $package) {
            $data = $package->getArgs();
            foreach ($data as $k => $v) {
                $v['taskNextRunTime'] = date('Y-m-d H:i:s', $v['taskNextRunTime']);
                $data[$k] = array_merge(['taskName' => $k], $v);
            }
            return new ArrayToTextTable($data);
        }, 'show');
    }

}
