<?php

namespace App\Http\Livewire\Bookmark;

use App\Models\Bookmark;
use Livewire\Component;

class BookmarkReceiver extends Component
{
    public $url;
    protected $queryString = ['url'];

    public function mount($slug) {
        $bookmark = Bookmark::create([
            'url' => $this->url,
        ]);
    }

    public function render()
    {
        return view('livewire.bookmark.bookmark-receiver');
    }
}
