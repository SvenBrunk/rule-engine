<?php

namespace OxidEsales\RuleEngine;

/**
 * Core component: Manages a list of rules and applies them in one run.
 */
class RuleEngine
{
    /** @var Rule[] */
    private array $rules = [];

    /**
     * Registriert eine oder mehrere Regeln.
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
     * Führt alle Regeln aus.
     *
     * @param array $context z. B. ['basket' => $basket, 'user' => $user]
     */
    public function applyRules(array $context): void
    {
        foreach ($this->rules as $rule) {
            $rule->apply($context);
        }
    }
}