<?php

namespace App\Http\Livewire\Bookmark;

use App\Models\Bookmark;
use App\Models\Receiver;
use Livewire\Component;

class BookmarkReceiver extends Component
{
    public $url;
    protected $queryString = ['url'];

    public function mount($slug) {

        $receiver = Receiver::where('slug', $slug)->first();
        if(!$receiver) abort(403);

        $bookmark = Bookmark::where('url', $this->url)->first();
        if(!$bookmark) {
            $bookmark = Bookmark::create([
                'url' => $this->url,
            ]);
        }
        else {
            $bookmark->touch();
        }

        $bookmark->syncTags($receiver->tags);

    }

    public function render()
    {
        return view('livewire.bookmark.bookmark-receiver')
            ->extends('layouts.public');
    }
}
