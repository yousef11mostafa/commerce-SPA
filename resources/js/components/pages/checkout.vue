<script setup>
import { computed, onMounted, reactive, ref } from "vue";
import { useStore } from "vuex";
import layout from "../layout/layout.vue";
import axios from "axios";

import { loadStripe } from "@stripe/stripe-js";
import { useRouter } from "vue-router";



const store = useStore();
const cart = store.getters["payments/getcart"];

const isLoading=true;

const getprice = (price) => {
    return price / 100;
};

const gettotal = (price, quantity) => {
    return (price * quantity) / 100;
};

const removefrombasket = (index) => {
    store.commit("payments/removeFromCart", index);
};

const subtotalPrice = computed(() => {
    return Math.floor(
        cart.reduce(
            (acc, current) => acc + gettotal(current.price, current.quantity),
            0
        )
    );
});

const getshipping = (price) => {
    return 0.03 * price;
};

const shipping = computed(() => {
    return Math.floor(getshipping(subtotalPrice.value));
});

const requiredprice = computed(() => {
    return Math.floor(subtotalPrice.value + shipping.value);
});

function handleInputChange(event, index) {
    const newValue = parseInt(event.target.value, 10);
    cart[index].quantity = newValue;
}

//  start payment code
const stripe = ref(null);
const cardElement = ref(null);
const paymentProcessing = ref(false);
const errors = ref(null);
const router = useRouter();

const customer = reactive({
    first_name: "",
    last_name: "",
    email: "",
    address: "",
    city: "",
    state: "",
    zip_code: "",
});

onMounted(async () => {
    stripe.value = await loadStripe(
        "pk_test_51PnjoCRqqajGQ8oZiYxHoC2PFOGj4zhkewWEAGohBfjspsSgaSeiWeN1Cs4WUjyz8plJyDC8ev9LncUQoSlLldXA00VcyRkvPH"
    );
    const elements = stripe.value.elements();
    cardElement.value = elements.create("card", {
        classes: {
            base: "form-control",
        },
    });
    cardElement.value.mount("#card-element");
});

const processPayment = async () => {
    paymentProcessing.value = true;


    console.log("one");

    const { paymentMethod, error } = await stripe.value.createPaymentMethod(
        "card",
        cardElement.value,
        {
            billing_details: {
                name: customer.first_name + " " + customer.last_name,
                email: customer.email,
                address: {
                    line1: customer.address,
                    city: customer.city,
                    state: customer.state,
                    postal_code: customer.zip_code,
                },
            },
        }
    );

    console.log("two");

    if (error) {
        paymentProcessing.value = false;

        console.log("error");
        console.error(error);
    } else {
        console.log("success");
        console.log(paymentMethod);
        customer.payment_method_id = paymentMethod.id;
        customer.amount = requiredprice.value;
        customer.return_url = window.location.href;
        // customer.cart = cart;
        customer.cart = JSON.stringify(cart);

        console.log(customer);

        axios
            .post("http://127.0.0.1:8000/api/v1/purcashe", customer)
            .then((response) => {
                paymentProcessing.value = false;
                console.log(response.data);

                store.commit("payments/setOrder", response.data);
                store.dispatch("payments/clearCart");

                router.push({ name: "Orders" });
            })
            .catch((error) => {
                paymentProcessing.value = false;
                console.error(error);
            });
    }
};

const errorFor = (field) => {
    return errors.value != null && errors.value[field]
        ? errors.value[field][0]
        : null;
};
</script>

<template>
    <layout>
        <div class="m-auto mt-5">

         <!-- loading -->
         <!-- <div>
             <h1>Loading Example</h1>
             <RotateLoader :loading="isLoading" color="#4A90E2" />
        </div> -->
         <!-- loading -->


            <div>
                <router-link to="/orders" class="btn btn-primary mb-3"
                    >Go to orders</router-link
                >
            </div>
            <!-- {{ cart[0] }} -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Product</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Total</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in cart" :key="item.id">
                        <td>{{ item.name }}</td>
                        <td>
                            <input
                                type="number"
                                class="form-control"
                                :value="item.quantity"
                                @input="
                                    (event) => handleInputChange(event, index)
                                "
                                min="1"
                            />
                        </td>
                        <td>{{ getprice(item.price) }}</td>
                        <td>{{ gettotal(item.price, item.quantity) }}</td>
                        <td>
                            <button
                                @click="removefrombasket(index)"
                                type="button"
                                class="btn btn-danger btn-sm"
                            >
                                Remove
                            </button>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end">Subtotal:</td>
                        <td>{{ subtotalPrice }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-end">Shipping:</td>
                        <!-- <td>{{getshipping(subtotalPrice)}}</td> -->
                        <td>{{ shipping }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-end">Total:</td>
                        <td>{{ requiredprice }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>

            <div class="container mt-5">
                <h2 class="mb-4">Payment Form</h2>
                <form class="mb-5" @submit.prevent="processPayment">
                    <!-- User Details Section -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="firstName" class="form-label"
                                    >First Name</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    id="firstName"
                                    :class="[
                                        {
                                            'is-invalid': errorFor(
                                                'customer.first_name'
                                            ),
                                        },
                                    ]"
                                    name="first_name"
                                    v-model="customer.first_name"
                                    :disabled="paymentProcessing"
                                    placeholder="Enter your first name"
                                />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="lastName" class="form-label"
                                    >Last Name</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    id="lastName"
                                    :class="[
                                        {
                                            'is-invalid':
                                                errorFor('customer.last_name'),
                                        },
                                    ]"
                                    name="last_name"
                                    v-model="customer.last_name"
                                    :disabled="paymentProcessing"
                                    placeholder="Enter your last name"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label"
                            >Email Address</label
                        >
                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            :class="[
                                { 'is-invalid': errorFor('customer.email') },
                            ]"
                            name="email"
                            v-model="customer.email"
                            :disabled="paymentProcessing"
                            placeholder="Enter your email"
                        />
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input
                            type="text"
                            class="form-control"
                            id="address"
                            :class="[
                                { 'is-invalid': errorFor('customer.address') },
                            ]"
                            name="address"
                            v-model="customer.address"
                            :disabled="paymentProcessing"
                            placeholder="Enter your address"
                        />
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="city" class="form-label"
                                    >City</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    id="city"
                                    :class="[
                                        {
                                            'is-invalid':
                                                errorFor('customer.city'),
                                        },
                                    ]"
                                    name="city"
                                    v-model="customer.city"
                                    :disabled="paymentProcessing"
                                    placeholder="Enter your city"
                                />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="state" class="form-label"
                                    >State</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    id="state"
                                    :class="[
                                        {
                                            'is-invalid':
                                                errorFor('customer.state'),
                                        },
                                    ]"
                                    name="state"
                                    v-model="customer.state"
                                    :disabled="paymentProcessing"
                                    placeholder="Enter your state"
                                />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="zip" class="form-label"
                                    >Zip Code</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    id="zip"
                                    :class="[
                                        {
                                            'is-invalid':
                                                errorFor('customer.zip_code'),
                                        },
                                    ]"
                                    name="zip_code"
                                    v-model="customer.zip_code"
                                    :disabled="paymentProcessing"
                                    placeholder="Enter your zip code"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Payment Details Section -->
                    <!-- <h4 class="mb-3">Payment Details</h4>

    <div class="mb-3">
      <label for="cardName" class="form-label">Name on Card</label>
      <input type="text" class="form-control" id="cardName" placeholder="Enter name as it appears on the card" required>
    </div>

    <div class="mb-3">
      <label for="cardNumber" class="form-label">Card Number</label>
      <input type="text" class="form-control" id="cardNumber" placeholder="Enter your card number" required>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="mb-3">
          <label for="expiration" class="form-label">Expiration Date</label>
          <input type="text" class="form-control" id="expiration" placeholder="MM/YY" required>
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
          <label for="cvv" class="form-label">CVV</label>
          <input type="text" class="form-control" id="cvv" placeholder="CVV" required>
        </div>
      </div>
    </div> -->

                    <!-- test     -->

                    <div class="row">
                        <div class="col-md-12 form-group mb-3">
                            <label for="card-element">Credit Card Info</label>
                            <div id="card-element"></div>
                        </div>
                    </div>

                    <!-- test     -->

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary w-100">
                        Submit Payment
                    </button>
                    <!-- <button type="submit"  :disabled="paymentProcessing" class="btn btn-primary w-100">Submit Payment</button> -->
                </form>
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
