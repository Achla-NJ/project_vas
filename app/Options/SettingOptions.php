<?php

namespace App\Options;

class SettingOptions
{
     public static function main(): array
     {
         return [
             'name' => 'App',
         ];
     }

     public static function courseTypes(): array
     {
         return [
            'single' => 'Single Courses',
            'bundle' => 'Bundle Courses',
         ];
     }

     public static function pageTypes(): array
     {
         return [
             'home' => 'Home',
         ];
     }

     public static function emailsInfo(): array
     {
         return [
            'workspace-agreement.blade.php' =>''

         ];
     }

     public static function emailsAllowToEdit(): array
     {
         return [
            'workspace-agreement.blade.php' => true,
         ];
     }
}
