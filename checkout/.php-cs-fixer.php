<?php declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
                ->ignoreUnreadableDirs()
                ->ignoreDotFiles(true)
                ->ignoreVCS(true)
                ->name('*.php')
                ->in(__DIR__)
                ->notName('_ide_helper.php')
                ->exclude('vendor')
                ->exclude('storage')
                ->exclude('bootstrap')
                ->sortByModifiedTime();

// https://mlocati.github.io/php-cs-fixer-configurator

return (new Config())
    ->setUsingCache(true)
    ->setCacheFile('.cache/php-cs-fixer.cache')
    ->setRiskyAllowed(true)
    ->setLineEnding("\n")
    ->setFinder($finder)
    ->setRules(
        [
            '@PSR2' => true,
            '@PSR12' => true,
            '@Symfony' => true,
            '@Symfony:risky' => true,
            '@PHP74Migration:risky' => true, // Implicit rules: @PHP71Migration:risky
            '@PHP80Migration' => true, // Implicit rules: @PHP74Migration, @PHP73Migration, @PHP71Migration
            '@PHPUnit84Migration:risky' => true, // Implicit rules: @PHPUnit75Migration:risky @PHPUnit60Migration:risky
            '@DoctrineAnnotation' => true,

            // Disable some rules from groups
            'blank_line_after_opening_tag' => false,
            'linebreak_after_opening_tag' => false,
            'native_function_invocation' => false,
            'no_superfluous_phpdoc_tags' => false,
            'phpdoc_align' => false,
            'phpdoc_no_empty_return' => false,
            'phpdoc_to_comment' => false,
            'phpdoc_var_without_name' => false,
            'self_accessor' => false,
            'single_import_per_statement' => false,
            'single_trait_insert_per_statement' => false,
            'static_lambda' => false,
            'yoda_style' => false,

            // Enable new rules (or change from group)
            'array_syntax' => ['syntax' => 'short'],
            'cast_spaces' => true,
            'combine_consecutive_unsets' => true,
            'combine_consecutive_issets' => true,
            'comment_to_phpdoc' => true,
            'concat_space' => ['spacing' => 'one'],
            'explicit_indirect_variable' => true,
            'explicit_string_variable' => true,
            'global_namespace_import' => true,
            'mb_str_functions' => true,
            'multiline_comment_opening_closing' => true,
            'multiline_whitespace_before_semicolons' => true,
            'no_useless_else' => true,
            'no_useless_return' => true,
            'nullable_type_declaration_for_default_null_value' => true,
            'ordered_imports' => ['imports_order' => ['class', 'function', 'const']],
            'php_unit_strict' => true,
            'php_unit_test_annotation' => ['style' => 'annotation'],
            'phpdoc_add_missing_param_annotation' => ['only_untyped' => false],
            'phpdoc_order' => true,
            'phpdoc_tag_casing' => true,
            'phpdoc_var_annotation_correct_order' => true,
            'self_static_accessor' => true,
            'simple_to_complex_string_variable' => true,
            'simplified_if_return' => true,
            'strict_comparison' => true,
            'strict_param' => true,
            'types_spaces' => ['space' => 'single'],

            'method_argument_space' => [
                'after_heredoc' => false,
            ],
            'no_whitespace_before_comma_in_array' => [
                'after_heredoc' => false,
            ],
            'trailing_comma_in_multiline' => [
                'after_heredoc' => false,
            ],
        ]
    );
