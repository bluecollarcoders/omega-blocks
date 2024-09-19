<?php

$block_wrapper_attributes = get_block_wrapper_attributes([
    'class' => 'alignfull'
]);

$normal_path   = 'M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z';
$inverted_path = 'M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z';

$top_transform    = "scaleX(" . ($attributes['topFlipX'] ? "-1" : "1" ) . ") rotate(". ($attributes['topFlipY'] ? "180deg" : "0") . ")";
$bottom_transform = "scaleY(-1) scaleX(" . ($attributes['bottomFlipX'] ? "-1" : "1" ) . ") rotate(". ($attributes['bottomFlipY'] ? "180deg" : "0") . ")";

?>

<div <?= $block_wrapper_attributes ?>>
    
<div class="curve top-curve" style="display: <?= $attributes['enableTopCurve'] ? "block" : "none" ?>; transform: <?= $top_transform ?>; height: <?= $attributes['topHeight'] ?>px;">
    <svg style="height: <?= $attributes['topHeight'] ?>px; width: <?= $attributes['topWidth'] ?>%;" preserveAspectRatio="none" viewBox="0 0 1200 120">
        <path fill="<?= $attributes['topColor'] ?? 'white' ?>" d="<?= $attributes['topFlipY'] ? $inverted_path : $normal_path ?>">
        </path>
    </svg>
</div>

    <?= $content; ?>;

<div class="curve bottom-curve" style="display: <?= $attributes['enableBottomCurve'] ? "block" : "none" ?>; transform: <?= $bottom_transform ?>; height: <?= $attributes['bottomHeight'] ?>px;">
    <svg style="height: <?= $attributes['bottomHeight'] ?>px; width: <?= $attributes['bottomWidth'] ?>%;" preserveAspectRatio="none" viewBox="0 0 1200 120">
        <path fill="<?= $attributes['bottomColor'] ?? 'white' ?>" d="<?= $attributes['bottomFlipY'] ? $inverted_path : $normal_path ?>">
        </path>
    </svg>
</div>

</div>