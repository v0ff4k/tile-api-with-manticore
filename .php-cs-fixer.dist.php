<?php

/**
 * Конфигурация PHP CS Fixer
 * 
 * Правила настроены на поддержание чистоты кода без излишней строгости.
 * Применяется только к исходному коду в папках src/ и tests/
 */

$finder = (new PhpCsFixer\Finder())
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->exclude([
        'var',
        'vendor',
        'node_modules',
    ])
;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        // Базовые правила PSR-12
        '@PSR12' => true,
        
        // Алиасы (безопасные)
        '@PhpCsFixer:risky' => false,
        
        // Массивы
        'array_syntax' => ['syntax' => 'short'],
        'trailing_comma_in_multiline' => [
            'elements' => ['arrays'],
        ],
        
        // Строки
        'single_quote' => true,
        'no_trailing_whitespace_in_string' => false,
        
        // Классы и пространства имён
        'ordered_class_elements' => false,
        'ordered_traits' => false,
        
        // Функции и методы
        'native_function_invocation' => false,
        'phpdoc_to_comment' => false,
        
        // Импорт и использование
        'no_unused_imports' => true,
        'fully_qualified_strict_types' => false,
        
        // Операторы
        'binary_operator_spaces' => [
            'default' => 'single_space',
            'operators' => ['=' => 'align_single_space_minimal'],
        ],
        
        // Комментарии и PHPDoc
        'phpdoc_align' => [
            'align' => 'left',
            'tags' => ['param', 'return', 'throws', 'var'],
        ],
        'phpdoc_line_span' => false,
        'phpdoc_summary' => false,
        
        // Контроль потока
        'yoda_style' => false,
        'simplified_if_return' => false,
        
        // Пробелы и форматирование
        'blank_line_before_statement' => [
            'statements' => ['return', 'throw', 'break'],
        ],
        'no_extra_blank_lines' => [
            'tokens' => [
                'curly_brace_block',
                'extra',
                'parenthesis_brace_block',
                'square_brace_block',
            ],
        ],
        
        // Типы (не risky)
        'cast_spaces' => ['space' => 'single'],
        'declare_strict_types' => false, // Не добавляем declare(strict_types=1) автоматически
        'strict_param' => false, // Не risky
    ])
    ->setFinder($finder)
;
