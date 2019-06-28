<?php


namespace LogGen;


class Markdown
{
    private $logs = [];

    public function __construct($logs)
    {
        $this->logs = $logs;
        $this->output();
    }

    private function output()
    {
        foreach ($this->logs as $group) {
            #echo print_r($log);
            #echo "\n\n";
            echo "#### " . $group['name'] . "\n";
            foreach ($group['commits'] as $commit) {
                echo $commit['subject'] . "\n";
                #print_r($commit);
            }
        }
    }

}