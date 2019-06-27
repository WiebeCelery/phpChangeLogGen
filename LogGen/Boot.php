<?php

namespace LogGen;

require 'Shell.php';


class Boot
{
    public $shell ;
    const SEPARATOR = "[<SEP>]";
    const END = "[<END>]";
    public $groups = [
        "feat",
        "fix",
        "refactor",
        "bug"
    ];


    public function __construct()
    {
        $this->shell = new Shell();

        $format = "'" . "%s" . self::SEPARATOR . "%b" . self::END . "'";
        $command = "git log 'v2.77.1'...'v2.78.0' --pretty=format:$format --no-merges";

        $output = $this->shell->run($command);

        $this->extract($output);
    }



    public function extract($output)
    {

        $commits = explode(self::END, $output);

        foreach ($commits as $commit) {
            #print $commit . "\n";
            list($subject,$body) = explode(self::SEPARATOR,$commit);
            print "#". $subject . "#\n";
            print "#". $body . "#\n";
        }



    }


    public function determineGroup($subject)
    {

    }
}
