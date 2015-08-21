<?php if (!defined( 'APPLICATION')) exit(); ?>
<div class="banner">
    <ul>
        <?php
        $count = C('Plugin.PrestigeSlider.ImageCount');
        
        for ($i = 1; $i <= $count+1; $i++){
            $h = C('Plugin.PrestigeSlider.Image'.$i.'url'); 
            $j = C('Plugin.PrestigeSlider.Image'.$i.'href');    
            
            if ($j == '') {
               echo "<li><img src='$h'></li>";
            } else {
                echo "<li><a href='$j'><img src='$h'></a></li>";
            }
        }
        ?>
    </ul>
</div>