<x-app>
    <div class="container mt-5 mb-5" style="background-color: rgb(254, 254, 254)">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ $product->image_url }}" class="img-fluid" alt="{{ $product->name }}">
            </div>
            <div class="col-md-6">
                <h2>{{ $product->name }}</h2>
                <p class="fs-4">{{ '$' . $product->price }}</p>
                <p>Categoría: {{ $product->category->name }}</p>
                <p>Descripción: {{ $product->description }}</p>
            </div>
        </div>
    </div>
</x-app>
