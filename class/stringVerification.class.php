<?php
class verificationString
{
    protected $character;
    protected $characterLength;

    public function __construct($character = '')
    {
        if('' !== $character) 
        {
            $this->character = $character;
            $this->characterLength = strlen($this->character);
        }
        else
        {
            $this->character = implode(range('a', 'z')) . implode(range('A', 'Z')) . implode(range(0, 9));
            $this->characterLength = strlen($this->character);
        }
    }

    public function resultString($length)
    {
        $temp_var = '';
        for($i = 0; $i < $length; $i++)
        {
            $temp_var .= $this->character[$this->randomizeKey(0, $this->characterLength)];
        }
        return $temp_var;
    }

    protected function randomizeKey($minVal, $maxVal)
    {
        $strength = ($maxVal - $minVal);
        if($strength < 0)
            return $minVal;
        $log_result = log($strength, 2);
        $byte_result = (int)($log_result / 8) + 1;
        $bit_result = (int)$log_result + 1;

        $lowerToupperBits = (int) (1 << $bit_result) - 1;
        do
        {
            $temp_no = hexdec(bin2hex(random_bytes($byte_result)));
            $temp_no = $temp_no & $lowerToupperBits;
        }
        while($temp_no >= $strength);
        return ($minVal + $temp_no);
    }
}
?>