<template>

    <div class="mx-auto" style="max-width: 1000px; margin-top: 50px;">
        <div class="card mb-3">
            <div class="row g-0">
                <div class="col-md-4">
                    <img :src="product.file.route" style="margin-left: 30px;" class="img-fluid rounded-start" :alt="product.name">
                </div>
                <div class="col-md-8">
                    <div class="card-body" style="margin-left: 30px">
                        <h2 class="card-title">{{ product.name }}</h2>
                        <p style="font-size: 17px" class="card-text">{{ product.description }}</p>
                        <p style="font-size: 25px" class="card-text"><small class="text-body-secondary">{{ '$' + product.price }}</small></p>

                        <button class="btn btn-primary" @click="addToCart">Agregar al carrito</button>

                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import { handlerErrors, showSuccessMessage} from '@/helpers/Alerts.js';

export default {
    props: {
        product: {
            type: Object,
            required: true
        }
    },

    methods: {
        addToCart() {
            axios.post('/cart/store', {
                id: this.product.id,
                quantity: 1
            })
            .then(response => {
                console.log(response.data);
                showSuccessMessage({ is_added: true });
            })
            .catch(error => {
                console.error(error);
            });
        }
    }
}
</script>
