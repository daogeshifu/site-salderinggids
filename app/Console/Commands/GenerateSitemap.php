<?php

namespace App\Console\Commands;

use App\Models\Article\Article;
use App\Models\Article\ArticleCategory;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate {--base-url= : Override APP_URL when generating absolute sitemap links}';
    protected $description = 'Generate the sitemap.xml file';

    public function handle()
    {
        $sitemap = Sitemap::create();
        $locales = $this->supportedLocales();
        $categories = ArticleCategory::query()->orderBy('name')->get();

        foreach ($locales as $locale) {
            $this->addStaticPages($sitemap, $locale);
            $this->addSectionPages($sitemap, $locale, $categories);
            $this->addCategoryPages($sitemap, $locale, $categories);
            $this->addArticlePages($sitemap, $locale);
        }

        // 保存到 public/sitemap.xml
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully: ' . public_path('sitemap.xml'));
    }

    private function addStaticPages(Sitemap $sitemap, string $locale): void
    {
        $pages = [
            ['path' => '/', 'priority' => 1.0, 'frequency' => Url::CHANGE_FREQUENCY_DAILY],
            ['path' => '/pricing', 'priority' => 0.8, 'frequency' => Url::CHANGE_FREQUENCY_WEEKLY],
            ['path' => '/price', 'priority' => 0.8, 'frequency' => Url::CHANGE_FREQUENCY_WEEKLY],
            ['path' => '/about', 'priority' => 0.7, 'frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
            ['path' => '/contact', 'priority' => 0.6, 'frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
            ['path' => '/help', 'priority' => 0.6, 'frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
            ['path' => '/terms', 'priority' => 0.4, 'frequency' => Url::CHANGE_FREQUENCY_YEARLY],
            ['path' => '/policy', 'priority' => 0.4, 'frequency' => Url::CHANGE_FREQUENCY_YEARLY],
        ];

        foreach ($pages as $page) {
            $sitemap->add(
                Url::create($this->localizedUrl($locale, $page['path']))
                    ->setLastModificationDate(Carbon::now())
                    ->setChangeFrequency($page['frequency'])
                    ->setPriority($page['priority'])
            );
        }
    }

    private function addSectionPages(Sitemap $sitemap, string $locale, Collection $categories): void
    {
        $sections = [
            'news' => ['priority' => 0.9, 'frequency' => Url::CHANGE_FREQUENCY_DAILY],
            'guides' => ['priority' => 0.9, 'frequency' => Url::CHANGE_FREQUENCY_WEEKLY],
            'cases' => ['priority' => 0.8, 'frequency' => Url::CHANGE_FREQUENCY_WEEKLY],
            'article' => ['priority' => 0.8, 'frequency' => Url::CHANGE_FREQUENCY_WEEKLY],
        ];

        foreach ($sections as $path => $meta) {
            $category = $categories->firstWhere('name', $path);

            $sitemap->add(
                Url::create($this->localizedUrl($locale, '/' . $path))
                    ->setLastModificationDate($category?->updated_at ?? Carbon::now())
                    ->setChangeFrequency($meta['frequency'])
                    ->setPriority($meta['priority'])
            );
        }
    }

    private function addCategoryPages(Sitemap $sitemap, string $locale, Collection $categories): void
    {
        foreach ($categories as $category) {
            if (!$category->name || in_array($category->name, ['news', 'guides', 'cases'], true)) {
                continue;
            }

            $sitemap->add(
                Url::create($this->localizedUrl($locale, '/' . $category->name))
                    ->setLastModificationDate($category->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.8)
            );
        }
    }

    private function addArticlePages(Sitemap $sitemap, string $locale): void
    {
        Article::query()
            ->with('category')
            ->whereNotNull('link')
            ->whereHas('translations', function ($query) use ($locale) {
                $query->where('locale', $locale);
            })
            ->orderBy('id')
            ->chunkById(1000, function ($articles) use ($sitemap, $locale) {
                foreach ($articles as $article) {
                    if (!$article->category || !$article->category->name) {
                        continue;
                    }

                    $sitemap->add(
                        Url::create($this->localizedUrl(
                            $locale,
                            '/' . $article->category->name . '/' . $article->link . '.html'
                        ))
                            ->setLastModificationDate($article->updated_at)
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                            ->setPriority(0.8)
                    );
                }
            });
    }

    private function localizedUrl(string $locale, string $path): string
    {
        $path = '/' . ltrim($path, '/');
        $defaultLocale = config('laravellocalization.defaultLocale', config('app.locale', 'en'));
        $hideDefaultLocale = config('laravellocalization.hideDefaultLocaleInURL', false);

        if ($locale !== $defaultLocale || !$hideDefaultLocale) {
            $path = '/' . $locale . ($path === '/' ? '' : $path);
        }

        return $this->baseUrl() . ($path === '/' ? '' : $path);
    }

    private function baseUrl(): string
    {
        return rtrim($this->option('base-url') ?: config('app.url'), '/');
    }

    private function supportedLocales(): array
    {
        return array_keys(config('laravellocalization.supportedLocales', [
            config('app.locale', 'en') => [],
        ]));
    }
}
