
    <div class="card mb-2">
        <div style="height:200px;background:url('{{$item->thumbnail? $item->thumbnail->filepath : MyHelper::photoPlaceholder()}}') center center;background-size: cover" alt="{{ $item->name }}"></div>
         <div class="card-body p-3">
            <h5 class="card-title mb-0 "><a class="text-dark" target="_blank" href="{{ route('user.attraction.show', ['attraction' => $item->id]) }}">{{ $item->name }}</a></h5>
            <p class="card-text text-truncate clearfix">{{ $item->location }}</p>
            <a href="#" class="action btn btn-link mb-0 text-e pl-0 {{ auth()->check() && $item->isLikedBy(auth()->user()->id) ? '' : 'text-dark' }} like"  data-pk="{{ $item->id }}">
                <i class="fas fa-heart"></i> <span class="count" data-pk="{{ $item->id }}">{{ $item->likers->count() }}</span> likes
            </a>
            <a href="javascript:void()" class="action btn btn-link pl-0 mb-0 text-dark float-right">
                <i class="fas fa-star"></i> {{ $item->average_rating ?: 0 }} overall rating
            </a>
        </div>
    </div>
