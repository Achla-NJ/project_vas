<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Options\SettingOptions;

class SettingController extends Controller
{
    function js_str_to_title($str, $suffix = '.blade.php', $replacement = '') {
        return str_replace($suffix, $replacement, ucwords(str_replace(['_', '-'], ' ', $str)));
    }

    public function edit()
    {
        $emailFiles = [];
        $info = SettingOptions::emailsInfo();
        $allow = SettingOptions::emailsAllowToEdit();
        foreach (glob(resource_path() . '/views/emails/*.blade.php') as $file) {
            $filename = basename($file);
            if (is_file($file) && @$allow[$filename]) {
                $emailFiles[] = [
                    'title' => $this->js_str_to_title($filename),
                    'file' => $filename,
                    'content' => file_get_contents($file),
                    'info' => @$info[$filename],
                ];
            }
        }

        return view('admin.setting.email', compact('emailFiles'));
    }

    public function update(Request $request)
    {
        $emails = $request->input('emails', []);
        foreach ($emails as $file => $content) {
            $path = resource_path("views/emails/{$file}");
            if (File::exists($path)) {
                File::put($path, $content);
            }
        }

        return redirect()->route('admin.email-template.edit')->with('success', 'Email templates updated successfully.');
    }
}
