<template>
    <div>
        <div class="columns">
            <div class="column is-full carousel-container is-clipped">
                <div class="is-relative">

                    <b-loading :is-full-page="false" v-model="loading"></b-loading>

                    <transition :name="transitionType" mode="in-out">
                        <div v-if="!loading">
                            <div class="columns">
                                <div class="column is-full">
                                    <ul class="steps">
                                        <li
                                            class="step-item"
                                            :class="{ 'is-completed': formData.step > 1, 'is-active': formData.step == 1 }"
                                        >
                                            <div class="step-marker">1</div>
                                        </li>
                                        <li
                                            class="step-item"
                                            :class="{ 'is-completed': formData.step > 2, 'is-active': formData.step == 2 }"
                                        >
                                            <div class="step-marker">2</div>
                                        </li>
                                        <li
                                            class="step-item"
                                            :class="{ 'is-completed': formData.step > 3, 'is-active': formData.step == 3 }"
                                        >
                                            <div class="step-marker">3</div>
                                        </li>
                                        <li
                                            class="step-item"
                                            :class="{ 'is-active': formData.step == 4 }"
                                        >
                                            <div class="step-marker">
                                                <i class="mdi mdi-check"></i>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="columns mt-5 mb-3">
                                <div class="column is-10 is-offset-1">
                                    <div v-show="formData.step == 1">
                                        <b-field
                                            :type="getFieldType()"
                                            :message="getFieldMessage('name')"
                                        >
                                            <b-input
                                                placeholder="Name *"
                                                rounded
                                                v-model="formData.name"
                                                @keyup.native.enter="validateStep"
                                            ></b-input>
                                        </b-field>
                                    </div>

                                    <div v-show="formData.step == 2">
                                        <b-field
                                            :type="getFieldType()"
                                            :message="getFieldMessage('surname')"
                                        >
                                            <b-input
                                                placeholder="Surname *"
                                                rounded
                                                v-model="formData.surname"
                                                @keyup.native.enter="validateStep"
                                            ></b-input>
                                        </b-field>
                                    </div>

                                    <div v-show="formData.step == 3">
                                        <b-field
                                            :type="getFieldType()"
                                            :message="getFieldMessage('email')"
                                        >
                                            <b-input
                                                placeholder="Email *"
                                                rounded
                                                v-model="formData.email"
                                                @keyup.native.enter="validateStep"
                                            ></b-input>
                                        </b-field>
                                    </div>

                                    <div v-show="formData.step == 4" class="has-text-centered min-height-success">
                                        <p class="has-text-weight-bold">Success!</p>
                                        <p>Thank you for filling out the form</p>
                                    </div>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column is-10 is-offset-1">
                                    <b-button
                                        type="is-primary is-light"
                                        rounded
                                        @click="reset"
                                        v-if="formData.step == 4"
                                    >
                                        Restart?
                                    </b-button>

                                    <b-button
                                        type="is-primary is-light"
                                        rounded
                                        @click="stepBack"
                                        :disabled="formData.step == 1"
                                        v-else
                                    >
                                        Prev
                                    </b-button>

                                    <b-button
                                        type="is-primary"
                                        class="is-pulled-right"
                                        rounded
                                        @click="validateStep"
                                        v-if="formData.step < 4"
                                    >
                                        Next
                                    </b-button>
                                </div>
                            </div>
                        </div>
                    </transition>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                loading: false,
                transitionType: "fade",
                windowWidth: window.innerWidth,
                formData: {
                    step: 1,
                    name: '',
                    surname: '',
                    email: ''
                },
                validation: {},
            }
        },
        mounted() {
            this.$nextTick(() => {
                window.addEventListener('resize', this.onResize);
            })
        },
        beforeDestroy() {
            window.removeEventListener('resize', this.onResize);
        },
        methods: {
            onResize() {
                this.windowWidth = window.innerWidth;
            },
            getFieldType(){
                return Object.keys(this.validation).length > 0 ? 'is-danger' : '';
            },
            getFieldMessage(field){
                return this.validation.hasOwnProperty(field) ? this.validation.[field][0] : '' ;
            },
            toggleLoading(){
                if(this.windowWidth < 768)
                    this.loading = !this.loading;
            },
            validateStep(){
                this.toggleLoading();

                axios.post('/api/validate-step', this.formData)
                .then((res) => {
                    this.transitionType = Object.keys(res.data.validation).length == 0 ? "slide-prev" : "fade"

                    setTimeout(() => {
                        this.validation = res.data.validation;
                        this.formData.step = res.data.step;
                        this.toggleLoading()
                    }, 100);
                })
                .catch(error => {
                    console.log(error);
                })
            },
            stepBack(){
                this.toggleLoading();

                this.transitionType = "slide-next";

                setTimeout(() => {
                    if(this.formData.step == 2)
                        this.formData.surname = '';
                    if(this.formData.step == 3)
                        this.formData.email = '';

                    this.validation = {};
                    this.formData.step--;

                    this.toggleLoading()
                }, 100);
            },
            reset() {
                this.toggleLoading();
                setTimeout(() => Object.assign(this.$data, this.$options.data.call(this)), 100);
            }
        }
    }
</script>
