<?php

namespace LogGen;

use LogGen\GetCliOpt ;
use LogGen\Markdown ;
use LogGen\Shell;


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
    public $logs = [];

    /**
     * Boot constructor.
     */
    public function __construct($input)
    {
//        #$this->shell = new Shell();
//        #$format = "'" . "%s" . self::SEPARATOR . "%b" . self::SEPARATOR . "%h" . self::END . "'";
//        #$command = "git log 'v2.77.1'...'v2.78.1' --pretty=format:$format --no-merges";
//        #$output = $this->shell->run($command);
//        #$this->extract($output);
//        #print_r($this->logs);
//
        $objGetCliOpt = new GetCliOpt();

        if ( $objGetCliOpt->setInput($input) ) {
            // use input settings
            $objGetOpt = $objGetCliOpt->parse();
            $a = $objGetOpt->getOptions();
            print_r($a);
        } else {
            // use default settings (latest release)
        }
//
//        #new Markdown($this->logs);

    }

    /**
     * @param $output
     */
    public function extract($output)
    {
        $commits = explode(self::END, $output);
        foreach ($commits as $commit) {
            list($subject,$body,$hash) = explode(self::SEPARATOR,$commit);
            $subject = trim($subject);
            $strIssue = $this->findIssue($body);
            $this->determineGroup($subject,$body,$hash,$strIssue);
        }
    }

    /**
     * @param $strSubject
     * @param $strBody
     * @param $hash
     * @param $strIssue
     */
    public function determineGroup($strSubject,$strBody,$hash,$strIssue)
    {
        foreach ($this->groups as $group) {
            $pattern = "/". $group ."(\(.+\))?:(.*)/";
            if ( preg_match($pattern,$strSubject,$arrMatches) ) {
                $this->logs[$group]['name'] = $group;
                $this->logs[$group]['commits'][$hash]['hash'] = $hash;
                $this->logs[$group]['commits'][$hash]['gitSubject'] = $strSubject;
                $this->logs[$group]['commits'][$hash]['body'] = $strBody;
                $this->logs[$group]['commits'][$hash]['subject'] = $arrMatches[2];
                $this->logs[$group]['commits'][$hash]['core'] = $arrMatches[1];
                $this->logs[$group]['commits'][$hash]['issue'] = $strIssue;
            }
        }
    }

    /**
     * @param $string
     * @return mixed|string
     */
    private function findIssue($string)
    {
        $issue = "";
        $pattern = "/#(\d+)/";
        if ( preg_match($pattern,$string,$arrMatches) ) {
            $issue = $arrMatches[1] ;
        }
        return $issue;
    }
}