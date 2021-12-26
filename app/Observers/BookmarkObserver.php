<?php

namespace App\Observers;

use App\Jobs\BookmarkExploreJob;
use App\Jobs\TagsToLowerCaseJob;
use App\Models\Bookmark;

class BookmarkObserver
{
    /**
     * Handle the Bookmark "created" event.
     *
     * @param  \App\Models\Bookmark  $bookmark
     * @return void
     */
    public function created(Bookmark $bookmark)
    {
        dispatch(new BookmarkExploreJob($bookmark));
        dispatch(new TagsToLowerCaseJob);
    }

    /**
     * Handle the Bookmark "updated" event.
     *
     * @param  \App\Models\Bookmark  $bookmark
     * @return void
     */
    public function updated(Bookmark $bookmark)
    {
        dispatch(new BookmarkExploreJob($bookmark));
        dispatch(new TagsToLowerCaseJob);
    }

    /**
     * Handle the Bookmark "deleted" event.
     *
     * @param  \App\Models\Bookmark  $bookmark
     * @return void
     */
    public function deleted(Bookmark $bookmark)
    {
        //
    }

    /**
     * Handle the Bookmark "restored" event.
     *
     * @param  \App\Models\Bookmark  $bookmark
     * @return void
     */
    public function restored(Bookmark $bookmark)
    {
        //
    }

    /**
     * Handle the Bookmark "force deleted" event.
     *
     * @param  \App\Models\Bookmark  $bookmark
     * @return void
     */
    public function forceDeleted(Bookmark $bookmark)
    {
        //
    }
}
