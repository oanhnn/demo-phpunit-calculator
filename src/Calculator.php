<?php

namespace Demo\Calculator;

class Calculator
{
    const OP_ADD = '+';
    const OP_SUB = '-';
    const OP_MUL = '*';
    const OP_DIV = '/';
    const OP_MOD = '%';

    /**
     * Limit display of calculator
     *
     * @var int
     */
    protected $limit = 10;

    /**
     * Current value in screen
     *
     * @var float|int
     */
    protected $value = 0;

    /**
     * Current operator
     *
     * @var string
     */
    protected $currentOperator;

    /**
     * Constructor
     *
     * @param int $limit Limit display of calculator
     */
    public function __construct($limit = 10)
    {
        $this->limit = $limit > 0 ? intval($limit) : 0;
        $this->current = 0;
    }

    /**
     * Random an integer between 0 and 10
     *
     * @return int
     */
    public static function rand()
    {
        return rand(0, 10);
    }

    /**
     * Addition
     * Sum of $a and $b.
     *
     * @param float|int $a
     * @param float|int $b
     * @return float|int
     */
    public static function add($a, $b)
    {
        return $a + $b;
    }

    /**
     * Subtraction
     * Difference of $a and $b.
     *
     * @param float|int $a
     * @param float|int $b
     * @return float|int
     */
    public static function sub($a, $b)
    {
        return $a - $b;
    }

    /**
     * Division
     * Quotient of $a and $b.
     *
     * @param float $a
     * @param float $b
     * @return float|int
     * @throws \InvalidArgumentException
     */
    public static function div($a, $b)
    {
        if (0 == $b) {
            throw new \InvalidArgumentException('Dividing by zero');
        }

        return $a / $b;
    }

    /**
     * Multiplication	
     * Product of $a and $b.
     *
     * @param float $a
     * @param float $b
     * @return float|int|double
     */
    public static function mul($a, $b)
    {
        return $a * $b;
    }

    /**
     * Modulus operator
     * Remainder of $a divided by $b.
     *
     * @param int $a
     * @param int $b
     * @return int 
     */
    public static function mod($a, $b)
    {
        $mod = intval($a) % intval($b);

        while ($mod < 0) {
            $mod += abs(intval($b));
        }

        return $mod;
    }

    /**
     * Set current value
     *
     * @param float|int $value
     */
    public function setValue($value)
    {
        $this->value = is_int($value) ? $value : floatval($value);
    }

    /**
     *
     * @param string    $operator
     * @param float|int $number
     * @return float|int
     */
    public function execute($operator, $number)
    {
        $method = self::getOperatorMethod($operator);
        $this->value = call_user_func([$this, $method], $this->value, $number);

        return $this->value;
    }

    /**
     * Print current value to output
     */
    public function output()
    {
        $format = sprintf('\%%d%s', $this->limit, is_int($this->value) ? 'd' : 'f');
        printf($format, $this->value);
    }

    /**
     * Get operator method
     *
     * @param type $operator
     * @return string
     * @throws \InvalidArgumentException
     */
    protected static function getOperatorMethod($operator)
    {
        $methods = [
            self::OP_ADD => 'add',
            self::OP_DIV => 'div',
            self::OP_MOD => 'mod',
            self::OP_MUL => 'mul',
            self::OP_SUB => 'sub',
        ];

        if (!isset($methods[$operator])) {
            throw new \InvalidArgumentException('Operator is invalid');
        }

        return $methods[$operator];
    }
}
