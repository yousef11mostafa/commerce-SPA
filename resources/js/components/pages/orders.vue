<script setup>
import { createStore, useStore } from "vuex";
import layout from "../layout/layout.vue";

const store = useStore();
const orders = store.getters["payments/getorders"];

console.log(orders);

import { ref, watch, computed } from "vue";

const index = ref(0);
const end = orders.length;

const loop = ref(true);

watch(index, (newValue, oldValue) => {
    if (oldValue === end) {
        loop.value = false;
    }
});
</script>

<template>
    <layout>
        <h5>your orders</h5>

        <br />

        <!-- start table -->
        <div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Transaction ID</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(order, index) in orders"
                        :key="order.id"
                        :data-bs-toggle="'collapse'"
                        :data-bs-target="'#order' + order.id"
                    >
                        <td>{{ index + 1 }}</td>
                        <td>{{ order.transaction_id }}</td>
                        <td>{{ order.total }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm">
                                Toggle Products
                            </button>
                        </td>
                    </tr>
                    <tr
                        class="collapse"
                        :id="'order' + order.id"
                        v-for="order in orders"
                        :key="'collapse-' + order.id"
                    >
                        <td colspan="5">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="product in order.products"
                                        :key="product.id"
                                    >
                                        <router-link
                                            :to="{
                                                name: 'showProduct',
                                                params: { slug: product.slug },
                                            }"
                                        >
                                            <td>{{ product.name }}</td>
                                        </router-link>

                                        <td>{{ product.quantity }}</td>
                                        <!-- Replace with actual product quantity -->
                                        <td>{{ product.price / 100 }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </layout>
</template>
