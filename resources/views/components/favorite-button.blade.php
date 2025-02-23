<a href="{{ route('favorites.toggle', ['modelType' => $modelType, 'modelId' => $modelId]) }}"
   class="favorite-link btn {{ $isFavorite ? 'btn-danger' : 'btn-outline-primary' }}">
    {{ $isFavorite ? __('interface.remove_from_favorites') : __('interface.add_to_favorites') }}
</a>
