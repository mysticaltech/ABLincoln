<?php

namespace Vimeo\ABLincoln\Experiments;

use \Psr\Log\LoggerInterface;

/**
 * Simple experiment trait that exposure logs according to PSR-3 logging
 * specifications. User experiments utilizing this trait should pass in their
 * own compatible logger instance.
 */
trait TraitExperiment
{
    use AbstractExperiment {
        AbstractExperiment::initialize as parentInitialize;
    }

    protected $logger;
    protected $LOG_FORMAT = '%s with event type: %s';

    /**
     * Initialize a new Simple experiment, passing in hashing inputs and logger
     *
     * @param array $inputs array of inputs to use for experiment hashing
     * @param LoggerInterface $logger optional PSR-3 logging instance to use
     */
    public function initialize($inputs, LoggerInterface $logger = null)
    {
        $this->parentInitialize($inputs);
        $this->logger = $logger;
    }

    /**
     * Set a new PSR-3 logging instance to use for output
     *
     * @param LoggerInterface $logger PSR-3 compliant logger to use for output
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * All logger configuring will be done outside of this class
     */
    protected function _configureLogger() {}

    /**
     * Use the logging instance to log experiment name, event type, and data
     *
     * @param array $data exposure log data to record
     */
    protected function _log($data)
    {
        if (isset($this->logger)) {
            $this->logger->info(sprintf($LOG_FORMAT, $this->name, $data['event']), $data);
        }
    }

    /**
     * Assume data has never been logged before for a Simple experiment
     */
    protected function _previouslyLogged()
    {
        return false;
    }
}