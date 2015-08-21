<?php defined('APPLICATION') or die;

$PluginInfo['PrestigeSlider'] = array(
    'Name' => 'Prestige Slider',
    'Description' => 'Adds an image slider above main content.',
    'Version' => '0.1',
    'RequiredTheme' => false,
    'RequiredApplications' => array('Vanilla' => '2.1'),
    'SettingsPermission' => array('Garden.Settings.Manage', 'PrestigeSlider.Settings.Manage'),
    'SettingsUrl' => '/plugin/prestigeslider',
    'RegisterPermissions' => array('PrestigeSlider.Settings.Manage'),
    'MobileFriendly' => true,
    'HasLocale' => false,
    'Author' => 'Gianni DaSilva',
    'AuthorUrl' => 'http://infinitum.co/'
);



class PrestigeSlider extends Gdn_Plugin {
    
    public function PluginController_PrestigeSlider_Create($Sender) {
      $Sender->Title('Prestige Slider');
      $Sender->AddSideMenu('plugin/prestigeslider');
      
      $Sender->Form = new Gdn_Form();
      
      $this->Dispatch($Sender, $Sender->RequestArgs);
   }
    
    public function Base_Render_Before($Sender) {
        $Sender->AddCssFile('plugins/PrestigeSlider/design/style.css');
        $Sender->AddJsFile('jquery-ui-1.8.17.custom.min.js');
        $Sender->AddJsFile('plugins/PrestigeSlider/js/unslider.min.js');
        $Sender->AddJsFile('plugins/PrestigeSlider/js/script.js');
    }
    
    public function Controller_Index($Sender) {
      // Prevent non-admins from accessing this page
      $Sender->Permission('Vanilla.Settings.Manage');
      
      $Sender->SetData('PluginDescription',$this->GetPluginKey('Description'));
		
        $Validation = new Gdn_Validation();
      $ConfigurationModel = new Gdn_ConfigurationModel($Validation);
      $ConfigurationModel->SetField(array(
         'Plugin.PrestigeSlider.RenderCondition'    => 'all',
         'Plugin.PrestigeSlider.ImageCount'    => 0,
         'Plugin.PrestigeSlider.Image1url'     => '',
         'Plugin.PrestigeSlider.Image2url'     => '',
         'Plugin.PrestigeSlider.Image3url'     => '',
         'Plugin.PrestigeSlider.Image4url'     => '',
         'Plugin.PrestigeSlider.Image5url'     => '',
         'Plugin.PrestigeSlider.Image1href'     => '',
         'Plugin.PrestigeSlider.Image2href'     => '',
         'Plugin.PrestigeSlider.Image3href'     => '',
         'Plugin.PrestigeSlider.Image4href'     => '',
         'Plugin.PrestigeSlider.Image5href'     => ''
      ));
      
      // Set the model on the form.
      $Sender->Form->SetModel($ConfigurationModel);
   
      // If seeing the form for the first time...
      if ($Sender->Form->AuthenticatedPostBack() === FALSE) {
         // Apply the config settings to the form.
         $Sender->Form->SetData($ConfigurationModel->Data);
		} else {
         $ConfigurationModel->Validation->ApplyRule('Plugin.PrestigeSlider.ImageCount', 'Required');

         $ConfigurationModel->Validation->ApplyRule('Plugin.PrestigeSlider.Image1url', 'Required');
         
         $Saved = $Sender->Form->Save();
         if ($Saved) {
            $Sender->StatusMessage = T("Your changes have been saved.");
         }
      }
      
      // GetView() looks for files inside plugins/PluginFolderName/views/ and returns their full path. Useful!
      $Sender->Render($this->GetView('settings.php'));
   }
    
    public function Base_BeforeRenderAsset_Handler($Sender) {
        $AssetName = GetValueR('EventArguments.AssetName', $Sender);
        
        if (InSection("DiscussionList")) {
            if (C('Plugin.PrestigeSlider.RenderCondition') == 'all' OR C('Plugin.PrestigeSlider.RenderCondition') == 'DiscussionList') {
                if ($AssetName == "Content"){
                    echo $Sender->FetchView($this->GetView('slider.php'));
                }
            }
        }

        if (InSection("CategoryList")) {
            if (C('Plugin.PrestigeSlider.RenderCondition') == 'all' OR C('Plugin.PrestigeSlider.RenderCondition') == 'CategoryList') {
                if ($AssetName == "Content"){
                    echo $Sender->FetchView($this->GetView('slider.php'));
                }
            }
        }
    }
    
    public function Base_AfterBody_Handler($Sender) {
        echo '<script>$(function() {$(\'.banner\').unslider();});</script>';
    }
    
    public function Setup() {
        SaveToConfig('Plugin.PrestigeSlider.RenderCondition', 'all');
        SaveToConfig('Plugin.PrestigeSlider.ImageCount', '1');   
        SaveToConfig('Plugin.PrestigeSlider.Image1url', 'http://placehold.it/730x200');
        SaveToConfig('Plugin.PrestigeSlider.Image2url', 'http://placehold.it/730x200'); 
    }

    public function onDisable () {
        RemoveFromConfig('Plugin.PrestigeSlider.RenderCondition');
        RemoveFromConfig('Plugin.PrestigeSlider.ImageCount');
        RemoveFromConfig('Plugin.PrestigeSlider.Image1url');
        RemoveFromConfig('Plugin.PrestigeSlider.Image2url');
        RemoveFromConfig('Plugin.PrestigeSlider.Image3url');
        RemoveFromConfig('Plugin.PrestigeSlider.Image4url');
        RemoveFromConfig('Plugin.PrestigeSlider.Image5url');
        RemoveFromConfig('Plugin.PrestigeSlider.Image1href');
        RemoveFromConfig('Plugin.PrestigeSlider.Image2href');
        RemoveFromConfig('Plugin.PrestigeSlider.Image3href');
        RemoveFromConfig('Plugin.PrestigeSlider.Image4href');
        RemoveFromConfig('Plugin.PrestigeSlider.Image5href');
    }

}