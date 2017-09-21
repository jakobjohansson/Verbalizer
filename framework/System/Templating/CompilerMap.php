<?php

namespace kiwi\System\Templating;

class CompilerMap
{
    /**
     * Return a map of the compilers to use.
     *
     * @return array
     */
    public static function get()
    {
        return [
            \kiwi\System\Templating\Compilers\IncludeCompiler::class,
            \kiwi\System\Templating\Compilers\ExpressionCompiler::class,
            \kiwi\System\Templating\Compilers\ForeachCompiler::class,
            \kiwi\System\Templating\Compilers\ConditionalCompiler::class
        ];
    }
}
