<script setup>
import { computed, onMounted, ref } from "vue";
import { useStore } from "vuex";
import layout from "../components/layout/layout.vue";

const store = useStore();

const products = ref([]);

onMounted(() => {
    store.dispatch("products/getproducts").then(() => {
        products.value = store.getters["products/getproducts"];
    });
});

const cart = ref([]);

const addtocard = (product) => {
    store.commit("payments/addToCart", product);
};
</script>

<template>
    <layout>
        <div class="row mt-5">
            <div
                v-for="product in products"
                :key="product.id"
                class="col col-md-6 col-lg-4 col-xl-3"
            >
                <div class="card m-1" style="width: 18rem">
                    <router-link
                        class="text-decoration-none"
                        :to="{
                            name: 'showProduct',
                            params: { slug: product.slug },
                        }"
                    >
                        <img
                            src="https://cdn4.vectorstock.com/i/1000x1000/58/48/blank-photo-icon-vector-3265848.jpg"
                            class="card-img-top"
                            style="height: 200px"
                            alt="..."
                        />
                        <div class="card-body">
                            <h5 class="card-title">{{ product.name }}</h5>
                            <h4 class="card-title">categories:</h4>
                            <span
                                class="p-1 btn bg-dark-subtle m-1"
                                v-for="cat in product.categories"
                                :key="cat.id"
                                >{{ cat.name }}</span
                            >
                            <br />
                            <p class="card-text">
                                <span style="font-weight: bold"
                                    >Description</span
                                >:{{ product.description.substring(0, 70) }}....
                            </p>
                        </div>
                    </router-link>
                    <div class="card-footer">
                        <button @click="addtocard(product)" class="btn btnn">
                            Add to cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </layout>
</template>

<style scoped>
.btnn {
    background-color: #bcd0c7 !important;
    border-color: #bcd0c7 !important;
    color: black;
}
</style>
