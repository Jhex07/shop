<template>
  <div>
    <h2>Mi Carrito</h2>
    <table class="table" v-if="cartItems.length > 0">
        <thead>
            <tr>
            <th scope="col">Producto</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Precio</th>
            <th scope="col">Acción</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, index) in cartItems" :key="index">
            <td>{{ item.name }}</td>
            <td>{{ item.pivot.quantity }}</td>
            <td>{{ '$' + item.price * item.pivot.quantity }}</td>
            <td>
            <button @click="removeFromCart(item.id)" class="btn btn-danger btn-sm">Eliminar</button>
            </td>
            </tr>
        </tbody>
        <tfoot>
        <tr>
          <td colspan="2"></td>
          <td>Total: {{ '$' + calculateTotal() }}</td>
          <td></td>
        </tr>
      </tfoot>
    </table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      cartItems: [],
    };
  },
  mounted() {
    this.fetchCartItems();
  },
  methods: {
    fetchCartItems() {
        axios.get('/cart/items')
        .then(response => {
            this.cartItems = response.data.items;
        })
        .catch(error => {
            console.error('Error ', error);
        });
    },
    removeFromCart(productId) {
      axios.delete(`/cart/items/${productId}`)
        .then(() => {
          this.fetchCartItems();
        })
        .catch(error => {
          console.error('Error', error);
        });
    },
    calculateTotal() {
      return this.cartItems.reduce((total, item) => total + (item.price * item.pivot.quantity), 0);
    },
  },
};
</script>
