<?php

namespace OxidEsales\RuleEngine;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * Condition that evaluates an expression via Symfony ExpressionLanguage
 */
class ExpressionCondition
{
    /** @var string */
    private string $expression;

    /** @var ExpressionLanguage */
    private ExpressionLanguage $expressionLanguage;

    /**
     * @param string             $expression         The expression to be checked, e.g. "basket.getPrice() > 100"
     * @param ExpressionLanguage $expressionLanguage
     */
    public function __construct(string $expression, ExpressionLanguage $expressionLanguage)
    {
        $this->expression = $expression;
        $this->expressionLanguage = $expressionLanguage;
    }

    /**
     * Checks, if the condition resolves to true
     *
     * @param array $context Context, e.g. ['basket' => $basket]
     *
     * @return bool
     */
    public function evaluate(array $context): bool
    {
        return (bool) $this->expressionLanguage->evaluate($this->expression, $context);
    }
}