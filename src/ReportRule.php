<?php

namespace Preport;

/**
 *
 */
class ReportRule
{
    /**
     * @var array
     */
    private $messages;

    /**
     * @var array
     */
    private $params;

    /**
     * @var array
     */
    private $predicates;

    /**
     * @var array
     */
    private $coorporative;

    /**
     * @var array
     */
    private $exclusive;

    /**
     *
     */
    public function __construct()
    {
        $this->messages = [];

        $this->params = [];

        $this->predicates = [];

        $this->coorporative = [];

        $this->exclusive = [];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return $this->messages;
    }

    /**
     * @return array
     */
    public function parameters()
    {
        return $this->params;
    }

    /**
     * @param  string $arg0
     * @param  mixed  $arg1 (optional)
     * @return $this
     */
    public function with()
    {
        $args = func_get_args();

        switch (func_num_args()) {
            case 1:
                return call_user_func_array([$this, 'withMessage'], $args);

            case 2:
                return call_user_func_array([$this, 'withParameter'], $args);

            default:
                throw new \Exception('TBD');
        }
    }

    /**
     * @param  callable $predicate
     * @return $this
     */
    public function where($predicate)
    {
        if (!is_callable($predicate)) {
            throw new \Exception('TBD');
        }

        $this->predicates[] = $predicate;

        return $this;
    }

    /**
     * @param  string $subject
     * @return $this
     */
    public function when($subject)
    {
        $this->coorporative[] = $subject;

        return $this;
    }

    /**
     * @param  string $subject
     * @return $this
     */
    public function unless($subject)
    {
        $this->exclusive[] = $subject;

        return $this;
    }

    /**
     * @param  array $satisfied (optional)
     * @return bool
     */
    public function isSatisfied(array $satisfied = [])
    {
        // Check dependencies.
        $coorporative = $this->coorporative;
        foreach ($satisfied as $report) {
            $subject = $report instanceof Report ? $report->subject() : $report;

            if (in_array($subject, $this->exclusive, true)) {
                return false;
            }

            if (in_array($subject, $coorporative, true)) {
                unset($coorporative[$subject]);
            }
        }
        if (count($coorporative) >= 1) {
            return false;
        }

        // Check predicates.
        foreach ($this->predicates as $predicate) {
            if (!call_user_func($predicate)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param  string $name
     * @param  mixed  $value
     * @return $this
     */
    protected function withParameter($name, $value)
    {
        if (array_key_exists($name, $this->params)) {
            throw new \Exception('TBD');
        }

        $this->params[$name] = $value;

        return $this;
    }

    /**
     * @param  string $message
     * @return $this
     */
    protected function withMessage($message)
    {
        $this->messages[] = $message;

        return $this;
    }
}
