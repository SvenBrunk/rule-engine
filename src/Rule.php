<?php

namespace OxidEsales\RuleEngine;

/**
 * Represents a rule with Condition + Actions.
 */
class Rule
{
    /** @var ExpressionCondition */
    private $condition;

    /** @var RuleActionInterface[] */
    private array $actions = [];

    /**
     * @param ExpressionCondition   $condition
     * @param RuleActionInterface[] $actions
     */
    public function __construct(ExpressionCondition $condition, array $actions = [])
    {
        $this->condition = $condition;
        $this->actions = $actions;
    }

    /**
     * Führt die Regel aus, falls Condition true ist.
     */
    public function apply(array $context): void
    {
        if ($this->condition->evaluate($context)) {
            foreach ($this->actions as $action) {
                $action->execute($context);
            }
        }
    }
}