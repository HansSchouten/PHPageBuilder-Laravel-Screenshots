<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use PHPageBuilder\Modules\GrapesJS\Thumb\ThumbGenerator;
use PHPageBuilder\PHPageBuilder;
use PHPageBuilder\Theme;
use PHPageBuilder\ThemeBlock;
use Exception;

class BlockScreenshotController extends Controller
{

    /**
     * Render the theme block that is currently publicly accessible (if the given access token matches).
     *
     * @param string $accessToken
     * @throws Exception
     */
    public function renderBlockForThumb(string $accessToken)
    {
        $renderBlockFile = 'render-block-thumbs/current-block.json';
        if (Storage::disk('local')->exists($renderBlockFile)) {
            $content = json_decode(Storage::disk('local')->get($renderBlockFile), true);
            if (! empty($content['access-token']) && $content['access-token'] === $accessToken) {
                $blockSlug = $content['block-slug'];
                $theme = new Theme(config('pagebuilder.theme'), config('pagebuilder.theme.active_theme'));
                $block = new ThemeBlock($theme, $blockSlug);

                new PHPageBuilder(config('pagebuilder'));
                $thumbRenderer = new ThumbGenerator($theme);
                $thumbRenderer->renderThumbForBlock($block);
            }
        }

        abort(404);
    }

}
