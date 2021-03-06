<template>
    <div>
        <div class="columns">
            <div class="column is-6 is-offset-3">
                <div class="box">

                    <div class="columns">
                        <div class="column is-full">
                            <h1 class="title is-4 has-text-primary has-text-centered">3 Steps Form</h1>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column is-full p-0">
                            <h3 class="subtitle is-6 has-text-grey-darker has-text-centered p-0">Practice Test | Treedom</h3>
                        </div>
                    </div>

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
                            <section v-show="formData.step == 1">
                                <b-field
                                    :type="Object.keys(validation).length > 0 ? 'is-danger' : '' "
                                    :message="validation.hasOwnProperty('name') ? validation.name[0] : '' "
                                >
                                    <b-input placeholder="Name *" rounded v-model="formData.name" @keyup.native.enter="validateStep"></b-input>
                                </b-field>
                            </section>

                            <section v-show="formData.step == 2">
                                <b-field
                                    :type="Object.keys(validation).length > 0 ? 'is-danger' : '' "
                                    :message="validation.hasOwnProperty('surname') ? validation.surname[0] : '' "
                                >
                                    <b-input placeholder="Surname *" rounded v-model="formData.surname" @keyup.native.enter="validateStep"></b-input>
                                </b-field>
                            </section>

                            <section v-show="formData.step == 3">
                                <b-field
                                    :type="Object.keys(validation).length > 0 ? 'is-danger' : '' "
                                    :message="validation.hasOwnProperty('email') ? validation.email[0] : '' "
                                >
                                    <b-input placeholder="Email *" rounded v-model="formData.email" @keyup.native.enter="validateStep"></b-input>
                                </b-field>
                            </section>

                            <section v-show="formData.step == 4" class="has-text-centered min-height-success">
                                <p class="has-text-weight-bold">Success!</p>
                                <p>Thank you for filling out the form</p>
                            </section>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column is-10 is-offset-1">
                            <div class="columns mt-3" v-if="formData.step < 4">
                                <div class="column is-6">
                                    <b-button
                                        type="is-primary is-light"
                                        rounded
                                        :disabled="formData.step == 1" @click="stepBack"
                                    >
                                        Prev
                                    </b-button>
                                </div>
                                <div class="column is-6">
                                    <b-button
                                        type="is-primary"
                                        class="is-pulled-right"
                                        rounded
                                        @click="validateStep"
                                    >
                                        Next
                                    </b-button>
                                </div>
                            </div>

                            <div class="columns mt-3" v-else>
                                <div class="column is-full">
                                    <b-button
                                        type="is-primary is-light"
                                        rounded
                                        @click="reset"
                                    >
                                        Reset?
                                    </b-button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                formData: {
                    step: 1,
                    name: '',
                    surname: '',
                    email: ''
                },
                validation: {}
            }
        },
        methods: {
            validateStep(){
                axios.post('/api/validate-step', this.formData)
                .then((res) => {
                    this.formData.step = res.data.step;
                    this.validation = res.data.validation;
                })
                .catch(error => {
                    console.log(error);
                })
            },
            stepBack(){
                if(this.formData.step == 2)
                    this.formData.surname = '';
                if(this.formData.step == 3)
                    this.formData.email = '';

                this.validation = {};
                this.formData.step--;
            },
            reset() {
                Object.assign(this.$data, this.$options.data.call(this));
            }
        }
    }
</script>
