<?php

$file = fopen($argv[1], "r+");

$pretab = [];
$tableau = [];
$tableau2 = [];


if ($file) {

    while (($buffer = fgets($file, 4096)) !== false) {
        $pretab[] = substr($buffer, 0, -1);
    }
    fclose($file);
}

$ligne = $pretab[0];
$colonne = strlen($pretab[1]);

for ($i = 1; $i < $ligne + 1; $i++) {
    $tempo = [];
    for ($j = 0; $j < $colonne; $j++) {
        $tempo[] = $pretab[$i][$j];
    }
    $tableau[$i] = $tempo;
}

for ($i = 1; $i < $ligne + 1; $i++) {
    $tableau2[$i - 1] = $tableau[$i];
}

$maxsize = 0;
$coordonnée = [];

for ($x = 0; $x < $ligne; $x++) {
    for ($y = 0; $y < $colonne; $y++) {
        if (isset($tableau2[$x][$y])) {
            if ($tableau2[$x][$y] == ".") {
                //echo $x . ";" . $y . " : ";
                $size = 1;
                $square = true;

                while ($size + $x < $ligne && $size + $y < $colonne && $square == true) {
                    //echo " 1er for ";
                    for ($i = $y; $i <= $size + $y; $i++) {
                        //echo $x + $size . ";" . $i . " / ";
                        if ($tableau2[$x + $size][$i] == 'o') {
                            $square = false;
                            break;
                        }                        
                    }
                    //echo " 2eme for ";
                    for ($i = $x; $i <= $size + $x; $i++) {
                        //echo $i . ";" . $y + $size . " / ";
                        if ($tableau2[$i][$y + $size] == 'o') {
                            $square = false;
                            break;
                        }
                    }
                    if ($square == true) {
                        //echo " +1 ";
                        $size++;
                    }
                }
                //echo "\n";
                if ($maxsize < $size) {
                    $coordonnée[] = [$x, $y];
                    $maxsize = $size;
                }
            }
        }
    }
}

$coordonnée = $coordonnée[count($coordonnée) - 1];


for ($i = 0; $i < $maxsize; $i++) {
    for ($j = 0; $j < $maxsize; $j++) {
        $tableau2[$coordonnée[0] + $i][$coordonnée[1] + $j] = "X";
    }
}

foreach ($tableau2 as $key => $value) {
    $tableau2[$key] = implode("", $value);
}
$tableau2 = implode("\n", $tableau2);
print_r($tableau2 . "\n");
