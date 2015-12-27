<?php

namespace Preport;

/**
 *
 */
class Reporter
{
    /**
     * @var array
     */
    private $rules;

    /**
     *
     */
    public function __construct()
    {
        $this->rules = [];
    }

    /**
     * @param  string             $subject
     * @return Preport\ReportRule
     */
    public function report($subject)
    {
        if (isset($this->rules[$subject])) {
            throw new \Exception('TBD');
        }

        $this->rules[$subject] = new ReportRule;

        return $this->rules[$subject];
    }

    /**
     * @return array
     */
    public function walk()
    {
        $reports = [];

        $rules = $this->rules;
        while (count($rules) !== 0) {
            $evaluated = false;
            foreach ($rules as $subject => $rule) {
                if ($rule->isSatisfied($reports)) {
                    $reports[$subject] = new Report($subject, $rule);
                }

                unset($rules[$subject]);

                $evaluated = true;
            }

            if (!$evaluated) {
                break;
            }
        }

        return $reports;
    }
}
