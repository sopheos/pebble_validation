<?php

namespace Pebble\Validation;

use PHPUnit\Framework\TestCase;

class TestHelper
{
    /**
     * Test la configuration des formulaires
     *
     * @param FormInterface $form
     * @param array $tests Tableau associatif nom => classe
     * @param array $required Liste des champs requis
     */
    public static function fields(FormInterface $form, array $tests, array $required = [])
    {
        $fields = $form->fields();

        // Pour chaque champ :
        foreach ($fields as $name => $field) {
            // On vérifie que le champ est testé
            TestCase::assertArrayHasKey($name, $tests, self::dangerMsg("Any test for {$name} field"));
            // On vérifie que le champ est de la bonne classe
            TestCase::assertSame($field::class, $tests[$name], self::dangerMsg("Incorrect field type"));

            // Test du champ requis
            $fieldReq = $field->getRequired() ? true : false;
            if (in_array($name, $required)) {
                TestCase::assertTrue($fieldReq, self::dangerMsg("{$name} is a required field"));
            } else {
                TestCase::assertFalse($fieldReq, self::dangerMsg("{$name} is not a required field"));
            }
        }

        // On vérifie que l'on a pas des champs non testés
        foreach (array_keys($tests) as $name) {
            TestCase::assertArrayHasKey($name, $fields, self::dangerMsg("{$name} field not found"));
        }

        // On vérifie que l'on a pas des champs requis non testés
        foreach ($required as $name) {
            TestCase::assertArrayHasKey($name, $fields, self::dangerMsg("{$name} required field not found"));
        }
    }

    /**
     * Test la configuration des champs
     *
     * @param FieldInterface $field
     * @param array $tests Tableau associatif nom => [property => value]|[]
     */
    public static function rules(FieldInterface $field, array $tests)
    {
        $fieldName = $field->name() ?: $field::class;

        // Pour chaque règle :
        foreach ($field->rules() as $rule) {
            $name = $rule->name();

            // Présence de la règle dans les tests
            $msg = self::dangerMsg("{$fieldName}::{$name} non testé.");
            TestCase::assertArrayHasKey($name, $tests, $msg);

            // Pour chaque propriété de la règle :
            foreach ($rule->properties() as $key => $value) {
                // Présence de la propriété dans les tests de la règle
                $msg = self::dangerMsg("{$fieldName}::{$name}-{$key} non testé");
                TestCase::assertArrayHasKey($key, $tests[$name] ?? [], $msg);

                // Test de la valeur de la propriété de la règle
                // par rapport à la de la propriété du test
                $msg = self::dangerMsg("{$fieldName}::{$name}-{$key} valeurs incorrecte.");
                $valueTest = is_object($value) ? $value::class : $value;
                $keyTest = is_object($tests[$name][$key]) ? $tests[$name][$key]::class : $tests[$name][$key];
                TestCase::assertSame($valueTest, $keyTest, $msg);

                // On supprime la proprité une fois testée
                unset($tests[$name][$key]);
            }

            // On vérifie que toutes les propriétés ont étés testées
            $msg = self::dangerMsg("{$fieldName} : propriété(s) non testés(s) pour {$fieldName}::{$name} : " . join(", ", array_keys($tests[$name])));
            TestCase::assertSame(0, count($tests[$name]), $msg);

            // Suppression de la règle complètement testée
            unset($tests[$name]);
        }

        // On vérifie que toutes les règles ont étés testées
        $msg = self::dangerMsg("règle(s) restante(s): " . join(", ", array_keys($tests)));
        TestCase::assertSame(0, count($tests), $msg);
    }

    /**
     * Test les règles d'un formulaire
     *
     * @param FormInterface $form
     * @param array $tests
     */
    public static function formRules(FormInterface $form, array $tests)
    {
        $fields = $form->fields();
        foreach ($fields as $name => $field) {
            TestCase::assertArrayHasKey($name, $tests, self::dangerMsg("Any test for {$name} field"));
            static::rules($field, $tests[$name]);
        }

        foreach (array_keys($tests) as $name) {
            TestCase::assertArrayHasKey($name, $fields, self::dangerMsg("{$name} field not tested"));
        }
    }

    private static function dangerMsg(string $msg)
    {
        return "\e[41;97m{$msg}\e[0m";
    }
}
