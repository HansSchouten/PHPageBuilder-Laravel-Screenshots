<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use PHPageBuilder\Theme;
use Illuminate\Support\Str;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class RenderBlockThumbs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pagebuilder:render-thumbs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Render thumbnails for each block which has no thumbnail or that has an updated view file.';

    /**
     * Execute the console command.
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function handle()
    {
        $disk = Storage::disk('local');
        $currentBlockFile = 'render-block-thumbs/current-block.json';
        $themeSlug = config('pagebuilder.theme.active_theme');
        $theme = new Theme(config('pagebuilder.theme'), $themeSlug);

        // abort if currently a rendering job is running
        if ($disk->exists($currentBlockFile)) {
            $content = json_decode($disk->get($currentBlockFile), true);
            $lastRender = new Carbon($content['timestamp']);
            if ($lastRender->diffInMinutes(Carbon::now()) <= 1) {
                $this->error("Last rendering was less than a minute ago.");
                return;
            }
        }

        // loop through all theme blocks until we encounter a block with a missing or outdated image
        foreach ($theme->getThemeBlocks() as $block) {
            $thumbPath = $block->getThumbPath();
            if (file_exists($thumbPath)) {
                continue;
            }

            // create a public access token for the theme block for which a thumbnail will be rendered
            $accessToken = Str::uuid();
            $disk->put($currentBlockFile, json_encode([
                'access-token' => $accessToken,
                'timestamp' => now()->format('Y-m-d H:i:s'),
                'block-slug' => $block->getSlug()
            ]));

            // request a screenshot for the theme block using the screenshot API and the generated public access token
            $screenshotPath = $this->takeScreenshot(route('render-block-thumb', $accessToken));
            if (! File::isDirectory(dirname($thumbPath))) {
                File::makeDirectory(dirname($thumbPath), 0755, true);
            }
            File::move($screenshotPath, $thumbPath);

            // remove the public access token for rendering this theme block
            $disk->put($currentBlockFile, json_encode([
                'access-token' => '',
                'timestamp' => now()->format('Y-m-d H:i:s'),
                'block-slug' => $block->getSlug()
            ]));

            $this->info("Thumbnail of '{$block->getSlug()}' block updated.");

            // reduce server workload
            sleep(2);
        }

        $this->info("All block thumbnails of '{$themeSlug}' theme are up-to-date.");
    }

    /**
     * Take screenshot of a given URL.
     *
     * @param string $url
     * @param int $width
     * @param int $height
     * @return string
     * @throws CouldNotTakeBrowsershot
     */
    protected function takeScreenshot($url, $width = 1300, $height = 900)
    {
        $path = storage_path('app/screenshots/' . Str::random(8) . '.jpg');
        Browsershot::url($url)
            ->windowSize($width, $height)
            ->setOption('args', ['--disable-web-security'])
            ->ignoreHttpsErrors()
            ->noSandbox()
            ->save($path);
        return $path;
    }

}
