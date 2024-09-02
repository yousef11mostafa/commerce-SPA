<script setup>
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";
import { useStore } from "vuex";
import layout from "../layout/layout.vue";

const store = useStore();

const product = ref({});

const route = useRoute();
const productName = route.params.slug;

onMounted(() => {
    store.dispatch("products/getproduct", productName).then(() => {
        product.value = store.getters["products/getproduct"];
        product.value = product.value[0];
    });
});

const formatCurrency = (price) => {
    return price / 100 + " eu";
};

const addtocard = (product) => {
    store.commit("payments/addToCart", product);
};
</script>

<template>
    <layout>
        <div class="row mt-5">
            <div class="d-flex flex-row justify-content-around">
                <div class="col-md-6">
                    <!-- <img class="card-img" src="https://dummyimage.com/640x640/bbb/555" alt="Vans"> -->
                    <img
                        src="https://cdn4.vectorstock.com/i/1000x1000/58/48/blank-photo-icon-vector-3265848.jpg"
                        class="card-img-top"
                        style="height: 600px"
                        alt="..."
                    />
                </div>

                <div class="col-md-5" v-if="product">
                    <h6 class="subtitle mb-2 text-muted">
                        <span
                            v-for="category in product.categories"
                            :key="category.id"
                            class="me-2"
                            >{{ category.name }}</span
                        >
                    </h6>
                    <h4 class="title">{{ product.name }}</h4>

                    <p class="card-text text-justify">
                        {{ product.description }}
                    </p>

                    <hr />

                    <div
                        class="buy d-flex justify-content-between align-items-center"
                    >
                        <div class="price text-success">
                            <!-- <h4 class="mt-4">price</h4> -->
                            <h4
                                class="mt-4"
                                v-text="formatCurrency(product.price)"
                            ></h4>
                        </div>
                        <button
                            class="btn btn-danger mt-3"
                            @click="addtocard(product)"
                        >
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </layout>
</template>

<style scoped>
.btn {
    background-color: #bcd0c7 !important;
    border-color: #bcd0c7 !important;
    color: black;
}
</style>
