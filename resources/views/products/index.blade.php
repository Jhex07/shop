<x-app title="Productos">
    <div class="container">
        <product-table :products="{{$products}}" :categories="{{ $categories }}"/>
    </div>
</x-app>
