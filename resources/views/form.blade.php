@extends('layout.master')

@section('content')
    <section class="hero is-fullheight gradient-background">
        <div class="hero-body">
            <div class="container">
                <div id="app">
                    <div class="columns">
                        <div class="column is-6 is-offset-3">
                            <div class="box">

                                <div class="columns">
                                    <div class="column is-full">
                                        <h1 class="title is-4 has-text-primary has-text-centered">
                                            3 Steps Form
                                        </h1>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column is-full p-0">
                                        <h3 class="subtitle is-6 has-text-grey-darker has-text-centered p-0">
                                            Practice Test | Treedom
                                        </h3>
                                    </div>
                                </div>

                                <form-component></form-component>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
