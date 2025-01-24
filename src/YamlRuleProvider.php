<?php

namespace OxidEsales\RuleEngine;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\Yaml\Yaml;

class YamlRuleProvider implements RuleProviderInterface
{
    /** @var string Pfad zur YAML-Datei */
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Lädt die Rules aus dem YAML-File.
     *
     * @return Rule[]
     */
    public function getRules(): array
    {
        $rules = [];

        if (file_exists($this->filePath)) {
            $yamlData = Yaml::parseFile($this->filePath);

            if (!empty($yamlData['rules']) && is_array($yamlData['rules'])) {
                $exprLang = new ExpressionLanguage();

                foreach ($yamlData['rules'] as $ruleConfig) {
                    $conditionStr = $ruleConfig['condition'] ?? null;
                    if (!$conditionStr) {
                        continue;
                    }

                    $condition = new ExpressionCondition($conditionStr, $exprLang);
                    $actions = $this->buildActions($ruleConfig['actions'] ?? []);

                    $rules[] = new Rule($condition, $actions);
                }
            }
        }

        return $rules;
    }

    /**
     * Erzeugt aus dem YAML-Actions-Array die konkreten Action-Objekte.
     *
     * @param array $actionConfigs
     * @return RuleActionInterface[]
     */
    private function buildActions(array $actionConfigs): array
    {
        $actions = [];

        foreach ($actionConfigs as $actionDef) {
            $class = $actionDef['class'] ?? null;
            $arguments = $actionDef['arguments'] ?? [];

            if ($class && class_exists($class)) {
                // Instanziere dynamisch
                $actionObj = new $class(...$arguments);
                if ($actionObj instanceof RuleActionInterface) {
                    $actions[] = $actionObj;
                }
            }
        }

        return $actions;
    }
}