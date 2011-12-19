<?php
/*
* This file is part of Phathom.
*
* Copyright (c) 2011 Martin Schrodt
*
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is furnished
* to do so, subject to the following conditions:
*
* The above copyright notice and this permission notice shall be included in all
* copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
* THE SOFTWARE.
*/

require "../../lib/Context.php";
require "../../lib/Phathom.php";
require "../../lib/StringContext.php";

class Calculator extends Phathom {

    public static function SRule() {
        return self::sequence(self::expression(), self::EOI);
    }

    public static function expressionRule() {
        return self::sequence(
            self::term(),
            self::zeroOrMore(self::firstOf(
                self::sequence("+", self::term(), function(Context $c) { $c->push($c->pop() + $c->pop()); }),
                self::sequence("-", self::term(), function(Context $c) { $c->push($c->pop(1) - $c->pop()); })
            ))
        );
    }

    public static function termRule() {
        return self::sequence(
            self::factor(),
            self::zeroOrMore(self::firstOf(
                self::sequence("*", self::factor(), function(Context $c) { $c->push($c->pop() * $c->pop()); }),
                self::sequence("/", self::factor(), function(Context $c) { $c->push($c->pop(1) / $c->pop()); })
            ))
        );
    }

    public static function factorRule() {
        return self::firstOf(self::number(), self::parens());
    }

    public static function parensRule() {
        return self::sequence("(", self::expression(), ")");
    }

    public static function numberRule() {
        return self::sequence(self::regex('/\d+(\.\d+)?/'), function(Context $c) { $c->push((double)$c->currentMatch()); });
    }

}

$start = microtime(true);

$input = "10";

echo "<table border='1'><tr>";
for ($i = 0; $i < strlen($input); $i++) {
	echo "<td width='20' align='center'>$i</td>";
}
echo "</tr><tr>";
for ($i = 0; $i < strlen($input); $i++) {
	echo "<td width='20' align='center'><b>".$input[$i]."</b></td>";
}
echo "</tr></table>";

$c = new StringContext($input);
$c->setTracingEnabled(true);
$result = Calculator::run("S", $c);
echo "done";
var_dump($result);
var_dump($c->state[VALUES]);
$c->dumpLog();

$end = microtime(true);
echo "took ".(1000*($end-$start))."ms";

?>

