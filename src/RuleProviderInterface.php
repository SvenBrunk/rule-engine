<?php
namespace OxidEsales\RuleEngine;

interface RuleProviderInterface
{
    /**
     * Gibt ein Array von Rule-Objekten zurück.
     *
     * @return Rule[]
     */
    public function getRules(): array;
}
