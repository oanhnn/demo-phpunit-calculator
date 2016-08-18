<?php

namespace Demo\Calculator;

class Expression
{
    const NUMBER = "[\-]?\d+(\.\d+)?";
    const OPERATOR = "[\+\-\*\/\%]";
    const SEXPR  = "([\-]?\d+(\.\d+)?)([\+\-\*\/\%]([\-]?\d+(\.\d+)?))*";

    protected $str;
    protected $childs;

    public function __construct($str)
    {

    }

    public function validate()
    {
        // define the grammar
        $number = "\d+(\.\d+)?";
        $ident  = "[a-z]\w*";
        $atom   = "[\+\-]?($number|$ident)";
        $op     = "[\+\-\*\/\%]";
        $sexpr  = "$atom($op$atom)*";

        // step1. remove whitespace
        $str = preg_replace('/\s+/', '', $this->str);

        // step2. repeatedly replace parenthetic expressions with 'x'
        $par = "/\($sexpr\)/";
        while (preg_match($par, $str)) {
            $str = preg_replace($par, 'x', $str);
        }

        // step3. no more parens, the string must be simple expression
        return (bool) preg_match("/^$sexpr$/", $str);
    }

    public function execute()
    {
        
    }
}
