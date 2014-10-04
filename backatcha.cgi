#!/usr/local/bin/perl

$count = 0;
while (<stdin>) {
    @w = split;
    $count++;
    for ($i=0; $i<=$#w; $i++) {
	$s[$i] += $w[$i];
    }
}

for ($i=0; $i<=$#w; $i++) {
    print $s[$i]/$count, "\t";
}

print "\n";