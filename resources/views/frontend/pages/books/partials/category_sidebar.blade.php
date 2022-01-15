<div class="col-md-3">
    <div class="widget">
      <h5 class="mb-2 border-bottom pb-3">
        Categories
      </h5>

      <div class="list-group mt-3">
          @foreach(App\Category::all() as $cat)
        <a href="{{route('categories.show', $cat->slug)}}" class="list-group-item list-group-item-action">
          {{ $cat->name }}
        </a>
        @endforeach
      </div>

    </div> <!-- Single Widget -->

  </div> <!-- Sidebar -->