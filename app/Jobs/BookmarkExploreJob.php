<?php

namespace App\Jobs;

use App\Crawlers\DomainCrawler;
use App\Models\Bookmark;
use App\Models\Domain;
use Embed\Embed;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use League\Uri\Uri;
use shweshi\OpenGraph\OpenGraph;

class BookmarkExploreJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Bookmark $bookmark;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Bookmark $bookmark)
    {
        $this->bookmark = $bookmark;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $embed = new Embed();

        $info = $embed->get($this->bookmark->url);

        $this->bookmark->url = $info->url ?? $this->bookmark->url;
        $this->bookmark->name = $info->title ?? 'No Name';
        $this->bookmark->description = $info->description ?? null;
        $this->bookmark->image = $info->image ?? null;
        $this->bookmark->type = $info->providerName ?? null;

        if($info->keywords) {
            $this->bookmark->syncTags($info->keywords);
        }

        ray($info->feeds);

        $this->bookmark->saveQuietly();

        return;

        $uri = Uri::createFromString($this->bookmark->url);
        $host = $uri->getHost();

        $data = $og->fetch($host, true);

        ray($data);

        $domain = Domain::where('url', $host)->first();
        if(!$domain) {
            $domain = Domain::create([
                'url' => $host,
                'name' => $data['title'] ?? 'No Name',
            ]);
        }

        $domain->update([
            'name' => $data['title'] ?? 'No Name',
            'description' => $data['description'] ?? null,
        ]);

        $domain->syncTags($this->bookmark->tags);

        // Crawler::create()
        //     ->setCrawlObserver(new DomainCrawler)
        //     ->startCrawling($this->bookmark->url);
    }
}
