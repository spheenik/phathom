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
require "../../lib/StringContext.php";
require "../../lib/Phathom.php";
require "lib/ValidationGenerator.php";
require "lib/CSSSpecParser.php";

//$genPath = ValidationGenerator::generate(array("all", "visual", "aural", "paged"), "output");
$genPath = ValidationGenerator::generate(array("lithron"), "output");

require $genPath."/CSSTree.php";
require $genPath."/CSS.php";
require $genPath."/CSSValidator.php";
require "lib/CSSDeclarationContext.php";
require "lib/CSSParser.php";

// $c = new StringContext("/* ---------- heise jobs Text-Skyscraper ---------- */ body{}");
// $c->setTracingEnabled(true);
// $result = CSSParser::run("S", $c);
// var_dump($result);
// $c->dumpLog();
// die();

$start = microtime(true);
$c = new StringContext(file_get_contents("test/heise.css"));
//$c->setTracingEnabled(true);
$result = CSSParser::run("S", $c);
$end = microtime(true);

echo ($result === true ? "sucessfully parsed, " : "failed to parse, ")."took ".(1000*($end-$start))."ms<br/><br/>";
if ($result == true) {
	$c->pop()->dump();
}

$c->dumpLog();

?>

