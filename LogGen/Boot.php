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

        var_dump($this->logs);
    }



    public function extract($output)
    {

        $commits = explode(self::END, $output);

        foreach ($commits as $commit) {
            #print $commit . "\n";
            list($subject,$body) = explode(self::SEPARATOR,$commit);
            $subject = trim($subject);
            #print "#". $subject . "#\n";
            #print "#". $body . "#\n";
            $this->determineGroup($subject);
        }
    }


    public function determineGroup($subject)
    {

        foreach ($this->groups as $group) {
            #print $subject;
            $pattern = "/". $group ."\(.+\):/";
            if ( preg_match($pattern,$subject) ) {
                $this->logs[$group][] = $subject;
            }
        }

    }
}
