<x-app>
    <div class="container">
        <div class="row">
            @foreach ($category->products as $product)
                <div class="col-md-3 mb-4">
                    <div class="card" style="width: 17rem; margin-left: 30px;">
                        <img src="{{ $product->file->route }}" class="card-img-top img-fluid" style="padding: 15px" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">Precio: {{ $product->price }}</p>
                            <a href="{{ route('products.show', ['product' => $product]) }}" class="btn btn-outline-primary">Ver</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app>
