<?php
/* =============================================================================
   QR encoder — byte mode, error correction level M, versions 1-10.

   Written out rather than pulled from a library because the accreditation code
   is the one thing a gate marshal must be able to scan offline, and a hosted
   image service would put that on someone else's uptime and leak every code in
   a URL. Output is SVG, so it stays sharp on paper and on a phone.
   ============================================================================= */

/* --- Galois field tables for Reed-Solomon --- */
function qr_gf() {
    static $t = null;
    if ($t !== null) return $t;
    $exp = array_fill(0, 512, 0); $log = array_fill(0, 256, 0);
    $x = 1;
    for ($i = 0; $i < 255; $i++) {
        $exp[$i] = $x; $log[$x] = $i;
        $x <<= 1;
        if ($x & 0x100) $x ^= 0x11D;
    }
    for ($i = 255; $i < 512; $i++) $exp[$i] = $exp[$i - 255];
    $t = [$exp, $log];
    return $t;
}
function qr_mul($a, $b) {
    if ($a == 0 || $b == 0) return 0;
    list($exp, $log) = qr_gf();
    return $exp[($log[$a] + $log[$b]) % 255];
}
function qr_rs($data, $ecLen) {
    /* generator polynomial */
    $gen = [1];
    list($exp, $log) = qr_gf();
    for ($i = 0; $i < $ecLen; $i++) {
        $next = array_fill(0, count($gen) + 1, 0);
        foreach ($gen as $j => $c) {
            /* g(x) *= (x - a^i). Keeping the array highest-degree-first, the
               x term holds the coefficient's index and the constant term
               shifts it down one. Written the other way round the generator
               is not monic and the synthetic division below is invalid. */
            $next[$j]     ^= $c;
            $next[$j + 1] ^= qr_mul($c, $exp[$i]);
        }
        $gen = $next;
    }
    $res = array_merge($data, array_fill(0, $ecLen, 0));
    for ($i = 0; $i < count($data); $i++) {
        $f = $res[$i];
        if ($f == 0) continue;
        foreach ($gen as $j => $c) $res[$i + $j] ^= qr_mul($c, $f);
    }
    return array_slice($res, count($data));
}

/* version => [total codewords, ec per block, [blocks in group1, blocks in group2]] for level M */
function qr_specs() {
    return [
        1  => [26,   10, [1, 0],  16],
        2  => [44,   16, [1, 0],  28],
        3  => [70,   26, [1, 0],  44],
        4  => [100,  18, [2, 0],  64],
        5  => [134,  24, [2, 0],  86],
        6  => [172,  16, [4, 0],  108],
    ];
    /* Versions 1-6 only: from version 7 a symbol carries several alignment
       patterns and a version-information block, and emitting one without them
       would produce a code that will not scan. Version 6-M still holds 106
       bytes, far more than an accreditation code or a pass URL needs. */
}

function qr_encode($text) {
    $bytes = array_values(unpack('C*', $text));
    $len = count($bytes);
    $specs = qr_specs();
    $ver = 0;
    foreach ($specs as $v => $s) {
        $cci = $v < 10 ? 8 : 16;
        $need = 4 + $cci + $len * 8;
        if ($need <= $s[3] * 8) { $ver = $v; break; }
    }
    if (!$ver) return null;
    list($total, $ecPer, $groups, $dataCw) = $specs[$ver];

    /* bit stream: mode 0100, char count, payload, terminator */
    $bits = '0100';
    $cci = $ver < 10 ? 8 : 16;
    $bits .= str_pad(decbin($len), $cci, '0', STR_PAD_LEFT);
    foreach ($bytes as $b) $bits .= str_pad(decbin($b), 8, '0', STR_PAD_LEFT);
    $cap = $dataCw * 8;
    $bits .= str_repeat('0', min(4, $cap - strlen($bits)));
    while (strlen($bits) % 8) $bits .= '0';
    $pad = ['11101100', '00010001']; $i = 0;
    while (strlen($bits) < $cap) { $bits .= $pad[$i % 2]; $i++; }

    $cw = [];
    foreach (str_split($bits, 8) as $b) $cw[] = bindec($b);

    /* split into blocks, compute EC for each, then interleave */
    $nb = $groups[0] + $groups[1];
    $short = intdiv($dataCw, $nb);
    $blocks = []; $ecs = []; $p = 0;
    for ($b = 0; $b < $nb; $b++) {
        $size = $short + ($b >= $groups[0] ? 1 : 0);
        $blk = array_slice($cw, $p, $size); $p += $size;
        $blocks[] = $blk;
        $ecs[] = qr_rs($blk, $ecPer);
    }
    $final = [];
    $maxD = max(array_map('count', $blocks));
    for ($i = 0; $i < $maxD; $i++) foreach ($blocks as $blk) if (isset($blk[$i])) $final[] = $blk[$i];
    for ($i = 0; $i < $ecPer; $i++) foreach ($ecs as $ec) $final[] = $ec[$i];

    /* --- build the matrix --- */
    $size = 17 + $ver * 4;
    $m = array_fill(0, $size, array_fill(0, $size, null));   /* null = free */

    $finder = function (&$m, $r, $c) use ($size) {
        for ($i = -1; $i <= 7; $i++) for ($j = -1; $j <= 7; $j++) {
            $rr = $r + $i; $cc = $c + $j;
            if ($rr < 0 || $cc < 0 || $rr >= $size || $cc >= $size) continue;
            $on = ($i >= 0 && $i <= 6 && ($j == 0 || $j == 6)) ||
                  ($j >= 0 && $j <= 6 && ($i == 0 || $i == 6)) ||
                  ($i >= 2 && $i <= 4 && $j >= 2 && $j <= 4);
            $m[$rr][$cc] = $on ? 1 : 0;
        }
    };
    $finder($m, 0, 0); $finder($m, 0, $size - 7); $finder($m, $size - 7, 0);

    /* timing patterns */
    for ($i = 8; $i < $size - 8; $i++) {
        $m[6][$i] = ($i % 2 == 0) ? 1 : 0;
        $m[$i][6] = ($i % 2 == 0) ? 1 : 0;
    }
    /* alignment pattern (single, versions 2-6 style placement) */
    if ($ver >= 2) {
        $centres = [6, $size - 7];
        foreach ($centres as $r) foreach ($centres as $c) {
            if (($r == 6 && $c == 6) || ($r == 6 && $c == $size - 7) || ($r == $size - 7 && $c == 6)) continue;
            for ($i = -2; $i <= 2; $i++) for ($j = -2; $j <= 2; $j++) {
                $m[$r + $i][$c + $j] = (max(abs($i), abs($j)) != 1) ? 1 : 0;
            }
        }
    }
    $m[$size - 8][8] = 1;   /* dark module */

    /* reserve format areas */
    for ($i = 0; $i < 9; $i++) {
        if ($m[8][$i] === null) $m[8][$i] = 0;
        if ($m[$i][8] === null) $m[$i][8] = 0;
    }
    for ($i = $size - 8; $i < $size; $i++) {
        if ($m[8][$i] === null) $m[8][$i] = 0;
        if ($m[$i][8] === null) $m[$i][8] = 0;
    }

    /* --- place data, zig-zag from bottom right --- */
    $bitstr = '';
    foreach ($final as $b) $bitstr .= str_pad(decbin($b), 8, '0', STR_PAD_LEFT);
    $bi = 0; $up = true;
    for ($col = $size - 1; $col > 0; $col -= 2) {
        if ($col == 6) $col--;
        for ($n = 0; $n < $size; $n++) {
            $row = $up ? $size - 1 - $n : $n;
            for ($k = 0; $k < 2; $k++) {
                $cc = $col - $k;
                if ($m[$row][$cc] !== null) continue;
                $bit = ($bi < strlen($bitstr)) ? (int)$bitstr[$bi] : 0;
                $bi++;
                /* mask 0: (row + col) % 2 == 0 */
                if ((($row + $cc) % 2) == 0) $bit ^= 1;
                $m[$row][$cc] = $bit;
            }
        }
        $up = !$up;
    }

    /* --- format information: level M (00), mask 0 --- */
    $fmt = 0x5412 ^ (0 << 10);           /* placeholder, replaced below */
    $data = (0b00 << 3) | 0;             /* EC level M = 00, mask 0 */
    $rem = $data << 10;
    for ($i = 4; $i >= 0; $i--) if ($rem & (1 << ($i + 10))) $rem ^= 0x537 << $i;
    $fmt = (($data << 10) | $rem) ^ 0x5412;
    for ($i = 0; $i < 15; $i++) {
        $bit = ($fmt >> $i) & 1;
        /* copy 1: up column 8 then along row 8 */
        if ($i < 6)       { $m[$i][8]      = $bit; }
        elseif ($i == 6)  { $m[7][8]       = $bit; }
        elseif ($i == 7)  { $m[8][8]       = $bit; }
        elseif ($i == 8)  { $m[8][7]       = $bit; }
        else              { $m[8][14 - $i] = $bit; }
        /* copy 2 */
        if ($i < 8)       { $m[8][$size - 1 - $i]  = $bit; }
        else              { $m[$size - 15 + $i][8] = $bit; }
    }
    return $m;
}

/* Render the matrix as an SVG string. */
function qr_svg($text, $px = 200, $quiet = 4) {
    $m = qr_encode($text);
    if (!$m) return '';
    $n = count($m);
    $span = $n + $quiet * 2;
    $d = '';
    for ($r = 0; $r < $n; $r++) {
        for ($c = 0; $c < $n; $c++) {
            if ($m[$r][$c]) $d .= 'M' . ($c + $quiet) . ' ' . ($r + $quiet) . 'h1v1h-1z';
        }
    }
    return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ' . $span . ' ' . $span . '" '
         . 'width="' . $px . '" height="' . $px . '" shape-rendering="crispEdges" role="img" '
         . 'aria-label="QR">'
         . '<rect width="' . $span . '" height="' . $span . '" fill="#ffffff"/>'
         . '<path d="' . $d . '" fill="#06202F"/></svg>';
}
