<?php

namespace Preport;

/**
 *
 */
class Report
{
    /**
     * @var string
     */
    private $subject;

    /**
     * @var ReportRule
     */
    private $rule;

    /**
     * @param string  $subject
     * @param Preport $rule
     */
    public function __construct($subject, ReportRule $rule)
    {
        $this->subject = $subject;

        $this->rule = $rule;
    }

    /**
     * @return string
     */
    public function subject()
    {
        return $this->subject;
    }

    /**
     * @return array
     */
    public function parameters()
    {
        return $this->rule->parameters();
    }

    /**
     * @return array
     */
    public function messages()
    {
        return $this->rule->messages();
    }
}
