<?php

namespace Delights\Banners;

use Spatie\Browsershot\Browsershot;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Generator
{
    private string $title;
    private string $body;
    private string $image;

    final public function __construct(
        string $title = null,
        string $body = null,
        string $image = null
    )
    {
        $this->title = $title ?? config('banners.title');
        $this->body = $body ?? config('banners.body');
        $this->image = $image ?? config('banners.image');
    }

    public static function make(
        string $title = null,
        string $body = null,
        string $image = null
    ): StreamedResponse
    {
        return (new static($title, $body, $image))->downloadResponse();
    }

    public function downloadResponse(): StreamedResponse
    {
        $image = Browsershot::url(
            route('render-banner') . '?' . http_build_query([
                'payload' => json_encode([
                    'title' => $this->title,
                    'body' => $this->body,
                    'image' => $this->image
                ], JSON_THROW_ON_ERROR)
            ])
        )
            ->addChromiumArguments(app()->environment('local') ? [
                'ignore-certificate-errors'
            ] : [])
            ->setNodeBinary(config('banners.node'))
            ->setNpmBinary(config('banners.npm'))
            ->setNodeModulePath(config('banners.node_modules'))
            ->screenshot();

        abort_unless($image !== '', 404);

        return response()->stream(function () use ($image) {
            echo $image;
        }, 200, [
            'Content-Type' => 'image/png'
        ]);
    }
}
