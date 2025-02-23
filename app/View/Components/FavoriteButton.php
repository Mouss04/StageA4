<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteButton extends Component
{
    public $modelType;
    public $modelId;
    public $isFavorite;

    public function __construct($modelType, $modelId)
    {
        $this->modelType = $modelType;
        $this->modelId = $modelId;
        $this->isFavorite = Auth::check() ? Favorite::where('user_id', Auth::id())
            ->where('model_type', $modelType)
            ->where('model_id', $modelId)
            ->exists() : false;
    }

    public function render()
    {
        return view('components.favorite-button');
    }
}
