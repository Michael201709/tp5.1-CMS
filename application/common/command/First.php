<?php

namespace app\common\command;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;

class First extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('first')
            ->addArgument('name', Argument::OPTIONAL, "your name")
            ->addOption('city', null, Option::VALUE_REQUIRED, 'city name')
            ->setDescription('Say Hello');
    }
    
    protected function execute(Input $input, Output $output)
    {
        // 指令输出
        // $output->writeln('first');
        $name = trim($input->getArgument('name'));
        $name = $name ? :'thinkphp';
        if ($input->hasOption('city')) {
            $city = PHP_EOL . 'From ' . $input->getOption('city');
        } else {
            $city = '';
        }
        $output->writeln("Hello," . $name . '!' . $city);
    }
}
