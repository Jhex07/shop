<x-app>

    <h1 style="margin-left: 30px">resultados para '{{ $query }}'</h1>

    <div class="row justify-content-center">

        @forelse ($products as $product)
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="{{ $product->file->route }}" class="img-fluid rounded-start" alt="{{ $product->name }}">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h3 class="card-title"><a class="product-link" href="{{ route('products.show', ['product' => $product]) }}">{{ $product->name }}</a></h5>
                            <p class="card-text" style="font-size: 20px">{{ '$' . $product->price }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <h3 style="margin-left: 60px">no se encontraron productos.</h3>
        @endforelse
    </div>
</x-app>
