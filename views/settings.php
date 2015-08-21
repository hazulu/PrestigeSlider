<?php if (!defined('APPLICATION')) exit(); ?>
<h1><?php echo T($this->Data['Title']); ?></h1>
<div class="Info">
   <?php echo T($this->Data['PluginDescription']); ?>
</div>
<h3><?php echo T('Settings'); ?></h3>
<?php
   echo $this->Form->Open();
   echo $this->Form->Errors();
?>
<ul>
   <li><?php
      echo $this->Form->Label('Display location', 'Plugin.PrestigeSlider.RenderCondition');
      echo '<p><b>Please choose based on your homepage settings.</b></p>';
      echo $this->Form->DropDown('Plugin.PrestigeSlider.RenderCondition',array(
         'all'             => 'Above Discussion & Category List',
         'DiscussionList'   => 'Above Discussion List',
         'CategoryList'     => 'Above Category List'
      ));
   ?></li>
   
   <li><?php
      echo $this->Form->Label('Amount of Images', 'Plugin.PrestigeSlider.ImageCount');
      echo $this->Form->DropDown('Plugin.PrestigeSlider.ImageCount', array('1','2','3
      ','4','5'));
   ?></li>
   
   <?php
        $count = C('Plugin.PrestigeSlider.ImageCount');
        
        for ($i = 1; $i <= $count+1; $i++){
           echo '<li>';    
           echo $this->Form->Label('Image '.$i.' url', 'Plugin.PrestigeSlider.Image'.$i.'url');
           echo $this->Form->Textbox('Plugin.PrestigeSlider.Image'.$i.'url');
           echo '</li>';
            
           echo '<li>';    
           echo $this->Form->Label('Image '.$i.' href', 'Plugin.PrestigeSlider.Image'.$i.'href');
           echo $this->Form->Textbox('Plugin.PrestigeSlider.Image'.$i.'href');
           echo '</li>';
        }
   ?>
   
</ul>
<?php
   echo $this->Form->Close('Save');
?>