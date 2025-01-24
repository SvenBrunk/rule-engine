<?php

namespace OxidEsales\RuleEngine;

/**
 * Core component: Manages a list of rules and applies them in one run.
 */
class RuleEngine
{
    /** @var Rule[] */
    private array $rules = [];

    /** @var RuleProviderInterface[] */
    private array $providers = [];

    /**
     * Registers a RuleProvider. (e.g. YAMLProvider, DBProvider etc.)
     */
    public function addProvider(RuleProviderInterface $provider): void
    {
        $this->providers[] = $provider;
    }

    /**
     * Registers one or more rules.
     *
     * @param Rule $rule
     *
     * @return void
     */
    public function addRule(Rule $rule): void
    {
        $this->rules[] = $rule;
    }

    /**
     * Loads all rules from all registered providers into rule array
     *
     * @return void
     */
    public function loadProviderRules(): void
    {
        foreach ($this->providers as $provider) {
            $this->rules = array_merge($this->rules, $provider->getRules());
        }
    }

    /**
     * Executes all rules.
     *
     * @param array $context z. B. ['basket' => $basket, 'user' => $user]
     */
    public function applyRules(array $context): void
    {
        $this->loadProviderRules();
        foreach ($this->rules as $rule) {
            $rule->apply($context);
        }
    }
}