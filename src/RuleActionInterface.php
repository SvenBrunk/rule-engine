<?php

namespace OxidEsales\RuleEngine;

/**
 * Interface for an executable action in the rule engine
 */
interface RuleActionInterface
{
    /**
     * Executes the action
     *
     * @param array $context Arbitrary data, e.g. ['basket' => $basket, 'user' => $user]
     *
     * @return void
     */
    public function execute(array $context): void;

}