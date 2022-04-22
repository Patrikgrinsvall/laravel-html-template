<?php

use Illuminate\Support\Facades\Cache;

if ( !function_exists("totaltime")) {
    function totaltime(bool $out = true)
    {
        $message = "[ ".CURRENT_REQUEST_ID." ][ ".date("Y-m-d h:i:s")." ] Done, Total script time : ".microtime(true) - LARAVEL_START;
        if ($out) {
            file_put_contents("php://stdout", $message);
        } else {
            return $message;
        }
    }
}
if ( !function_exists("dump_cache")) {
    function dump_cache()
    {
        $console = false;
        if (class_exists(Illuminate\Foundation\Application::class)) {
            $console = App::runningInConsole();
        }
        if ($console) {
            dump("Here are cache tags: ", $tags = collect(Cache::tags('*'))->keys()->toArray());
            foreach ($tags as $tag) {
                dump(collect(Cache::tags($tag))->values()->first());
            }
            dump("Cache info: ", "\t config: ".App::configurationIsCached(),
                "\t Routes: ".App::routesAreCached(),
                "\t Packages: ".App::getCachedPackagesPath(),
                "\t Services: ".App::getCachedServicesPath());
        } else {
            dump("please run this in console");
        }

    }

}